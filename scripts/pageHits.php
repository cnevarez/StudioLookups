
<?php

require("connect.php");
//creating the SQL command
$sql="UPDATE `page_hits` SET hits = hits + 1";
$query = mysqli_query($con,$sql);

//viewing the results
$sql2="SELECT hits from `page_hits`";
$query2 = mysqli_query($con,$sql2);


while($row = mysqli_fetch_array($query2))
  {
  echo $row['hits'];


  }
mysqli_close($con);
?>

