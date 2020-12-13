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
            die("ERROR: Could not able to execute $query. " . mysqli_error($conn));
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

    //-------------------- DELETING AN EMAIL------------------------------ //
    // Get the id of the email that has been selected 
    function getSelectedEmail($subject, $date, $time, $email, $conn){
        // Write the query to get inbox
        $sql = "SELECT Email_Sent.emailID, Email_Sent.perID as SenderID, Email_Sent.dateSent, Email_Sent.timeSent,
                Email_Sent.subject, Email_Sent.content, Email_Recipient.perID as RecipientID, T.groupID as GroupRecipientID,
                Person.image, Person.fname, Person.lname, Person.email
                from Email_Sent 
                left join Email_Recipient 
                on Email_Sent.emailID = Email_Recipient.emailID 
                left join Person 
                on Email_Sent.perID = Person.perID 
                left join (select Email_Sent.emailID, EmailGroup_Recipient.groupID 
                from Email_Sent inner join EmailGroup_Recipient 
                on Email_Sent.emailID = EmailGroup_Recipient.emailID) as T 
                on Email_Sent.emailID = T.emailID 
                where Email_Sent.perID ='".$email."' and Email_Sent.dateSent ='".$date."' and Email_Sent.timeSent ='".$time."'
                and Email_Sent.subject ='".$subject."'";

         // execute query
         $result = mysqli_query($conn, $sql);

         if ($result){
             // get query result as an array
            $mail = mysqli_fetch_assoc($result);

            // get emailID
            return $emailID = $mail['emailID'];
         }
         else{
            die("ERROR: Could not able to execute $sql. " . mysqli_error($conn));
         }
    }

    // Get the email id and recipient id from the email recipient table as arguments to insert into trash
    function getRecipientDetails($emailID, $conn){
        // Write the query to get inbox
        $sql = "SELECT * FROM Email_Recipient WHERE emailID =". $emailID;

        // execute query
        $result = mysqli_query($conn, $sql);

        if ($result){
            // get query result as an array
            $recipient = mysqli_fetch_assoc($result);

            // Get recipient ID
            $recipientID = $recipient['perID'];

            // True if email recipient is an individual and false if it's a group
            $status = true;

            if ($recipient == ''){
                $recipientID = getGroupRecipientDetails($emailID, $conn)[1];
                $status = false;
            }
        
            // Return the details of the email
            return array($emailID, $recipientID, $status);
        }
        else{
            die("ERROR: Could not able to execute $sql. " . mysqli_error($conn));
        }
    }

    //Get the email id and group recipient id from the email recipient table as arguments to insert into trash
    function getGroupRecipientDetails($emailID, $conn){
        // Write the query to get inbox
        $sql = "SELECT * FROM EmailGroup_Recipient WHERE emailID =". $emailID;

        // execute query
        $result = mysqli_query($conn, $sql);

        if ($result){
            // get query result as an array
            $recipient = mysqli_fetch_assoc($result);

            // Get recipient ID
            $recipientID = $recipient['groupID'];
            $status = false;
        
            // Return the details of the email
            return array($emailID, $recipientID);
        }
        else{
            die("ERROR: Could not able to execute $sql. " . mysqli_error($conn));
        }
    }

    // Insert the email into the trash table
    function moveToTrash($senderID, $recipientID, $emailID, $conn, $status){
        // Write the query to get inbox
        $sql = 'INSERT into Trash (senderID, emailID, recipientID, deleterID) 
        values ('.$senderID.', '.$emailID.', '.$recipientID.', '.$_SESSION['id'].')';

        // execute query
        $result = mysqli_query($conn, $sql);

        if ($result){
            // throw an alert that email has been moved to trash
            deleteEmail($emailID, $conn, $status, '');
            header('Location: ../mail.php?error=Email has been moved to trash');
        }
        else{
            die("ERROR: Could not able to execute $sql. " . mysqli_error($conn));
        }
    }

    // Remove email from inbox 
    function deleteEmail($email, $conn, $status, $tab){
        // Get the table we are deleting from
        $table = 'EmailGroup_Recipient';

        // Set table to that respective of the email recipient
        if ($status == 1){
            $table = 'Email_Recipient';
        }

        // Write the query to get inbox
        $sql = 'DELETE FROM '.$table.' WHERE emailID ='. $email;

        // execute query
        $result = mysqli_query($conn, $sql);

        if ($result){
            // throw an alert that email has been moved to trash
            header('Location: ../mail.php?error=Email has been moved to trash');
        }
        else{
            die("ERROR: Could not able to execute $sql. " . mysqli_error($conn));
        }
    }

