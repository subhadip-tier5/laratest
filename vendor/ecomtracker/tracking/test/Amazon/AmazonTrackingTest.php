<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Ecomtracker\Tracking\AmazonService as AmazonService;

class AmazonTest extends TestCase
{
    use WithoutMiddleware;


    public function testTrack()
    {

        // some sample Amazon product
        $asin='B00I8BIBCW';
        $marketplace='com';


        $product_data=AmazonService::getProductData($asin,$marketplace);
        $this->assertArrayHasKey('ASIN', $product_data);



    }



}