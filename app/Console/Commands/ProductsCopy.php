<?php

namespace App\Console\Commands;

use App\Models\Product;
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
    protected $i = 0;

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
        $connection = DB::connection('mysql')->table('products');
        $scndConnection = DB::connection('second_mysql');

//        dd($connection->count(), $scndConnection->table('products')->count());

//        $scndConnection->table('products')
//            ->orderBy('id')
//            ->each(function ($product) use ($connection) {
//                $connection->insertOrIgnore((array)$product);
//                echo $product->id . PHP_EOL;
//            });

//        DB::connection('second_mysql')->table('products')
//            ->orderBy('id')->chunk(1000, function ($products)  {
//                // Przekonwertuj produkty na tablicę
//                $dataToInsert = [];
//
//                foreach ($products as $product) {
//                    $dataToInsert[] = (array)$product; // Dodaj każdy produkt do tablicy
//                }
//                $this->i++;
//
//                // Wstaw wszystkie produkty jednocześnie, ignorując istniejące
//                DB::connection('mysql')->table('products')->insertOrIgnore($dataToInsert);
//                echo $this->i . PHP_EOL;
//            });

        $this->info('Products copied successfully!');
    }
}
