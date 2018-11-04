<?php
	require 'Model/Catalog/SessionProduct.php';
	require 'Model/DataOptions.php';
	require 'Model/Catalog/ProductConfigurable.php';
	require 'Model/CatalogProduct.php';
	
	$optionData = new DataOptions();

	$sessionProduct = new SessionProduct();
	$colorOptions = $optionData::COLOR_OPTIONS;
	$storageOptions = $optionData:: STORAGE_OPTIONS;
	$typeProduct = $optionData::TYPE_PRODUCT;
	
	$configurableProducts = new ProductConfigurable();
	$simpleProducts = $configurableProducts->getSimpleProduct($sessionProduct->getProductCollections());
	$catalogProducts = new CatalogProduct();
	$productCollections = $catalogProducts->getAvailableProduct($sessionProduct->getProductCollections());


?>
<?php if (empty($_GET)) : ?>
	<form action="index.php" method="GET" enctype="multipart/form-data">
		<div class='field-wrap'>
			<span class='label'>Type Product</span>
			<select name='type-product'>
				<?php foreach ($typeProduct as $value => $label) : ?>
					<option value='<?php echo $value; ?>'>
						<?php echo $label; ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		<input type = "submit" />
	</form>
<?php else : ?>
<html>
<?php if ($_GET['type-product'] == 'simple') : ?>
	<body>
		<form action="Controller\Product\CreateProduct.php" method="post" enctype="multipart/form-data">
			<input type='hidden' name='type-product' value='<?php echo $_GET['type-product'] ?>' />
			<div class='product-data'>
				<div class='field-wrap'>
					<span class='label'>Name</span>
					<input type="text" name="name" required id="name"/>
				</div>
				<div class='field-wrap'>
					<span class='label'>SKU</span>
					<input type="text" name="sku" required id="name"/>
				</div>
				<div class='field-wrap'>
					<span class='label'>Desciption</span>
					<textarea name='desciption' rows="4" cols="50"></textarea>
				</div>
				<div class='field-wrap'>
					<span class='label'>Origin</span>
					<input type="text" name="origin" id="origin"/>
				</div>
				<div class='field-wrap'>
					<span class='label'>Factory Date</span>
					<input type="date" name="factoryDate" id="factoryDate"/>
				</div>
				<div class='field-wrap'>
					<span class='label'>Weight</span>
					<input type="number" name="weight" id="weight"/>
				</div>
				<div class='field-wrap'>
					<span class='label'>Market Price</span>
					<input type="number" name="market_price" id="market_price"/>
				</div>
				<div class='field-wrap'>
					<span class='label'>Sales Price</span>
					<input type="number" name="sales_price" id="sales_price"/>
				</div>
				<div class='field-wrap'>
					<span class='label'>Color</span>
					<select name='color'>
						<?php foreach ($colorOptions as $value => $label) : ?>
							<option value='<?php echo $value; ?>'>
								<?php echo $label; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class='field-wrap'>
					<span class='label'>Storage</span>
					<select name='storage'>
						<?php foreach ($storageOptions as $value => $label) : ?>
							<option value='<?php echo $value; ?>'>
								<?php echo $label; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class='base-image'> 
				Select base image to upload:
				<input type="file" name="base_image" id="base_image">
			</div>
			<div class='default-image'> 
				Select default image to upload:
				<input type="file" name="default_image" id="default_image">
			</div>
			<div class='thumnail-image'> 
				Select default image to upload:
				<input type="file" name="thumnail" id="thumnail">
			</div>
			<input type="submit" value="Create Product" name="create">
			<input type="submit" value="Clear All" name="clear">
		</form>
	</body>
<?php elseif($_GET['type-product'] == 'configurable') : ?>
	<?php if (empty($simpleProducts)) : ?>
		<h1>Do not have any simple product to create configurable product</h1>
	<?php else : ?>
		<form action="Controller\Product\CreateProduct.php" method="post" enctype="multipart/form-data">
			<input type='hidden' name='type-product' value='<?php echo $_GET['type-product'] ?>' />
			<div class='product-data'>
				<div class='field-wrap'>
					<span class='label'>Name</span>
					<input type="text" name="name" required id="name"/>
				</div>
				<div class='field-wrap'>
					<span class='label'>SKU</span>
					<input type="text" name="sku" required id="name"/>
				</div>
				<div class='field-wrap'>
					<span class='label'>Desciption</span>
					<textarea name='desciption' rows="4" cols="50"></textarea>
				</div>
				<div class='field-wrap'>
					<span class='label'>Origin</span>
					<input type="text" name="origin" id="origin"/>
				</div>
				<div class='field-wrap'>
					<span class='label'>Factory Date</span>
					<input type="date" name="factoryDate" id="factoryDate"/>
				</div>
				<div class='field-wrap'>
					<span class='label'>Weight</span>
					<input type="number" name="weight" id="weight"/>
				</div>
				<div class='field-wrap'>
					<span class='label'>Market Price</span>
					<input type="number" name="market_price" id="market_price"/>
				</div>
				<div class='field-wrap'>
					<span class='label'>Sales Price</span>
					<input type="number" name="sales_price" id="sales_price"/>
				</div>
				<div class='field-wrap'>
					<span class='label'>Simple Product</span>
					<select name='childrenProduct[]' multiple>
						<?php foreach ($simpleProducts as $product) : ?>
							<option value='<?php echo $product['sku'].'-'.$product['color'].'-'.$product['storage']; ?>'>
								<?php echo $product['sku'].'-'.$product['color'].'-'.$product['storage']; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class='base-image'> 
				Select base image to upload:
				<input type="file" name="base_image" id="base_image">
			</div>
			<div class='default-image'> 
				Select default image to upload:
				<input type="file" name="default_image" id="default_image">
			</div>
			<div class='thumnail-image'> 
				Select default image to upload:
				<input type="file" name="thumnail" id="thumnail">
			</div>
			<input type="submit" value="Create Product" name="create">
			<input type="submit" value="Clear All" name="clear">
		</form>
	<?php endif; ?>	
<?php endif; ?>
</html>
<?php endif; ?>
<?php if(!empty($productCollections)) : ?>
<ul class='product-list'>
<?php foreach ($productCollections as $product) : ?>
	<li>
		<a href='Controller/Product/ProductDetail.php?sku=<?php echo $product['sku'] ?>'>
			<?php if (is_null($product['urlImage'])) : ?>
				NO IMAGE
			<?php else : ?>
				<div><img src="<?php echo $product['urlImage'] ?>" alt="Smiley face" height="42" width="42"></div>
			<?php endif; ?>
			<div>
				<span>Product Name: </span> 
				<?php echo $product['name']; ?>
			</div>
			<div>
				<span>Product Price: </span> 
				<?php echo $product['price']; ?>
			</div>
		</a>
	</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>