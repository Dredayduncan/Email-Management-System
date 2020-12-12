<?php
    include "verification/config.php";

    // start session
    session_start();

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
        public function search($data, $menu){
            // Write the query to get the results for the search data
            $sql = '';

            // Assign appropriate query
            if ($menu == 'inbox'){
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
                        where Email_Recipient.perID ='".$this->id."' or T.groupID= '7' 
                        and Email_Sent.subject like '%".$data."%' or Email_Sent.content like '%".$data."%' or Person.fname like '%".$data."%' 
                        or Person.lname like '%".$data."%' or Person.email like '%".$data."%' order by dateSent DESC";
            }
            elseif ($menu == 'sent'){
                $sql = "SELECT Email_Sent.emailID, Email_Sent.perID as SenderID, Email_Sent.dateSent, Email_Sent.timeSent,
                        Email_Sent.subject, Email_Sent.content, Email_Recipient.perID as RecipientID, T.groupID as GroupRecipientID,
                        Person.image, Person.fname, Person.lname, Person.email 
                        from Email_Sent 
                        left join Email_Recipient 
                        on Email_Sent.emailID = Email_Recipient.emailID 
                        left join Person 
                        on Email_Recipient.perID = Person.perID 
                        left join (select Email_Sent.emailID, EmailGroup_Recipient.groupID 
                        from Email_Sent inner join EmailGroup_Recipient 
                        on Email_Sent.emailID = EmailGroup_Recipient.emailID) as T 
                        on Email_Sent.emailID = T.emailID 
                        where Email_Sent.perID ='".$this->id."'
                        and Email_Sent.subject like '%".$data."%' or Email_Sent.content like '%".$data."%' or Person.fname like '%".$data."%' 
                        or Person.lname like '%".$data."%' or Person.email like '%".$data."%' order by dateSent DESC";

            }
            elseif ($menu == 'trash'){
                $sql = "SELECT Email_Sent.emailID, Email_Sent.perID as SenderID, Email_Sent.dateSent, Email_Sent.timeSent,
                        Email_Sent.subject, Email_Sent.content, Email_Recipient.perID as RecipientID, T.groupID as GroupRecipientID,
                        Person.image, Person.fname, Person.lname, Person.email, Trash.deleterID 
                        from Email_Sent 
                        left join Email_Recipient 
                        on Email_Sent.emailID = Email_Recipient.emailID 
                        left join Trash 
                        on Email_Sent.emailID = Trash.emailID
                        left join Person 
                        on Email_Sent.perID = Person.perID 
                        left join (select Email_Sent.emailID, EmailGroup_Recipient.groupID 
                        from Email_Sent inner join EmailGroup_Recipient 
                        on Email_Sent.emailID = EmailGroup_Recipient.emailID) as T 
                        on Email_Sent.emailID = T.emailID 
                        where Trash.deleterID ='".$this->id."'
                        and Email_Sent.subject like '%".$data."%' or Email_Sent.content like '%".$data."%' or Person.fname like '%".$data."%' 
                        or Person.lname like '%".$data."%' or Person.email like '%".$data."%' order by dateSent DESC";
            }
            

            // Generate the email cards
            return $this->generateEmailCards($sql);
        }

        //Get inbox of the user
        public function inbox(){
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
              where Email_Recipient.perID ='".$this->id."' or T.groupID= '7' order by dateSent DESC";

            // Generate the email cards
            return $this->generateEmailCards($sql);
        }

        //Get all emails sent by the user
        public function sent(){
            // Write the query to get sent
            $sql = "SELECT Email_Sent.emailID, Email_Sent.perID as SenderID, Email_Sent.dateSent, Email_Sent.timeSent,
                Email_Sent.subject, Email_Sent.content, Email_Recipient.perID as RecipientID, T.groupID as GroupRecipientID,
                Person.image, Person.fname, Person.lname, Person.email 
                from Email_Sent 
                left join Email_Recipient 
                on Email_Sent.emailID = Email_Recipient.emailID 
                left join Person 
                on Email_Recipient.perID = Person.perID 
                left join (select Email_Sent.emailID, EmailGroup_Recipient.groupID 
                from Email_Sent inner join EmailGroup_Recipient 
                on Email_Sent.emailID = EmailGroup_Recipient.emailID) as T 
                on Email_Sent.emailID = T.emailID 
                where Email_Sent.perID ='".$this->id."' order by dateSent DESC";

            // Generate the email cards
            return $this->generateEmailCards($sql);

        }

        public function trash(){
            // Write the query to get sent
            $sql = "SELECT Email_Sent.emailID, Email_Sent.perID as SenderID, Email_Sent.dateSent, Email_Sent.timeSent,
             Email_Sent.subject, Email_Sent.content, Email_Recipient.perID as RecipientID, T.groupID as GroupRecipientID,
              Person.image, Person.fname, Person.lname, Person.email, Trash.deleterID 
              from Email_Sent 
              left join Email_Recipient 
              on Email_Sent.emailID = Email_Recipient.emailID 
              left join Trash 
              on Email_Sent.emailID = Trash.emailID
              left join Person 
              on Email_Sent.perID = Person.perID 
              left join (select Email_Sent.emailID, EmailGroup_Recipient.groupID 
              from Email_Sent inner join EmailGroup_Recipient 
              on Email_Sent.emailID = EmailGroup_Recipient.emailID) as T 
              on Email_Sent.emailID = T.emailID 
              where Trash.deleterID ='".$this->id."' order by Email_Sent.dateSent DESC";

            // Generate the email cards
            return $this->generateEmailCards($sql);
        }

        // Generate Email cards for a side menu. Takes in the query and generates the email cards
        private function generateEmailCards($query){
            // Write the query to get inbox
            $sql = $query;

            // execute query
            $result = mysqli_query($this->conn, $sql);

            //Check if query fails
            if(!$result){
                die("ERROR: Could not able to execute $sql. " . mysqli_error($this->conn));
            }else{
                // Create an email card for each record returned and print them in the mail page
                while ($data = mysqli_fetch_array($result)){
                    echo $this->emailCard($data['image'], $data['dateSent'], $data['timeSent'], $data['fname'],
                    $data['lname'], $data['subject'], $data['content'], $data['email']);
                }

                //Update Email preview to view full email content when an email card is selected
                echo $this->clickable();
            }
        }

        // Create an email card for each record in the email table in the database
        private function emailCard($img, $date, $time, $fname, $lname, $subject, $content, $email){
            // Get the time that'll be displayed on the

            $timespan = date('m/d/Y', strtotime($date.' '.$time));
            $current = strtotime(date("Y-m-d"));

            $dat = strtotime($date);
            // $time = date('h:i', strtotime($time));

            $datediff = $dat - $current;
            $difference = floor($datediff/(60*60*24));
            if($difference==0){
                $timespan = 'Today';
            }
            else if($difference > -1 && $difference < 0){
                $timespan = 'Yesterday';
            } 

            return "<div class='email-card'>
            <img src='verification/uploads/".$img."' alt='IMG'>
            <span class='dot'></span>
            <p class='date' hidden>".$date."</p>
            <p class='time' hidden>".$time."</p>
            <p class='senderEmail' hidden>".$email."</p>
            <div class='name'>
                <p>".$fname.' '.$lname."</p>
            </div>
            <div class='sub'>
                <p>".$subject."</p><p class='timespan'>".$timespan."</p>
            </div>
            <div class='text'>
                <p> ".$content."</p>
            </div>	
        </div>";

        }

        //Update Email Preview on email card selection
        private function clickable(){
            echo "<script>
                $('.email-card').on('click', function(){
                let exist = document.getElementsByClassName('select');
                if (exist.length > 0){
                    exist[0].classList.remove('select');
                }
    
                let img = $(this).closest('.email-card').children('img').attr('src');
                let name = $(this).closest('.email-card').children('.name').children('p').html();
                let subject = $(this).closest('.email-card').children('.sub').children('p').html();
                let content = $(this).closest('.email-card').children('.text').children('p').html();
                let date = $(this).closest('.email-card').children('.date').html();
                let time = $(this).closest('.email-card').children('.time').html();
                
                $('.options li').css('color', 'rgb(81, 99, 138)')
                $('.options li').css('cursor', 'pointer')
                $(this).addClass('select');
    
                //display full email in email-preview
                $.get('Email.php', {preview: 'true', img: img, name: name, sub: subject, content: content, date: date, time: time}, function(data){
                    $('.email-preview').html(data);
                });
    
            });
            </script>
        ";
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
        </div>
        
        <script>
            $('.email-preview .timespan').css('display', 'none');

        </script>
        ";
    }


    // Check if ajax request has been received
    if (isset($_GET['menu'])){
        $menu = new Email($_GET['id'], $_GET['email'], $conn);
        // Dislay respective information of selected side menu
        switch ($_GET['menu']) {
            
            case 'inbox':
                $menu->inbox();
                break;
            case 'sent':
                $menu->sent();
                break;
            case 'trash':
                $menu->trash();
                break;
            default:
                echo "";
                break;
        }
    }

    // Check if ajax request has been received and return results for what was search for
    if (isset($_GET['search'])){
        // Create Email object
        $menu = new Email($_SESSION['id'], $_SESSION['userEmail'], $conn);

        // Return results
        $menu->search($_GET['info'], $_GET['table']);
        
    }

?>