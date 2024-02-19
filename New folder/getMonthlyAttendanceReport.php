<?php 
	require_once('config.php');
	require_once('loginSession.php');
	
	$db = new Database();
	$fNum = new Formatnumber();


	$year = "";
	$error = false;

	if(isset($_GET['currentYear'])){
		$currentYear = $_GET['currentYear'];
		$year = $currentYear;
		// echo($currentYear);
	}else if(isset($_GET['yearPick'])){
		$yearPick = $_GET['yearPick'];
		$year = $yearPick;
		// echo($yearPick);
	}else{
		$error = true;
	}

	if($error){
		//if naay error
		echo '
			 <div class="alert">
			 	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			 	<strong>Error!</strong> Page Not Found ...
			 </div>';
	}else{
		//walay error
		
?>



<br />
<br />


	<table id="myTable" class="table table-striped" border="1">  
		<thead>
			<th><center>MONTH</center></th>
			<th><center>NUMBER OF STUDENTS</center></th>
			<th><center>REMARKS</center></th>
		</thead>
	<tbody>
		<?php
			$months = array("January", "Febuary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
			$monthNum = 1; //1 = jan, 2 =feb, . . . and so on 
			$overAllTotal = 0;
			//$year sa igbaw
			foreach ($months as $m) {
				# code...
				$first = "$year-$monthNum-01";//begin
				
				if($monthNum == 12){
					$year++;
					$monthNum = 1;
					$second = "$year-$monthNum-01";//begin
				}else{
					$monthNum++;
					$second = "$year-$monthNum-01";//begin
					$monthNum--;
				}


				$sql = "SELECT COUNT(*) as monthlyTotal FROM logged_book
						WHERE logb_login BETWEEN ? AND ?
						";	

				$res = $db->getRow($sql, [$first, $second]);
				$monthlyTotal = $res['monthlyTotal'];		
				$monthlyTotal = $fNum->putComma($monthlyTotal);
				echo "<tr>";
					echo "<td align='center'>$m</td>";//month
					echo "<td align='right'>$monthlyTotal</td>";//number of stud
					echo "<td align='center'></td>";//remarks
				echo "</tr>";

				$overAllTotal += $monthlyTotal;
				$monthNum++;
			}
			//convert overAllTotal nga naay comma
			$overAllTotal = $fNum->putComma($overAllTotal);
		 ?>
		 <tr>
		 	<td></td>
		 	<td align="right"><strong>TOTAL: <?php echo $overAllTotal; ?></strong></td>
		 	<td></td>
		 </tr>
	</tbody>
<?php
	}
// SELECT * FROM logged_book 
// WHERE `logb_login` BETWEEN '2015-12-01' AND '2016-01-01'
$db->Disconnect();
 ?>
