<?php include("functions.php");
$pattern="/^[A-Za-z0-9-,\s]+$/";
$manager=new databaseManager;
?>

<!DOCTYPE html>
<html>
<head>
	<title>ADD</title>
	<script src="js/script.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/jquery.flip"></script>
	<script src="js/jquery.flip.min"></script>
	<script>
	$(document).ready(function() {
		$("#accordion").hide();
		$("#accordion").fadeIn("slow");
		$("#accordion").accordion();
  });
  </script>
  
  <style>
	@font-face{
		font-family:Sensible;
		src:url('css/Sensible.ttf');
	}
	
	body{
		background-color:black;
		font-size:20px;
		color:white;
		background-image:url('css/pics/bilog.png');
	}
	
	h3{
		background-color:none;
		font-size:20px;
		font-family:Sensible;
		color:gold;
		margin-left:25%;
		width:20%;
	}
	
	a{
		text-decoration:none;
		color:gold;
	}
	
	table{
		margin-left:30%;
	}
	
	td{
		color:white;
		font-size:15px;
		font-family:Sensible;
		
	}
	
	input[type= submit]{
		background-color:white;
	}
	
	input[type= checkbox]{
		background-color:white;
		font-family:Sensible;
	}
	
	select{
		background-color:white;
		font-family:Sensible;
	}
	
	input[type= number]{
		background-color:white;
		font-family:Sensible;
	}
	
	input{
		font-family:Sensible;
	}
	
	a:hover{
		color:white;
	}
	
	#center{	
		position:absolute;
		width:77%;
		height:8%;
		top:0%;
		padding-left:23%;
		left:0%;
		overflow:hidden;
		background-color:gray;
		color:white;
		opacity:0.8;
		font-family:Sensible;
		font-size:50px;
		padding-top:0.3%;
	}
	
	#label{
		margin-top:5%;
	}
  </style>
  
