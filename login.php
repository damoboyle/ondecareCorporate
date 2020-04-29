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

    $email = $_POST ['username'];
    $password = $_POST ['logpsw'];

    $sql = "SELECT id, password FROM epiz_25644198_ondecare.corporate WHERE email='$email'";
    $results = mysqli_query($conn, $sql);

    if(mysqli_num_rows($results) > 0)
    {
		while($record = mysqli_fetch_assoc($results))
		{
			if(SHA1($password) == $record["password"])
			{
				echo "Logging In<br/>";
		
				//Pass Company id so relevent data may be pulled from Database
				echo '<form id="data" method="post" action="metric.php">
					<input type="hidden" name="id" value="'.$record["id"].'">
					If not redirected<br/>
					<button type="submit">Click Here</button>
				</form>';
				echo "<script>
    					document.getElementById('data').submit();
					</script>";
			}
			else
			{
				echo "Incorrect Password";
				echo "<script>
						alert('The Password you entered was incorrcet. Please try again!');
						window.location.href='index.html';
					</script>";
			}
		}	
   }
   else
   {
   	header ($_SERVER['SERVER_PROTOCOL'] . '204 No Content');
	echo("No records found");

	echo "<script>
			alert('That user does not exist!');
			window.location.href='index.html';
		</script>";
   }

   $conn->close();
?>