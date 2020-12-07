<!DOCTYPE html>
<html lang="en">
<head>
	<title>DreMail</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/logo.gif" alt="IMG">
				</div>

				<div class='forms-container'>
						<!-- Sign In Form -->
					<form class="login100-form validate-form" action="verification/login.php" id='logIn'>
						<span class="login100-form-title">
							Member Login
						</span>

						<div class="wrap-input100 validate-input" data-validate = "Valid email is required!">
							<input id="user" class="input100" type="text" name="email" placeholder="Email Address">
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-user" aria-hidden="true"></i>
							</span>
						</div>

						<div class="wrap-input100 validate-input" data-validate = "Password must be 8-15 characters and must contain lowercase, uppercase, and a number!">
							<input id="pass" class="input100" type="password" name="pass" placeholder="Password">
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-lock" aria-hidden="true"></i>
							</span>
						</div>

						<div class="container-login100-form-btn">
							<button class="login100-form-btn" form='logIn' id='login'>
								Login
							</button>
						</div>

						<div class="text-center p-t-12">
							<span class="txt1">
								Forgot
							</span>
							<a class="txt2" href="#">
								Username / Password?
							</a>
						</div>

						<div class="text-center p-t-136">
							<a class="txt2" href="#" id='sign-up-btn'>
								Create your Account
								<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
							</a>
						</div>
					</form>


					<!-- Sign Up Form -->
					<form class="signup100-form validate-form" action="verification/signUp.php" id='signUp'>
						<span class="login100-form-title">
							Member Sign Up
						</span>

						<div class="wrap-input100 validate-input" data-validate = "Valid username is required!">
							<input id="signUpUser" class="input100" type="text" name="email" placeholder="Email">
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-user" aria-hidden="true"></i>
							</span>
						</div>

						<div class="wrap-input100 validate-input" data-validate = "Password is required">
							<input id="signUpPass" class="input100" type="password" name="pass" placeholder="Password">
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-lock" aria-hidden="true"></i>
							</span>
						</div>

						<div class="wrap-input100 validate-input" data-validate = "Passwords do not match">
							<input id="signUpCpass" class="input100" type="password" name="cpass" placeholder="Confirm Password">
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-lock" aria-hidden="true"></i>
							</span>
						</div>

						<div class="wrap-input100 validate-input" data-validate = "Picture is required!">
							<input type="file" id="picture" onchange="pictureInput(event)" style="display: none; " />
							<input id="pic-btn" type="button" class="login100-form-btn" value="Select Profile Picture..." onclick="document.getElementById('picture').click();" />
							<span class="focus-input100"></span>
							<img id="pic" height="80">
						</div>

						<div class="container-login100-form-btn">
							<button class="login100-form-btn" form='signUp' name='submit' id="signup">
								Sign Up
							</button>
						</div>

						<div class="text-center p-t-136">
							<a class="txt2" href="#" id='sign-in-btn'>
								Login
								<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
							</a>
						</div>
					</form>
				</div>
				
			</div>
		</div>
	</div>




<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
<!--===============================================================================================-->
	<script >
		//Image skills
		$('.js-tilt').tilt({
			scale: 1.1
		})

		//Display selected profile photo
		function pictureInput(event){
            var input = document.getElementById('picture');

			var reader = new FileReader();
			
			//Display Image
            reader.onload = function(){
            var dataURL = reader.result;
			var output = document.getElementById('pic');
			output.style.display = 'flex';
            output.src = dataURL;
			};
			
            reader.readAsDataURL(input.files[0]);

            return false;
        }

		//Login Validation
		$('#login').on('click', function(){
			let status = true;

			let email = document.getElementById('user').value;
			let password = document.getElementById('pass').value;

			//Regex for validation
			let emailReg = /^\w{1,}(\.\w{1,}|\S)@ashesi\.edu\.gh$/;
			let passReg = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,15}$/;

			//Validate password
			if (password.length == 0 || !passReg.test(password)){
				$('#pass').parent().addClass('alert-validate');
				status = false;
			}
			else{
				$('#pass').parent().removeClass('alert-validate');
			}

			//Validate email
			if (email.length == 0 || !emailReg.test(email)){
				$('#user').parent().addClass('alert-validate');
				status = false;
			}
			else{
				$('#user').parent().removeClass('alert-validate');
			}

			return status;

		});

		// Sign Up Validation
		$('#signup').on('click', function(){
			let status = true;

			let email = document.getElementById('signUpUser').value;
			let password = document.getElementById('signUpPass').value;
			let cpass = document.getElementById('signUpCpass').value;
			let pic = document.getElementById('picture').value;

			//Regex for validation
			let emailReg = /^\w{1,}(\.\w{1,}|\S)@ashesi\.edu\.gh$/;
			let passReg = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,15}$/;

			//Validate password
			if (password.length == 0 || !passReg.test(password)){
				$('#signUpPass').parent().addClass('alert-validate');
				status = false;
			}
			else{
				$('#signUpPass').parent().removeClass('alert-validate');
			}

			//Validate email
			if (email.length == 0 || !emailReg.test(email)){
				$('#signUpUser').parent().addClass('alert-validate');
				status = false;
			}
			else{
				$('#signUpUser').parent().removeClass('alert-validate');
			}

			//Validate confirm password
			if (cpass.length == 0 || password !== cpass){
				$('#signUpCpass').parent().addClass('alert-validate');
				status = false;
			}
			else{
				$('#signUpCpass').parent().removeClass('alert-validate');
			}

			//Check if image has been selected
			if (pic.length == 0){
				$('#pic-btn').css('background-color', 'red');
				status = false;
			}
			else{
				$('#pic-btn').css('background-color', 'rgb(64, 104, 82)');
			}

			return status;
		});

	</script>


</body>
</html>
