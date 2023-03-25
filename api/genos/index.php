<?php
$servername = "localhost";
$username = "epink";
$password = "880208Limitless@";
$dbname = "admin_epink";
$domain = 'https://epink.health/api';
$db = new mysqli($servername, $username, $password, $dbname);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}else{
	echo 'Connected';
}
echo '<h1>GENOS<br>Table<br></h1>';

$sql = "SHOW TABLES";
$result = $db->query($sql);
if ($result->num_rows > 0) {
$tables = $result->fetch_all();
foreach($tables as $table)
{
	$tablename = $table[0];
	$tabletoedit = $table[0];
    echo '<h2>'. $tablename .'</h2>
	<a href="'.$domain.'/genos/generator.php?table='. $tablename .'&action=viewall">View All</a><br>
	<a href="'.$domain.'/genos/generator.php?table='. $tablename .'&action=viewthis">View This</a><br>
	<a href="'.$domain.'/genos/generator.php?table='. $tablename .'&action=insert">Create</a><br>
	<a href="'.$domain.'/genos/generator.php?table='. $tablename .'&action=edit">Edit</a><br>
	<a href="'.$domain.'/genos/generator.php?table='. $tablename .'&action=delete">Delete</a><br>
	
	<a href="'.$domain.'/genos/generator.php?table='. $tablename .'&action=viewall&backlink=-management">View All</a><br>
	<a href="'.$domain.'/genos/generator.php?table='. $tablename .'&action=viewthis&backlink=-management">View This</a><br>
	<a href="'.$domain.'/genos/generator.php?table='. $tablename .'&action=insert&backlink=-management">Create</a><br>
	<a href="'.$domain.'/genos/generator.php?table='. $tablename .'&action=edit&backlink=-management">Edit</a><br>
	<a href="'.$domain.'/genos/generator.php?table='. $tablename .'&action=delete&backlink=-management">Delete</a><br>
	';
}
}else{
	echo 'NADA';
}
?>
