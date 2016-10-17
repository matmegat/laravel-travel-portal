<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class J6Command extends Command
{
    const STEP = 10;
    const MAX_ID = 100000;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'command:loadJ6';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load tour in Cache from J6';

    private $api;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        $this->api = new \services\Api\J6(['useCache' => false]);

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
        } else {
            $this->processQueue();
        }

        exit;

        $api = new \services\Api\J6();

        $tours_content = $api->getAllProducts();

        foreach ($tours_content['response'] as $key => $content) {
            $description = $api->getProduct($content['ID']);
            $ps = [];
            $count = preg_match_all('/<p[^>]*>(.*?)<\/p>/is', html_entity_decode($description['response']['Content']), $matches);
            for ($i = 0; $i < $count; ++$i) {
                $ps[] = $matches[0][$i];
            }

            $tours_content['response'][$key]['description'] = $ps[0];

            if (count($description['response']['Photos']) > 0) {
                $tours_content['response'][$key]['photo'] = $description['response']['Photos'][0]['URL'];
            } else {
                $tours_content['response'][$key]['photo'] = 'no-image.jpg';
            }
        }
    }

    private function initQueue()
    {
        for ($from = 1; $from <= self::MAX_ID; $from += self::STEP) {
            $to = $from + self::STEP - 1;

            $data = \TourPullQueue::where('from_id', '=', $from)
                ->where('to_id', '=', $to)
                ->first();

            if (!empty($data)) {
                continue;
            }

            $data = new \TourPullQueue();
            $data->from_id = $from;
            $data->to_id = $to;
            $data->save();
        }
    }

    private function processQueue()
    {
        $task = \TourPullQueue::orderBy('created_at', 'asc')
            ->first();

        if (empty($task)) {
            return;
        }

        $this->syncData($task->from_id, $task->to_id);
        $task->delete();
    }

    private function syncData($from, $to)
    {
        $search = new \services\Search\Tour\J6();

        $ids = [];
        $foundIds = [];
        for ($id = $from; $id <= $to; ++$id) {
            $ids[] = $id;
            $product = $this->api->getProduct($id);

            if (!$product) {
                continue;
            }

            $search->storeProduct($product);

            $foundIds[] = $id;
        }

        $search->deleteProducts(array_values(array_diff($ids, $foundIds)));
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
            ['start', null, InputOption::VALUE_REQUIRED],
            ['sleep', null, InputOption::VALUE_REQUIRED],
        ];
    }
}
