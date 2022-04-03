<?php

namespace App\Console\Commands;

use App\Models\Vehicle;
use Illuminate\Console\Command;
use Illuminate\Console\Concerns\InteractsWithIO;

class VehicleParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vehicle:parse 
                            {path? : Xml file path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsing an xml file to add, edit and delete vehicles';

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
     */
    public function handle()
    {
        $filePath = $this->argument('path') ?? storage_path('app/public/default_parser_data.xml');

        $this->info("Start parse $filePath");
        $xml_string = file_get_contents($filePath);

        $bar = $this->output->createProgressBar();
        $parseResult = Vehicle::createFromXml($xml_string, $bar);

        $this->info("\n---FINISH---");
        $this->info('Total count of vehicles processed: ' . $parseResult['parseCount']);
        $this->info('Count of vehicles added: ' . $parseResult['addCount']);
        $this->info('Count of updated vehicles: ' . $parseResult['updateCount']);
        $this->info('Count of deleted vehicles: ' . $parseResult['deleteCount']);
    }
}
