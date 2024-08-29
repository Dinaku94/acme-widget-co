<?php

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Basket;
use AcmeWidgetCo\BuyOneGetOneHalfPrice;
use AcmeWidgetCo\ProductCatalog;

class BasketTest extends TestCase {

    public function testBasketTotal() {
        $catalog = new ProductCatalog();
        $deliveryCharges = [
            50 => 4.95,
            90 => 2.95,
            99999 => 0,
        ];
        $specialOffers = [
            new BuyOneGetOneHalfPrice('R01')
        ];

        $basket = new Basket($catalog, $deliveryCharges, $specialOffers);
        $basket->add('R01');
        $basket->add('R01');

        // Round the total to two decimal places
        $this->assertEquals(54.37, round($basket->total(), 2));
    }

    public function testBasketMultipleItems() {
        $catalog = new ProductCatalog();
        $deliveryCharges = [
            50 => 4.95,
            90 => 2.95,
            99999 => 0,
        ];
        $specialOffers = [
            new BuyOneGetOneHalfPrice('R01')
        ];

        $basket = new Basket($catalog, $deliveryCharges, $specialOffers);
        $basket->add('B01');
        $basket->add('B01');
        $basket->add('R01');
        $basket->add('R01');
        $basket->add('R01');

        $this->assertEquals(98.27, round($basket->total(), 2));
    }
}
