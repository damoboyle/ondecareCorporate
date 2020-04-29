<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="description" content="Employer Metric Page">
		<meta name="keywords" content="HTML, CSS, JavaScript, PHP">
		<meta name="author" content="Andrew Barras, Arun Karki, Asim Oli, Damian O'Boyle, Rajib Rijal">
		
		<title>Employer Metrics Page</title>
		<link rel="icon" href="icon.png">
		<link rel="stylesheet" type="fonts" href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" >
		<link rel="stylesheet" type="text/css" href="metric.css">
	</head>

	<body>
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
		    $sponsored = 0;
		    $subs = 0;

		    $sql = "SELECT subsidised FROM epiz_25644198_ondecare.id_$dbTable";
    		$results = mysqli_query($conn, $sql);
    		if(mysqli_num_rows($results) > 0)
		    {
		    	$sponsored = mysqli_num_rows($results);
		    	
		     	while($record = mysqli_fetch_assoc($results))
		     	{
		     		$value = $record["subsidised"];
		     		if($value == "Full Subsidy" || $value == "Mixed")
						$subs++;
		     	}	
		    }
		    else
		    {
		        header ($_SERVER['SERVER_PROTOCOL'] . '204 No Content');
		    }

            $sql = "SELECT gift, daycare FROM epiz_25644198_ondecare.corporate WHERE id=$dbTable";
    		$results = mysqli_query($conn, $sql);
            $manual = mysqli_fetch_assoc($results);

            $gift = $manual['gift'];
            $daycare = $manual['daycare'];

    		echo "<h1>Corporate Dashboard</h1>

			<table cellpadding=15 cellspacing=10 width=70%>
				<tr><td>
					<label>Sponsored Employees: </label>
						<p>$sponsored</p>
							
				</td><td>
					<label>Gift Cards Sent: </label>
						<p>$gift</p>
							
				</td></tr>
				<tr><td>
					<label>Subsidized Employees: </label>
						<p>$subs</p>
							
				</td><td>
					<label>Popup Daycare Events: </label>
						<p>$daycare</p>
				</td></tr>	
			</table>";
		
			//Get Company id from Database
		    $sql2 = "SELECT company, email FROM epiz_25644198_ondecare.corporate WHERE id='$dbTable'";
		    $results = mysqli_query($conn, $sql2);
		    $mailRecord = mysqli_fetch_assoc($results);
		    $name = $mailRecord["company"];
		    $email = $mailRecord["email"];
		?>
		
		<h1>Program Management and Options</h1>
			<button id="gift" onclick="window.location.href='https://expensivejaguar-c7e6.azurewebsites.net/'">Buy/Send Gift Cards</button><!--Will link to Gift Card Page-->
			<button id="popup" onclick="window.location.href='mailto:support@ondecare.com?subject=Request%20for%20PopUp%20DayCare%20Event&body=<?php echo $name; ?> would like to request a Popup Daycare Event%0D%0A%0D%0ADate:%0D%0ATime:%0D%0ALocation:%0D%0AComments:'">Schedule Popup Daycare</button>
			<button type="submit" id="manage" form="data">Manage Your Program</button>

		<?php
			//Pass Company id so relevent data may be pulled from Database
			echo '<form id="data" method="post" action="management.php">
					<input type="hidden" name="id" value="'.$dbTable.'">
					</form>';
		?>

		<br/>
		<h1 id="report">Real Time Reporting</h1>
		<button id="request" onclick="window.location.href='mailto:support@ondecare.com?subject=Corporate%20Report%20Request&body=<?php echo $name; ?> is requesting a corporate report from their Dashboard%0D%0AComments:'">Request a Report</button>
			<div class="soon">Coming Soon</div><!--To be left to client to update in the future due to advice not to pull realtime information on their end-->
	</body>
</html>