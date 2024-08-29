# **Acme Widget Co - Shopping Basket System**

The system supports adding products to a basket, applying special offers, calculating the total cost including delivery charges, and running unit tests to verify the functionality. The project is containerized using Docker, ensuring a consistent development and testing environment.

## **Features**

- **Product Catalog**: The system includes a predefined product catalog with three products: Red Widget (R01), Green Widget (G01), and Blue Widget (B01).
- **Special Offers**: Supports a "buy one, get one half price" offer on Red Widgets (R01).
- **Delivery Charges**: Applies delivery charges based on the total order value:
  - Orders under $50: $4.95
  - Orders between $50 and $90: $2.95
  - Orders of $90 or more: Free delivery

### **Installation**

1. **Clone the repository**:
    ```bash
    git clone https://github.com/yourusername/acme-widget-co.git
    cd acme-widget-co
    ```

2. **Build the Docker Image**:
    ```bash
    docker-compose build
    ```

3. **Start the Docker Container**:
    ```bash
    docker-compose up
    ```

## **Testing**

### **Running Tests**

The project uses PHPUnit for testing. The test cases are located in the `tests/` directory, specifically in the `BasketTest.php` file.

1. **Run PHPUnit Tests**:
    - After starting the container, you can run the PHPUnit tests using:
    ```bash
    docker-compose exec app vendor/bin/phpunit tests
    ```
    - This command will execute the test cases defined in the `tests/BasketTest.php` file.

2. **Test Output**:
    - PHPUnit will output the results of the tests directly in the terminal, indicating which tests passed, failed, or were skipped.

### **Understanding and Modifying Test Cases**

The primary test cases are located in the `tests/BasketTest.php` file. These tests verify that the basket system correctly handles product additions, special offers, and delivery charges.

#### **Test Case Structure**

Each test case is a method in the `BasketTest` class and uses assertions to verify expected outcomes.

Example of a basic test case:

```php
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

        $this->assertEquals(54.37, $basket->total());
    }
}
```

#### **Key Components of a Test Case**

1. **Setup**:
    - The test case begins by setting up the necessary environment, such as creating instances of `ProductCatalog`, `Basket`, and applying special offers.

2. **Actions**:
    - The test case then performs actions like adding products to the basket.

3. **Assertions**:
    - Finally, the test case uses assertions (`$this->assertEquals`) to compare the expected outcome with the actual result produced by the system.

### **Adding a New Test Case**

To add a new test case:

1. **Create a New Method in `BasketTest.php`**:
    - Add a method with a descriptive name, such as `testMultipleItemsWithOffers`.

2. **Setup the Test Environment**:
    - Initialize the objects (`Basket`, `ProductCatalog`, etc.) and define any specific conditions you want to test.

3. **Perform Actions**:
    - Simulate user actions, like adding products to the basket.

4. **Add Assertions**:
    - Use assertions to verify that the system behaves as expected under the given conditions.

Example of a new test case:

```php
public function testMultipleItemsWithOffers() {
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
    $basket->add('G01');
    $basket->add('B01');

    $this->assertEquals(65.85, $basket->total());
}
```

### **Running Specific Tests**

You can run specific tests by using the `--filter` option with PHPUnit:

```bash
docker-compose exec app vendor/bin/phpunit --filter testBasketTotal tests
```

This command will only run the `testBasketTotal` method.

## **Usage**

### **Adding Products to the Basket**

You can add products to the basket using the `Basket` class. Here's an example:

```php
$basket = new AcmeWidgetCo\Basket($catalog, $deliveryCharges, $specialOffers);
$basket->add('R01');
$basket->add('G01');
$total = $basket->total();
echo "Total: $" . $total;
```

### **Applying Special Offers**

Special offers like "buy one, get one half price" on Red Widgets (R01) are automatically applied when you calculate the total:

```php
$specialOffers = [new AcmeWidgetCo\BuyOneGetOneHalfPrice('R01')];
$basket = new AcmeWidgetCo\Basket($catalog, $deliveryCharges, $specialOffers);
$basket->add('R01');
$basket->add('R01');
$total = $basket->total();
echo "Total with offer: $" . $total;
```

## **Docker Commands**

- **Rebuild the Docker Image**:
    ```bash
    docker-compose build
    ```

- **Start the Containers in Detached Mode**:
    ```bash
    docker-compose up
    ```

- **Stop and Remove Containers**:
    ```bash
    docker-compose down
    ```

## **Extending the System**

To add more features or products:

- **Add a New Product**: Modify the `ProductCatalog` class to include the new product and its price.
- **Add a New Offer**: Create a new offer class similar to `BuyOneGetOneHalfPrice` and add it to the special offers array when initializing the `Basket` class.
