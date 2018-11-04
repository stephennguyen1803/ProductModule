<?php 
class SessionProduct 
{
	const DATA = 'PRODUCTS';
	
	public function __construct()
	{
		if(!isset($_SESSION)) {
			session_start(); 
		}
		if (empty($_SESSION[self::DATA])) {
			$_SESSION[self::DATA] = null;
		}
	}
	
	public function getProductCollections()
	{
		return $_SESSION[self::DATA];
	}
	
	public function getProductBySku($sku){
		return empty($_SESSION[self::DATA][$sku]) ? null : $_SESSION[self::DATA][$sku];
	}
}
?>