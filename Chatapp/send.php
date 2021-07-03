<?php
session_start();

include('include/connection.php');

    $sent_by = "";
    $received_by = "";
    $message = "";
    $createdAt = date("Y-m-d h:i:sa");

    // get data from form
    if(isset($_POST['sent_by'])) {

        $sent_by = $_POST['sent_by'];

    }

    if(isset($_POST['received_by'])) {

        $received_by = $_POST['received_by'];

    }

    if(isset($_POST['message'])) {

        $message = $_POST['message'];

    }

    if($message!=""){
      $query = "INSERT INTO messages(sent_by,recieved_by,message,createdAt) VALUES('$sent_by','$received_by','$message','$createdAt')";
      $sendquery= mysqli_query($con,$query) or die(mysqli_error($con));

      if($sendMessageStatus) {

          header("Location: ./messages.php?receiver=$received_by");
    }

    else{
          header("Location: ./messages.php?receiver=$received_by");

    }

}
 ?>
