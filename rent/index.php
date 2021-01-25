<?php
$subtitle = 'Rent';
$nav = "bike";
$root = "../";
include $root . 'header.php';

include $root . 'db.php';

$sql_types = "SELECT * FROM models_types";
$sql_brands = "SELECT * FROM brands";
$sql_models = "SELECT 
models.model AS model, 
models.type AS types, 
brands.brand AS brand, 
models.product_code AS product_code, 
models.price AS price,
models.img AS img 
FROM models 
INNER JOIN brands ON models.brand = brands.id";

$search = $sort = null;
if (isset($_GET['search'])) {
	$search = $_GET['search'];
	$sql_models = $sql_models . " WHERE (models.model like '$search' OR brands.brand like '$search')";
}

if (isset($_GET['type'])){
	$result_types = $connect->query($sql_types);
	if ($row = $result_types->fetch_assoc()){
		$sql_models = $sql_models . " WHERE models.type='$row[ID])'";
	}
}

if (isset($_GET['brand'])){
	$result_brands = $connect->query($sql_brands);
	if ($row = $result_brands->fetch_assoc()){
		$sql_models = $sql_models . " WHERE models.brand='$row[ID])'";
	}
}

if (isset($_GET['model'])){
	$sql_models = $sql_models . " WHERE models.model='$_GET[model])'";
}


if (isset($_GET['sort'])) {
	$sort = $_GET['sort'];
	if ($sort == 'price_asc') {
		$sql_models = $sql_models . " ORDER BY models.price";
	} else if ($sort == 'price_des') {
		$sql_models = $sql_models . " ORDER BY models.price DESC";
	} else if ($sort == 'name_asc') {
		$sql_models = $sql_models . " ORDER BY brands.brand, models.model";
	} else if ($sort == 'name_des') {
		$sql_models = $sql_models . " ORDER BY brands.brand DESC, models.model DESC";
	}
} else {
	$sql_models = $sql_models . " ORDER BY year_of_production DESC";
}

$result_types = $connect->query($sql_types);
$result_brands = $connect->query($sql_brands);
$result_models = $connect->query($sql_models);

?>

<link rel="stylesheet" type="text/css" href="<?php echo $root ?>assets/css/form.css">

