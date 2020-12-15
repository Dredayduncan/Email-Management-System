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
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/mail.css">
<!--===============================================================================================-->
<?php 
	include "verification/config.php";
	include "Email.php";
	

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

	// Check for error and display the error
	if (isset($_GET['error'])){
		echo "<script> alert('". $_GET['error']."') </script>";
	}

	// if (isset($_GET['current'])){
	// 	echo "<script> $('#".$_GET['current']."').click(); </script>";
	// 	// echo "<script> alert('". $_GET['current']."') </script>";
	// }

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

					<div id='searchbar' class='wrap-input100 validate-input'>
						<input id='search' class='input100' type='text' name='search' placeholder='Search'>
						<span class='focus-input100' data-placeholder='&#xf002;'></span>
					</div>

					<div class="options">
						<li><i class="fa fa-reply"></i> &nbsp; Reply</li>
						<li id='mark'><i class="fa fa-envelope"></i>&nbsp; Mark As Unread</li>
						<li id='delete'><i class="fa fa-trash"></i>&nbsp; Delete</li>
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
					<li id="inbox" class='side-menu'>
						<i class='fas fa-inbox'></i>
						&nbsp; Inbox
						<div class='indicate'> <p></p></div>
						<i class='hov fas fa-star'></i>
					</li>
					<li id="sent" class='side-menu'>
						<i class='far fa-paper-plane'></i>
						&nbsp; Sent
						<div class='indicate'> <p></p></div>
						<i class='hov fas fa-star'></i>
					</li>
					<li id="trash" class='side-menu'>
						<i class='fas fa-trash'></i>
						&nbsp; Trash
						<div class='indicate'> <p></p></div>
						<i class='hov fas fa-star'></i>
					</li>
					<li class='side-menu'>
						<i class='fa fa-users'></i>
						&nbsp; Groups
						<i class='hov fa fa-star'></i>
					</li>

					<!-- <li id='group' class='label'>
						<i id="drop" class='fas fa-angle-down'></i>
						&nbsp; &nbsp;
						<i class='fa fa-users'></i>
						&nbsp; Groups
						<i class='hov fa fa-star'></i>
						
						<li id="inbox" class='side-menu sub-menu'>
							&nbsp; <p>Inboxsdgasdhgdhfdghrwhrwhrhgrghrghrehrw</p> 
							<i class='hov fas fa-star'></i>
						</li>
					</li> -->

				</div>
					
				<div class='email-container'>
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
	<script >
		//Display new email template when new message button is clicked
		$('#btn').on('click', function(){
			$('.side-nav').css('margin-left', '3%');
			//Get and display email template
			$.get('utility/control.php', {newEmail: true}, function(data){
                $('.email-preview').html(data);
			});
			
			// Get appropriate menu bar
			$.get('utility/control.php', {menu: 'true'}, function(data){
                $('.options').html(data);
			});

			
		});

		// Indicate when side menu is selected
		$(".side-menu").on('click', function(){
			$('.side-nav').find('.chosen').removeClass('chosen').addClass('side-menu');
			$(this).removeClass('side-menu').addClass('chosen');

			// When the Trash menu has been selected
			if ($('.side-nav').find('.chosen').attr('id') === 'trash'){
				$('.options').children('li').eq(0).html('<i class="fas fa-trash-restore" aria-hidden="true"></i>  Restore');
				$('.options').children('li').eq(0).attr('id', 'restore');

				// Restore deleted email
				$('#restore').on('click', function(){
			
					// Get details of the email
					let name = $('.select').children('.name').children('p').html();
					let subject = $('.select').children('.sub').children('p').html();
					let date = $('.select').children('.date').html();
					let time = $('.select').children('.time').html();
					let senderEmail = $('.select').children('.senderEmail').html();

					//restore the email 
					$.get('utility/emailFunctions.php', {restore: $('.chosen').attr('id'), name: name.split(' ')[0], sub: subject, 
						date: date, time: time, email: senderEmail}, function(data){
						location.replace('mail.php');
						// $('.emails').html(data);
						
					});
				});
			}else{
				$('.options').children('li').eq(0).html('<i class="fa fa-reply"></i> &nbsp; Reply');
				$('.options').children('li').eq(0).attr('id', '');
			}

			//display email cards for selected side menu
            $.get('Email.php', {menu: this.id, id: <?=json_encode($_SESSION['id']);?>, email: <?=json_encode($_SESSION['userEmail']) ?>}, function(data){
                $('.emails').html(data);
            });
			
		});

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
				$('.chosen').css('visibility', 'hidden');
			}
			else{
				$('#drop').removeClass('fas fa-angle-right').addClass('fas fa-angle-down');
				$('.side-menu').css('visibility', 'visible');
				$('.chosen').css('visibility', 'visible');
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
			}
		});

		// Move deleted email to trash
		$('#delete').on('click', function(){
			// Grab data
			let name = $('.select').children('.name').children('p').html();
			let subject = $('.select').children('.sub').children('p').html();
			let date = $('.select').children('.date').html();
			let time = $('.select').children('.time').html();
			let senderEmail = $('.select').children('.senderEmail').html();

			let menu = $('.side-nav').find('.chosen').attr('id');

			if (menu === 'trash'){
				//delete selected email card from Trash
				$.get('utility/emailFunctions.php', {menu: menu, name: name.split(' ')[0], sub: subject, 
					date: date, time: time, email: senderEmail}, function(data){
					location.replace('mail.php');
					// $('.emails').html(data);
				});
			}
			else{

				if (menu === 'sent'){
					senderEmail = <?=json_encode($_SESSION['userEmail']);?>;
				}
				//delete selected email card
				$.get('utility/emailFunctions.php', {delete: menu, name: name.split(' ')[0], sub: subject, 
					date: date, time: time, email: senderEmail}, function(data){
					location.replace('mail.php');
					// $('.emails').html(data);
				});
			}	
		});

		// Get emails that match what has been search
		$('#search').keyup(function(){
			if (document.getElementById('search').value.length == 0){
				//display email cards for selected side menu
				$.get('Email.php', {menu: $('.side-nav').find('.chosen').attr('id'), id: <?=json_encode($_SESSION['id']);?>, email: <?=json_encode($_SESSION['userEmail']) ?>}, function(data){
                	$('.emails').html(data);
            	});
			}
			else{
				$.get('Email.php', {search: 'true', info: document.getElementById('search').value, table: $('.side-nav').find('.chosen').attr('id')}, function(data){
					$('.emails').html(data);
				});
			}
			
		});

		// Mark and email as unread
		$('#mark').on('click', function(){
			// Grab data
			let name = $('.select').children('.name').children('p').html();
			let subject = $('.select').children('.sub').children('p').html();
			let date = $('.select').children('.date').html();
			let time = $('.select').children('.time').html();
			let senderEmail = $('.select').children('.senderEmail').html();

			if ($('.chosen').attr('id') === 'sent'){
					senderEmail = <?=json_encode($_SESSION['userEmail']);?>;
					name = '';
            }

			// Temporarily increment unread number of emails value
			let current = $('.chosen').find('.indicate p').html();
			if (current === ''){
				current = 0;
			}
			$('.chosen').find('.indicate p').html(parseInt(current) + 1);
			$('<span class="dot"></span>').insertAfter('.select img');
			

			$.post('utility/emailFunctions.php', {unread: $('.chosen').attr('id'), name: name.split(' ')[0], sub: subject, 
				date: date, time: time, mail: senderEmail}, function(data){
				// location.replace('mail.php?current=', $(this).attr('id'));
				return;
			});
		});

		// Select inbox by default
		$('.side-nav').children('li').eq(1).click();


	</script>

</body>
</html>
