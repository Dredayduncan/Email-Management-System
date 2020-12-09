<?php
    
    //Establish Database Connection
    include "config.php";

    #Get form data
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $pass = password_hash($password, PASSWORD_DEFAULT);

    //Get Image Upload path
    $targetDir = "uploads/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    //Get file type
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

    

    //Check if file is an image and upload it to the server
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){

        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            echo "true";
        }
        else{
            echo "false";
            die;
        }
    }

    //Check if email exists
    $query = "SELECT * FROM Person where email='".$email."'";

    // execute query
    $result = mysqli_query($conn, $query);

    //Check if email is present
    if (mysqli_num_rows($result) != 0) {

        // get query result as an array
        $user = mysqli_fetch_assoc($result);

        if ($user['password']){
            session_start();
            $_SESSION['signUpemail'] = $email;
            $_SESSION['signUpimg'] = $fileName;
            $_SESSION['pass'] = $password;
            header("Location: ../index.php?error=Listed email already has an account!");
            die;
        }
        
        //Update the password and image of the user
        $sql = "UPDATE Person SET password ='".$pass."', image = '".$fileName."' WHERE email = '".$email."'";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        //Verify if query executes successfully
        if ($res){
            session_start();
            $_SESSION['email'] = $email;
            header("Location: ../index.php?success=Account has been successfully created!");
            die;
        }
        else{
            session_start();
            $_SESSION['signUpemail'] = $email;
            $_SESSION['signUpimg'] = $fileName;
            $_SESSION['pass'] = $password;
            header("Location: ../index.php?error=Account could not be created!");
            die;
        }
        
    }
    else{
        session_start();
        $_SESSION['signUpemail'] = $email;
        $_SESSION['signUpimg'] = $fileName;
        $_SESSION['pass'] = $password;
        header("Location: ../index.php?error=Email does not exist!");
        die;
    }
    

?>