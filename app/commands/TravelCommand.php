<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class TravelCommand extends Command
{
    const STEP = 100;
    const MAX_ID = 20000;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'command:loadtravel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'load travel data from API in Cache';

    private $api;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        $this->api = new \services\Api\Travel(['useCache' => false]);

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        if ($this->argument('initQueue')) {
            $this->initQueue();
        } elseif ($this->option('updateExists')) {
            $this->updateExists();
        } else {
            $this->processQueue();
        }
    }

    private function updateExists()
    {
        $tours = \TravelTour::take(50)
            ->where('updated_at', '<', new DateTime('-6 hours'))
            ->orderBy('updated_at', 'asc')
            ->get();
        $ids = [];
        foreach ($tours as $tour) {
            $ids[] = $tour->id;
        }

        $this->updateData($ids);
    }

    private function initQueue()
    {
        for ($from = 1; $from <= self::MAX_ID; $from += self::STEP) {
            $to = $from + self::STEP - 1;

            $data = \TravelTourQueue::firstOrNew(['from' => $from, 'to' => $to]);

            if ($data->exists) {
                continue;
            }

            $data->save();
        }
    }

    private function processQueue()
    {
        $task = \TravelTourQueue::orderBy('created_at', 'asc')
            ->first();

        if (empty($task)) {
            return;
        }

        $time = time() + microtime();

        $result = $this->syncData($task->from, $task->to);
        $task->delete();

        $executionTime = round((time() + microtime() - $time), 2);

        $log = new TravelTourLog();
        $log->from = $task->from;
        $log->to = $task->to;
        $log->result = $result;
        $log->time = $executionTime;
        $log->save();
    }

    private function syncData($from, $to)
    {
        $search = new \services\Search\Tour\Travel();

        $ids = [];
        for ($id = $from; $id <= $to; ++$id) {
            $ids[] = (string) $id;
        }

        $foundIds = $this->updateData($ids);

        $search->deleteProducts(array_values(array_diff($ids, $foundIds)));

        return [
            'foundIds' => $foundIds,
            'count' => count($foundIds),
        ];
    }

    private function updateData($ids)
    {
        $search = new \services\Search\Tour\Travel();
        $foundIds = [];

        $products = $this->api->getProductsByIds($ids);
        foreach ($products as $value) {
            try {
                $value['images'] = $this->api->getImgProductsPrettify($value['productId']);

                if ($value['productClass'] == 'Z') {
                    foreach ($value['faresprices'] as $k => $faresprice) {
                        $value['faresprices'][$k]['productPricesDetails'] = $this->api->getPackage($faresprice['productPricesDetailsId']);
                    }
                }

                $search->storeProduct($value);

                $foundIds[] = (string) $value['productId'];
            } catch (\Exception $e) {
            }
        }

        return $foundIds;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['initQueue', null, InputOption::VALUE_OPTIONAL],
            ['updateExists', null, InputOption::VALUE_OPTIONAL],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['updateExists', null, InputOption::VALUE_REQUIRED],
        ];
    }
}
