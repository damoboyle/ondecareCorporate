<?php
	$dbTable = $_POST ['id'];
	$count = 0;

	$host = "sql202.epizy.com:3306";
	$database = "epiz_25644198_ondecare";
	$username = "epiz_25644198";
	$password = "25nGNQu3B0";

	$conn = mysqli_connect($host, $username, $password, $database);
   	if(!$conn)
   	{
		die("Unable to connect: " . $conn->connect_error);
	}

	if($_FILES['userfile']['name'])
	{
		$filename = explode('.', $_FILES['userfile']['name']);
		if($filename[1] == 'csv')
		{
			$handle = fopen($_FILES['userfile']['tmp_name'], "r");
			while($data = fgetcsv($handle))
			{
				++$count;
				$name = mysqli_real_escape_string($conn, $data[0]);
				$email = mysqli_real_escape_string($conn, $data[1]);
				$plan = mysqli_real_escape_string($conn, $data[2]);

				$sql = "INSERT INTO epiz_25644198_ondecare.id_$dbTable (sponsored_name, sponsored_email, subsidised) VALUES ('$name', '$email', '$plan')";

				if ($conn->query($sql) === TRUE)
				{
					echo "Line $count Imported: $name<br/>";
					header ($_SERVER['SERVER_PROTOCOL'] . '201 Created');
				} else {
					echo "<script>
						alert('Unable to upload".$name."'s Information. See Line ".$count." of imported File');
					</script>";
				}
			}
			fclose($handle);
			echo "<script>
				alert('File Successfully Imported');
			</script>";
		} else {
			echo "<script>
				alert('Incorrect File Type. Try Again');
			</script>";
		}
	} else {
			echo "<script>
				alert('File not recognised');
			</script>";
		}

	echo '<form id="data" method="post" action="metric.php">
		<input type="hidden" name="id" value="'.$dbTable.'">
		<br/>If not redirected<br/>
		<button type="submit">Click Here</button>
	</form>';
	echo "<script>
		document.getElementById('data').submit();
	</script>";
?>