//--------------------------- RESTORING AN EMAIL------------------------------ //

    // Move selected email to inbox from trash 
    function restoreToInbox($emailID, $conn){
        // Write the query to get inbox
        $sql = 'INSERT into Email_Recipient (perID, emailID) values ('.$_SESSION['id'].', '.$emailID.')';

        // execute query
        $result = mysqli_query($conn, $sql);

        if ($result){
            // throw an alert that email has been moved to trash
            deleteFromTrash($emailID, $conn);
            header('Location: ../mail.php?error=Email has been restored');
        }
        else{
            die("ERROR: Could not able to execute $sql. " . mysqli_error($conn));
        }
    }

    function deleteFromTrash($email, $conn){
        // Write the query to get inbox
        $sql = 'DELETE from Trash where emailID ='.$email.' and deleterID ='.$_SESSION['id'];

        // execute query
        $result = mysqli_query($conn, $sql);

        if (!$result){
            die("ERROR: Could not able to execute $sql. " . mysqli_error($conn));
        }
    }

//--------------------- MARK EMAIL AS READ OR UNREAD---------------------- //

// Mark the selected email as read
function markAsRead($emailID, $conn){

    // Write the query to get inbox
    $sql = 'UPDATE Email_Sent SET status = "READ" WHERE emailID ='.$emailID;

    // execute query
    $result = mysqli_query($conn, $sql);

    if (!$result){
        die("ERROR: Could not able to execute $sql. " . mysqli_error($conn));
    }
}

// Mark the selected email as unread
function markAsUnread($emailID, $conn){

    // Write the query to get inbox
    $sql = 'UPDATE Email_Sent SET status = "UNREAD" WHERE emailID ='.$emailID;

    // execute query
    $result = mysqli_query($conn, $sql);

    if (!$result){
        die("ERROR: Could not able to execute $sql. " . mysqli_error($conn));
    }
}


    

//--------------------------- PROCESSING ------------------------------ //
    //Move Email to Trash if delete was selected
    if (isset($_GET['delete'])){
        $name = $_GET['name'];
        $subject = $_GET['sub'];
        $date = $_GET['date'];
        $time = $_GET['time'];
        $email = $_GET['email'];
        
        // Get the ID of the sender of the email
        $mailID = getRecipient($email, $conn);

        // Get the id of the email to be deleted
        $id = getSelectedEmail($subject, $date, $time, $mailID, $conn);

        // Get the details of the email in the recipient table
        $details = getRecipientDetails($id, $conn);

        // Use the details to move the email to trash
        moveToTrash($mailID, $details[1], $details[0], $conn, $details[2]);
    }

    // If the delete has been selected in the trash menu
    elseif (isset($_GET['menu'])){
        $name = $_GET['name'];
        $subject = $_GET['sub'];
        $date = $_GET['date'];
        $time = $_GET['time'];
        $email = $_GET['email'];
        
        // Get the ID of the sender of the email
        $mailID = getRecipient($email, $conn);

        // Get the id of the email to be deleted
        $id = getSelectedEmail($subject, $date, $time, $mailID, $conn);

        // Write the query to get inbox
        $sql = 'DELETE FROM Trash WHERE emailID ='. $id;

        // execute query
        $result = mysqli_query($conn, $sql);

        if ($result){
            // throw an alert that email has been moved to trash
            header('Location: ../mail.php?error=Email has been permanently deleted');
        }
        else{
            die("ERROR: Could not able to execute $sql. " . mysqli_error($conn));
        }
    }

    // if the restore button has been clicked
    elseif(isset($_GET['restore'])){
        // Get posted data
        $name = $_GET['name'];
        $subject = $_GET['sub'];
        $date = $_GET['date'];
        $time = $_GET['time'];
        $email = $_GET['email'];
        
        // Get the ID of the sender of the email
        $mailID = getRecipient($email, $conn);

        // Get the id of the email to be restored
        $id = getSelectedEmail($subject, $date, $time, $mailID, $conn);

        // Restore the selected email
        restoreToInbox($id, $conn);
    }

    // If email card has been clicked to be marked as read
    elseif(isset($_POST['read'])){
         // Get posted data
        //  $name = $_POST['name'];
         $subject = $_POST['sub'];
         $date = $_POST['date'];
         $time = $_POST['time'];
         $email = $_POST['mail'];

        // Get the ID of the sender of the email
        $mailID = getRecipient($email, $conn);

        // Get the id of the email to be marked as read
        $id = getSelectedEmail($subject, $date, $time, $mailID, $conn);

        // Mark email as read
        markAsRead($id, $conn);
    }

    // If Mark as Unread button has been clicked
    elseif(isset($_POST['unread'])){
        // Get posted data
        $name = $_POST['name'];
        $subject = $_POST['sub'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $email = $_POST['mail'];

       // Get the ID of the sender of the email
       $mailID = getRecipient($email, $conn);

       // Get the id of the email to be marked as read
       $id = getSelectedEmail($subject, $date, $time, $mailID, $conn);

       // Mark email as unread
       markAsUnread($id, $conn);
   }

    else{
        // If delete was not selected then you're here because the send email button was clicked so send the email
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
    }

    

    


    


   
    
?>