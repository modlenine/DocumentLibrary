<!DOCTYPE html>
<html lang="en">
<head>
	<title>Document Library System Login Page</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?=base_url('assets/images/')?>slc.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url('login_page/')?>vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url('login_page/')?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url('login_page/')?>vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?=base_url('login_page/')?>vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url('login_page/')?>vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url('login_page/')?>css/util.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url('login_page/')?>css/main.css">
<!--===============================================================================================-->
<style>
.container-login100{
	background: linear-gradient(-135deg, #f8f9fa, #000000);
}
</style>
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="<?=base_url('login_page/')?>images/saleecolour_logo.png" alt="IMG" ><br>
					<img src="<?=base_url('login_page/')?>images/our_company.jpg" alt="IMG" >
				</div>

				<form class="login100-form validate-form" action="<?=base_url()?>login/check_login" method="post">
					<span class="login100-form-title">
						Document Library System
					</span>
					<?php echo $this->session->flashdata('msg');?>
					<div class="wrap-input100 validate-input" data-validate = "กรุณากรอก Username">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "กรุณากรอก Password">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<!-- <div class="wrap-input100 validate-input" data-validate = "กรุณากรอกคำตอบของท่าน">
						<input class="input100" type="text" name="questionTest" placeholder="ห้าบวกห้าเท่ากับเท่าไร">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-question-circle" aria-hidden="true"></i>
						</span>

					</div>
					<label style="color:red">*กรุณาพิมพ์คำตอบเป็นตัวหนังสือ เช่น สิบห้า</label> -->
					
					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="http://203.107.156.180/intsys/usermanage/resetpassword/index.php">
							Password?
						</a>
					</div>

					<div class="text-center p-t-136">
						<!-- <a class="txt2" href="#">
							Create your Account
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a> -->
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="<?=base_url('login_page/')?>vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=base_url('login_page/')?>vendor/bootstrap/js/popper.js"></script>
	<script src="<?=base_url('login_page/')?>vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=base_url('login_page/')?>vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=base_url('login_page/')?>vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="<?=base_url('login_page/')?>js/main.js"></script>

</body>
</html>