<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>
<title>Studio Account Look-up</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<meta name="og:type" content="website">
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
<link rel="shortcut icon" href="http://flrc.mindfireinc.com/wp-content/uploads/2011/08/MindFireIncFavIcon.png">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<script>
function studioAcc(str, page, str2)
{
if (str=="")
  {
  document.getElementById("results").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("results").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET", page+"?q="+str+"&active="+str2,true);
xmlhttp.send();
}

function suggest(inputString, page, id, suggestions, suggestionsList){
		if(inputString.length == 0) {
			$(suggestions).fadeOut();
		} else {
		$(id).addClass('load');
			$.post(page, {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$(suggestions).fadeIn();
					$(suggestionsList).html(data);
					$(id).removeClass('load');
				}
			});
		}
	}

	function fill(thisValue) {
		$('#pAccount').val(thisValue);
		setTimeout("$('#suggestions').fadeOut();", 200);
	}
		function fill2(thisValue) {
		$('#pAccountID').val(thisValue);
		setTimeout("$('#suggestions2').fadeOut();", 200);
	}
	function fill3(thisValue) {
		$('#pAccountname').val(thisValue);
		setTimeout("$('#suggestions3').fadeOut();", 200);
	}


</script>
<style>
.rz-video {
	position: relative;
	padding-bottom: 56.25%;
	/* 16:9 */ padding-top: 
 25px;
	height: 0;
}
.rz-video iframe {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
}
body {
	font-family:"Myriad Pro";
}
#result {
	height:20px;
	font-size:16px;
	font-family:Arial, Helvetica, sans-serif;
	color:#333;
	padding:5px;
	margin-bottom:10px;
	background-color:#FFFF99;
}
#pAccount, #pAccountID, #pAccountname {
	padding:3px;
	border:1px #CCC solid;
	font-size:17px;
}
.suggestionsBox {
	position: absolute;
	left: 0px;
	top:40px;
	margin: 26px 0px 0px 0px;
	width: 200px;
	padding:0px;
	background-color: #000;
	border-top: 3px solid #000;
	color: #fff;
}
.suggestionList {
	margin: 0px;
	padding: 0px;
	z-index:999;
}
.suggestionList ul li {
	list-style:none;
	margin: 0px;
	padding: 6px;
	border-bottom:1px dotted #666;
	cursor: pointer;
	z-index:999;
}
.suggestionList ul li:hover {
	background-color: #FC3;
	color:#000;
	z-index:999;
}
ul {
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#FFF;
	padding:0;
	margin:0;
}
.load {
	background-image:url(scripts/loader.gif);
	background-position:right;
	background-repeat:no-repeat;
}
#suggest, #suggestid, #suggestpname {
	position:relative;
}
#ptable tr:nth-child(even) {
	background: #CCC;
}
#ptable tr:nth-child(odd) {
	background: #FFF
}
a, a:visited {
	color:#ff6600;
}

