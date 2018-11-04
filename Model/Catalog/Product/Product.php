<?php 

include 'Price.php';
include 'Attributes.php';
include 'Gallary.php';

class Product {
	
	protected $attributesProduct;
	protected $priceData;
	protected $typeProduct;
	protected $parentProduct;
	protected $childrenProduct;
	protected $images;
	
	public function __construct (
		$request,
		$fileImage
	)
	{
		$this->typeProduct = $request['type-product'];
		if ($this->typeProduct === 'simple') {
			$this->attributesProduct = new Attributes( 
			$request['name'], $request['sku'], $request['desciption'], $request['origin'],
				$request['factoryDate'], $request['weight'], $request['color'], $request['storage']
				);
		} else {
			$this->attributesProduct = new Attributes( 
			$request['name'], $request['sku'], $request['desciption'], $request['origin'],
				$request['factoryDate'], $request['weight']);
				
			if ($this->validateChildrenProduct($request['childrenProduct'])) {
				$this->childrenProduct = $request['childrenProduct'];
			} else {
				echo 'Error Children product with the same attribute';
			}
	
		}
		$this->priceData = new Price();
		$this->priceData->setSalePrice($request['sales_price']);
		$this->priceData->setMarketPrice($request['market_price']);
		$this->parentProduct = ($request['type-product'] === 'configurable');
		//$this->childrenProduct = $childrenProduct;*/
		
		$this->images = $fileImage;
		$this->gallery = new Gallary(); 
	}
	
	public function getData()
	{
		$productData = $this->attributesProduct->getAttributes();
		$productData['price'] = [
			'salePrice' => $this->priceData->getSalePrice(),
			'marketPrice' => $this->priceData->getMarketPrice(),
		];
		$productData['type-product'] = $this->typeProduct;
		//$productData['parentProduct'] = $this->parentProduct;
		$productData['childrenProduct'] = $this->childrenProduct;
		$productData['gallery'] = $this->getImagesProduct($this->images);
		return $productData;
	}
	
	
	public function getImagesProduct(array $imagesData)
	{
		$gallery = [];
		$sku = $this->attributesProduct->getSku();
		if (!is_null($imagesData["base_image"])) {
			$gallery['base_image'] = $this->gallery ->saveImageProduct($imagesData["base_image"],$sku,'base_image');
		}
		if (!is_null($imagesData["default_image"])){
			$gallery['default_image'] = $this->gallery ->saveImageProduct($imagesData["default_image"],$sku,'default_image');
		}
		if (!is_null($imagesData["thumnail"])) {
			$gallery['thumnail'] = $this->gallery ->saveImageProduct($imagesData["thumnail"],$sku,'thumnail');
		}
		return $gallery;
	}
	
	protected function validateChildrenProduct($childrenProducts)
	{
		$data = [];
		foreach ($childrenProducts as $product) {
			$attributesData = explode('-',$product,2)[1];
			if (in_array($attributesData,$data)) {
				return false;
			}
			$data[] = $attributesData;
		}
		return true;
	}
}