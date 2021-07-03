<?php

    // session start
    session_start();

    // include DB connection
    include('include/connection.php');

    // declaring variables
    $email = "";
    $password = "";

    // getting form data!
    if(isset($_POST['email'])) {
        $email = $_POST['email'];
    }

    if(isset($_POST['password'])) {
        $password = $_POST['password'];
    }


    if($email != "" && $password != "") { // if the fields are not empty!

        $checkUser = "SELECT * FROM `users` WHERE `user_email` = '$email'";
        $checkUserStatus = mysqli_query($con,$checkUser) or die(mysqli_error($con));

        if(mysqli_num_rows($checkUserStatus) > 0) { // if user exists!
          $_SESSION['email'] = $email;
          header('Location: ./chats.php?message=Yokoso! You have successfully logged in!');



        } else {

            header('Location: ./Signup.php?message=Unable to login into your account!');

        }

    } else { // if the fields are empty!

        header('Location: ./Signup.php?message=Please fill all the fields!');

    }

?>
