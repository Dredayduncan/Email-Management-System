<!DOCTYPE html>
<html lang="en">
<head>
	<title>DreMail</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="shortcut icon" href="#">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/mail.css">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<!-- Top navigation bar -->
				<div class="top-nav">
					<li class="slider">
						<i class="fas fa-bars"></i>
					</li>
					
					<div id="btn">
						<i class="fa fa-pencil-square-o"></i>
						<span class="noselect"> &nbsp; New Message</span>
						<div id="circle"></div>
					</div>

					<div class='wrap-input100 validate-input'>
						<input class='input100' type='text' name='search' placeholder='Search'>
						<span class='focus-input100' data-placeholder='&#xf002;'></span>
					</div>

					<div class="options">
						<li><i class="fa fa-reply"></i> &nbsp; Reply</li>
						<li><i class="fa fa-reply-all"></i>&nbsp; Reply All</li>
						<li><i class="fa fa-envelope-open"></i>&nbsp; Mark As Unread</li>
						<li><i class="fa fa-trash"></i>&nbsp; Delete</li>
					</div>
				</div>
				
				<!-- Side NAV -->
				<div class="side-nav">
					<!-- <a href="index.html"><img src="images/kada.png"></a> -->
					<!-- <div class="divider"></div> -->
					<li class='side-menu'>
						<i class='fas fa-inbox'></i>
						&nbsp; Inbox
						<i class='hov fas fa-star'></i>
					</li>
					<li class='side-menu'>
						<i class='far fa-paper-plane'></i>
						&nbsp; Sent
						<i class='hov fas fa-star'></i>
					</li>
					<li class='side-menu'>
						<i class='fa fa-users'></i>
						&nbsp; Groups
						<i class='hov fa fa-star'></i>
					</li>

				</div>

				<div class="preview">
					<!-- Emails listing -->
					<div class="emails"></div>
					<!-- Email Preview -->
					<div class="email-preview"></div>
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
	<script src="js/mail.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		});

		$(".side-menu").hover(
			function(){
				$(this).find(".hov").css("display", "flex");
			},
			function(){
				$(".hov").css("display", "none");
			}
		);

	</script>

</body>
</html>
