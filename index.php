<?php

/*
Corey Gumbs
Week 4 Final Exam
Contact Manager
Fia O'Loughlin - Instructor
SSL-1115
11/20/15
*/

session_start();
if(isset($_SESSION["message"])){
    echo $_SESSION["message"];
    unset($_SESSION["message"]);
}

//Establish connection to the Database
$user = "root";
$pass = "root";
$dbh = new PDO('mysql:host=localhost;dbname=SSL;port=8889;', $user, $pass);


/*-------------Functions---------*/

//validate user url input
function validateURL($url){
    if(filter_var($url, FILTER_VALIDATE_URL) || (empty($url) == true)){
        return true;
    }else{
        return false;
    }
}

//validate user emails
function validateEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL) || (empty($email) == true)) {
        return true;

    }else{
        return false;
    }
}

//image upload and saving
function saveImage(){
    if(!empty($_FILES['img_upload']['name'])){
        //sets variable to store file type information
        $img_type = $_FILES['img_upload']['name'];

        //an array that stores the required file formats allowed
        $allowed = array('jpg', 'png', 'jpeg');

        //variable that stores the returned information of the uploaded file
        // and its specific file extension
        $type = pathinfo($img_type, PATHINFO_EXTENSION);
        //array conditional that checks the file extension against
        // the allowed array file formats
        if (in_array($type, $allowed)) {
            //variable that takes temp file of uploaded user file
            $tmp_img = $_FILES['img_upload']['tmp_name'];
            //returns trailing name of file/original name of file from temp file
            $img_target = basename($_FILES['img_upload']['name']);
            //directory of where the images are stored.
            $img_directory = "images";
            //moves the uploaded file from temp to the images directory if condition is met.
            move_uploaded_file($tmp_img, $img_directory . "/" . $img_target);
            //prints user's uploaded file to html
            return $img_directory . "/" . $img_target;
        } else {
            //message that displays if file type condition false
            echo "<p class='error'>Wrong File Type.<br/> Please Try Again.</p>";
        }
    }

}

//retrieve contact amount from database
function contactCount(){
    $user = "root";
    $pass = "root";
    $dbh = new PDO('mysql:host=localhost;dbname=SSL;port=8889;', $user, $pass);
//foreach loop/display values
//reads/parses the database and returns the data for output to web page
    $stmt = $dbh->prepare('SELECT count(id) as id from contacts;');
    $stmt->execute();
    $count = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($count as $entry){
        echo "<div class='countAmount'>Contacts ( {$entry['id']} )</div>";
    }
}

//query contacts and output to page
function getContacts()
{
    //Establish connection to the Database
    $user = "root";
    $pass = "root";
    $dbh = new PDO('mysql:host=localhost;dbname=SSL;port=8889;', $user, $pass);

    //reads/parses the database and returns the data for output to web page
    $stmt = $dbh->prepare('SELECT * from contacts order by id ASC ;');
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ////foreach loop/display dynamic values
    //if value is null or empty displays placeholder information in its place
    foreach ($results as $row) {

        if (is_null($row['contactImage']) || empty($row['contactImage'])) {
            $row['contactImage'] = "images/no_image.png";
        }

        if(is_null($row['altEmail']) || empty($row['altEmail'])){
            $row['altEmail'] = "Not provided. Please update contact.";
        }

        if(is_null($row['contactWebsite']) || empty($row['contactWebsite'])){
            $row['contactWebsite'] = "Not provided. Please update contact.";
        }

        if(is_null($row['contactNotes']) || empty($row['contactNotes'])){
            $row['contactNotes'] = "Not provided. Please update contact.";
        }

        //output results to contact page
        echo "<div class='indContacts''>
                    <h3 class='idHead'>ID: {$row['id']}</h3>
                    <div class='contactImg'>
                    <img src='{$row['contactImage']}'>
                    </div>
                    <div class='contactInfo'>
                    <h2> {$row['firstname']} {$row['lastname']}</h2>
                    <h5><span>Phone:</span> {$row['contactPhone']}</h5>
                    <h5><span>Primary Email:</span> {$row['contactEmail']}</h5>
                    <h5><span>Other Email:</span> {$row['altEmail']}</h5>
                    <h5><span>Website:</span> {$row['contactWebsite']}</h5>
                    <h5><span>Notes:</span> {$row['contactNotes']}</h5>
                    </div>
                    <div class='actionBtn'>
                    <a href='updateContact.php?id={$row['id']}'><button class='updateBtn'>Update</button></a>
                    <!-- uses Delete button uses javascript confirm() for delete confirmation alert -->
                    <a href='deleteContact.php?id={$row['id']}' onclick=\"return confirm('Delete this contact?')\"><button class='deleteBtn'>Delete</button></a>
                    </div>
                </div>";
    }
}

