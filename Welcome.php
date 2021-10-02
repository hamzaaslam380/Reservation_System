<?php 
// Include config file
require_once "config.php";

session_start();

	$user_id = $_SESSION["user_id"];
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    $time_to = trim($_POST["time_to"]);
    $time_from = trim($_POST["time_from"]);
    $day = trim($_POST["day"]);
    $month = trim($_POST["month"]);
	$user_id = $_SESSION["user_id"];
	
        	
		$sql = " INSERT into user_availabilty(user_id,time_to,time_from,user_day,user_month) VALUES ('$user_id','$time_to','$time_from','$day','$month')"; 
		if ($link->query($sql) === TRUE) {
		  header("location: Welcome.php");
		}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
		table {
		  font-family: arial, sans-serif;
		  border-collapse: collapse;
		  width: 100%;
		}

		td, th {
		  border: 1px solid #dddddd;
		  text-align: left;
		  padding: 8px;
		}
		</style>

</head>
<body>

<nav class="navbar navbar-light bg-light">
	<a class="navbar-brand">Meeting Reservation System</a>
	<!-- Button trigger modal -->
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
	ADD YOUR AVAILIBILTY HOURS
	</button>
</nav>

<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
		  
		<form action="Welcome.php" method="post">
		<div> TIME 
		
		<select name="time_to" id="time-to">
		</select>
		<span> TILL </span>
		<select name="time_from" id="time-from">
		</select>
		
		</div>
		
		<br> </br>
		
		<div> DAY 
		<select name="day" id="day">
		</select>
		 </div>
		 
		<br> </br> 
		 
		<div> MONTH 
		<input type="text" name="month" id="month"> 
		</div>
		
		
		</div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<input type="submit" class="btn btn-primary" value="SUBMIT">
		</div>
			
        </form>
		
		</div>
	  </div>
	</div>

<h1> Your Reservations </h1>

	<table>
	  <?php
	$result = mysqli_query($link,"SELECT * FROM reservation");

echo "<table border='1'>
<tr>
<th>Name</th>
<th>Reason</th>
<th>Time To</th>
<th>Time From</th>
<th>Day</th>
<th>Month</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['name'] . "</td>";
echo "<td>" . $row['comments'] . "</td>";
echo "<td>" . $row['time_to'] . "</td>";
echo "<td>" . $row['time_from'] . "</td>";
echo "<td>" . $row['res_day'] . "</td>";
echo "<td>" . $row['res_month'] . "</td>";
echo "</tr>";
}
echo "</table>";

?>


	<script>
	
	document.getElementById("month").addEventListener("focus", function(){
		var d = new Date();
		var n = d.getMonth();
		document.getElementById("month").value = n;
		//document.getElementById("month").disabled = true;
	});
		
		var time_to = document.getElementById("time-to");
		var content;

		for (let i = 1; i <= 24; i++) {
		  content += "<option value = " + i + " >" + i + "</option>";
		}

		time_to.innerHTML = content;
		
		var time_from = document.getElementById("time-from");
		var contents;

		for (let i = 1; i <= 24; i++) {
		  contents += "<option value = " + i + " >" + i + "</option>";
		}

		time_from.innerHTML = contents;
		
		var day = document.getElementById("day");
		var contentss;

		for (let i = 1; i <= 30; i++) {
		  contentss += "<option value = " + i + " >" + i + "</option>";
		}

		day.innerHTML = contentss;
		
	</script>
	
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>