<?php
	$host = "sql202.epizy.com";
    $database = "epiz_25644198_ondecare";
    $username = "epiz_25644198";
    $password = "25nGNQu3B0";

   $conn = mysqli_connect($host, $username, $password, $database);
   	if(!$conn)
   	{
		die("Unable to connect: " . $conn->connect_error);
    }

    $dbTable = $_POST ['id'];
    //Total number of employees passed
    $total = (count($_POST) -2) /3;

    for ($x = 1; $x <= $total; $x++) {
    	$name = $_POST ['eName'.$x];
	    $email = $_POST ['email'.$x];
	    $plan = $_POST ['spinner'.$x];

	    $sql = "SELECT sponsored_name FROM epiz_25644198_ondecare.id_$dbTable WHERE email='$email'";
    	$results = mysqli_query($conn, $sql);
    	
    		$sql1 = "INSERT INTO epiz_25644198_ondecare.id_$dbTable (sponsored_name, sponsored_email, subsidised) VALUES ('$name', '$email', '$plan')";

		if ($conn->query($sql1) === TRUE)
		{
			echo "Row$x posted<br/>";
			header ($_SERVER['SERVER_PROTOCOL'] . '201 Created');
		} else {
		    echo "Error: " . $sql1 . "<br>" . $conn->error;

		    $record = mysqli_fetch_assoc($results);
    		echo "<script>
					alert('Cannot add ".$name." to your client list. That Email: ".$email." is already associated with ".$record['sponsored_name']."');
				</script>";
		}
	}
	echo '<form id="data" method="post" action="metric.php">
			<input type="hidden" name="id" value="'.$dbTable.'">
			If not redirected<br/>
			<button type="submit">Click Here</button>
		</form>';
	echo "<script>
    		document.getElementById('data').submit();
		</script>";
?>