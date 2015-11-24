<?php
require_once("../includes/initialize.php");
//require_once("../includes/functions.php");
//require_once("../includes/database.php");
//require_once("../includes/user.php");

/*
if(isset($database)) {echo "true";} else {echo "false";}
echo "<br>";

echo $database->escape_value("Is this working?<br>");


$sql = "INSERT INTO users(id, username, password, first_name, last_name) ";
$sql .= "VALUES (1, 'test_user_1', 'secretpwd', 'sky', 'high')";
$result = $database->query($sql);


$sql = "SELECT * FROM users WHERE id = 1";
$result = $database->query($sql);
$found_user =  $database->fetch_array($result);
echo $found_user['username'];

echo "<hr/>";

//$User = new User();
//$found_user = User::find_all();
*/

// $record = User::find_by_id(1);
// $user =  new User();
// $user->id =  $record['id'];
// $user->username = $record['username'];
// $user->password = $record['password'];
// $user->first_name = $record['first_name'];
// $user->last_name = $record['last_name'];
// echo $user->full_name()."<br>";
// 
// echo $user->username;



$user = User::find_by_id(1);
echo $user->full_name();

echo "<hr>";

$users = User::find_all();
foreach($users as $user) {
	echo "User: ". $user->username. "<br/>";
	echo "Name: ". $user->full_name(). "<br><br>";
}



// $user_set = User::find_all();
// while($user = $database->fetch_Array($user_set)){
// 	echo "User: ". $user['username']. "<br>";
// 	echo "Name: ". $user['first_name']. "<br>";
// }

?>