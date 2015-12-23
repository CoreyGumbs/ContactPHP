/*
 Corey Gumbs
 Week 4 Final Exam
 Contact Manager
 Fia O'Loughlin - Instructor
 SSL-1115
 11/20/15
 */

$(document).ready(function(){

    //client.php form functionality
    //hides and shows form on button click
    $(".showForm").hide();
    $("#showTog").show();

    $("#showTog").click(function(){
        $(".showForm").toggle("drop");
    });

    //updateContact.php form functionality
    //hides and shows form on button click
    $(".showForm").hide();
    $("#showTog2").show();

    $("#showTog2").click(function(){
        $(".showForm").toggle("drop");
    });

    //creates fade in/out effect on update confirmation div in $_SESSION
    $(".confirmed").fadeIn().delay(500).fadeOut(2000);

    //creates fade in/out effect on delet confirmation div in $_SESSION
    $(".contactDelete").fadeIn().delay(500).fadeOut(2000);

});
