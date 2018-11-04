<?php 

class Attributes {
	
	protected $productName;
	protected $productSku;
	protected $desciption;
	protected $origin;
	protected $factoryDate;
	protected $weight;
	protected $color;
	protected $storage;
	protected $sessionProduct;
	
	public function __construct(
		$productName,
		$productSku = null,
		$desciption = null,
		$origin = null,
		$factoryDate = null,
		$weight = null,
		$color = null,
		$storage = null
	) {
		$this->productName = $productName;
		$this->productSku  = $this->validateSku($productSku) ? $productSku: exit;
		$this->desciption = $desciption;
		$this->origin  = $origin;
		$this->factoryDate = $factoryDate;
		$this->weight  = $weight;
		$this->color = $color;
		$this->storage  = $storage;	
		$sessionProduct = new SessionProduct();
	}
	
	public function validateSku($productSku) {
		if (is_null($productSku)) {
			echo 'Please input sku product';
			return false;
		}
		
		if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $productSku))
		{
			echo 'Please not use special key';
			return false;
		}
		
		if (isset($_SESSION['PRODUCTS'][$productSku])) {
			echo 'Duplicate SKU. Please check it again';
			return false;
		}
		return true;
	}
	/**
	*@return array attribure
	**/
	public function getAttributes(){
		return [
			'name' => $this->productName,
			'sku'  => $this->productSku,
			'desciption' => $this->desciption,
			'origin'	=> $this->origin,
			'factoryDate' => $this->factoryDate,
			'weight' => $this->weight,
			'color' => $this->color,
			'storage' => $this->storage
		];
	}
	
	public function getSku()
	{
		return $this->productSku;
	}
}