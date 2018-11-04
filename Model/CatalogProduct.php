<?php 

class CatalogProduct
{
	public function getAvailableProduct($productCollections)
	{
		$products = [];
		if(is_null($productCollections)) {
			return $products;
		}
		foreach($productCollections as $product) {
			if (($product['type-product'] === 'simple') || ($product['type-product'] === 'configurable') && !empty($product['childrenProduct'])) {
				$products[] = [
					'sku' => $product['sku'],
					'name' =>  $product['name'],
					'urlImage' => empty($product['gallery']['default_image']) ? null : $product['gallery']['default_image'],
					'price' => $product['price']['salePrice']
				];
			}
		}
		return $products;
	}
}