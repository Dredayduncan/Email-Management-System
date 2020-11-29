<?php  
    $servername = "localhost";  
    $username = "root";  
    $password = "";  
    $dbname = "theEmaildb";

    //Establish the link to the database using mysqli_connect(server name, dbusername, dbpassword, dbname)
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    //Validate the status of the connection
    if ($conn == false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
?>