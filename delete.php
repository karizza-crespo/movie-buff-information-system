<?php include("functions.php");?>

<html>
	<head>
		<title>DELETE</title>
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery-ui.min.js"></script>
		<script src="js/jquery.flip"></script>
		<script src="js/jquery.flip.min"></script>
		<script>
		  $(document).ready(function() {
			$("#buttons").hide();
			$("#searchbar").hide();
			$("#searchbar").fadeIn("slow");
			$("#buttons").fadeIn("slow");
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
				color:gold;
				font-family:Sensible;
				margin-left:2%;
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
				margin-top:1%;
				background-color:black;
			}
			
			td{
				color:white;
				font-size:15px;
				font-family:Sensible;
			}
			
			input[type= submit], input[type=button]{
				background-color:gold;
				font-size:13px;
				color:black;
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
			
			input,td {
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
				width:100%;
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
			
			#buttons, .header{
				padding-top:2%;
				padding-left:8%;
			}
			
			#searchbar{
				padding-left:30%;
				margin-top:5%;
			}
			
		  </style>
		<script>
			function checkall()
			{
				var target=document.getElementsByTagName('input');
				for(i=0; i<target.length; i++)
				{
					if(target[i].type=='checkbox')
						target[i].checked='checked';
				}
			}
			
			function uncheckall()
			{
				var target=document.getElementsByTagName('input');
				for(i=0; i<target.length; i++)
				{
					if(target[i].type=='checkbox')
						target[i].checked='';
				}
			}
		</script>
	</head>
	<body>
		<br />
		<br />
		<div id='buttons'>
			<form name="retrieveAll" action="delete.php" method="post">
				<input type="button" value="Check All" name="check" onclick="checkall();"/>
				<input type="button" value="Uncheck All" name="uncheck" onclick="uncheckall();"/>
				<input type="submit" value="Delete" name="delete" />
		</div>
		<?php
			$manager = new databaseManager;
			$searchMovies=$manager->retrieveAllMovies();
			if($searchMovies!=null)
			{
				echo "<br />MOVIES: <br />";
				$manager->printDelete('Movie', $searchMovies);
			}
			else
				echo "<br /><span style='color:red'>Movie table is empty.</span><br />";
			$searchActors=$manager->retrieveAllActors();
			if($searchActors!=null)
			{
				echo "<br />ACTORS: <br />";
				$manager->printDelete('Actor', $searchActors);
			}
			else
				echo "<br /><span style='color:red'>Actor table is empty.</span><br />";
			$searchStaff=$manager->retrieveAllStaff();
			if($searchStaff!=null)
			{
				echo "<br />PRODUCTION STAFF: <br />";
				$manager->printDelete('Production_staff', $searchStaff);
			}
			else
				echo "<br /><span style='color:red'>Production_staff table is empty.</span><br />";
			$searchAward=$manager->retrieveAllAwards();
			if($searchAward!=null)
			{
				echo "<br />AWARDS: <br />";
				$manager->printDelete('Award', $searchAward);
			}
			else
				echo "<br /><span style='color:red'>Award table is empty.</span><br />";
			$searchRoles=$manager->retrieveAllMovieRoles();
			if($searchRoles!=null)
			{
				echo "<br />MOVIE ROLES: <br />";
				$manager->printDelete('MovieRole', $searchRoles);
			}
			else
				echo "<br /><span style='color:red'>Acts_in table is empty.</span><br />";
			$searchPositions=$manager->retrieveAllPositions();
			if($searchPositions!=null)
			{
				echo "<br />STAFF POSITIONS: <br />";
				$manager->printDelete('StaffPosition', $searchPositions);
			}
			else
				echo "<br /><span style='color:red'>Is_produced_by table is empty.</span><br />";
			$searchDates=$manager->retrieveAllDates();
			if($searchDates!=null)
			{
				echo "<br />AWARDING DATES: <br />";
				$manager->printDelete('AwardingDate', $searchDates);
			}
			else
				echo "<br /><span style='color:red'>Receives table is empty.</span><br />";
			if(isset($_POST['delete']))
			{
				$delMovie=$_POST['movie'];
				$delActor=$_POST['actor'];
				$delProdStaff=$_POST['prodstaff'];
				$delAward=$_POST['award'];
				$delDate=$_POST['awardingdate'];
				$delRole=$_POST['movierole'];
				$delPos=$_POST['position'];
				$delete=$manager->deleteDatabase($delMovie, $delActor, $delProdStaff, $delAward, $delDate, $delRole, $delPos);
				header('Location: delete.php');
			}
		?>
		</form>
		<div id='center'>
				<a href='home.php'>Home</a><a href='add.php'> Add </a><a href='search.php'> Search </a><a href='delete.php'> Delete </a><a href='edit.php'> Edit </a>
		</div>
	</body>
</html>