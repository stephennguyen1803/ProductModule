<?php

class Image {
	
	const WORK_SPACE = 'Controller\Product';
	const MEDIA_ROOT = '/Media/';
	protected $currentDir;
	protected $mediaDir;
	
	public function __construct()
	{
		$this->currentDir = getcwd();
		$this->mediaDir = str_replace(self::WORK_SPACE,'',$this->currentDir) . self::MEDIA_ROOT;
	}
	
	/**
	* check file is image or not ?
	* @input $fileName//stores the name of the temporary file | $_FILES["fileToUpload"]["tmp_name"]
	* @return boolen
	**/
	public function checkImage($fileTmpName) {
		$check = getimagesize($fileTmpName);
		if($check !== false) {
			return true;
		} else {
			echo "File is not an image.";
			return false;
		}
	}
	
	/**
	* check type file is allow or not
	* @input $_FILES["fileToUpload"]["name"] //stores the original filename from the client
	* @return boolen
	**/
	public function checkImageType($fileName) {
		// Allow certain file formats
		$targetFile = $this->mediaDir. basename($fileName);
		$imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			return false;
		}
		return true;
	}
	
	/**
	* check size image > 5MB
	* @input $_FILES["fileToUpload"]["size"]
	* @output boolen
	**/
	public function checkImageSize($fileSize) {
		if ($fileSize > 500000) {
			echo "Sorry, your file is too large.";
			return false;
		}
		return true;
	}
	
	/**
	* check file exits or not
	* @input $_FILES["fileToUpload"]["name"] //stores the original filename from the client
	* @return boolen
	**/
	public function checkNotDuplicate($fileName) {
		$targetFile = $this->mediaDir. basename($fileName);
		if (file_exists($targetFile)) {
			echo "Sorry, file already exists.";	
			return false;
		}
		return true;
	}
	
	/**
	* Save image to folder MEDIA_ROOT
	* @input $_FILES["fileToUpload"], $nameFolder 
	**/
	public function saveImage($fileImage, $nameFolder = null) {
		$folderPath = $this->createChildrenFolder($nameFolder);
		if (empty($fileImage['tmp_name']))
		{
			return null;
		}
		if ($this->checkImage($fileImage['tmp_name']) 
			&& $this->checkImageType($fileImage['name']) 
			&& $this->checkImageSize($fileImage['size']) 
			&& $this->checkNotDuplicate($fileImage['name']))
		{
			$targetFile = $folderPath. basename($fileImage['name']);
			move_uploaded_file($fileImage['tmp_name'], $targetFile);
			return $targetFile;
		} else {
			echo "Sorry, there was an error uploading your file.";
			return null;
		}
	}
	
	
	public function createChildrenFolder($nameFolder = null)
	{
		$pathFolder = $this->mediaDir;
		if(!is_null($nameFolder)) {
			$pathFolder = $pathFolder.'/'.$nameFolder.'/';
			if (!file_exists($pathFolder)) {
				mkdir($pathFolder, 0777, true);
			}
		}
		return $pathFolder;
	}
}

/**
$currentDir = getcwd();
$target_dir = "/Media/";
$mediaDir  = str_replace('Catalog\Product','',$currentDir);
$target_file = $mediaDir. $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}**/
?>