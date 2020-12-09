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
<?php 
	//Start a session
	session_start();

	if (!isset($_SESSION['userEmail'])){
		header('Location: index.php');
	}

	// Destroy session on logout
	function logout(){
		header('Location: index.php'); 
		session_destroy();
	}

	//Execute function of logout element has been clicked
	if (isset($_GET['exit'])) {
		logout();
	  }

?>
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
						<li><a href="mail.php?exit=true"><img href='index.php' height=45 src="<?php
										if (isset($_SESSION['img'])){
											echo $_SESSION['img'];
										}
										else{
											echo '';
										}
									?>" alt="IMG"></a>
						</li>
					</div>
				</div>
				
				<!-- Side Navigation Bar -->
				<div class="side-nav">
					<li id="lab" class='label'>
						<i id="drop" class='fas fa-angle-down' style="font-size: 20px;"></i>
						&nbsp;<p> <?php
										if (isset($_SESSION['userEmail'])){
											echo $_SESSION['userEmail'];
										}
										else{
											echo '';
										}
									?>
						</p>
					</li>
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

					<!-- Emails listing -->
					<div class="emails">
						<div class="email-card">
							<img src="images/logo.png" alt="">
							<p class="date" hidden>2020/20/12</p>
							<div class="name">
								<p>Andrew Duncan</p>
							</div>
							<div class="sub">
								<p >Assignment 2 Submission</p>
							</div>
							<div class="text">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
									sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
									Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
									 commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
									  dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
									   sunt in culpa qui officia deserunt mollit anim id est laborum.
								</p>
							</div>	
						</div>
						<div class="email-card">
							<img src="images/logo.png" alt="">
							<p class="date" hidden>2020/20/12</p>
							<div class="name">
								<p>Andrew Duncan</p>
							</div>
							<div class="sub">
								<p >Assignment 2 Submission</p>
							</div>
							<div class="text">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
									sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
									Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
									 commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
									  dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
									   sunt in culpa qui officia deserunt mollit anim id est laborum.
								</p>
							</div>	
						</div>
						<div class="email-card">
							<img src="images/logo.png" alt="">
							<p class="date" hidden>2020/20/12</p>
							<div class="name">
								<p>Andrew Duncan</p>
							</div>
							<div class="sub">
								<p >Assignment 2 Submission</p>
							</div>
							<div class="text">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
									sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
									Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
									 commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
									  dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
									   sunt in culpa qui officia deserunt mollit anim id est laborum.
								</p>
							</div>	
						</div>
						<div class="email-card">
							<img src="images/logo.png" alt="">
							<p class="date" hidden>2020/20/12</p>
							<div class="name">
								<p>Andrew Duncan</p>
							</div>
							<div class="sub">
								<p >Assignment 2 Submission</p>
							</div>
							<div class="text">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
									sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
									Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
									 commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
									  dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
									   sunt in culpa qui officia deserunt mollit anim id est laborum.
								</p>
							</div>	
						</div>
						<div class="email-card">
							<img src="images/logo.png" alt="">
							<p class="date" hidden>2020/20/12</p>
							<div class="name">
								<p>Andrew Duncan</p>
							</div>
							<div class="sub">
								<p >Assignment 2 Submission</p>
							</div>
							<div class="text">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
									sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
									Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
									 commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
									  dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
									   sunt in culpa qui officia deserunt mollit anim id est laborum.
								</p>
							</div>	
						</div>
						<div class="email-card">
							<img src="images/logo.png" alt="">
							<p class="date" hidden>2020/20/12</p>
							<div class="name">
								<p>Andrew Duncan</p>
							</div>
							<div class="sub">
								<p >Assignment 2 Submission</p>
							</div>
							<div class="text">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
									sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
									Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
									 commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
									  dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
									   sunt in culpa qui officia deserunt mollit anim id est laborum.
								</p>
							</div>	
						</div>
						<div class="email-card">
							<img src="images/logo.png" alt="">
							<p class="date" hidden>2020/20/12</p>
							<div class="name">
								<p>Andrew Duncan</p>
							</div>
							<div class="sub">
								<p >Assignment 2 Submission</p>
							</div>
							<div class="text">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
									sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
									Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
									 commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
									  dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
									   sunt in culpa qui officia deserunt mollit anim id est laborum.
								</p>
							</div>	
						</div>
						<div class="email-card">
							<img src="images/logo.png" alt="">
							<p class="date" hidden>2020/20/12</p>
							<div class="name">
								<p>Andrew Duncan</p>
							</div>
							<div class="sub">
								<p >Assignment 2 Submission</p>
							</div>
							<div class="text">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
									sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
									Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
									 commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
									  dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
									   sunt in culpa qui officia deserunt mollit anim id est laborum.
								</p>
							</div>	
						</div>
					</div>
						
					
					<!-- Email Preview -->
					<div class="email-preview">
						<!-- Header -->
						<div class="head">
							<img src="images/logo.png" alt="">
							<h5>Andrew Duncan</h5>
							<p class="dat">12/12/2020 at 12:39pm</p>
						</div>

						<!-- Subject of Email -->
						<h3>Assignment 2 Submission</h3>

						<!-- Email Body -->
						<div class="msg">
							<p >
								Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
								sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
								Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
								commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
								dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
								sunt in culpa qui officia deserunt mollit anim id est laborum.

								Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
								sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
								Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
								commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
								dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
								sunt in culpa qui officia deserunt mollit anim id est laborum.

								
							</p>
						</div>
						
					</div>
				<!-- </div> -->
				

				
				
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
	<script >

		//Display star icon when you hover over the options on the side
		$(".side-menu").hover(
			function(){
				$(this).find(".hov").css("display", "flex");
			},
			function(){
				$(".hov").css("display", "none");
			}
		);

		//Show or hide side menu items on dropdown when the email is selected
		$('#lab').on('click', function(){
			if ($('#drop').hasClass('fas fa-angle-down')){
				$('#drop').removeClass('fas fa-angle-down').addClass('fas fa-angle-right');
				$('.side-menu').css('visibility', 'hidden');
			}
			else{
				$('#drop').removeClass('fas fa-angle-right').addClass('fas fa-angle-down');
				$('.side-menu').css('visibility', 'visible');
			}
		});

		//Adjust the view when the slider is toggled
		$('.slider').on('click', function(){
			if ($('.emails').hasClass('email-slided')){
				$('.side-nav').css('display', 'block');
				$('.emails').removeClass('email-slided');
				$('.email-preview').removeClass('preview-slided');
				$('.options').removeClass('options-slided');
				$('.wrap-input100').removeClass('search-slided');
			}
			else{
				$('.side-nav').css('display', 'none');
				$('.emails').addClass('email-slided');
				$('.email-preview').addClass('preview-slided');
				$('.options').addClass('options-slided');
				$('.wrap-input100').addClass('search-slided');
				// $('.options').removeClass('options').addClass('options-selected');
			}
		});

		//Inidicate when an email card has been selected
		function select(id){
            let exist = document.getElementsByClassName("selected");
            if (exist.length > 0){
                exist[0].classList.remove("selected");
            }

            if (id !== 'admin'){
                $('.limiter').css('display', 'none');
                $('.limiter').css('top', '-8%');
            }else{
                $('.limiter').css('display', 'flex');
                $('.limiter').css('top', '0');
            }

            document.getElementById(id).classList.add("selected");
        }

		$('.email-card').on('click', function(){
			let exist = document.getElementsByClassName("select");
            if (exist.length > 0){
                exist[0].classList.remove("select");
            }

			console.log($(this).closest('.email-card').children('img').attr('src'));
			console.log($(this).closest('.email-card').children('.name').children('p').html());
			console.log($(this).closest('.email-card').children('.sub').children('p').html());
			console.log($(this).closest('.email-card').children('.text').children('p').html());
			console.log($(this).closest('.email-card').children('.date').html());
			
			$('.options li').css('color', 'rgb(81, 99, 138)')
			$('.options li').css('cursor', 'pointer')
			$(this).addClass('select');
		});



	</script>

</body>
</html>
