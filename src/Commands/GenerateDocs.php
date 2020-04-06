<?php

namespace AnsJabar\LaraDocs\Commands;

use Illuminate\Console\Command;
use AnsJabar\LaraDocs\Generator;

class GenerateDocs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laradocs:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the API documentation from Annotations';

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
     * @return mixed
     */
    public function handle()
    {
        (new Generator)->generate();
        $this->info('Documentation generated.');
    }
}