</head>
<body style="font-size:62.5%;">
	<div id="label">
	<?php
		if(isset($_POST['submitmovie']))	//lahat ng action na gagawin kapag clicked ung submit na button
		{
			if(preg_match($pattern, $_POST['movieName']) && preg_match($pattern, $_POST['producer']))
			{
				$producers=array();
				$ctr=0;
				$token=strtok($_POST['producer'], ',');
				while($token)
				{
					$producers[$ctr++]=$token;
					$token=strtok(',');
				}
				$movie=$manager->addNewMovie($_POST['movieName'], $_POST['filmBudget'], $_POST['runningTime'], $_POST['boxOffice'], $producers, $_POST['releaseDate'], $_POST['genre']);
				if($movie==1)
					echo "<span style='color:blue; font-size:20px;'><center>Movie Added.</center></span><br />";	//create user
				else if($movie==2)
					echo "<span style='color:red; font-size:20px;'><center>Movie is already in the database.</center></span><br />";
				else
					echo "<span style='color:red; font-size:20px;'><center>Failed to add movie.</center></span><br />";
			}
			else
				echo "<span style='color:red; font-size:20px;'><center>Invalid Movie Details.</center></span><br />";
		}
		if(isset($_POST['submitactor']))	//lahat ng action na gagawin kapag clicked ung submit na button
		{
			if(preg_match($pattern, $_POST['actorName']))
			{
				$actor=$manager->addNewActor($_POST['actorName'], $_POST['actorAge'], $_POST['actorGender']);
				if($actor==1)
					echo "<span style='color:blue; font-size:20px;'><center>Actor Added.</center></span><br />";	//create user
				else if($actor==2)
					echo "<span style='color:red; font-size:20px;'><center>Actor is already in the database.</center></span><br />";
				else
					echo "<span style='color:red; font-size:20px;'><center>Failed to add actor.</center></span><br />";
			}
			else
				echo "<span style='color:red; font-size:20px;'><center>Invalid Actor Details.</center></span><br />";
		}
		if(isset($_POST['submitstaff']))	//lahat ng action na gagawin kapag clicked ung submit na button
		{
			if(preg_match($pattern, $_POST['staffName']) && preg_match($pattern, $_POST['department']))
			{
				$staff=$manager->addNewStaff($_POST['staffName'], $_POST['department'], $_POST['staffGender']);
				if($staff==1)
					echo "<span style='color:blue; font-size:20px;'><center>Staff Added.</center></span><br />";	//create user
				else if($staff==2)
					echo "<span style='color:red; font-size:20px;'><center>Staff is already in the database.</center></span><br />";
				else
					echo "<span style='color:red; font-size:20px;'><center>Failed to add staff.</center></span><br />";
			}
			else
				echo "<span style='color:red; font-size:20px;'><center>Invalid Staff Details.</center></span><br />";
		}
		if(isset($_POST['submitaward']))	//lahat ng action na gagawin kapag clicked ung submit na button
		{
			if(preg_match($pattern, $_POST['awardName']))
			{
				$award=$manager->addNewAward($_POST['awardName'], $_POST['movie'], $_POST['awardStatus']);
				if($award==1)
					echo "<span style='color:blue; font-size:20px;'><center>Award Added.</center></span><br />";	//create user
				else if($award==2)
					echo "<span style='color:red; font-size:20px;'><center>Award is already in the database.</center></span><br />";
				else
					echo "<span style='color:red; font-size:20px;'><center>Failed to add award.</center></span><br />";
			}
			else
				echo "<span style='color:red; font-size:20px;'><center>Invalid Award Details.</center></span><br />";
		}
		if(isset($_POST['submitmovierole']))	//lahat ng action na gagawin kapag clicked ung submit na button
		{
			if(preg_match($pattern, $_POST['movierole']))
			{
				$movieroles=array();
				$ctr=0;
				$token=strtok($_POST['movierole'], ',');
				while($token)
				{
					$movieroles[$ctr++]=$token;
					$token=strtok(',');
				}
				$award=$manager->addNewMovieRole($_POST['actor'], $_POST['movie'], $_POST['amountreceived'], $movieroles);
				if($award==1)
					echo "<span style='color:blue; font-size:20px;'><center>Movie Role Added.</center></span><br />";	//create user
				else if($award==2)
					echo "<span style='color:red; font-size:20px;'><center>Movie Role is already in the database.</center></span><br />";
				else
					echo "<span style='color:red; font-size:20px;'><center>Failed to add Movie role.</center></span><br />";
			}
			else
				echo "<span style='color:red; font-size:20px;'><center>Invalid Movie Role Details.</center></span><br />";
		}
		if(isset($_POST['submitawardingdate']))	//lahat ng action na gagawin kapag clicked ung submit na button
		{
			$awarddate=$manager->addNewReceives($_POST['actor'], $_POST['award'], $_POST['datereceived']);
			if($awarddate==1)
				echo "<span style='color:blue; font-size:20px;'><center>Awarding Date Added.</center></span><br />";	//create user
			else if($awarddate==2)
				echo "<span style='color:red; font-size:20px;'><center>There is already an Awarding Date in the database.</center></span><br />";
			else
				echo "<span style='color:red; font-size:20px;'><center>Failed to add awarding date.</center></span><br />";
		}
		if(isset($_POST['submitstaffrole']))	//lahat ng action na gagawin kapag clicked ung submit na button
		{
			if(preg_match($pattern, $_POST['staffrole']))
			{
				$positions=array();
				$ctr=0;
				$token=strtok($_POST['staffrole'], ',');
				while($token)
				{
					$positions[$ctr++]=$token;
					$token=strtok(',');
				}
				$award=$manager->addNewStaffRole($_POST['movie'], $_POST['staff'], $_POST['amountreceived'], $positions);
				if($award==1)
					echo "<span style='color:blue; font-size:20px;'><center>Position Added.</center></span><br />";	//create user
				else if($award==2)
					echo "<span style='color:red; font-size:20px;'><center>Position is already in the database.</center></span><br />";
				else
					echo "<span style='color:red; font-size:20px;'><center>Failed to add position.</center></span><br />";
			}
			else
				echo "<span style='color:red; font-size:20px;'><center>Invalid Staff Position Details.</center></span><br />";
		}
	?>
	</div>
	<div id="accordion">
		<h3><a href="#">Add Movie</a></h3>
		<div>
			<div id="addMovieDeets">
				<form name="addMovie" onsubmit="return validateAddMovie();" action="add.php" method="post">
					<table>
						<tr>
							<td><label for="movieName">Movie Name: </label></td>
							<td><input type="text" id="movieName" name="movieName" /></td>
						</tr>
						<tr>
							<td><label for="producer">Producer(s): </label></td>
							<td><input type="text" id="producer" name="producer"/></td>
							<td><i>separate values by comma(,)</i></td>
						</tr>
						<tr>
							<td><label for="runningTime">Running Time: </label></td>
							<td><input type="number" id="runningTime" name="runningTime" min="30" max="180" step="5" value="30" /></td>
							<td><i>mins (approx)</i></td>
						</tr>
						<tr>
							<td><label for="filmBudget">Film Budget: </label></td>
							<td><input type="number" id="filmBudget" name="filmBudget" min="0" step="any" value="0"/></td>
							<td><i>US Dollars</i></td>
						</tr>
						<tr>
							<td><label for="boxOffice">Box Office: </label></td>
							<td><input type="number" id="boxOffice" name="boxOffice" min="0" step="any" value="0"/></td>
							<td><i>US Dollars</i></td>
						</tr>
						<tr>
							<td><label for="releaseDate">Release Date: </label></td>
							<td><input type="date" id="releaseDate" name="releaseDate"/></td>
							<td><i>(MM-DD-YYYY)</i></td>
						</tr>
					</table>
					<table>
						<tr>
							<td>Genre:</td>
						</tr>
						<tr>
							<td><input type="checkbox" value="Action" name="genre[]" id="Action"/><label for="Action">Action</label></td>
							<td><input type="checkbox" value="Adventure" name="genre[]" id="Adventure"/><label for="Adventure">Adventure</label></td>
							<td><input type="checkbox" value="Animation" name="genre[]" id="Animation"/><label for="Animation">Animation</label></td>
							<td><input type="checkbox" value="Comedy" name="genre[]" id="Comedy"/><label for="Comedy">Comedy</label></td>
							<td><input type="checkbox" value="Crime" name="genre[]" id="Crime"/><label for="Crime">Crime</label></td>
							<td><input type="checkbox" value="Drama" name="genre[]" id="Drama"/><label for="Drama">Drama</label></td>
						</tr>
						<tr>
							<td><input type="checkbox" value="Documentary" name="genre[]" id="Documentary"/><label for="Documentary">Documentary</label></td>
							<td><input type="checkbox" value="Family" name="genre[]" id="Family"/><label for="Family">Family</label></td>
							<td><input type="checkbox" value="Fantasy" name="genre[]" id="Fantasy"/><label for="Fantasy">Fantasy</label></td>
							<td><input type="checkbox" value="Horror" name="genre[]" id="Horror"/><label for="Horror">Horror</label></td>
							<td><input type="checkbox" value="Musical" name="genre[]" id="Musical"/><label for="Musical">Musical</label></td>
							<td><input type="checkbox" value="Mystery" name="genre[]" id="Mystery"/><label for="Mystery">Mystery</label></td>
						</tr>
						<tr>
							<td><input type="checkbox" value="Romance" name="genre[]" id="Romance"/><label for="Romance">Romance</label></td>
							<td><input type="checkbox" value="Sci-Fi" name="genre[]" id="Sci-Fi"/><label for="Sci-Fi">Sci-Fi</label></td>
							<td><input type="checkbox" value="Serial" name="genre[]" id="Serial"/><label for="Serial">Serial</label></td>
							<td><input type="checkbox" value="Short" name="genre[]" id="Short"/><label for="Short">Short</label></td>
							<td><input type="checkbox" value="Silent" name="genre[]" id="Silent"/><label for="Silent">Silent</label></td>
						</tr>
						<tr>
							<td><input type="checkbox" value="War" name="genre[]" id="War"/><label for="War">War</label></td>
							<td><input type="checkbox" value="Western" name="genre[]" id="Western"/><label for="Western">Western</label></td>
							<td><input type="checkbox" value="Biography" name="genre[]" id="Biography"/><label for="Biography">Biography</label></td>
							<td><input type="checkbox" value="Thriller" name="genre[]" id="Thriller"/><label for="Thriller">Thriller</label></td>
							<td><input type="checkbox" value="History" name="genre[]" id="History"/><label for="History">History</label></td>
						</tr>
						<tr>
							<td><input type="submit" value="Add Movie" title="Add" name="submitmovie"/></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<h3><a href="#">Add Actor</a></h3>
		<div>
			<div id="addActorDeets">
				<form name="addActor" onsubmit="return validateAddActor();" action="add.php" method="post">
					<table>
						<tr>
							<td><label for="actorName">Actor Name: </label></td>
							<td><input type="text" id="actorName" name="actorName" /></td>
						</tr>
						<tr>
							<td><label for="actorAge">Age: </label></td>
							<td><input type="number" id="actorAge" name="actorAge" min="13" max="115" value="13"/></td>
						</tr>
						<tr>
							<td>Gender:</td>
							<td><input type="radio" name="actorGender" id="genderM" value="M" checked="checked"/><label for="genderM">Male</label><input type="radio" name="actorGender" id="genderF" value="F" /><label for="genderF">Female</label></td>
						</tr>
						<tr>
							<td><input type="submit" value="Add Actor" title="Add" name="submitactor"/></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<h3><a href="#">Add Production Staff</a></h3>
		<div>
			<div id="addProdStaffDeets">
				<form name="addStaff" onsubmit="return validateAddStaff();" action="add.php" method="post">
					<table>
						<tr>
							<td><label for="staffName">Staff Name: </label></td>
							<td><input type="text" id="staffName" name="staffName" /></td>
						</tr>
						<tr>
							<td><label for="department">Department: </label></td>
							<td><input type="text" id="department" name="department" /></td>
						</tr>
						<tr>
							<td>Gender: </td>
							<td><input type="radio" name="staffGender" id="staffGenderM" value="M" checked="checked"/><label for="staffGenderM">Male</label><input type="radio" name="staffGender" id="staffGenderF" value="F" /><label for="staffGenderF">Female</label></td>
						</tr>
						<tr>
							<td><input type="submit" value="Add Staff" title="Add" name="submitstaff"/></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<h3><a href="#">Add Award</a></h3>
		<div>
			<div id="addAwardDeets">
				<form name="addAward" onsubmit="return validateAddAward();" action="add.php" method="post">
					<table>
						<tr>
							<td><label for="awardName">Award Name: </label></td>
							<td><input type="text" id="awardName" name="awardName" /></td>
						</tr>
						<tr>
							<td><label for="movie">Movie: </label></td>
							<td><select name="movie"><?php $manager->printMovies();?></select></td>
						</tr>
						<tr>
							<td><label for="awardStatus">Award Status: </a></td>
							<td><input type="radio" name="awardStatus" id="awardStatusN" value="N" checked="checked"/><label for="awardStatusN">Nominated<label><input type="radio" name="awardStatus" id="awardStatusW" value="W" /><label for="awardStatusW">Won</label></td>
						</tr>
						<tr>
							<td><input type="submit" value="Add Award" title="Add" name="submitaward"/></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<h3><a href="#">Add Receiving Date</a></h3>
		<div>
			<div id="addAwardDate">
				<form name="addAwardingDate" onsubmit="return validateAddAwardingDate();" action="add.php" method="post">
					<table>
						<tr>
							<td><label for="actor">Actor: </label></td>
							<td><select name="actor"><?php $manager->printActors();?></select></td>
						</tr>
						<tr>
							<td><label for="award">Award:</a></td>
							<td><select name="award"><?php $manager->printAwards();?></select></td>
						</tr>
						<tr>
							<td><label for="datereceived">Date Received:</a></td>
							<td><input type='date' name='datereceived' id='datereceived'></td>
							<td><i>(MM-DD-YYYY)</i></td>
						</tr>
						<tr>
							<td><input type="submit" value="Add Awarding Date" title="Add" name="submitawardingdate"/></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<h3><a href="#">Add Movie Role</a></h3>
		<div>
			<div id="addMovieRole">
				<form name="addMovieRole" onsubmit="return validateAddMovieRole();" action="add.php" method="post">
					<table>
						<tr>
							<td><label for="actor">Actor: </label></td>
							<td><select name="actor"><?php $manager->printActors();?></select></td>
						</tr>
						<tr>
							<td><label for="movie">Movie:</a></td>
							<td><select name="movie"><?php $manager->printMovies();?></select></td>
						</tr>
						<tr>
							<td><label for="amountreceived">Amount Received:</a></td>
							<td><input type='number' min='0' max='1000000000' value="0" name='amountreceived'></td>
							<td><i>US Dollars</i></td>
						</tr>
						<tr>
							<td><label for="movierole">Movie Role:</a></td>
							<td><input type='text' name='movierole'></td>
							<td><i>separate values by comma(,)</i></td>
						</tr>
						<tr>
							<td><input type="submit" value="Add Movie Role" title="Add" name="submitmovierole"/></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<h3><a href="#">Add Staff Position</a></h3>
		<div>
			<div id="addStaffRole">
				<form name="submitStaffRole" onsubmit="return validateAddStaffPosition();" action="add.php" method="post">
					<table>
						<tr>
							<td><label for="staff">Staff: </label></td>
							<td><select name="staff"><?php $manager->printStaff();?></select></td>
						</tr>
						<tr>
							<td><label for="movie">Movie:</a></td>
							<td><select name="movie"><?php $manager->printMovies();?></select></td>
						</tr>
						<tr>
							<td><label for="amountreceived">Amount Received:</a></td>
							<td><input type='number' min='0' max='1000000000' value="0" name='amountreceived'></td>
							<td><i>US Dollars</i></td>
						</tr>
						<tr>
							<td><label for="staffrole">Position:</a></td>
							<td><input type='text' name='staffrole'></td>
							<td><i>separate values by comma(,)</i></td>
						</tr>
						<tr>
							<td><input type="submit" value="Add Staff Position" title="Add" name="submitstaffrole"/></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
	<div id='center'>
		<a href='home.php'>Home</a><a href='add.php'> Add </a><a href='search.php'> Search </a><a href='delete.php'> Delete </a><a href='edit.php'> Edit </a>
	</div>
</body>
</html>