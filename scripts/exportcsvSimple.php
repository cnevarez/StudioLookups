<?php
require("connect.php");
$q = $_GET['q'];
$a = $_GET['active'];
// Table Name that you want
// to export in csv
$ShowTable = "studioaccids";

$FileName = $q ."_Subaccounts_" . date("Y-m-d") . ".csv";


// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $FileName);

// create a file pointer connected to the output stream
$file = fopen($FileName,"w");

// output the column headings
fputcsv($file, array('Account ID', 'Account Name', 'Parent Account Name', 'Status', 'Creation Date', 'Last Update'));

// fetch the data
$sql = "SELECT id, account_name, parent_name, status, creationDate, lastUpdate FROM $ShowTable where parent_name = '".$q."'";
if ($a == 1) {
   $sql .= "AND status = 'active' order by account_name asc";
}
else{
	$sql .= "order by account_name asc";
}
$rows = mysqli_query($con, $sql);

// loop over the rows, outputting them
while ($row = mysqli_fetch_assoc($rows)) fputcsv($output, $row);
fclose($file);
header("Location: $FileName");
 
echo "Complete Record saves as CSV in file: <b style=\"color:red;\">$FileName</b>";
?>