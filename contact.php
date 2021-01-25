<?php
$root = "";
$subtitle = 'Contact Us';
$nav = "contact";
include $root . 'header.php';

session_start();
// NOTE: this page must be saved as a .php file.
// And your server must support PHP 5.3+ PHP Mail().
// Define variables and set to empty values
$result = $first_name = $last_name = $email = $phone = $message  = "";
$err_first_name = $err_last_name = $err_email = $err_phone = $err_message = $err_captcha = "";

if (isset($_POST["submit"])) {
	$first_name 	= $_POST['first_name'];
	$last_name		= $_POST['last_name'];
	$email 			= $_POST['email'];
	$phone			= $_POST['phone'];
	$message		= $_POST['message'];

	// Check if first name is entered
	if (empty($_POST["first_name"])) {
		$err_first_name = "Please enter your First Name.";
	} else {
		$first_name = test_input($_POST["first_name"]);
	}
	// Check if last name is entered
	if (empty($_POST["last_name"])) {
		$err_last_name = "Please enter your Last Name.";
	} else {
		$lastNname = test_input($_POST["last_name"]);
	}
	// Check if email is entered
	if (empty($_POST["email"])) {
		$err_email = "Please enter your email address.";
	} else {
		$email = test_input($_POST["email"]);
		// check if e-mail address is valid format
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$err_email = "Invalid email format.";
		}
	}
	// Check if phone is entered although it is not required so we don't need error message
	if (empty($_POST["phone"])) {
		$phone = "";
	} else {
		$phone = test_input($_POST["phone"]);
	}
	//Check if message is entered
	if (empty($_POST["message"])) {
		$err_message = "Please enter your message.";
	} else {
		$message = test_input($_POST["message"]);
	}

	if (empty($_SESSION['6_letters_code']) || strcmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0) {
		$err_captcha = "The captcha code does not match!";
	}

	// If there are no errors, send the email & output results to the form
	if (!$err_first_name && !$err_last_name && !$err_email && !$err_phone &&  !$err_message) {
		include_once("db.php");

		$sql = "INSERT INTO contact_us(first_name, last_name, email, phone, message) 
		VALUES ('$first_name', '$last_name', '$email', '$phone', '$message')";
		if ($connect->query($sql) === TRUE) {
			$result = '<div class="alert alert-success"><i class="fas fa-check"></i> Message sent! Thank you for contacting us. We will get in touch with you soon.</div>';
		} else {
			$result = '<div class="alert alert-danger"><span class="fas fa-exclamation-triangle"></span> Sorry there was a form processing error. Please try again later.</div>';
		}

		$connect->close();
	}
}
//sanitize data inputs   
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = (filter_var($data, FILTER_SANITIZE_STRING));
	return $data;
}
//end form processing script
?>

<link rel="stylesheet" type="text/css" href="<?php echo $root ?>assets/css/form.css">
<script src='https://www.google.com/recaptcha/api.js'></script>
<script defer src="https://maps.googleapis.com/maps/api/js?key=&callback=myMap">
</script>
<script>
	function myMap() {
		var myCenter = new google.maps.LatLng(3.1976122, 101.7011029);
		var mapCanvas = document.getElementById("map");
		var mapOptions = {
			center: myCenter,
			zoom: 17
		};
		var map = new google.maps.Map(mapCanvas, mapOptions);
		var marker = new google.maps.Marker({
			position: myCenter
		});
		marker.setMap(map);

		marker.addListener('click', function() {
			infowindow.open(map, marker);
		});

		var infowindow = new google.maps.InfoWindow({
			content: '<div class="iw-container">' + '<div class="iw-title mb-1">MY V Bike Rental</div>' +
				'<div class="row mb-1"><div class="col-auto px-0"><i class="fas fa-map-marker-alt"></i></div><div class="col pr-0 text-left">MY V Bike Rental<br>LG-02, Waterfront Village,<br>Lot 4181, Persiaran Gamuda Gardens 1,<br>Bandar Gamuda Gardens,<br>48050 Rawang.</div></div>' +
				'<div class="row mb-1"><div class="col-auto px-0"><i class="far fa-clock"></i></div><div class="col pr-0 text-left">Weekday 10am - 8pm<br>Weekend / Public Holiday 8am - 8pm</div></div>' +
				'<div class="row mb-1"><div class="col-auto px-0"><i class="fas fa-phone-alt"></i></div><div class="col pr-0 text-left"><a href="tel:+6017-2342810">017-2342810</a></div></div>' +
				'<div class="row"><div class="col-auto px-0"><i class="fas fa-envelope"></i></div><div class="col pr-0 text-left"><a href="mailto:ecocanasports@gmail.com">ecocanasports@gmail.com</a></div></div>',
		});
	}
