<?php

session_start();
echo"rnadi";
include('include/connection.php');

$search="";

if(isset($_POST['search'])){

  $search = $_POST['search'];

}

echo "search=".$search;

if($search!=""){

  $searchUser = "SELECT * FROM users WHERE user_name = '$search' OR user_email = '$search'";
         $searchUserStatus = mysqli_query($con,$searchUser) or die(mysqli_error($con));

         if(mysqli_num_rows($searchUserStatus) > 0) { // if there is an user!

             header('Location: http://localhost/Chatapp/searchresult.php?message=Search_results!');

         } else {

             header('Location: http://localhost/Chatapp/searchresult.php?message=No_user_found!');

         }


     } else { // if the fields is empty!

         header('Location: ../chats.php?message=Please input something!');

     }

     $_SESSION['search'] = $search;



 ?>
