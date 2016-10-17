<?php

use Illuminate\Console\Command;

class TravelCategoriesCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'command:travelCategories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

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
        $data = $this->api->getCountries();
        foreach ($data as $id => $name) {
            $country = \TravelCountry::firstOrNew(['id' => $id]);
            $country->name = $name;
            $country->save();

            $this->replaceStates($id);
        }
    }

    private function replaceStates($countryId)
    {
        if (!$countryId) {
            return false;
        }

        $data = $this->api->getStates($countryId);
        foreach ($data as $id => $name) {
            if ($id == 0) {
                continue;
            }

            $state = \TravelState::firstOrNew(['id' => $id]);
            $state->name = $name;
            $state->country_id = $countryId;
            $state->save();

            $this->replaceRegions($id);
        }
    }

    private function replaceRegions($stateId)
    {
        if (!$stateId) {
            return false;
        }

        $data = $this->api->getRegions(['states' => $stateId]);
        foreach ($data as $id => $name) {
            if ($id == 0) {
                continue;
            }

            $state = \TravelRegion::firstOrNew(['id' => $id]);
            $state->name = $name;
            $state->state_id = $stateId;
            $state->save();
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
        return [];
    }
}
