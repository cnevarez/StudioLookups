<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
$q = $_GET['q'];
$a = $_GET['active'];

require("connect.php");
//looking up by account name
$sql="SELECT id, account_name, parent_name, status, creationDate, lastUpdate FROM studioaccids where parent_name = '".$q."'";

//adding account name resukts to a variable
$accounts = mysqli_query($con,$sql);

//looking up if they are subscribed to the ETL by name
$sql2="SELECT studioaccids.id, account_name, status, creationDate, lastUpdate, subscribed FROM studioaccids 
LEFT JOIN etl
ON studioaccids.id=etl.id
WHERE studioaccids.parent_name = '".$q."'";

if ($a == '1') {
   $sql2 .= "and status = 'active' order by studioaccids.account_name asc";
}
else{
	$sql2 .= "order by studioaccids.account_name asc";
}

$subresult = mysqli_query($con, $sql2);
$num_rows = mysqli_num_rows($subresult);


//Looking up API creds
$apiCredsSql = mysqli_query($con,"SELECT GUID, Pass FROM apicreds where apicreds.account = '".$q."'");
$apiCreds = mysqli_fetch_array($apiCredsSql);

//$subscribe = mysqli_fetch_array($subscribe);

if($num_rows !== 0){

		echo "<table border='1' id='ptable' style='text-align:left; border-collapse:collapse;' cellspacing='2' cellpadding='2'>
		<caption><strong>Showing " . $num_rows . " sub-account(s) for " . $q . "</strong><br/><br/>API credentials for this Parent account are<br/><strong>GUID:</strong>".$apiCreds['GUID']."<br/><strong>Password:</strong>".$apiCreds['Pass']." <br /><a href='scripts/exportcsv.php?q=". $q . "&active=" . $a ."' class='btn btn-success btn-sm' target='_blank'>Export</a><br /><br /></caption>
		<tr>
		<th>Account ID</th>
		<th>Account Name</th>
		<th>Status</th>
		<th>Creation Date</th>
		<th>Last Updated</th>
		<th>Subscribed to the ETL</th>
		</tr>";
		
		
		while($row = mysqli_fetch_array($subresult))
		  {
		  echo "<tr>";
		  echo "<td>" . $row['id'] . "</td>";
		  echo "<td>" . $row['account_name'] . "</td>";
		  echo "<td>" . $row['status'] . "</td>";
		  echo "<td>" . $row['creationDate'] . "</td>";
		  echo "<td>" . $row['lastUpdate'] . "</td>";
		   if($row['subscribed'] == ""){
			  echo "<td>TRUE</td>";
		  }
		  else{
		  echo "<td>" . $row['subscribed'] . "</td>";
		  }
		  echo "</tr>";
		  }
		echo "</table>";
		echo "<a href='#' onclick='fill(\"". $q . "\");studioAcc(\"" . $q . "\", \"scripts/studioacc.php\")'>Look up ID for " . $q ."</a>";
		}
else{
	echo "<strong>This parent account has no Sub-accounts tied to it</strong><br/><img src='images/dickGun.gif'>";
}

mysqli_close($con);
?>

</body>
</html>