<?php
//three atributes to post to mysql
$name = $_POST['name'];
$email = $_POST['email'];
$comments = $_POST['comments'];
//checks if they are not empty fields then sets the other values needed to gain access
if(!empty($name) || !empty($email) || !empty($comments)){
	$host = "localhost";
	$dbUsername = "koi";
	$dbPassword = "password";
	$dbname = "newleafDB";

	//connection code to mysql with parameters
	$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
	//kills the connection if there is an error and doesnt hang forever
	if(mysqli_connect_error()){
		die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
	}
	else{
		//allows only one email per person, this is temporary.
		//wanted to reduce spam emails
		$SELECT = "SELECT email From comments Where email = ? Limit 1";
		//inserts into table called comments 
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

			//successful post, it will redirect to thanks message
			header('Location: http://newleaf.onthewifi.com/thanks.html');
		}
		else{	//failed post, send oops message
				header('Location: http://newleaf.onthewifi.com/oops.html');
		}
	}
}//failed post, send oops message
else{
	header('Location: http://newleaf.onthewifi.com/oops.html');
	die();}

?>