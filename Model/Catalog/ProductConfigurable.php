<?php 

class ProductConfigurable
{
	public function getSimpleProduct($productCollections)
	{
		$simpleProduct = [];
		if(is_null($productCollections)) {
			return $simpleProduct;
		}
		foreach($productCollections as $product) {
			if ($product['type-product'] === 'simple' && $product['color'] != 'No' && $product['storage'] != 'No' ) {
				$simpleProduct[] = [
					'sku' => $product['sku'],
					'color' => $product['color'],
					'storage' => $product['storage']
				];
			}
		}
		return $simpleProduct;
	}
	
	
	public function getChildrenSimpleProduct($productCollections)
	{
		$simpleProduct = [];
		if(is_null($productCollections)) {
			return $simpleProduct;
		}
		foreach($productCollections as $product) {
			if ($product['type-product'] === 'simple' && $product['color'] != 'No' && $product['storage'] != 'No' ) {
				$simpleProduct[$product['sku']] = [
					'color' => $product['color'],
					'storage' => $product['storage']
				];
			}
		}
		return $simpleProduct;
	}
}