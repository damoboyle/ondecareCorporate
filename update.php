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
    $name = $_POST['cName'];
    $executive = $_POST['executive'];
    $email = $_POST['cEmail'];
    $password = $_POST['password'];
    
	$sql = "UPDATE epiz_25644198_ondecare.corporate SET company = '$name', executive = '$executive', email = '$email', password = SHA1('$password') WHERE id=$dbTable";

	if ($conn->query($sql) === TRUE)
	{
		echo "Info Updated";
		header ($_SERVER['SERVER_PROTOCOL'] . '202 Accepted');

		echo "<script>
					alert('Corporate Information Updated Successfully');
				</script>";
	} else {
		echo "Info Failed to Update<br/>Error: " . $sql . "<br>" . $conn->error;

		echo "<script>
					alert('Failed to Update Corporate Information, Please try Again.');
				</script>";
	}

	//Address update criteria
	$query = $_POST['Address'] != "" && $_POST['street'] != "" || $_POST['city'] != "" || $_POST['state'] != "" || $_POST['zip'] != "";

	if ($query) {
		$address = $_POST['Address'] . ", " . $_POST['street']  . ", " . $_POST['city'] . ", " . $_POST['state'] . ", " . $_POST['zip'];

		$sql = "UPDATE epiz_25644198_ondecare.corporate SET address = '$address' WHERE id=$dbTable";

		if ($conn->query($sql) === TRUE)
		{
			echo "<br/>Address Updated";
			header ($_SERVER['SERVER_PROTOCOL'] . '202 Accepted');

			echo "<script>
					alert('Address Updated Successfully');
				</script>";
		} else {
			echo "Address Failed to Update<br/>Error: " . $sql . "<br>" . $conn->error;
			echo "<script>
					alert('Address Failed to Update, Please try again.');
				</script>";
		}
	}
	else {
		echo "<script>
					alert('Your Address was unchanged.');
				</script>";
	}

	echo '<form id="data" method="post" action="metric.php">
			<input type="hidden" name="id" value="'.$dbTable.'">
			If not redirected<br/>
			<button type="submit">Click Here</button>
		</form>';
	echo "<script>
    		document.getElementById('data').submit();
		</script>";

	$conn->close();
?>