<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="description" content="Management Page">
		<meta name="keywords" content="HTML, CSS, JavaScript, PHP">
		<meta name="author" content="Andrew Barras, Arun Karki, Asim Oli, Damian O'Boyle, Rajib Rijal">
		
		<title>Employer Managment Page</title>
		<link rel="icon" href="icon.png">
		<link rel="stylesheet" type="fonts" href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" >
		<link rel="stylesheet" type="text/css" href="management.css">
		<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
	</head>
	
	<body>
		<?php
			//Pulls data for default Info
			$dbTable = $_POST ['id'];
			
			$host = "sql202.epizy.com";
			$database = "epiz_25644198_ondecare";
			$username = "epiz_25644198";
			$password = "25nGNQu3B0";

		   	$conn = mysqli_connect($host, $username, $password, $database);
		   	if(!$conn)
		   	{
				die("Unable to connect: " . $conn->connect_error);
			}

		    	$sql = "SELECT * FROM epiz_25644198_ondecare.corporate WHERE id=$dbTable";
			$results = mysqli_query($conn, $sql);
			$record = mysqli_fetch_assoc($results);

			$company = $record["company"];
			$executive = $record['executive'];
			$email = $record['email'];
			$password = $record['password'];
			$address = $record['address'];

			$conn->close();
		?>

		<h1>Program Managment</h1>
		<h2>Add Employees to Program</h2>

		<form id="employeeShelf" action="addEmployees.php" method="post">
			<!-- Tag to calculate total number of Employee Fields -->
			<div id="addEmployee" class="clonedSection">
                <?php
                //Pass Company id so relevent data may be pulled from Database
                echo '<input type="hidden" name="id" value="'.$dbTable.'">';
                ?>
				<div>
					<input type="text" id="eName1" name="eName1" placeholder="Employee Name" pattern="[^'\x22\(\)\{}]+" title="Invalid input. Avoid Special Characters and Symbols.">
					<input type="text" id="email1" name="email1" placeholder="Email Address" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$" title="Please only enter a conventionally formatted email address.">
					<select name="spinner1" id="spinner1">
						<option value="No Plan">No Plan</option>
						<option value="Full Subsidy">Full Subsidy</option>
						<option value="Voluntary">Voluntary</option>
						<option value="Mixed">Mixed</option>
					</select>
					<br/>
				</div>
			</div>
		</form>

		<button id="manage" onclick="add();"> + </button>
		<button id="delete" onclick="remove();"> Delete </button>

		<script type="text/javascript" language="JavaScript">
  			function add() {
				//Variable that stores (Number of Employee Fields) + 1
				var numItems = ($('#employeeShelf').children().length +1);
				
				//Variable that stores clone of first field
				var clone = jQuery("#addEmployee").first().clone().prop('id', 'addEmployee'+numItems);
				
				//Changes clone's eName to (eName+numItems)
				clone.find("input:first").attr("name", "eName"+numItems);
				
				//Changes clone's email to (email+numItems)
				clone.find("input:eq(1)").attr("name", "email"+numItems);
				
				//Changes clone's spinner to (spinner+numItems)
				clone.find("select").attr("name","spinner"+numItems);
				
				//Adds clone to Webpage
				jQuery("#employeeShelf").append(clone);
			}
			
			function remove() {
				// how many duplicate input fields we currently have
				var num = ($('#employeeShelf').children().length);
				
				// remove the last field
		        	$('#addEmployee'+num).first().remove(); 
		    	}
  		</script>

  		<form enctype="multipart/form-data" id="upload" action="upload.php" method="post">
  			<label for="userfile">Upload a Formatted File:&emsp;&emsp;</label>
  				<input type="file" id="userfile" name="userfile" required>
                <input type="hidden" name="id" value="<?php echo $dbTable; ?>">
                <input type="submit">
		</form>
		
		<button type="submit" name="submit" id="add" form="employeeShelf">Add</button>

		<script type="text/javascript" language="JavaScript">
			function check(theForm) {
			    if (theForm.password.value != theForm.confirm.value)
			    {
			        alert('Your Passwords don\'t match!');
			        return false;
			    } else {
			        return true;
			    }
			}
		</script>

		<h1>Update Corporate Information</h1>
		
		<form action="update.php" method="post" onsubmit="return check(this);">
			<table cellpadding="5" cellspacing=5 width="90%">
	  			<tr><td>
				<input type="text" id="cName" name="cName" value="<?php echo $company; ?>" placeholder="Company Name" pattern="[^'\x22\(\)\{}]+" title="Invalid input. Avoid Special Characters and Symbols." required>
					</td><td>
				<input type="text" id="Address" name="Address" placeholder="Address">
					</td><td>
						<h3><?php echo "Current Address:" ?></h3>
				</td></tr>
				<tr><td>
			    <input type="text" id="executive" name="executive" value="<?php echo $executive; ?>"placeholder="Authorising Executive" pattern="[^'\x22\(\)\{}]+" title="Invalid input. Avoid Special Characters and Symbols." required>
			    	</td><td>
			    <input type="text" id="street" name="street" placeholder="Street">
					</td><td>
						<p><?php echo $address; ?></p>
				</td></tr>
				<tr><td>
			    <input type="text" id="cEmail" name="cEmail" value="<?php echo $email; ?>" placeholder="Company Email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$" title="Please only enter a conventionally formatted email address." required>
			    	</td><td>
			    <input type="text" id="city" name="city" placeholder="City">
				</td></tr>
				<tr><td>
				<input type="password" id="password" name="password" placeholder="New Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number, one uppercase letter, one lowercase letter and at least 8 or more characters" required>
					</td><td>
			  	<select name="state" id="state" required>
			  		<option value="ST" disabled selected>State</option>
					<option value="AL">Alabama</option>
					<option value="AK">Alaska</option>
					<option value="AZ">Arizona</option>
					<option value="AR">Arkansas</option>
					<option value="CA">California</option>
					<option value="CO">Colorado</option>
					<option value="CT">Connecticut</option>
					<option value="DE">Delaware</option>
					<option value="DC">District Of Columbia</option>
					<option value="FL">Florida</option>
					<option value="GA">Georgia</option>
					<option value="HI">Hawaii</option>
					<option value="ID">Idaho</option>
					<option value="IL">Illinois</option>
					<option value="IN">Indiana</option>
					<option value="IA">Iowa</option>
					<option value="KS">Kansas</option>
					<option value="KY">Kentucky</option>
					<option value="LA">Louisiana</option>
					<option value="ME">Maine</option>
					<option value="MD">Maryland</option>
					<option value="MA">Massachusetts</option>
					<option value="MI">Michigan</option>
					<option value="MN">Minnesota</option>
					<option value="MS">Mississippi</option>
					<option value="MO">Missouri</option>
					<option value="MT">Montana</option>
					<option value="NE">Nebraska</option>
					<option value="NV">Nevada</option>
					<option value="NH">New Hampshire</option>
					<option value="NJ">New Jersey</option>
					<option value="NM">New Mexico</option>
					<option value="NY">New York</option>
					<option value="NC">North Carolina</option>
					<option value="ND">North Dakota</option>
					<option value="OH">Ohio</option>
					<option value="OK">Oklahoma</option>
					<option value="OR">Oregon</option>
					<option value="PA">Pennsylvania</option>
					<option value="RI">Rhode Island</option>
					<option value="SC">South Carolina</option>
					<option value="SD">South Dakota</option>
					<option value="TN">Tennessee</option>
					<option value="TX">Texas</option>
					<option value="UT">Utah</option>
					<option value="VT">Vermont</option>
					<option value="VA">Virginia</option>
					<option value="WA">Washington</option>
					<option value="WV">West Virginia</option>
					<option value="WI">Wisconsin</option>
					<option value="WY">Wyoming</option>
				</select>
		  		</td></tr>
				<tr><td>
				<input type="password" id="confirm" name="confirm" placeholder="Confirm New Password" required>
					</td><td>
				<input type="text" id="zip" name="zip" placeholder="ZIP">
				</td></tr>
		  	</table>

		  	<?php
			//Pass Company id so relevent data may be pulled from Database
			echo '<input type="hidden" name="id" value="'.$dbTable.'">';
			?>
			
			<button id="update" type="submit">Update</button>
		</form>

	</body>
</html>
