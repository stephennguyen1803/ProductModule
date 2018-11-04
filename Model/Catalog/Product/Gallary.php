<?php
require 'Image.php';
class Gallary extends Image 
{
	const BASE_IMAGE = 'base_image';
	const DEFAULT_IMAGE = 'default_image';
	const THUMNAIL = 'thumnail';
	
	/**
	* using to save image for product
	* @input fileImage($_FILE), product SKU, type image ('base_image, default_image, ...)
	* @output return url image
	**/
	public function saveImageProduct($fileImage, $productSKU, $typeImage = self::DEFAULT_IMAGE) {
		$folderName = $typeImage;
		if(!is_null($productSKU)) {
			$folderName = $productSKU.'/'.$typeImage;
		}
		if (!is_null($this->saveImage($fileImage, $folderName))) {
			return $this->siteURL().$folderName.'/'.$fileImage['name'];
		}	
		return null;
	}
	
	
	public function siteURL() 
	{
		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || 
		$_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$domainName = $_SERVER['HTTP_HOST'];
		$dataServer = explode('/',$_SERVER['REQUEST_URI']);
		return $protocol.$domainName.'/'.$dataServer[1].'/Media/';
	}
}
?>