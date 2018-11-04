<?php 
	require '../../Model/Catalog/SessionProduct.php';
	require '../../Model/Catalog/ProductConfigurable.php';
	$sessionProduct = new SessionProduct();
	
?>
<?php if (empty($_GET) && empty($_GET['sku'])) : ?>
WRONG DATA OR NOT EXIT PRODUCT
<?php else : ?>
	<?php if(!empty($sessionProduct->getProductBySku($_GET['sku']))) {
		$productData = $sessionProduct->getProductBySku($_GET['sku']);
		if ($productData['type-product'] === 'configurable') {
			$configurableData = new ProductConfigurable();
			$childrenProduct = $configurableData->getChildrenSimpleProduct($sessionProduct->getProductCollections());
	?>
	<?php 	if( empty($_GET['color']) && empty($_GET['storage'])) { 
			$collorOption = [];
			$storageOption = [];
			foreach($productData['childrenProduct'] as $atributeData) {
				$sku = explode('-',$atributeData,2)[0];
				$collorOption[] = $childrenProduct[$sku]['color'];
				$storageOption[] = $childrenProduct[$sku]['storage'];
			}
	?>
		
		<form action="ProductDetail.php" method="GET" enctype="multipart/form-data">
		<h2>Select Option to view product</h2>
			<input type='hidden' name='sku' value='<?php echo $_GET['sku']; ?>' >
			<div class='field-wrap'>
				<span class='label'>Color</span>
				<select name='color'>
					<?php foreach ($collorOption as $data) : ?>
						<option value='<?php echo $data; ?>'>
							<?php echo $data; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class='field-wrap'>
				<span class='label'>Storage</span>
				<select name='storage'>
					<?php foreach ($storageOption as $data) : ?>
						<option value='<?php echo $data; ?>'>
							<?php echo $data; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
		<input type ="submit" />
	</form>
	<?php } else { 
			$childrenSKU = null;
			foreach($productData['childrenProduct'] as $atributeData) {
				$data = explode('-',$atributeData,3);
				$sku = $data[0];
				$color = $data[1];
				$storage = $data[2];
				if ($color === $_GET['color'] && $storage === $_GET['storage']) {
					$childrenSKU = $sku;
				}
			}
			if (is_null($childrenSKU)) {
				echo 'Product Not Available';
				exit;
			} else {
				$productDataChilren = $sessionProduct->getProductBySku($childrenSKU);
			}
	?>
		<ul class='gallery'>
		<?php if (is_null($productDataChilren['gallery']['default_image'])) : ?>
				<li>NO IMAGE</li>
			<?php else : ?>
				<li><img src="<?php echo $productDataChilren['gallery']['default_image'] ?>" height="42" width="42"></li>
		<?php endif; ?>
		<?php if (is_null($productDataChilren['gallery']['base_image'])) : ?>
				<li>NO IMAGE</li>
			<?php else : ?>
				<li><img src="<?php echo$productDataChilren['gallery']['base_image'] ?>"  height="42" width="42"></li>
		<?php endif; ?>
		<?php if (is_null($productDataChilren['gallery']['thumnail'])) : ?>
				<li>NO IMAGE</li>
			<?php else : ?>
				<li><img src="<?php echo $productDataChilren['gallery']['thumnail'] ?>"  height="42" width="42"></li>
		<?php endif; ?>
		</ul>
		<div>
		<span>Product Name: </span> 
			<?php echo $productData['name']; ?>
		</div>
		<div>
			<span>Product Sale Price: </span> 
			<?php echo $productDataChilren['price']['salePrice']; ?>
		</div>
		<div>
			<span>Product Description: </span> 
			<?php echo $productDataChilren['desciption']; ?>
		</div>
		<div>
			<span>Product Factory Date: </span> 
			<?php echo $productDataChilren['factoryDate']; ?>
		</div>
		<div>
			<span>Product Weigth: </span> 
			<?php echo $productDataChilren['weight']; ?>
		</div>
	<?php } ?>
	<?php } else { ?>
		<ul class='gallery'>
		<?php if (is_null($productData['gallery']['default_image'])) : ?>
				<li>NO IMAGE</li>
			<?php else : ?>
				<li><img src="<?php echo $productData['gallery']['default_image'] ?>" height="42" width="42"></li>
		<?php endif; ?>
		<?php if (is_null($productData['gallery']['base_image'])) : ?>
				<li>NO IMAGE</li>
			<?php else : ?>
				<li><img src="<?php echo $productData['gallery']['base_image'] ?>"  height="42" width="42"></li>
		<?php endif; ?>
		<?php if (is_null($productData['gallery']['thumnail'])) : ?>
				<li>NO IMAGE</li>
			<?php else : ?>
				<li><img src="<?php echo $productData['gallery']['thumnail'] ?>"  height="42" width="42"></li>
		<?php endif; ?>
		</ul>
		<div>
			<span>Product Name: </span> 
			<?php echo $productData['name']; ?>
		</div>
		<div>
			<span>Product Sale Price: </span> 
			<?php echo $productData['price']['salePrice']; ?>
		</div>
		<div>
			<span>Product Description: </span> 
			<?php echo $productData['desciption']; ?>
		</div>
		<div>
			<span>Product Factory Date: </span> 
			<?php echo $productData['factoryDate']; ?>
		</div>
		<div>
			<span>Product Weigth: </span> 
			<?php echo $productData['weight']; ?>
		</div>
		<div>
			<span>Product Color: </span> 
			<?php echo $productData['color']; ?>
		</div>
		<div>
			<span>Product Storage: </span> 
			<?php echo $productData['storage']; ?>
		</div>
	<?php }; ?>
	<?php } else {  echo 'Do not exit this product'; }?>
<?php endif; ?>