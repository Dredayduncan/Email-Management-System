<?php
    include "verification/config.php";

    //Email Class
    class Email{

        //User's id
        private $id;
        private $conn;
        private $email;
    
        function __construct($id, $email, $conn){
            $this->id = $id;
            $this->conn = $conn;
            $this->email = $email;
        }

        //Generate data based on what was searched
        public function search($data){

        }

        public function newMessage(){

        }

        //Get inbox of the user
        public function inbox(){
            // Write the query to get inbox
            $sql = "SELECT Email_Sent.emailID, Email_Sent.perID as SenderID, Email_Sent.dateSent, Email_Sent.timeSent,
             Email_Sent.subject, Email_Sent.content, Email_Recipient.perID as RecipientID, T.groupID as GroupRecipientID,
              Person.image, Person.fname, Person.lname 
              from Email_Sent 
              left join Email_Recipient 
              on Email_Sent.emailID = Email_Recipient.emailID 
              left join Person 
              on Email_Sent.perID = Person.perID 
              left join (select Email_Sent.emailID, EmailGroup_Recipient.groupID 
              from Email_Sent inner join EmailGroup_Recipient 
              on Email_Sent.emailID = EmailGroup_Recipient.emailID) as T 
              on Email_Sent.emailID = T.emailID 
              where Email_Recipient.perID ='".$this->id."' or T.groupID= '7' order by dateSent DESC";

            // execute query
            $result = mysqli_query($this->conn, $sql);

            //Check if query fails
            if(!$result){
                die("ERROR: Could not able to execute $sql. " . mysqli_error($this->conn));
            }else{
                // Create an email card for each record returned and print them in the mail page
                while ($data = mysqli_fetch_array($result)){
                    echo $this->emailCard($data['image'], $data['dateSent'], $data['timeSent'], $data['fname'],
                    $data['lname'], $data['subject'], $data['content']);
                }
            }
        }

        //Get all emails sent by the user
        public function sent(){

        }

        public function trash(){

        }

        // Create an email card for each record in the email table in the database
        private function emailCard($img, $date, $time, $fname, $lname, $subject, $content){
            return "<div class='email-card'>
            <img src='verification/uploads/".$img."' alt='IMG'>
            <p class='date' hidden>".$date."</p>
            <p class='time' hidden>".$time."</p>
            <div class='name'>
                <p>".$fname.' '.$lname."</p>
            </div>
            <div class='sub'>
                <p>".$subject."</p>
            </div>
            <div class='text'>
                <p> ".$content."</p>
            </div>	
        </div>";

        }
    }

    //Check if an email card has been selected from ajax request
    if (isset($_GET['preview'])){

        // Get details of the email 
        $img = $_GET['img'];
        $name = $_GET['name'];
        $subject = $_GET['sub'];
        $content = $_GET['content'];
        $date = $_GET['date'];
        $time = $_GET['time'];

        //Show the full email content of the email card selected
        preview($img, $name, $subject, $content, $date, $time);
            
    }

    //Show the full full content of an email
    function preview($img, $name, $subject, $content, $date, $time){
        echo "<!-- Header -->
        <div class='head'>
            <img src='".$img."' alt='IMG'>
            <h5>".$name."</h5>
            <p class='dat'>".$date." at ".$time."</p>
        </div>

        <!-- Subject of Email -->
        <h3>".$subject."</h3>

        <!-- Email Body -->
        <div class='msg'>
            <p>".$content."</p>
        </div>";
    }


?>