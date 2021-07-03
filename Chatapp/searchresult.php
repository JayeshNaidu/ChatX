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
    $search = $_SESSION['search'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wassup</title>
    <!-- external stylesheets -->
    <link rel="stylesheet" href="css/newstyles2.css">
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
margin-right: 2rem
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



<div class="container mt-4">
      <div class="card mycard">
        <div class="card-title text-center">
          <form class="form-inline mt-4" style = "display : inline-block" method = "POST" action = ".\searchuser.php">
            <input class="form-control mr-sm-2" type="search" name = "search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
        <div class="card-body mb-4">
          <?php
            $searchUser = "SELECT * FROM users WHERE user_name = '$search' OR user_email = '$search'";
            $searchUserStatus = mysqli_query($con,$searchUser) or die(mysqli_error($con));
            if(mysqli_num_rows($searchUserStatus) > 0) {
                while($searchUserRow = mysqli_fetch_assoc($searchUserStatus)){
                    $email = $searchUserRow['user_email'];
          ?>
          <div class="card">
            <div class="card-body">
                <h6><strong><img class="friendspic" src = "images/<?=$searchUserRow['dp']?>" alt = "dp" width = "40"/><?=$searchUserRow['user_name']?></strong><a href="./messages.php?receiver=<?=$email?>" class="btn btn-outline-primary" style = "float:right">Send message</a></h6>
            </div>
          </div>
          <?php
                }
            } else {
                echo "No users found!";
            }
          ?>
        </div>
      </div>
    </div>

    <!-- Bootstrap scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <!-- Scripts -->

</body>
</html>
