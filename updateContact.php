<?php
/*
Corey Gumbs
Week 4 Final Exam
Contact Manager
Fia O'Loughlin - Instructor
SSL-1115
11/20/15
*/

//start session for update confirmation
session_start();


//establish DB connection
$user = 'root';
$pass = 'root';
$dbh = new PDO('mysql:host=localhost;dbname=SSL;port=8889;', $user, $pass);

$id =$_GET['id'];

$stml = $dbh->prepare("select * from contacts where id = :contactId");
$stml->bindParam(':contactId', $id);
$stml->execute();
$result = $stml->fetchAll(PDO::FETCH_ASSOC);


//database function that updates any newly inputed information into database seperately
//prevents the deletion of data not updated in database
function databaseUpdate($fname, $lname, $phone, $email, $othEmail, $website, $note, $image){
    $user = 'root';
    $pass = 'root';
    $dbh = new PDO('mysql:host=localhost;dbname=SSL;port=8889;', $user, $pass);

    $id = $_GET['id'];

    //check if database returns null for columns and updates to database if there is no issues.
    if($fname != NULL){
        $stml = $dbh->prepare("update contacts set firstname='{$fname}' WHERE id='{$id}'");
        $stml->execute();
    }

    if($lname != NULL){
        $stml = $dbh->prepare("update contacts set lastname='{$lname}' WHERE id='{$id}'");
        $stml->execute();
    }
    if($phone != NULL){
        $stml = $dbh->prepare("update contacts set contactPhone='{$phone}' WHERE id='{$id}'");
        $stml->execute();
    }

    if($email != NULL){
        $stml = $dbh->prepare("update contacts set contactEmail='{$email}' WHERE id='{$id}'");
        $stml->execute();
    }

    if($othEmail != NULL){
        $stml = $dbh->prepare("update contacts set altEmail='{$othEmail}' WHERE id='{$id}'");
        $stml->execute();
    }

    if($website != NULL){
        $stml = $dbh->prepare("update contacts set contactWebsite='{$website}' WHERE id='{$id}'");
        $stml->execute();
    }

    if($note != NULL){
        $stml = $dbh->prepare("update contacts set contactNotes='{$note}' WHERE id='{$id}'");
        $stml->execute();
    }

    if($image != NULL){
        $stml = $dbh->prepare("update contacts set contactImage='{$image}' WHERE id='{$id}'");
        $stml->execute();
    }
}

//updates images to database
function updateImage(){
    if(!empty($_FILES['img_upload']['name'])){
        //sets variable to store file type information
        $img_type = $_FILES['img_upload']['name'];
        var_dump($img_type);
        //an array that stores the required file fo rmats allowed
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

//function that does logic and outputs
function updateContacts()
{

    //establish DB connection
    $user = 'root';
    $pass = 'root';
    $dbh = new PDO('mysql:host=localhost;dbname=SSL;port=8889;', $user, $pass);

    $id =$_GET['id'];

    $stml = $dbh->prepare("select * from contacts where id = :contactId");
    $stml->bindParam(':contactId', $id);
    $stml->execute();
    $result = $stml->fetchAll(PDO::FETCH_ASSOC);

    //checks if there is data returned from database and if none/null
    //inputs placeholder information in its place.
    if (is_null($result[0]['contactImage'])) {
        $result[0]['contactImage'] = "images/no_image.png";
    }

    if(is_null($result[0]['altEmail'])|| empty($result[0]['altEmail'])){
        $result[0]['altEmail'] = "Not provided. Please update contact.";
    }

    if(is_null($result[0]['contactWebsite']) || empty($result[0]['contactWebsite'])){
        $result[0]['contactWebsite'] = "Not provided. Please update contact.";
    }

    if(is_null($result[0]['contactNotes']) ||empty($result[0]['contactNotes'])){
        $result[0]['contactNotes'] = "Not provided. Please update contact.";
    }

    //output currently store profile information for user review before updating
    echo "<div class='indUpdate'>
        <h1>Your Current Contact Profile:</h1>
        <div class='updateImg'>
            <h3>Contact Picture:</h3>
            <img src='{$result[0]['contactImage']}'/>
        </div>
        <div class='updateInfo'>
            <h3>Conact Information:</h3>
            <h1>{$result[0]['firstname']} {$result[0]['lastname']}</h1>
            <h3><span>Phone:</span> {$result[0]['contactPhone']}</h3>
            <h3><span>Primary Email:</span> {$result[0]['contactEmail']}</h3>
            <h3><span>Other Email:</span> {$result[0]['altEmail']}</h3>
            <h3><span>Website:</span> {$result[0]['contactWebsite']}</h3>
            <h3><span>Notes:</span> {$result[0]['contactNotes']}</h3>
        </div>
    </div>";

}

//on submit logic
if(isset($_POST['submit'])){
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $phone = $_POST['phone'];
    $primeEml = $_POST['prim_email'];
    $otherEml = $_POST['other_email'];
    $website = $_POST['website'];
    $notes = $_POST['comments'];

    //calls the update image function on submit
    $img = updateImage();

    //creates confirmaiton session message on post
    $_SESSION["message"] = "<div class='confirmed'><h4>Update Successful!</h4></div>";

    //calls update function on any inputed data to form
    databaseUpdate($fname, $lname, $phone, $primeEml, $otherEml,$website, $notes, $img);

    //returns user to index.php page
    header("Location: index.php");
}

echo "
<!doctype html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Contact Dashboard</title>
    <link rel='stylesheet' href='css/normalize.css'>
    <link rel='stylesheet' href='css/style.css'>
</head>
<body>
<nav>
    <h1>iForget Contact Manager</h1>
    <a href='index.php'><button id='cancel'>Cancel</button></a>
    <button id='showTog2'>Update Contact</button>
</nav>
<aside class='showForm'>
    <div id='formSection'>
        <h4>Update Contact</h4>
        <form action='' enctype='multipart/form-data' method='post'>
            <label for='first_name'>First Name : </label><input id='first_name' type='text' name='first_name' value='' /><br/>
            <label for='last_name'>Last Name : </label><input  id='last_name' type='text' name='last_name' value='' /><br />
            <label for='phone'>Phone : XXX-XXX-XXXX </label><input id='phone' type='tel' name='phone' value='' maxlength='20' /><br />
            <label for='prim_email'>Primary Email : </label><input id='prim_email' type='email' name='prim_email' value='' /><br />
            <label for='other_email'>Other Email : </label><input id='other_email' type='email' name='other_email' value='' /><br />
            <label for='website'>Web Site: </label><input id='website' type='url' name='website' value='' /><br />
            <label for='notes'>Notes:</label><br /><textarea name='comments' id='notes'   maxlength='150'></textarea><br />
            <label for='img_upload'>Upload Image: </label><input id='img_upload' type='file' name='img_upload' value='upload' /><br />
            <input type='submit' name='submit' value='submit' />
            <input type='reset' name='reset' value='reset'' />
        </form>
    </div>
</aside>
<div class='instructions'>
    <h1>Update Contacts.<br></h1>
    <h2>Update your contacts.</h2>
    <h2>Update whatever field you like.</h2>
    <h3>Click the update contact button to get started.</h3>

</div>

<section id='update'>";
 updateContacts();
echo "</section>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script>
<script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js'></script>
<script language='JavaScript' type='text/javascript' src='js/scripts.js'></script>
</body>
</html>
";

