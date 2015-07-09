<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
$q = $_GET['q'];

require("file:///C|/PROGRA~2/EASYPH~1.1VC/data/localweb/projects/StudioAcc/scripts/connect.php");
//looking up by account name
$sql="SELECT id, account_name, parent_name, status FROM studioaccids where parent_name = '".$q."' order by account_name ASC";

//adding account name resukts to a variable
$accounts = mysqli_query($con,$sql);

//looking up if they are subscribed to the ETL by name
$subresult = mysqli_query($con, "SELECT studioaccids.id, account_name, status, subscribed FROM studioaccids 
LEFT JOIN etl
ON studioaccids.id=etl.id
WHERE studioaccids.parent_name = '".$q."'
order by studioaccids.account_name asc");
$subscribe = mysqli_fetch_array($subresult);
if(mysqli_num_rows($subresult) !== 0){

echo "<table border='1' id='ptable' style='text-align:left; border-collapse:collapse;' cellspacing='2' cellpadding='2'>
<tr>
<th>Account ID</th>
<th>Account Name</th>
<th>Status</th>
<th>Subscribed to the ETL</th>
</tr>";


while($row = mysqli_fetch_array($subresult))
  {
  echo "<tr>";
  echo "<td>" . $row['id'] . "</td>";
  echo "<td>" . $row['account_name'] . "</td>";
  echo "<td>" . $row['status'] . "</td>";
   if($row['subscribed'] == ""){
	  echo "<td>TRUE</td>";
  }
  else{
  echo "<td>" . $row['subscribed'] . "</td>";
  }
  echo "</tr>";
  }
echo "</table>";
}
else{
	echo "This parent account has no Sub-accounts tied to it";
}

mysqli_close($con);
?>

</body>
</html>