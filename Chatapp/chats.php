<?php

    // session start
    session_start();


    // include DB connection
    include('include/connection.php');

    if(!isset($_SESSION['email'])) { // if user not logged in!

        header('Location: ./index.php');

    } else {

        $email = $_SESSION['email'];


    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
    <!-- external stylesheets -->
    <!--fonts-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@700&display=swap" rel="stylesheet">

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>

<style media="screen">
  body{
    background-image:url('css/Tranquil.jpg') ;
    font-family: 'Montserrat', sans-serif;
  }
  .navpic{
    width: 40px;
height: 40px;
border-radius: 50%;

  }
  .friendspic{
    width: 100px;
height: 100px;
border-radius: 50%;
margin-right: 2rem;

  }
  .mycard{
    margin-top: 20%;
  }
</style>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Chat_X</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">

      <?php

       $getUser = "SELECT * FROM users WHERE user_email = '$email'";
       $getUserStatus = mysqli_query($con,$getUser) or die(mysqli_error($con));
       $rows = mysqli_num_rows($getUserStatus);

       $getUserRow = mysqli_fetch_assoc($getUserStatus);

     ?>


     <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img class="navpic"src="images/<?=$getUserRow['dp'] ?>" alt="Profile image" width = "40" class = "dropdown"/>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href=""><?php echo 'Name: '.$getUserRow['user_name']; ?></a>
          <a class="dropdown-item" href=""><?php echo 'Email: '.$email; ?></a>
          <a class="dropdown-item" href="./logout.php">logout</a>



        </div>
      </li>





    </ul>
  </div>
</nav>

    <!-- chats section -->
    <div class="container ">
      <div class="card mycard">
        <div class="card-title text-center">
          <form class="form-inline mt-4" style = "display : inline-block" method = "POST" action = ".\searchuser.php">
            <input class="form-control mr-sm-2" type="search" name = "search" placeholder="Find friends!" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
        <div class="card-body mb-4">
          <?php
            $lastMessage = "SELECT DISTINCT sent_by FROM messages WHERE recieved_by = '$email'";
            $lastMessageStatus = mysqli_query($con,$lastMessage) or die(mysqli_error($con));
            if(mysqli_num_rows($lastMessageStatus) > 0) {
              while($lastMessageRow = mysqli_fetch_assoc($lastMessageStatus)) {
                $sent_by = $lastMessageRow['sent_by'];
                $getSender = "SELECT * FROM users WHERE user_email = '$sent_by'";
                $getSenderStatus = mysqli_query($con,$getSender) or die(mysqli_error($con));
                $getSenderRow = mysqli_fetch_assoc($getSenderStatus);
          ?>
          <div class="card">
            <div class="card-body">
              <h6><strong><img class="friendspic"src = "images/<?=$getSenderRow['dp']?>" alt = "dp" width = "40"/> <?=$lastMessageRow['sent_by'];?></strong><a href="./messages.php?receiver=<?=$sent_by?>" class="btn btn-outline-primary" style = "float:right">Send message</a></h6>
            </div>
          </div><br/>
          <?php
            }
          } else {
          ?>
            <div class="card-body text-center">
              <h6><strong>No conversations yet!</strong></h6>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
    </div>

    <!-- Bootstrap scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/5c4119c7b9.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

</body>
</html>
