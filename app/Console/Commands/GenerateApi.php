<?php

namespace App\Console\Commands;

use App\ApiGenerator;
use Illuminate\Console\Command;

class GenerateApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'generate:api';
    protected $signature = 'generate:api {--m=}';
    protected $model;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'REST Api Generator With API Resources & FormRequest';

    // public function __construct()
    // {
    //     parent::__construct();
    // }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->model = $this->option('m');
        if (empty($this->model)) {
            $this->error('Nama Argument tidak data!');

            return false;
        }
        if (!file_exists(base_path('app/Models/' . $this->model . '.php'))) {
            $this->error($this->model . ' tidak ditemukan');

            return false;
        }
        $this->info('Model ditemulkan');
        $this->info(base_path());
        $api = new ApiGenerator($this->model);
        $controller = $api->generateController();
        if ($controller) {
            $this->info('Controller Berhasil dibuat!');
        } else {
            $this->error('Controller Sudah ada!');
        }
        $resource = $api->generateResource();
        if ($resource) {
            $this->info('Resource Berhasil dibuat!');
        } else {
            $this->error('Resource Sudah ada!');
        }

        $request = $api->generateRequest();
        if ($request) {
            $this->info('Request Berhasil dibuat!');
        } else {
            $this->error('Request Sudah ada!');
        }


        $collection = $api->generateCollection();
        if ($collection) {
            $this->info('Collection Berhasil dibuat!');
        } else {
            $this->error('Collection Sudah ada!');
        }

        // $route = $api->generateRoute();
        // if ($route) {
        //     $this->info('Route Berhasil ditambahkan!');
        // } else {
        //     $this->error('Route Sudah ada!');
        // }

        $this->info('Api Created SuccessFully!');


        return true;
    }
}
