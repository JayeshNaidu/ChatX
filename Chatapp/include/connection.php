<?php
  $con = mysqli_connect('localhost','root','','mychat') or die('connection error');

  //check connection
  if($con == false){
    die('connection error'. mysqli_connect_error());
  }

 ?>
