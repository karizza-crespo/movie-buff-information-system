<?php include("functions.php");
$pattern="/^[A-Za-z0-9-,\s]+$/";
?>
<html>
	<head>
		<title>EDITING...</title>
		<script src="js/script.js"></script>
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery-ui.min.js"></script>
		<script src="js/jquery.flip"></script>
		<script src="js/jquery.flip.min"></script>
		<script>
			$(document).ready(function() {
			$("#main").hide();
			$("#main").fadeIn("slow");
		  });
		</script>
		<style>
		@font-face{
			font-family:Loyal;
			src:url('css/Loyal.ttf');
		}

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
		#main{
			margin-top:5%;
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
		
		#accordion{
			margin-top:5%;
		}
		
		a:hover{
			color:white;
		}
		
		#center{	
		position:absolute;
		width:75%;
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
	
  </style>
	</head>
	<body>
		<div id='main'>
		<table>
		<form name='updateDetails' onsubmit="return validateEdit();" action='editDetails.php' method='post'>
		<?php 
			$manager = new databaseManager;
			$searchMovies=$manager->retrieveAllMovies();
			for($i=0; $i<count($searchMovies); $i++)
			{
				if(isset($_POST["movie$i"]))
					$manager->printEditForm('Movie', $searchMovies[$i]);
			}
			$searchActors=$manager->retrieveAllActors();
			for($i=0; $i<count($searchActors); $i++)
			{
				if(isset($_POST["actor$i"]))
					$manager->printEditForm('Actor', $searchActors[$i]);
			}
			$searchStaff=$manager->retrieveAllStaff();
			for($i=0; $i<count($searchStaff); $i++)
			{
				if(isset($_POST["prodstaff$i"]))
					$manager->printEditForm('Production_staff', $searchStaff[$i]);
			}
			$searchAward=$manager->retrieveAllAwards();
			for($i=0; $i<count($searchAward); $i++)
			{
				if(isset($_POST["award$i"]))
					$manager->printEditForm('Award', $searchAward[$i]);
			}
			$searchRoles=$manager->retrieveAllMovieRoles();
			for($i=0; $i<count($searchRoles); $i++)
			{
				if(isset($_POST["movierole$i"]))
					$manager->printEditForm('MovieRole', $searchRoles[$i]);
			}
			$searchPositions=$manager->retrieveAllPositions();
			for($i=0; $i<count($searchPositions); $i++)
			{
				if(isset($_POST["position$i"]))
					$manager->printEditForm('StaffPosition', $searchPositions[$i]);
			}
			$searchDates=$manager->retrieveAllDates();
			for($i=0; $i<count($searchDates); $i++)
			{
				if(isset($_POST["awardingdate$i"]))
					$manager->printEditForm('AwardingDate', $searchDates[$i]);
			}
			if(isset($_POST['editMovie']))
			{
				if(preg_match($pattern, $_POST['producer']))
				{
					$movie=$manager->editDatabaseMovie($_POST['moviename'], $_POST['producer'], $_POST['runningtime'], $_POST['filmbudget'], $_POST['boxoffice'], $_POST['releasedate'], $_POST['genre']);
					if($movie)
						header('Location: edit.php');
					else
							echo "<span style='color:red'><br /><center>Failed to update Movie.</center></span><br />";
				}
				else
					echo "<span style='color:red'><br /><center>Invalid Movie Details.</center></span><br />";
			}
			if(isset($_POST['editActor']))
			{
				$actor=$manager->editDatabaseActor($_POST['actorname'], $_POST['actorage'], $_POST['actorGender']);
				if($actor)
					header('Location: edit.php');
				else
					echo "<span style='color:red'><br /><center>Failed to update Actor.</center></span><br />";
			}
			if(isset($_POST['editStaff']))
			{
				if(preg_match($pattern, $_POST['department']))
				{
					$staff=$manager->editDatabaseStaff($_POST['staffname'], $_POST['department'], $_POST['staffGender']);
					if($staff)
						header('Location: edit.php');
					else
						echo "<span style='color:red'><br /><center>Failed to update Staff.</center></span><br />";
				}
				else
					echo "<span style='color:red'><center><br />Invalid Staff Details.</center></span><br />";
			}
			if(isset($_POST['editAward']))
			{
				$award=$manager->editDatabaseAward($_POST['awardname'], $_POST['movie'], $_POST['awardstatus'], $_POST['awardgenre']);
				if($award)
					header('Location: edit.php');
				else
					echo "<span style='color:red'><br /><center>Failed to update Award.</center></span><br />";
			}
			if(isset($_POST['awardingDate']))
			{
				$date=$manager->editDatabaseDate($_POST['actorname'], $_POST['awardname'], $_POST['datereceived']);
				if($date)
					header('Location: edit.php');
				else
					echo "<span style='color:red'><br /><center>Failed to update Awarding Date.</center></span><br />";
			}
			if(isset($_POST['movieRole']))
			{
				if(preg_match($pattern, $_POST['movieroles']))
				{
					$role=$manager->editDatabaseRole($_POST['actorname'], $_POST['moviename'], $_POST['movieroles'], $_POST['amountreceived']);
					if($role)
						header('Location: edit.php');
					else
						echo "<span style='color:red'><br /><center>Failed to update Movie Role.</center></span><br />";
				}
				else
					echo "<span style='color:red'><br /><center>Invalid Movie Role Details.</center></span><br />";
			}
			if(isset($_POST['staffPosition']))
			{
				if(preg_match($pattern, $_POST['staffpositions']))
				{
					$position=$manager->editDatabasePosition($_POST['staffname'], $_POST['moviename'], $_POST['staffpositions'], $_POST['amountreceived']);
					if($position)
						header('Location: edit.php');
					else
						echo "<span style='color:red'><br /><center>Failed to update Staff Position.</center></span><br />";
				}
				else
					echo "<span style='color:red'><br /><center>Invalid Staff Position Details.</center></span><br />";
			}
		?>
		</form>
		</table>
		</div>
		<div id='center'>
			<a href='home.php'>Home</a><a href='add.php'> Add </a><a href='search.php'> Search </a><a href='delete.php'> Delete </a><a href='edit.php'> Edit </a>
		</div>
	</body>
</html>