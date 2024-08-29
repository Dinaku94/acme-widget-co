<?php

namespace AcmeWidgetCo;

class BuyOneGetOneHalfPrice {
    private $productCode;

    public function __construct($productCode) {
        $this->productCode = $productCode;
    }

    public function apply(array $products, $total) {
        $count = array_count_values($products);
        
        if (isset($count[$this->productCode])) {
            $halfPriceItems = floor($count[$this->productCode] / 2);
            $productPrice = $this->getProductPrice($this->productCode);
            
            // Apply half-price discount and round it before subtracting
            $total -= round($halfPriceItems * ($productPrice / 2), 2);
        }
        
        return $total;
    }

    private function getProductPrice($productCode) {
        $prices = [
            'R01' => 32.95,
            'G01' => 24.95,
            'B01' => 7.95
        ];
        return $prices[$productCode] ?? 0;
    }
}
