<?php

use Illuminate\Console\Command;

class DevCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'dev';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run other commands for devs';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->call('ide-helper:generate');
        $this->call('ide-helper:models', ['--nowrite' => 'No']);
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
