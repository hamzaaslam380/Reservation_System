<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$user_id = $name = $time_to = $time_from = $day = $month = $occupy = $reason = $res_user_id = "";
$user_id_err = $name_err = $time_to_err = $time_from_err = $day_err = $month_err = $reason_err = $res_user_id_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	if(!empty($_POST['Check-Availabilty-Hours'])){
		if(empty(trim($_POST["user_id"]))){
			$user_id_err = "Please enter a user id.";     
		} else{
			$user_id = trim($_POST["user_id"]);
		}

		// Check input errors before inserting in database
		if(empty($user_id_err)){
			
			$sql = "select user_id from User where user_id = '$user_id'";  
			$result = mysqli_query($link, $sql);  
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
			$count = mysqli_num_rows($result);  
			  
			if($count == 1){
				$userid = $row['user_id'];
			}
			else{
				$user_id_err = "User Not Found";
			}			
		}
	}
	if(!empty($_POST['Reservation-form'])){
		if(empty(trim($_POST["res_user_id"]))){
			$res_user_id_err = "Please enter id.";     
		} else{
			$res_user_id = trim($_POST["res_user_id"]);
		}
		if(empty(trim($_POST["name"]))){
			$name_err = "Please enter name.";     
		} else{
			$name = trim($_POST["name"]);
		}
		
		if(empty(trim($_POST["reason"]))){
			$reason_err = "Please enter reason.";     
		} else{
			$reason = trim($_POST["reason"]);
		}
		
		if(empty(trim($_POST["time_to"]))){
			$time_to_err = "Please enter a time.";     
		} else{
			$time_to = trim($_POST["time_to"]);
		}
		
		if(empty(trim($_POST["time_from"]))){
			$time_from_err = "Please enter a time.";     
		} else{
			$time_from = trim($_POST["time_from"]);
		}
		if(empty(trim($_POST["day"]))){
			$day_err = "Please enter a day.";     
		} else{
			$day = trim($_POST["day"]);
		}
		
		if(empty(trim($_POST["month"]))){
			$month_err = "Please enter a month.";     
		} else{
			$month = trim($_POST["month"]);
		}
		
		if(( (int)$_POST["time_to"]+1) != ((int) $_POST["time_from"])){
			$time_to_err = "Only 1 Hour Slot Is Allowed.";     
			$time_from_err = "Only 1 Hour Slot Is Allowed.";     
			
		}
		else{
			
			if((int) $time_from == (int) $time_to){
			
				$sql = "select user_id from User where user_id = '$res_user_id'";  
				$result = mysqli_query($link, $sql);  
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
				$count = mysqli_num_rows($result);  
				
				$user_id = $row['user_id'];
				  
				if($count == 1){
					
					$sql1 = "Select * from user_availabilty where user_id = '$res_user_id'";
					$result1 = mysqli_query($link, $sql1);  
					$row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);  
					$count1 = mysqli_num_rows($result1);

					$time_to_new = $row1['time_to'];
					$time_from_new = $row1['time_from'];
					$day_new = $row1['user_day'];
					$month_new = $row1['user_month'];
					
					if((int)$time_to >= (int) $time_to_new){
						
						if((int) $time_from <= (int) $time_from_new){
							
							if((int) $day == (int) $day_new ){
								
								if((int) $month == (int) $month_new ){
									
									$sql = "Select *from reservation where user_id = '$user_id'";
									$result = mysqli_query($link, $sql);  
									$row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
									$count = mysqli_num_rows($result);
									
									if((int) $row['time_to'] == (int) $time_to){
										$time_to_err = "Time Already Allocated";
									}
									else{
										if((int) $row['time_from'] == (int) $time_from){
											$time_from_err = "Time Already Allocated";
											
										}
										else{
											$sql = "INSERT INTO reservation (user_id, name, comments,res_day,res_month,time_to,time_from,occupy)
												VALUES ('$user_id', '$name', '$reason','$day', '$month' , '$time_to', '$time_from', '1')";

											if ($link->query($sql) === TRUE) {
													  echo "New record created successfully";
											} 
										}	
									}
										
								}
								else{
									$month_err = "User Not Availabile In This Month";
								}							
							}else{
								$day_err = "User Not Availabile In This Day";
							}
						}else{
							$time_from_err = "User Not Availabile At That Time";
						}
					}else{
						$time_to_err = "User Not Availabile At That Time";
					}
					
				}
				else{
					$res_user_id_err = "User Not Found ";
				}
			}
			else{
				$time_to_err = "Atleast 1 Hour Is Required For Meeting";
				$time_from_err = "Atleast 1 Hour Is Required For Meeting";
			}
		}	
	}
}


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper"  style="width:800px; margin:0 auto;">
        <h2>Make a Reservation</h2>
        <p>Please fill this form to make an reservation.</p>
		
		<form action="reservation.php" method="post">
		 	<div class="form-group">
                <label>USER ID (if you dont know user id contact the person whom you want to reservation )</label>
                <input type="text" name="user_id" class="form-control <?php echo (!empty($user_id_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $user_id; ?>">
                <span class="invalid-feedback"><?php echo $user_id_err; ?></span>
			</div> 
			
			AVAILABLE SLOTS IS (24 Hours)
			<br> </br>
			
			<div> FROM
			<select>
				<?php
					$records = mysqli_query($link, "SELECT time_to AS time_to From user_availabilty WHERE user_id = '$userid'");  // Use select query here 
				

					while($data = mysqli_fetch_array($records) )
					{
						echo "<option value='". $data['time_to'] ."'>" .$data['time_to'] ."</option>";  // displaying data in option menu
					}
	
				?>  
			</select>
			TO
			<select>
				<?php
					$records = mysqli_query($link, "SELECT time_from From user_availabilty WHERE user_id = '$userid'");  // Use select query here 
				

					while($data = mysqli_fetch_array($records) )
					{
						echo "<option value='". $data['time_from'] ."'>" .$data['time_from'] ."</option>";  // displaying data in option menu
					}
	
				?>  
			</select>
			<div>
			
			<br> </br>
			
			<div class="form-group">
				<input type="submit" class="btn btn-primary" name="Check-Availabilty-Hours" value="Check Availabilty Hours">
			</div>
		 
		</form>
		
        <form action="reservation.php" method="post"> 
		    <div class="form-group">
                <label>User Id</label>
                <input type="text" name="res_user_id" class="form-control <?php echo (!empty($res_user_id_err)) ? 'is-invalid' : ''; ?>" >
                <span class="invalid-feedback"><?php echo $res_user_id_err; ?></span>
            </div> 
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" >
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Reason</label>
                <input type="text" name="reason" class="form-control <?php echo (!empty($reason_err)) ? 'is-invalid' : ''; ?>" >
                <span class="invalid-feedback"><?php echo $reason_err; ?></span>
            </div>
			
			<div class="form-group">
                <label>Enter Your Slot For Booking 			(Note: MAX 1 Hour Meeting i.e 1=1AM , 13=1PM)</label>
				<div> 
				TO
                <input type="number" name="time_to" class="form-control <?php echo (!empty($time_to_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $time_to_err; ?></span>
				From
                <input type="number" name="time_from" class="form-control <?php echo (!empty($time_to_err)) ? 'is-invalid' : ''; ?>" >
                <span class="invalid-feedback"><?php echo $time_from_err; ?></span>
				</div>
            </div>
			
			<div class="form-group">
                <label>Day (Note: Most Of The User Availabile For Only Current Day)</label>
                <input type="number" name="day" class="form-control <?php echo (!empty($day_err)) ? 'is-invalid' : ''; ?>" >
                <span class="invalid-feedback"><?php echo $day_err; ?></span>
            </div>
			
			<div class="form-group">
                <label>Month (Note : This Reservation Is Only For This Month Dont Change Month)</label>
                <input type="number" id= "month" name="month" class="form-control <?php echo (!empty($month_err)) ? 'is-invalid' : ''; ?>" >
                <span class="invalid-feedback"><?php echo $month_err; ?></span>
            </div>
			
			<div class="form-group">
                <input type="submit" class="btn btn-primary" name = "Reservation-form" value="Submit">
            </div>
			
  
        </form>
    </div> 

	<script>
	document.getElementById("month").addEventListener("focus", function(){
		var d = new Date();
		var n = d.getMonth();
		document.getElementById("month").value = n;
		//document.getElementById("month").disabled = true;
	});	
	</script>
</body>
</html>