</script>
<script>
	function refresh_captcha() {
		var x = Math.floor((Math.random() * 1000000000) + 1);
		$('#captchaimg').attr('src', 'html-contact-form-captcha/captcha_code_file.php?rand=' + x);
	}
</script>
<script>
	if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
	}
</script>

<body>
	<?php include $root . 'navbar.php' ?>
	<section>
		<?php include $root . 'sidenavigation.php' ?>
		<div class="container text-center">
			<div class="main content-border">
				<div id="map" style="height:400px; width:100%;"></div>
				<form class="form-horizontal sub-content" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
					<div class="h3 mb-3">Get in touch with us</div>
					<!--when submit button is clicked, show results here-->
					<?php
					if ($result != "") {
						echo '<div class="form-group"><div class="col-sm-12 col-sm-offset-2">' . $result . '</div></div>';
					}
					?>
					<div class="row">
						<div class="col form-group">
							<label for="first_name" class="control-label">First Name<span class="required">*</span></label>
							<input type="text" class="custom-form-control" id="first_name" name="first_name" placeholder="First Name">
							<?php echo
							'<small class="invalid">' . $err_first_name . '</small>' ?>
						</div>
						<div class="col form-group">
							<label for="last_name" class="control-label">Last Name<span class="required">*</span></label>
							<input type="text" class="custom-form-control" id="last_name" name="last_name" placeholder="Last Name">
							<?php echo
							'<small class="invalid">' . $err_last_name . '</small>' ?>
						</div>
					</div>
					<div class="row">
						<div class="col form-group">
							<label for="email" class="control-label">Email<span class="required">*</span></label>
							<input type="text" class="custom-form-control" id="email" name="email" placeholder="Email">
							<?php echo
							'<small class="invalid">' . $err_email . '</small>' ?>
						</div>
						<div class="col form-group">
							<label for="phone" class="control-label">Phone</label>
							<input type="text" class="custom-form-control" id="phone" name="phone" placeholder="Phone" value="<?php echo $phone; ?>">
							<?php echo
							'<small class="invalid">' . $err_phone . '</small>' ?>
						</div>
					</div>
					<div class="row">
						<div class="col form-group">
							<label for="message" class="control-label">Message<span class="required">*</span></label>
							<textarea type="text" class="custom-form-control" id="message" name="message" placeholder="How can we help you?"></textarea>
							<?php echo
							'<small class="invalid">' . $err_message . '</small>' ?>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-6 form-group">
							<label for="message">Enter security code<span class="required">*</span></label>
							<div class="my-2">
								<img src="html-contact-form-captcha/captcha_code_file.php?rand=<?php echo rand(); ?>" id="captchaimg" class="">
							</div>
							<div class="row">
								<input id="6_letters_code" class="custom-form-control col" name="6_letters_code" type="text">
								<button type="button" class="btn btn-sm col-auto" onclick="refresh_captcha()"><i class="fas fa-redo"></i></button>
							</div>
							<?php echo
							'<small class="invalid">' . $err_captcha . '</small>' ?>
						</div>
					</div>

					<div class="form-group text-center mt-4">
						<div id="sendButton">
							<button type="submit" class="btn btn-warning" id="submit" name="submit">Send</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
	<?php include $root . 'footer.html' ?>
</body>

</html>