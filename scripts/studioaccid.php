<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
$q = $_GET['q'];

require("connect.php");
//looking up by account name
$sql="SELECT id, account_name, parent_name, status, creationDate, lastUpdate FROM studioaccids WHERE studioaccids.id = '".$q."' group by studioaccids.id";

//adding account name resukts to a variable
$accounts = mysqli_query($con,$sql);

//looking up if they are subscribed to the ETL by name
$subresult = mysqli_query($con, "SELECT etl.id, subscribed FROM studioaccids, etl WHERE studioaccids.id = etl.id and studioaccids.id = '".$q."' group by studioaccids.id");
$num_rows = mysqli_num_rows($subresult);
$subscribe = mysqli_fetch_array($subresult);

//Looking up API creds
$apiCredsSql = mysqli_query($con,"SELECT GUID, Pass, id FROM apicreds, studioaccids where apicreds.account = studioaccids.account_name and studioaccids.id = '".$q."'");
$apiCreds = mysqli_fetch_array($apiCredsSql);


			echo "<table border='1' id='ptable' style='text-align:left; border-collapse:collapse;' cellspacing='2' cellpadding='2'>
			<tr>
			<th>Account ID</th>
			<th>Account Name</th>
			<th>Parent Account</th>
			<th>Status</th>
			<th>Creation Date</th>
			<th>Last Updated</th>
			<th>Subscribed to the ETL</th>
			<th>API Creds</th>
			</tr>";
			
			
			while($row = mysqli_fetch_array($accounts))
			  {
			  echo "<tr>";
			  echo "<td>" . $row['id'] . "</td>";
			  echo "<td>" . $row['account_name'] . "</td>";
			   echo "<td><a href='#' onclick='fill3(\"" . $row['parent_name'] . "\");studioAcc(\"" . $row['parent_name'] . "\", \"scripts/studioParentacc.php\", \"2\")'>" . $row['parent_name'] ."</a></td>";
			  echo "<td>" . $row['status'] . "</td>";
			  echo "<td>" . $row['creationDate'] . "</td>";
			  echo "<td>" . $row['lastUpdate'] . "</td>";
			  if($subscribe['subscribed'] == ""){
				  echo "<td>TRUE</td>";
			  }
			  else{
			  echo "<td>" . $subscribe['subscribed'] . "</td>";
			  }
				if($apiCreds['GUID'] == ""){
				  echo "<td>None Yet</td>";
			  }
			  else{
			  echo "<td>" . $apiCreds['GUID'] ."<br/>".$apiCreds['Pass']. "</td>";
			  }
			  echo "</tr>";
			  }
			echo "</table>";
	


mysqli_close($con);
?>

</body>
</html>