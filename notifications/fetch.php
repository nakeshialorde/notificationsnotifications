<?php
include('notifications\connect.php');
if(isset($_POST['view'])){
$con = mysqli_connect("localhost", "root", "", "cobnotifications");
if($_POST["view"] != '')
{
    $update_query = "UPDATE cobnotifications SET notification_status = 1 WHERE notification_status=0";
    mysqli_query($con, $update_query);
}
$query = "SELECT * FROM cobnotifications ORDER BY notification_id DESC LIMIT 5";
$result = mysqli_query($con, $query);
$output = '';
if(mysqli_num_rows($result) > 0)
{
 while($row = mysqli_fetch_array($result))
 {
   $output .= '
   <li>
   <a href="#">
   <strong>'.$row["subject"].'</strong><br />
   <small><em>'.$row["messages"].'</em></small>
   </a>
   </li>
   ';
 }
}
else{
     $output .= '<li><a href="#" class="text-bold text-italic">No Notification Found</a></li>';
}

$status_query = "SELECT * FROM cobnotifications WHERE notification_status=0";
$result_query = mysqli_query($con, $status_query);
$count = mysqli_num_rows($result_query);
$data = array(
    'notification' => $output,
    'unseen_notification'  => $count
);

echo json_encode($data);

}

?>
