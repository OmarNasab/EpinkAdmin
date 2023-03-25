<?php
header("Access-Control-Allow-Origin: *");
$servername = "localhost";
$username = "epink";
$password = "880208Limitless@";
$dbname = "admin_epink";
header('Content-Type: application/xml; charset=utf-8');
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM users WHERE type ='2'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  echo '<markers>';
  while($row = $result->fetch_assoc()) {
$runnerid = $row["id"];
/* $sqls = "UPDATE users SET availability='Off' WHERE id='$runnerid'";

if ($conn->query($sqls) === TRUE) {
  echo "Record updated successfully";
} else {
  echo "Error updating record: " . $conn->error;
} */
    echo '  <marker id="'.$row["id"].'" name="'.$row["firstname"].' '.$row["lastname"].'" address="Credit RM'.$row["rider_credit"].'" lat="'.$row["lat"].'" lng="'.$row["lng"].'" type="Rider" />';
  }
  echo '</markers>';
} else {
  echo "0 results";
}
$conn->close();
?>