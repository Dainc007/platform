<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class ProductsCopy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:products-copy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy products from second database to first database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::connection('second_mysql')->table('products')->orderBy('id')->chunk(1000, function ($products) {
            DB::connection('mysql')->transaction(function () use ($products) {
                DB::connection('mysql')->table('products')->insert($products->toArray());
            });
        });

        $this->info('Products copied successfully!');
    }
}
