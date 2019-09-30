<?php

$name = $_POST['name'];
$email = $_POST['email'];
$comments = $_POST['comments'];

if(!empty($name) || !empty($email) || !empty($comments)){
	$host = "localhost";
	$dbUsername = "koi";
	$dbPassword = "password";
	$dbname = "newleafDB";


	$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
	if(mysqli_connect_error()){
		die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
	}
	else{
		$SELECT = "SELECT email From comments Where email = ? Limit 1";
		$INSERT = "INSERT Into comments (name, email, comments) values (?, ?, ?)";


		$stmt = $conn->prepare($SELECT);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->bind_result($email);
		$stmt->store_result();
		$rnum = $stmt->num_rows;

		if($rnum==0){
			$stmt->close();
			$stmt = $conn->prepare($INSERT);
			$stmt->bind_param("sss", $name, $email,$comments);
			$stmt->execute();

			
			header('Location: http://newleaf.onthewifi.com/thanks.html');
		}
		else{
				header('Location: http://newleaf.onthewifi.com/oops.html');
		}
	}
}
else{
	header('Location: http://newleaf.onthewifi.com/oops.html');
	die();}

?>