<body>

	<?php include $root . 'navbar.php' ?>
	<section>
		<?php include $root . 'sidenavigation.php' ?>
		<div class="container my-4">
			<div class="row">
				<div class="col-lg-auto pl-0">
					<form>
						<div class="content-nav sub-content">
							<div class="content-nav-section">
								<div class="content-nav-title">Types</div>
								<div class="content-nav-list">
									<?php
									if (!empty($result_types) && $result_types->num_rows > 0) {
										// output data of each row
										while ($row = $result_types->fetch_assoc()) {
									?>
											<div class="custom-control custom-checkbox custom-checkbox-sunshine">
												<input type="checkbox" class="custom-control-input custom-control-input-sunshine" id="<?php echo $row['type'] ?>" name="type" value="<?php echo $row['type'] ?>" <?php if (isset($_GET['type']) && !strcmp($_GET['type'], $row['type'])) { echo 'checked'; } ?>>
												<label class="custom-control-label" for="<?php echo $row['type'] ?>" ><?php echo $row['type'] ?></label>
											</div>
									<?php }
									} ?>
								</div>
							</div>
							<div class="content-nav-section">
								<div class="content-nav-title">Brands</div>
								<div class="content-nav-list">
									<?php									
									if (!empty($result_brands) && $result_brands->num_rows > 0) {
										// output data of each row
										while ($row = $result_brands->fetch_assoc()) {
									?>
											<div class="custom-control custom-checkbox custom-checkbox-sunshine">
												<input type="checkbox" class="custom-control-input custom-control-input-sunshine" id="<?php echo $row['brand'] ?>" name="brand" value="<?php echo $row['brand'] ?>" 
												<?php if (isset($_GET['brand']) && !strcmp($_GET['brand'], $row['brand'])) { echo 'checked'; } ?>>
												<label class="custom-control-label" for="<?php echo $row['brand'] ?>"><?php echo $row['brand'] ?></label>
											</div>
									<?php }
									} ?>
								</div>
							</div>
							<div class="content-nav-section">
								<div class="content-nav-title">Models</div>
								<div class="content-nav-list">
									<?php
									if (!empty($result_models) && $result_models->num_rows > 0) {
										// output data of each row
										while ($row = $result_models->fetch_assoc()) {
									?>
											<div class="custom-control custom-checkbox custom-checkbox-sunshine">
												<input type="checkbox" class="custom-control-input custom-control-input-sunshine" id="<?php echo $row['model'] ?>" name="model" value="<?php echo $row['model'] ?>" <?php if (isset($_GET['model']) && !strcmp($_GET['model'], $row['model'])) { echo 'checked'; } ?>>
												<label class="custom-control-label" for="<?php echo $row['model'] ?>"><?php echo $row['model'] ?></label>
											</div>
									<?php }
									} ?>
								</div>
							</div>
							<div class="content-nav-section">
								<div class="content-nav-title">Price Range</div>
								<div class="content-nav-field">
									<div class="row mb-3">
										<div class="col pl-0"><input type="text" class="custom-form-control" name="min_price" placeholder="RM MIN"></div>
										<div id="price-divider" class="col-auto px-0">-</div>
										<div class="col pr-0"><input type="text" class="custom-form-control" name="max_price" placeholder="RM MAX"></div>
									</div>
									<div>
										<button type="submit" class="btn btn-warning w-100">APPLY</button>
									</div>
								</div>
							</div>
							<?php if (isset($_GET['search']) || isset($_GET['brand']) || isset($_GET['model']) || isset($_GET['type'])) { ?>
								<div class="content-nav-section">
									<a href="?" class="btn btn-warning w-100">CLEAR ALL</a>
								</div>
							<?php } ?>
						</div>
					</form>
				</div>
				<div class="col-lg pr-0">
					<div class="sub-content">
						<?php if ($search) { ?>
							<div class="row mb-4 search-result">
								<div>SEARCH RESULTS FOR '<?php echo $search ?>' </div>
							</div>
						<?php } ?>
						<div class="content-header d-flex justify-content-between">

							<div class="form-group row">
								<label for="colFormLabel" class="col-sm-auto col-form-label pl-0">Sort By</label>
								<div class="col-sm">
									<select id="sort" class="custom-form-control custom-form-select mr-sm-2" name="sort">
										<option value="">New arrivals</option>
										<option value="name_asc" <?php if ($sort == 'name_asc') {
																		echo 'selected';
																	} ?>>Name: Low to high</option>
										<option value="name_des" <?php if ($sort == 'name_des') {
																		echo 'selected';
																	} ?>>Name: High to low</option>
										<option value="price_asc" <?php if ($sort == 'price_asc') {
																		echo 'selected';
																	} ?>>Price: Low to high</option>
										<option value="price_des" <?php if ($sort == 'price_des') {
																		echo 'selected';
																	} ?>>Price: High to low</option>
									</select>
								</div>
							</div>
							<div class="row">
								<nav aria-label="Page navigation">
									<ul class="pagination pagination-sm justify-content-end">
										<li class="page-item disabled">
											<a class="page-link" href="#" tabindex="-1" aria-disabled="true"><i class="fas fa-angle-double-left"></i></a>
										</li>
										<li class="page-item"><a class="page-link" href="#">1</a></li>
										<li class="page-item"><a class="page-link" href="#">2</a></li>
										<li class="page-item"><a class="page-link" href="#">3</a></li>
										<li class="page-item">
											<a class="page-link" href="#"><i class="fas fa-angle-double-right"></i></a>
										</li>
									</ul>
								</nav>
							</div>
						</div>
						<?php
						$result_models = $connect->query($sql_models);
						if (!empty($result_models) && $result_models->num_rows > 0) {
						?>
							<div class="content-body list-item-row">
								<?php while ($row = $result_models->fetch_assoc()) { ?>
									<div class="list-item-col">
										<a href="<?php echo $root ?>rent/reservation.php?bike=<?php echo $row['product_code']; ?>">
											<div class="list-item-img">
												<img src="<?php echo $root ?>assets/img/motorbike/<?php echo $row['img']; ?>">
											</div>
											<div class="list-item-title"><?php echo $row['brand'] . ' ' . $row['model']; ?></div>
											<div class="list-item-price">RM <?php echo $row['price']; ?></div>
										</a>
									</div>
								<?php } ?>
							</div>
						<?php } else { echo 'No results found'; } ?>
						
					</div>
				</div>
			</div>
		</div>
	</section>
	<script>
		$("#sort").change(function() {
			var val = $(this).val();
			url = window.location.href;
			var url = new URL(url);
			if (val == '') {
				url.searchParams.delete('sort');
			} else {
				url.searchParams.set('sort', val);
			}
			window.location = url;
		});
	</script>

	<?php include $root . 'footer.html' ?>
</body>

</html>