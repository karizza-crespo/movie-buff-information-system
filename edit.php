<?php include("functions.php");?>

<html>
	<head>
		<title>EDIT</title>
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
				font-family:Sensible;
			}
			
			#main{
				color:gold;
				padding-left:2%;
				padding-top:40px;
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
				background-color:black;
			}
			
			td{
				color:white;
				font-size:15px;
				font-family:Sensible;
				
			}
			
			th{
				color:gold;
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
			
		  </style>
	</head>
	<body>
		<div id='main'>
		<form name='updateDetails' action='editDetails.php' method='post'>
		<?php
			$manager = new databaseManager;
			$searchMovies=$manager->retrieveAllMovies();
			if($searchMovies!=null)
			{
				echo "<br />MOVIES: <br /><br />";
				$manager->printEdit('Movie', $searchMovies);
			}
			else
				echo "<br /><span style='color:red'>Movie table is empty.</span><br />";
			$searchActors=$manager->retrieveAllActors();
			if($searchActors!=null)
			{
				echo "<br />ACTORS: <br /><br />";
				$manager->printEdit('Actor', $searchActors);
			}
			else
				echo "<br /><span style='color:red'>Actor table is empty.</span><br />";
			$searchStaff=$manager->retrieveAllStaff();
			if($searchStaff!=null)
			{
				echo "<br />PRODUCTION STAFF: <br /><br />";
				$manager->printEdit('Production_staff', $searchStaff);
			}
			else
				echo "<br /><span style='color:red'>Production_staff table is empty.</span><br />";
			$searchAward=$manager->retrieveAllAwards();
			if($searchAward!=null)
			{
				echo "<br />AWARDS: <br /><br />";
				$manager->printEdit('Award', $searchAward);
			}
			else
				echo "<br /><span style='color:red'>Award table is empty.</span><br />";
			$searchRoles=$manager->retrieveAllMovieRoles();
			if($searchRoles!=null)
			{
				echo "<br />MOVIE ROLES: <br /><br />";
				$manager->printEdit('MovieRole', $searchRoles);
			}
			else
				echo "<br /><span style='color:red'>Acts_in table is empty.</span><br />";
			$searchPositions=$manager->retrieveAllPositions();
			if($searchPositions!=null)
			{
				echo "<br />STAFF POSITIONS: <br /><br />";
				$manager->printEdit('StaffPosition', $searchPositions);
			}
			else
				echo "<br /><span style='color:red'>Is_produced_by table is empty.</span><br />";
			$searchDates=$manager->retrieveAllDates();
			if($searchDates!=null)
			{
				echo "<br />AWARDING DATES: <br /><br />";
				$manager->printEdit('AwardingDate', $searchDates);
			}
			else
				echo "<br /><span style='color:red'>Receives table is empty.</span><br />";
		?>
		</form>
		</div>
		<div id='center'>
		<a href='home.php'>Home</a><a href='add.php'> Add </a><a href='search.php'> Search </a><a href='delete.php'> Delete </a><a href='edit.php'> Edit </a>
	</div>
	</body>
</html>