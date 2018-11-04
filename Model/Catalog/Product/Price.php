<?php 

require 'PriceInterface.php';

class Price implements PriceInterface {
	
	const CURRENCY = '$';
	
	protected $salePrice;
	
	protected $marketPrice;
	
	protected $currency;
	
	public function setSalePrice($price)
	{
		if(is_numeric($price)) {
			$this->salePrice = $this->getCurrentcy(). round($price,2);
		} else {
			echo 'wrong format number';
		}

	}
	
	public function setMarketPrice($price)
	{
		if(is_numeric($price)) {
			$this->marketPrice = $this->getCurrentcy(). round($price,2);
		} else {
			echo 'wrong format number';
		}
	}
	
	public function getSalePrice()
	{
		return $this->salePrice;
	}
	
	public function getMarketPrice()
	{
		return $this->marketPrice;
	}
	
	public function getCurrentcy()
	{
		return self::CURRENCY;
	}
	
}

?>