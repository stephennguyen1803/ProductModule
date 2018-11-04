<?php 
include '../../Model/Catalog/Product/Product.php';
require '../../Model/Catalog/SessionProduct.php';

$session = new SessionProduct();
if(isset($_POST["create"])) {	
	$product = new Product($_POST, $_FILES);
	$productData = $product->getData();
	$_SESSION[$session::DATA][$_POST['sku']] = $productData;
} elseif($_POST['clear']){
	$_SESSION[$session::DATA] = null;
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>