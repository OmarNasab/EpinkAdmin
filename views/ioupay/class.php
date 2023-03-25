<?php
$servername      = "localhost";
$username        = "epink";
$password        = "880208Limitless@";
$dbname          = "admin_epink";
$currentdatetime = date("Y-m-d H:i:s");

$db = new mysqli($servername, $username, $password, $dbname);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}


class users{
    function getName($id){
        global $db;
        $sql    = "SELECT * FROM users WHERE id='$id'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["firstname"] . ' ' . $row["lastname"];
        } else {
            return "User not found";
        }
    }
	function updateFirstname($uid, $newname){
		global $db;
		$sql = "UPDATE users SET firstname='$newname' WHERE id='$uid'";
		if ($db->query($sql) === TRUE) {
			return "Record updated successfully";
		} else {
			return "Error updating record: " . $db->error;
		}
	}
	function checkJson($jsondata){
		$json = json_decode($jsondata);
		foreach ($json as $key => $value){
			echo $key.' '.$value;
		}
	}
	function updateUser($uid, $jsondata){
		global $db;
		$json = json_decode($jsondata);
		foreach ($json as $key => $value){
			$sql = "UPDATE users SET '$key'='$value' WHERE id='$uid'";
			$db->query($sql);
		}
	}
}


$person   = new users();
$person->updateUser(3, '{"firstname":"CLASS", "lastname":"TESTING"}');
echo $person->getName(3);
