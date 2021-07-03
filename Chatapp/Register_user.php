<?php
session_start();
include('include/connection.php');

$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if(isset($_POST['submit'])){

  $name = mysqli_real_escape_string($con,$_POST['user_name']);
  $pass =  mysqli_real_escape_string($con,$_POST['user_pass']);
  $email = mysqli_real_escape_string($con,$_POST['user_email']);
  $filename = $_FILES['fileToUpload']['name'];
  $filesize = $_FILES['fileToUpload']['size'];


  //check if its actual image or fake
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
 if($check !== false) {
   echo "File is an image - " . $check["mime"] . ".";
   $uploadOk = 1;
 } else {
   echo "File is not an image.";
   $uploadOk = 0;
 }

}

// Check if file already exists
//if (file_exists($target_file)) {
  //echo "Sorry, file already exists.";
  //$uploadOk = 0;
//}


// Check file size
//if ($_FILES["fileToUpload"]["size"] > 500000) {
//  echo "Sorry, your file is too large.";
  //$uploadOk = 0;
//}


// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}


$pp = basename($_FILES["fileToUpload"]["name"]);








// Name and pass  and email check

  if(strlen($name)<1){
    echo "<script>alert('please enter valid name')</script>";
  }

  if(strlen($pass)<8){
      echo "<script>alert('Password should be more than 8 characters')</script>";
      exit();
  }

  $emailcheck = "SELECT * FROM users WHERE user_email = '$email'";
  $runcheck = mysqli_query($con,$emailcheck);
  $check = mysqli_num_rows($runcheck);
  if($check==1){
      echo "<script>alert('Email already exists')</script>";
      echo "<script>window.open('Signup.php','_self')</script>";
      exit();
  }
  else{

  }

  //Inserting data into DB

  $sql= "INSERT INTO users (user_name,user_email,user_pass,dp) VALUES ('$name','$email',MD5('$pass'),'$pp')";

  $query = mysqli_query($con, $sql);

  if(!$query){
    echo 'error' . mysqli_error($con);
  }
  else {
    echo "<script> alert('Congratulations $name, your account has been created') </script>";
    echo"<script>window.open('Signup.php','_self')</script>";
  }

  mysqli_close($con);

 ?>
