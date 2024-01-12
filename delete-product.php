<?php

require 'src/connection.php';
require 'src/repository/ProductRepository.php';

$id = $_POST['id'];

$repository = new ProductRepository($pdo);
$repository->deleteProduct($id);

header('Location: admin.php');
exit();
