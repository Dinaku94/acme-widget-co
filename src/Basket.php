<?php

namespace AcmeWidgetCo;

class Basket {
    private $products = [];
    private $catalog;
    private $deliveryCharges;
    private $specialOffers;

    public function __construct(ProductCatalog $catalog, array $deliveryCharges, array $specialOffers) {
        $this->catalog = $catalog;
        $this->deliveryCharges = $deliveryCharges;
        $this->specialOffers = $specialOffers;
    }

    public function add($productCode) {
        $this->products[] = $productCode;
    }

    public function total() {
        $total = 0;

        // Calculate total price of products
        foreach ($this->products as $productCode) {
            $total += $this->catalog->getPrice($productCode);
        }

        // Apply offers and round after applying each offer
        foreach ($this->specialOffers as $offer) {
            $total = round($offer->apply($this->products, $total), 2);
        }

        // Add delivery charge and round it
        $total += round($this->getDeliveryCharge($total), 2);

        // Round the final total to two decimal places
        return round($total, 2);
    }

    private function getDeliveryCharge($total) {
        foreach ($this->deliveryCharges as $amount => $charge) {
            if ($total < $amount) {
                return $charge;
            }
        }
        return 0;
    }
}
