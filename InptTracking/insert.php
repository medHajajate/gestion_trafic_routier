<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$con=mysqli_connect("localhost","root","","loginregister");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
 
// Escape user inputs for security
$user_id = mysqli_real_escape_string($con, $_POST['user_id']);
$longitude = mysqli_real_escape_string($con, $_POST['longitude']);
$latitude = mysqli_real_escape_string($con, $_POST['latitude']);

 
// attempt insert query execution
$sql = "UPDATE  users   SET cercle_long= '$longitude',cercle_lat='$latitude' WHERE user_id='$user_id'";
if(mysqli_query($con, $sql)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
}
 
// close connection
mysqli_close($link);
header('Location: insert.php');
?>