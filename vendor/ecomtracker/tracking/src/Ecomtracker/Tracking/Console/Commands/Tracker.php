<?php

namespace Ecomtracker\Tracking\Console\Commands;
use Ecomtracker\Product\Models\Product as ParentProduct;
use Ecomtracker\Amazon\Models\Product as AmazonProduct;

use Illuminate\Console\Command;

class Tracker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracker:track-amazon-products
                            {--product_id= : The ID of the product model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Track All or individual Amazon product';

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
        $this->info('Command launched');

        $product_id = $this->option('product_id');
        $this->info('$product_id:'.$product_id);

        if ($product_id)
        {
            $AmazonProduct=AmazonProduct::find($product_id);
            $res=\Ecomtracker\Tracking\TrackingService::TrackOne($AmazonProduct->asin,$AmazonProduct->marketplace);
        }
        else
        {
            $res=\Ecomtracker\Tracking\TrackingService::TrackAll();
        }


    }
}
