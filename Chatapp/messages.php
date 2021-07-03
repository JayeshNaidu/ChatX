<?php

    // session start
    session_start();

    // include DB connection
    include('include/connection.php');

    error_reporting(0);
    if(!isset($_SESSION['email'])) { // if user not logged in!

        header('Location: ./index.php');

    } else {

        $email = $_SESSION['email'];

    }
    $receiver = $_GET['receiver'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wassup</title>
    <!-- external stylesheets -->
    <link rel="stylesheet" href="assets/css/chats.css">
    <link rel="stylesheet" href="assets/css/message.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@700&display=swap" rel="stylesheet">
    <!-- Fontawesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
  <style media="screen">
    body{
      background-image:url('css/Tranquil.jpg') ;
      font-family: 'Montserrat', sans-serif;
    }
    .friendspic{
      width: 100px;
  height: 100px;
  border-radius: 50%;
  margin-right: 2%;
    }
    .navpic{
      width: 40px;
  height: 40px;
  border-radius: 50%;

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


<div class="container">
       <?php
           $getReceiver = "SELECT * FROM users WHERE user_email = '$receiver'";
           $getReceiverStatus = mysqli_query($con,$getReceiver) or die(mysqli_error($con));
           $getReceiverRow = mysqli_fetch_assoc($getReceiverStatus);
           $received_by = $getReceiverRow['user_email'];
       ?>
       <div class="card mt-4">
            <div class="card-header">
                <h6><img class="friendspic" src="images/<?=$getReceiverRow['dp']?>" alt="Profile image" width = "40" "/><strong><?=$getReceiverRow['user_name']?></strong></h6>
            </div>

            <?php
              $getMessage = "SELECT * FROM messages WHERE sent_by = '$receiver' AND recieved_by = '$email' OR sent_by = '$email' AND recieved_by = '$receiver' ORDER BY createdAt asc";
              $getMessageStatus = mysqli_query($con,$getMessage) or die(mysqli_error($con));
              if(mysqli_num_rows($getMessageStatus) > 0) {
                  while($getMessageRow = mysqli_fetch_assoc($getMessageStatus)) {
                              $message_id = $getMessageRow['id'];
              ?>

              <div class="card-body">
                <h6 style = "color: #007bff"><?=$getMessageRow['sent_by']?></h6>
                  <div class="message-box ml-4">
                    <p class="text-center"><?=$getMessageRow['message']?></p>
                  </div>
              </div>
              <?php
                    }
                } else {
            ?>
            <div class="card-body">
                    <p class = "text-muted">No messages yet! Say 'Hi'</p>
            </div>
            <?php
                }
            ?>

            <div class="card-footer text-center">
            <form action="./send.php" method = "POST" style = "display: inline-block">
            <input type="hidden" name = "sent_by" value = "<?=$email?>"/>
            <input type="hidden" name = "received_by" value = "<?=$receiver?>"/>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <input type="text" name = "message" id = "message" class="form-control" placeholder = "Type your message here" autocomplete="off" required/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type = "submit" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

 <!-- Bootstrap scripts -->
 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>