.error {
	background-color:#FF8080;
	padding:4px;
	margin:auto;
	border: 2px solid #F00;
	border-radius: 15px;
	
}
</style>
</head>
<body>
<?php
if(isset($_POST['email'])&&isset($_POST['password'])){
	if($_POST['email'] == 'team@mindfireinc.com' && $_POST['password'] =='1234cbb'){ ?>


<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div>
        <p style="text-align: center;"><img src="http://srchris.comuv.com/scripts/Studioacclookup.png"/><br/>
        </p>
        <p style="text-align: center;">
          <?php

require("scripts/connect.php");

date_default_timezone_set('America/Los_Angeles');
//looking up by account name
$sql="SELECT DATE_FORMAT(UPDATE_TIME, '%W %M %D, %Y at %r') as 'updated' FROM information_schema.tables WHERE TABLE_SCHEMA = '$tableSchema' AND TABLE_NAME = 'studioaccids'";
$sql2="SELECT FORMAT(count(*),0) as 'count' FROM studioaccids";
$upresult = mysqli_query($con, $sql);
$count = mysqli_query($con,$sql2);
while($row = mysqli_fetch_array($upresult))
  {
  echo "Database last updated on <strong>" . $row['updated'] . " EST</strong><br/>";
  }
while($row = mysqli_fetch_array($count))
  {
  echo "Number of Studio accounts: <strong>" . $row['count'] . "</strong>";
  }
?>
        </p>
      </div>
      <hr>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <div id="suggest">
          <label>Account Name</label>
          <input class="form-control " type="text"  id="pAccount"  onkeyup="suggest(this.value, 'scripts/autosuggest.php', '#pAccount', '#suggestions', '#suggestionsList');" onblur="fill(this.value);" placeholder="Account Name">
        </div>
        <br />
        <br />
        <button class="  btn-info btn" onclick="studioAcc(pAccount.value, 'scripts/studioacc.php')">Search</button>
        <div class="suggestionsBox" id="suggestions" style="display: none;"> <img src="scripts/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
          <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <div id="suggestid">
          <label>Account ID</label>
          <input class="form-control " type="text" id="pAccountID" onkeyup="suggest(this.value, 'scripts/autosuggestid.php', '#pAccountID', '#suggestions2', '#suggestionsList2');" onblur="fill2(this.value);" placeholder="Account ID">
        </div>
        <br />
        <br/>
        <button class="  btn-info btn" onclick="studioAcc(pAccountID.value, 'scripts/studioaccid.php')">Search</button>
        <div class="suggestionsBox" id="suggestions2" style="display: none;"> <img src="scripts/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
          <div class="suggestionList" id="suggestionsList2"> &nbsp; </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <div id="suggestpname">
          <label>Parent Account</label>
          <input class="form-control " type="text" id="pAccountname" onkeyup="suggest(this.value, 'scripts/autosuggestpname.php', '#pAccountname', '#suggestions3', '#suggestionsList3');" onblur="fill3(this.value);" placeholder="Parent Account">
        </div>
        <div class="form-group">
          <p>Include inactive accounts?</p>
        </div>
        <button class="  btn-info btn"  name="active" id="active" onclick="studioAcc(pAccountname.value, 'scripts/studioParentacc.php', '1')">No (Search)</button>
        <button class="  btn-info btn"  name="active" id="active" onclick="studioAcc(pAccountname.value, 'scripts/studioParentacc.php', '2')">Yes (Search)</button>
        <div class="suggestionsBox" id="suggestions3" style="display: none;"> <img src="scripts/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
          <div class="suggestionList" id="suggestionsList3"> &nbsp; </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <center>
        <div id="results"></div>
      </center>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <hr>
      <div>
        <?php
			//increasing the page hit by 1
			$sql3="UPDATE `page_hits` SET hits = hits + 1";
			$query3 = mysqli_query($con,$sql3);
			
			//viewing the results
			$sql4="SELECT hits from `page_hits`";
			$query4 = mysqli_query($con,$sql4);
			
			
			while($row = mysqli_fetch_array($query4))
			  {
			  echo "This page has been visited " .$row['hits']. " times";
			
			
			  }
			mysqli_close($con);
			?>
        <p style="text-align: center;">MindFireInc&copy; 2014 | 30 Corporate Park Dr. | Irvine CA, 92606 | 877 560 3473</p>
      </div>
    </div>
  </div>
</div>
</body>
</html><?php } 
else{ ?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div>
        <h1 style="text-align: center;">Please log in to continue</h1>
      </div>
      <div>
        <h4 style="text-align: center;">If you do not have a login, contact Chris :)</h4>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
      <form method="post">
        <div class="form-group">
        <div class="error">Invalid Email or Password</div>
          <label>Email</label>
          <span style="color:red;"> &#42</span>
          <input class="form-control " type="text" name="email" required>
        </div>
        <div class="form-group">
          <label>Password</label>
          <span style="color:red;"> &#42</span>
          <input class="form-control " type="password" name="password" required>
        </div>
        <button class="btn btn-default  " type="submit">Submit</button>
      </form>
    </div>
    <div class="col-md-4"></div>
  </div>
</div>
</body>
</html>

<?php }

}
	else{ ?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div>
        <h1 style="text-align: center;">Please log in to continue</h1>
      </div>
      <div>
        <h4 style="text-align: center;">If you do not have a login, contact Chris :)</h4>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
      <form method="post">
        <div class="form-group">
          <label>Email</label>
          <span style="color:red;"> &#42</span>
          <input class="form-control " type="text" name="email" required>
        </div>
        <div class="form-group">
          <label>Password</label>
          <span style="color:red;"> &#42</span>
          <input class="form-control " type="password" name="password" required>
        </div>
        <button class="btn btn-default  " type="submit">Submit</button>
      </form>
    </div>
    <div class="col-md-4"></div>
  </div>
</div>
</body>
</html><?php	}?>
