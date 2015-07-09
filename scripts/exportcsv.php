<?php
require("connect.php");
$q = $_GET['q'];
$a = $_GET['active'];
// Table Name that you want
// to export in csv
$ShowTable = "studioaccids";
 
$FileName = $q ."_Subaccounts_" . date("Y-m-d") . ".csv";
$file = fopen($FileName,"w");
 
$sql = "SELECT id, account_name, parent_name, status, creationDate, lastUpdate FROM $ShowTable where parent_name = '".$q."'";
if ($a == 1) {
   $sql .= "AND status = 'active' order by account_name asc";
}
else{
	$sql .= "order by account_name asc";
}
$results = mysqli_query($con, $sql);

$row = mysqli_fetch_assoc($results);
// Save headings alon
	$HeadingsArray=array();
	foreach($row as $name => $value){
		$HeadingsArray[]=$name;
	}
	fputcsv($file,$HeadingsArray); 
	
// Save all records without headings
 
	while($row = mysqli_fetch_assoc($results)){
	$valuesArray=array();
		foreach($row as $name => $value){
		$valuesArray[]=$value;
		}
	fputcsv($file,$valuesArray); 
	}
	fclose($file);
 
header("Location: $FileName");
 
echo "Complete Record saves as CSV in file: <b style=\"color:red;\">$FileName</b>";
?>