<?php
interface PriceInterface {	
	/**
	**/
	public function setSalePrice($salePrice);
	
	public function setMarketPrice($marketPrice);
	
	public function getSalePrice();
	
	public function getMarketPrice();
	
	public function getCurrentcy();
}
?>