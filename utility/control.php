<?php
    session_start();

    //Check if ajax request to display new email template has been received
    if (isset($_GET['newEmail'])){
        return newMessage();
    }

    //Check if ajax request to display new email template menu bar has been received and determine the menu bar to display
    if (isset($_GET['menu'])){
        if ($_GET['menu'] == 'true'){
            return newMessageOptions();
        }
        else{
            return regularOptions();
        }
    }


    //Generate new email template
    function newMessage(){
        echo "<div class='form-container'>
        <form id='form' action='utility/emailFunctions.php' method='POST'>
            <div class='wrap-input100 validate-input' data-validate = 'Input cannot be empty or is invalid!'>
                <input disabled class='input100' type='text' name='id' placeholder='".$_SESSION['userEmail']."'>
                <span class='focus-input100' data-placeholder='&#xf056;'></span>
            </div>
            <div class='wrap-input100 validate-input' data-validate = 'Enter valid email address'>
                <input id='email' class='input100' type='text' name='email' placeholder='To'>
                <span class='focus-input100' data-placeholder='&#xf056;'></span>
            </div>
            <div class='wrap-input100 validate-input' data-validate = 'Subject cannot be empty'>
                <input id='sub' class='input100' type='text'  name='subject' placeholder='Subject'>
                <span class='focus-input100' data-placeholder='&#xf056;'></span>
            </div>
            <div class='wrap-input100 validate-input' data-validate = 'Message cannot be empty'>
                <textarea id='content' name='content' placeholder='Input message here...' class='wrap-input100 validate-input' rows='22'></textarea>
            </div>
            
        </form>
        </div>";
    }

    // Generate the menu bar that comes with the new email template
    function newMessageOptions(){
        echo "<li id='send'><i class='far fa-paper-plane'></i> &nbsp; Send</li>
            <li id='discard'><i class='fa fa-trash'></i>&nbsp; Discard</li>
            <li id='attach'><i class='fa fa-paperclip'></i>&nbsp; Attach</li>
            <li><a href='mail.php?exit=true'><img href='index.php' height=45 src='".$_SESSION['img']."' alt='IMG'></a>
        </li>

        <script>

            // Make options appear active
            $('.options li').css('color', 'rgb(81, 99, 138)')
            $('.options li').css('cursor', 'pointer')

            //Adjust side nav position
            $('.side-nav').css('left', '-49.9%');

            //Remove email template when discard has been clicked
            $('#discard').on('click', function(){
                $('.email-preview').html('');

                // Get appropriate menu bar
                $.get('utility/control.php', {menu: false}, function(data){
                    $('.options').html(data);
                });
            });

            // Validate new email template 
            $('#send').on('click', function(){
                let status = true;

                // Grab form data
                let recipient = document.getElementById('email').value;
                let subject = document.getElementById('sub').value;
                let content = document.getElementById('content').value;

                //Regex for validation
			    let emailReg = /^\w{1,}(\.\w{1,}|\S)@ashesi\.edu\.gh$/;

                //Validate recipient email address
                if (recipient.length == 0 || !emailReg.test(recipient)){
                    $('#email').parent().addClass('alert-validate');
                    status = false;
                }
                else{
                    $('#email').parent().removeClass('alert-validate');
                }

                // Validate subject
                if (subject.length == 0){
                    $('#sub').parent().addClass('alert-validate');
                    status = false;
                }
                else{
                    $('#sub').parent().removeClass('alert-validate');
                }

                // Validate content of the email
                if (content.trim().length == 0){
                    $('#content').parent().addClass('alert-validate');
                    status = false;
                }
                else{
                    $('#content').parent().removeClass('alert-validate');
                }

                // If validations are successful, submit the form
                if (status === true){
                    document.getElementById('form').submit();
                }
            
                return status;
            });
            
            
        </script>
        
        ";
    }

    // Display the normal menu bar
    function regularOptions(){
        echo "<li><i class='fa fa-reply'></i> &nbsp; Reply</li>
            <li><i class='fa fa-envelope'></i>&nbsp; Mark As Unread</li>
            <li><i class='fa fa-trash'></i>&nbsp; Delete</li>
            <li><a href='mail.php?exit=true'><img href='index.php' height=45 src='".$_SESSION['img']."' alt='IMG'></a>
        </li>

        <script>
            
            $('.side-nav').css('left', '-52.9%');
        </script>
        
        ";
    }
?>
