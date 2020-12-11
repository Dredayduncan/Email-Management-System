<?php
    include '../verification/config.php';
    session_start();

    // Get the id of the recipient of the email
    function getRecipient($email, $conn){
        // Write query
        $sql = 'SELECT perID FROM Person WHERE email = "'.$email.'"';

       // Execute query
       $res = mysqli_query($conn, $sql);

       // Check if query was executed    
       if ($res){

           // get query result as an array
           $id = mysqli_fetch_assoc($res);

           return $id['perID'];
       }    
       else {
            // Redirect back to mail page with error message
            header('Location: ../mail.php?error=Error: Email Recipient does not exist!');
            die;
       }

    }

    // Get the id of the email that was sent
    function getEmailID($senderID, $content, $date, $time, $conn){
        // Get the email id of the created email
        $sql = 'SELECT emailID FROM Email_Sent 
                WHERE perID = "'.$senderID.'" and content = "'.$content.'" and dateSent ="'.$date.'" and timeSent = "'.$time.'"';
        
        // Execute query
        $res = mysqli_query($conn, $sql);

        // Check if query was executed    
        if ($res){

            // get query result as an array
            $email = mysqli_fetch_assoc($res);

            return $email['emailID'];
        }    
        else {
            // Redirect back to mail page with error message
            header('Location: ../mail.php?error=Error: Email Does Not Exist!');
            die;
        }

    }

    // Send the email to the email send table in the database
    function sendEmail($senderID, $subject, $content, $date, $time, $conn){

        //Write query to insert email into the email sent database
        $query = 'INSERT into Email_Sent (perID, subject, content, dateSent, timeSent, status) 
        values ('.$senderID.', "'.$subject.'", "'.$content.'", "'.$date.'", "'.$time.'", "UNREAD")';

        // Execute query
        $res = mysqli_query($conn, $query);

        // Check if query was executed    
        if (!$res){
            // Redirect back to mail page with error message
            header('Location: ../mail.php?error=Email Could Not Be Sent!');
            die;
        }

        // Return true when the query has been executed successfully
        return true;

    }

    // Allow the recipient to receive the email by inserting the email into the email recipient table
    function receiveEmail($emailID, $recipientID, $conn){
        // Write query
        $sql = 'INSERT into Email_Recipient values ('.$recipientID.', '.$emailID.')';

        // Execute query
        $res = mysqli_query($conn, $sql);

        // Check if query was executed    
        if (!$res){
            // Redirect back to mail page with error message
            header('Location: ../mail.php?error=Error: Email could not be received!');
            die;
        }

        // Return true when the query has been executed successfully
        header('Location: ../mail.php?error=Email was sent successfully');
    }


    // Grab form data
    $recipient = $_POST['email'];
    $subject = $_POST['subject'];
    $content = $_POST['content'];
    $senderID = $_SESSION['id'];

    // Set default timezone and get current date and time
    date_default_timezone_set('GMT');
    $date = date("Y-m-d");
    $time = date("h:i:s");

    //Get recipient id if recipient exists
    $recipientID = getRecipient($recipient, $conn);

    // Send email
    sendEmail($senderID, $subject, $content, $date, $time, $conn);
    
    // Get the id of the email that was sent
    $emailID = getEmailID($senderID, $content, $date, $time, $conn);

    // Enable Recipient to receive the email
    receiveEmail($emailID, $recipientID, $conn);


?>