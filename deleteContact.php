<?php
/*
Corey Gumbs
Week 4 Final Exam
Contact Manager
Fia O'Loughlin - Instructor
SSL-1115
11/20/15
*/

//session that produces a confirmation of delete
session_start();
$_SESSION["message"] = "<div class='contactDelete'><h4>Contact Deleted</h4></div>";

//connects database
$user = "root";
$pass = "root";
$dbh = new PDO('mysql:host=localhost;dbname=SSL;port=8889;', $user, $pass);

//gets contact id
$contactid = $_GET['id'];

//deletes selected contact from database
if(isset($contactid)) {
    $stmt = $dbh->prepare("DELETE FROM contacts WHERE id IN (:contactid);");
    $stmt->bindParam(':contactid', $contactid);
    $stmt->execute();
}

//returns user to index.php page
header('Location: index.php');
