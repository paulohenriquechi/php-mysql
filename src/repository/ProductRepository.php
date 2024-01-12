<?php

class ProductRepository
{
    private PDO $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    private function setProduct($product) : Product {
        return new Product(
            $product['id'],
            $product['type'],
            $product['name'],
            $product['description'],
            $product['price'],
            $product['image']
        );
    }

    public function allProducts() : array {
        $productsQuery = "SELECT * FROM products ORDER BY price";
        $statement = $this->pdo->query($productsQuery);
        $productsList = $statement->fetchAll();

        $products = array_map(function ($product){
            return $this->setProduct($product);
        }, $productsList);

        return $products;
    }

    public function coffeeOptions() : array {
        $coffeeProductsQuery = "SELECT * FROM products WHERE type = 'Cafe' ORDER BY price ASC";
        $statement = $this->pdo->query($coffeeProductsQuery);
        $coffeeProductsList = $statement->fetchAll();

        $coffeeProducts = array_map(function ($coffeeProduct){
            return $this->setProduct($coffeeProduct);
        }, $coffeeProductsList);

        return $coffeeProducts;
    }

    public function lunchOptions() : array {
        $lunchProductsQuery = "SELECT * FROM products WHERE type = 'Almoco' ORDER BY price ASC";
        $statement = $this->pdo->query($lunchProductsQuery);
        $lunchProductsList = $statement->fetchAll();

        $lunchProducts = array_map(function ($lunchProduct){
            return $this->setProduct($lunchProduct);
        }, $lunchProductsList);

        return $lunchProducts;
    }

    public function createProduct(Product $product) : void {
        $createQuery = "INSERT INTO products (type, name, description, price, image) VALUES (:type, :name, :description, :price, :image)";
        $statement = $this->pdo->prepare($createQuery);
        $statement->execute([
            ':type' => $product->getType(),
            ':name' => $product->getName(),
            ':description' => $product->getDescription(),
            ':price' => $product->getPrice(),
            ':image' => $product->getImage()
        ]);
    }

    public function editProduct(Product $product) : void {
        $editQuery = "UPDATE products SET type = :type, name = :name,description = :description, price = :price, image = :image WHERE id = :id;";
        $statement = $this->pdo->prepare($editQuery);
        $statement->execute([
            ':type' => $product->gettype(),
            ':name' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'image' => $product->getImage(),
            'id' => $product->getId()
        ]);
    }
    
    public function getProduct(int $id) : Product {
        $getQuery = "SELECT * FROM products WHERE id = ?";
        $statement = $this->pdo->prepare($getQuery);
        $statement->bindValue(1, $id);
        $statement->execute();
        $product = $statement->fetch();
        
        return $this->setProduct($product);
    }

    public function deleteProduct(int $id) : void {
        $deleteQuery = "DELETE FROM products WHERE id = ?";
        $statement = $this->pdo->prepare($deleteQuery);
        $statement->bindValue(1, $id);
        $statement->execute();
    }
}