//End function libraries
//start logic - Validation and Query Database on server request
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    //call validation functions instances
    $primEmailValidate = validateEmail($_POST['prim_email']);
    $otherEmailValidate = validateEmail($_POST['other_email']);
    $urlValidate = validateURL($_POST['website']);

    //email and url validation logic
    if($primEmailValidate == false || $urlValidate == false || $otherEmailValidate == false ) {

        if ($primEmailValidate == false) {
            echo "<div class='error_msg'>Please Enter Valid Primary Email. You Entered {$_POST['prim_email']}</div>";
        }

        if ($otherEmailValidate == false) {
            echo "<div class='error_msg'>Please Enter Valid Other Email. You Entered {$_POST['other_email']}</div>";
        }

        if ($urlValidate == true) {
            echo "<div class='error_msg'>Please Enter Valid URL using \"http://www.\" format. You Entered: {$_POST['website']}</div>";
        }

    }else{

        //set $_POST data variables
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $phoneNum = $_POST['phone'];
        $primEmail = $_POST['prim_email'];
        $otherEmail = $_POST['other_email'];
        $otherEmail = $_POST['other_email'];
        $website = $_POST['website'];
        $notes = $_POST['comments'];
        $image = saveImage();


        //insert binded data collected from form into database
        $stmt = $dbh->prepare("insert into contacts(firstname, lastname, contactPhone, contactEmail, altEmail, contactWebsite, contactImage, contactNotes) values(:firstname, :lastname, :phone, :email, :altEmail, :website, :image, :notes)");
        $stmt->bindParam(':firstname', $firstName);
        $stmt->bindParam(':lastname', $lastName);
        $stmt->bindParam(':phone', $phoneNum);
        $stmt->bindParam(':email', $primEmail);
        $stmt->bindParam(':altEmail', $otherEmail);
        $stmt->bindParam(':website', $website);
        $stmt->bindParam(':notes', $notes);
        $stmt->bindParam(':image', $image);
        $stmt->execute();
    }
}

//end logic
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Dashboard</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav>
    <h1>iForget Contact Manager</h1>
    <?php contactCount(); ?>
    <button id="showTog">Add Contact</button>
</nav>
<aside class="showForm">
    <div id="formSection">
        <h4>Add Contacts</h4>
        <form action="index.php" enctype="multipart/form-data" method="post">
            <label for="first_name">First Name<span>*</span> : </label><input id="first_name" type="text" name="first_name" value="" required /><br/>
            <label for="last_name">Last Name<span>*</span> : </label><input  id="last_name" type="text" name="last_name" value="" required /><br />
            <label for="phone">Phone<span>*</span> : </label><input id="phone" type="tel" name="phone" value="" maxlength="20" required /><br />
            <label for="prim_email">Primary Email<span>*</span> : </label><input id="prim_email" type="email" name="prim_email" value="" required /><br />
            <label for="other_email">Other Email: </label><input id="other_email" type="email" name="other_email" value="" /><br />
            <label for="website">Web Site: </label><input id="website" type="url" name="website" value="" /><br />
            <label for="notes">Notes:</label><br /><textarea name="comments" id="notes"   maxlength="150"></textarea><br />
            <label for="img_upload">Upload Image: </label><input id="img_upload" type="file" name="img_upload" value="upload" /><br />
            <input type="submit" name="submit" value="submit" />
            <input type="reset" name="reset" value="reset" />
        </form>
    </div>
</aside>
<div class="instructions">
    <h1>Add Contacts. <br>Update Contacts.<br> Delete Contacts.<br></h1>
    <h2>Enter your contacts.</h2>
    <h3>Click the add contact button to get started.</h3>
</div>

<section id="contacts">

    <?php
    getContacts();
    ?>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/scripts.js"></script>
</body>
</html>