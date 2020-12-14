<?php
    include "verification/config.php";

    // start session
    session_start();

    //Email Class
    class Email{

        //User's id, email and connection to the database
        private $id;
        private $conn;
        private $email;
        private $unreadNumber;
    
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
                        Person.image, Person.fname, Person.lname, Person.email, Email_Sent.status 
                        from Email_Sent 
                        left join Email_Recipient 
                        on Email_Sent.emailID = Email_Recipient.emailID 
                        left join Person 
                        on Email_Sent.perID = Person.perID 
                        left join (select Email_Sent.emailID, EmailGroup_Recipient.groupID 
                        from Email_Sent inner join EmailGroup_Recipient 
                        on Email_Sent.emailID = EmailGroup_Recipient.emailID) as T 
                        on Email_Sent.emailID = T.emailID 
                        where (Email_Recipient.perID ='".$this->id."' or T.groupID in (".$this->getGroups()."))
                        and Email_Sent.subject like '%".$data."%' or Email_Sent.content like '%".$data."%' or Person.fname like '%".$data."%' 
                        or Person.lname like '%".$data."%' or Person.email like '%".$data."%' ";
            }
            elseif ($menu == 'sent'){
                $sql = "SELECT Email_Sent.emailID, Email_Sent.perID as SenderID, Email_Sent.dateSent, Email_Sent.timeSent,
                        Email_Sent.subject, Email_Sent.content, Email_Recipient.perID as RecipientID, T.groupID as GroupRecipientID,
                        Person.image, Person.fname, Person.lname, Person.email, Email_Sent.status
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
                        and (Email_Sent.subject like '%".$data."%' or Email_Sent.content like '%".$data."%' or Person.fname like '%".$data."%' 
                        or Person.lname like '%".$data."%' or Person.email like '%".$data."%') ";

            }
            elseif ($menu == 'trash'){
                $sql = "SELECT Email_Sent.emailID, Email_Sent.perID as SenderID, Email_Sent.dateSent, Email_Sent.timeSent,
                        Email_Sent.subject, Email_Sent.content, Email_Recipient.perID as RecipientID, T.groupID as GroupRecipientID,
                        Person.image, Person.fname, Person.lname, Person.email, Trash.deleterID, Email_Sent.status 
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
                        and (Email_Sent.subject like '%".$data."%' or Email_Sent.content like '%".$data."%' or Person.fname like '%".$data."%' 
                        or Person.lname like '%".$data."%' or Person.email like '%".$data."%') ";
            }
            
            // Generate the email cards
            return $this->generateEmailCards($sql);
        }

        //Get inbox of the user
        public function inbox(){
            // Write the query to get inbox
            $sql = "SELECT Email_Sent.emailID, Email_Sent.perID as SenderID, Email_Sent.dateSent, Email_Sent.timeSent,
             Email_Sent.subject, Email_Sent.content, Email_Recipient.perID as RecipientID, T.groupID as GroupRecipientID,
              Person.image, Person.fname, Person.lname, Person.email, Email_Sent.status
              from Email_Sent 
              left join Email_Recipient 
              on Email_Sent.emailID = Email_Recipient.emailID 
              left join Person 
              on Email_Sent.perID = Person.perID 
              left join (select Email_Sent.emailID, EmailGroup_Recipient.groupID 
              from Email_Sent inner join EmailGroup_Recipient 
              on Email_Sent.emailID = EmailGroup_Recipient.emailID) as T 
              on Email_Sent.emailID = T.emailID 
              where Email_Recipient.perID ='".$this->id."' or T.groupID in (".$this->getGroups().") order by dateSent DESC";

            // Generate the email cards
            return $this->generateEmailCards($sql);
        }

        //Get all emails sent by the user
        public function sent(){
            // Write the query to get sent
            $sql = "SELECT Email_Sent.emailID, Email_Sent.perID as SenderID, Email_Sent.dateSent, Email_Sent.timeSent,
            Email_Sent.subject, Email_Sent.content, Email_Recipient.perID as RecipientID, EmailGroup_Recipient.groupID as GroupRecipientID,
            Person.image, Person.fname, Person.lname, Person.email, Email_Sent.status, Email_Group.name as groupName, Email_Group.groupID, Email_Group.image as groupImage
            from Email_Sent 
            left join Email_Recipient 
            on Email_Sent.emailID = Email_Recipient.emailID 
            left join Person 
            on Email_Recipient.perID = Person.perID 
            left join EmailGroup_Recipient 
            on Email_Sent.emailID = EmailGroup_Recipient.emailID
            left join Email_Group
            on Email_Group.groupID = EmailGroup_Recipient.groupID
            where Email_Sent.perID ='".$this->id."' and (EmailGroup_Recipient.groupID is not null 
            or Email_Recipient.perID is not null)
            order by dateSent DESC";

            // Generate the email cards
            return $this->generateEmailCards($sql);
        }

        public function trash(){

            // Query Without Sent
            $sql = "SELECT Email_Sent.emailID, Email_Sent.perID as SenderID, Email_Sent.dateSent, Email_Sent.timeSent,
            Email_Sent.subject, Email_Sent.content, Email_Group.groupID as groupID, Email_Group.name as 				groupName,
            Email_Group.image as groupImage,
            Person.image, Person.fname, Person.lname, Person.email, Email_Sent.status, Trash.deleterID, Trash.senderID, Trash.recipientID 
            FROM Trash
            left join Email_Sent
            on Email_Sent.emailID = Trash.emailID
            left join Person
            on Person.perID = Email_Sent.perID
            left join Email_Group
            on Email_Group.groupID = Trash.grouprecipientID
            where Trash.deleterID = '6' and (Email_Sent.perID > '".$this->id."' or Email_Sent.perID < '".$this->id."') order by Email_Sent.dateSent DESC";

            // Query With sent
            $sql2 = "SELECT Email_Sent.emailID, Email_Sent.perID as SenderID, Email_Sent.dateSent, Email_Sent.timeSent,
            Email_Sent.subject, Email_Sent.content, Email_Group.groupID as groupID, Email_Group.name as 				groupName,
            Email_Group.image as groupImage,
            Person.image, Person.fname, Person.lname, Person.email, Email_Sent.status, Trash.deleterID, Trash.senderID, Trash.recipientID 
            FROM Trash
            left join Email_Sent
            on Email_Sent.emailID = Trash.emailID
            left join Person
            on Person.perID = Trash.recipientID
            left join Email_Group
            on Email_Group.groupID = Trash.grouprecipientID
            where Trash.senderID = '".$this->id."' order by Email_Sent.dateSent DESC";

            // Generate the email cards
            $this->generateEmailCards($sql);
            $this->generateEmailCards($sql2);
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
                // Get the number of unread emails
                $unread = 0;
                // Create an email card for each record returned and print them in the mail page
                while ($data = mysqli_fetch_array($result)){
                    $img = $data['image'];
                    $fname = $data['fname'];
                    $lname = $data['lname'];
                    $email  = $data['email'];

                    // Check if the email was sent to a group and retrieve the group's details
                    if ($img == ''){
                        $img = $data['groupImage'];
                        $fname = $data['groupName'];
                        $email = $data['SenderID'];
                    }
                    
                    // Increment unread if the email hasn't been read
                    if ($data['status'] == 'UNREAD'){
                        $unread += 1;

                        // Create email card
                        echo $this->emailCard($img, $data['dateSent'], $data['timeSent'], $fname,
                        $lname, $data['subject'], $data['content'], $email, true);
                    }
                    else{
                        // Create email card
                        echo $this->emailCard($img, $data['dateSent'], $data['timeSent'], $fname,
                        $lname, $data['subject'], $data['content'], $email, false);
                    }
                    
                }

                //Update the number of unread emails
                $this->unreadNumber = $unread;

                //Update Email preview to view full email content when an email card is selected
                echo $this->clickable();
            }
        }

        // Create an email card for each record in the email table in the database
        private function emailCard($img, $date, $time, $fname, $lname, $subject, $content, $senderEmail, $status){
            // Get the time that'll be displayed on the

            $timespan = date('m/d/Y', strtotime($date.' '.$time));
            $current = strtotime(date("Y-m-d"));

            $dat = strtotime($date);
            // $time = date('h:i', strtotime($time));

            // Determine the date that should show up on the card
            $datediff = $dat - $current;
            $difference = floor($datediff/(60*60*24));
            if($difference==0){
                $timespan = 'Today';
            }
            else if($difference > -1 && $difference < 0){
                $timespan = 'Yesterday';
            } 

            $indicator = "<span class='dot'></span>";

            if ($status == false){
                $indicator = '';
            }

            return "<div class='email-card'>
            <img src='verification/uploads/".$img."' alt='IMG'>
            ".$indicator."
            <p class='date' hidden>".$date."</p>
            <p class='time' hidden>".$time."</p>
            <p class='senderEmail' hidden>".$senderEmail."</p>
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

            // Set number of emails that are unread
            $unread = "$('.chosen .indicate p').html('".$this->unreadNumber."')";

            if ($this->unreadNumber == 0){
                $unread = '';
            }

            echo "<script>
                $('.email-card').on('click', function(){
                    let exist = document.getElementsByClassName('select');
                    if (exist.length > 0){
                        exist[0].classList.remove('select');
                    }
        
                    // Get details of the selected email
                    let img = $(this).closest('.email-card').children('img').attr('src');
                    let name = $(this).closest('.email-card').children('.name').children('p').html();
                    let subject = $(this).closest('.email-card').children('.sub').children('p').html();
                    let content = $(this).closest('.email-card').children('.text').children('p').html();
                    let date = $(this).closest('.email-card').children('.date').html();
                    let time = $(this).closest('.email-card').children('.time').html();
                    let senderEmail = $(this).children('.senderEmail').html();

                    if ($('.chosen').attr('id') === 'sent'){
                        senderEmail ='".$_SESSION['userEmail']."';
                        name = '';
                    }
                    
                    // Make buttons appear active
                    $('.options li').css('color', 'rgb(81, 99, 138)')
                    $('.options li').css('cursor', 'pointer')
                    $(this).addClass('select');
                    let id = $(this).attr('id');

                    // Temporarily decrement unread number of emails value
                    if ($(this).find('.dot').html() != undefined){
                        let current = $('.chosen').find('.indicate p').html();

                        if (parseInt(current) == 1){
                            $('.chosen').find('.indicate p').html('');
                        }else{
                            $('.chosen').find('.indicate p').html(parseInt(current) - 1);
                        }
                    }

                    // Remove indicator and Mark email as read
                    $(this).find('.dot').remove();
                    $.post('utility/emailFunctions.php', {read: $('.chosen').attr('id'), name: name.split(' ')[0], sub: subject, 
                        date: date, time: time, mail: senderEmail}, function(data){    
                        return;
                    });
        
                    //display full email in email-preview
                    $.get('Email.php', {preview: 'true', img: img, name: name, sub: subject, content: content, date: date, time: time}, function(data){
                        $('.email-preview').html(data);
                    });
                    
                });

                ".$unread."

            </script>
        ";
        }

        // Get all the groups that the user belongs to
        private function getGroups(){
            // Write the query to get inbox
            $sql = "SELECT groupID FROM Person_Email where perID =". $this->id;

            // execute query
            $result = mysqli_query($this->conn, $sql);

            $groups = '';

            //Check if query fails
            if($result){
                // Create an email card for each record returned and print them in the mail page
                while ($data = mysqli_fetch_array($result)){
                    $groups.= '"'.$data['groupID']. '",';
                }

                // Return the groups without the last comma
                return rtrim($groups, ", ");
            }else{
                die("ERROR: Could not able to execute $sql. " . mysqli_error($this->conn));
            }
        }

    }


//-----------------END EMAIL CLASS------------------------ //

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









//--------------------------- PROCESSING---------------------------------- //

    //Check if an email card has been selected from ajax request for preview
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

    // Check if ajax request has been received to show emails of respective side menus
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