<?php
	$dbTable = $_POST ['id'];

	$host = "sql202.epizy.com:3306";
	$database = "epiz_25644198_ondecare";
	$username = "epiz_25644198";
	$password = "25nGNQu3B0";

   $conn = mysqli_connect($host, $username, $password, $database);
   	if(!$conn)
   	{
		die("Unable to connect: " . $conn->connect_error);
    }

	if($_FILES['file']['name'])
	{
		$filename = explode('.', $_FILES['file']['name']);
		if($filename[1] == 'csv')
		{
			$handle = fopen($_FILES['file']['tmp_name'], "r");
			while($data = fgetcsv($handle))
			{
				$name = mysqli_real_escape_string($conn, $data[0]);
				$email = mysqli_real_escape_string($conn, $data[1]);
				$plan = mysqli_real_escape_string($conn, $data[2]);

				$sql = "INSERT INTO epiz_25644198_ondecare.id_$dbTable (sponsored_name, sponsored_email, subsidised) VALUES ('$name', '$email', '$plan')";

				mysqli_query($conn)
			}
			fclose($handle);
			echo "<script>
					alert('File Successfully Imported');
				</script>";
		}
		else {
			echo "<script>
					alert('Incorrect File Type. Try Again');
				</script>";
		}
	}
	else {
			echo "<script>
					alert('No File Submitted');
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
?>