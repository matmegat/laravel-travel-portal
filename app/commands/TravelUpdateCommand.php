<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class TravelUpdateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'command:updatetravel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updating products in Cache';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $api = new \services\Api\Travel();

        $products = $api->getProducts();

        if (isset($products['status']) && $products['status'] === 'error') {
            throw new \Exception("failed to retrieve products, received {$products['statusCode']} {$products['statusText']}.");
        }

        $count = 0;
        $lastupdates = [];
        $productsIds = [];
        $updatedProds = 0;
        foreach ($products['results'] as $key => $product) {
            ++$count;
            $productsIds[] = $product['productId'];

            if ($count % 30 == 0) {
                $productsIds = implode(',', $productsIds);
                $lastupdates[] = $api->getLastUpdate($productsIds);

                foreach ($products['results'] as $k => $v) {
                    if (isset($lastupdates[0][$v['productId']])) {
                        if ($lastupdates[0][$v['productId']] != $v['lastupdate']) {
                            $products['results'][$k] = $api->getTourInfo($lastupdates[0][$v['productId']]);
                            ++$updatedProds;
                            $this->info('Updated '.$updatedProds.' product(s)');
                        }
                    }

                    $productsIds = [];
                    $lastupdates = [];
                }
            }
        }

        if ($updatedProds == 0) {
            $this->info('Updates not found for products');
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}