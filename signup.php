<?php
	$host = "sql202.epizy.com:3306";
	$database = "epiz_25644198_ondecare";
	$username = "epiz_25644198";
	$password = "25nGNQu3B0";

   $conn = mysqli_connect($host, $username, $password, $database);
   	if(!$conn)
   	{
		die("Unable to connect: " . $conn->connect_error);
    }

    $company = $_POST ['company'];
    $executive = $_POST ['executive'];
    $email = $_POST ['email'];
    $password = $_POST ['SUpsw'];

    $sql = "SELECT * FROM epiz_25644198_ondecare.corporate WHERE email='$email'";
    $results = mysqli_query($conn, $sql);
    if(mysqli_num_rows($results) != NULL)
    {
    	echo 	"<script>
					alert('Email address already exists within our System! Account cannot be created, Please try again.');
					window.location.href='index.html';
				</script>";
    } else {
	    //Add Company to Corporate Database
	    $sql1 = "INSERT INTO epiz_25644198_ondecare.corporate (company, executive, email, password, address, gift, daycare) VALUES ('$company', '$executive', '$email', SHA1('$password'), '', 0, 0)";

	    if ($conn->query($sql1) === TRUE)
	    {
		    echo "Your Information has been processed successfully!";
		    header ($_SERVER['SERVER_PROTOCOL'] . '201 Created');
		} else
	    	echo "Error: " . $sql1 . "<br>" . $conn->error;

	    //Send an email to the user with their login information

	    //Get Company id from Database
	    $sql2 = "SELECT id FROM epiz_25644198_ondecare.corporate WHERE email='$email'";
	    $results = mysqli_query($conn, $sql2);
	    $record = mysqli_fetch_assoc($results);
	    $name = "id_".$record["id"];

		//Create Database to Maintain Specific Corporate Information
	    $sql3 = "CREATE TABLE $name (
			sponsored_name VARCHAR(30) NOT NULL,
			sponsored_email VARCHAR(50) NOT NULL PRIMARY KEY,
			subsidised VARCHAR(15) NOT NULL
		)";

	    if ($conn->query($sql3) === TRUE)
	    {
		    echo "<br/>Backend Corporate Information Configured!";
		    header ($_SERVER['SERVER_PROTOCOL'] . '201 Created');

		    echo "<br/>Logging In<br/>";
		
			//Pass Company id so relevent data may be pulled from Database
			echo '<form id="data" method="post" action="metric.php">
				<input type="hidden" name="id" value="'.$record["id"].'">
				If not redirected<br/>
				<button type="submit">Click Here</button>
				</form>';
			echo "<script>
    				document.getElementById('data').submit();
				</script>";
		} else {
	    	echo "Error: " . $sql . "<br>" . $conn->error;

	    	echo "<br/>Failed to Signup";
				echo "<script>
						alert('We were unable to process your information at this time... Please Try Again.');
						window.location.href='index.html';
					</script>";
		}
	}

    $conn->close();
?>