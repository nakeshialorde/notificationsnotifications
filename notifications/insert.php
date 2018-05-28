<?php
//insert.php
if(isset($_POST["cobnotifications"]))
{
 include("notifications/connect.php");
 $email = mysqli_real_escape_string($con, $_POST["email"]);
 $subject = mysqli_real_escape_string($con, $_POST["subject"]);
 $message = mysqli_real_escape_string($con, $_POST["message"]);
 mysqli_query($con,"SELECT * FROM cobnotifications");
 mysqli_query($con,"INSERT INTO cobnotifications (notification_id, user_id, email, subject, message)
 VALUES ('$subject', '$message')");
 mysqli_close($con);
?>
