<?php

namespace AcmeWidgetCo;

class ProductCatalog {
    private $products;

    public function __construct() {
        $this->products = [
            'R01' => 32.95,
            'G01' => 24.95,
            'B01' => 7.95,
        ];
    }

    public function getPrice($productCode) {
        return $this->products[$productCode] ?? 0;
    }
}
