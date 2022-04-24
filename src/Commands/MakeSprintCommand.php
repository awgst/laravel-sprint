<?php

namespace Awgst\Sprint\Commands;

use Illuminate\Console\Command;
use Awgst\Sprint\Generators\ModuleGenerator;
use Awgst\Sprint\Modules\Module;
use Symfony\Component\Console\Input\InputArgument;

class MakeSprintCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sprint:init {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for init a sprint';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');

        $module = new Module($name);
        $generator = new ModuleGenerator($module);

        $success = $generator->generate();

        if ($success) {
            $this->info("Successfully initialize {$name}");
        } else {
            $this->error($GLOBALS['SPRINT_ERRORS']);
        }

        return $success;
    }
}