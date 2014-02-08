<?php include("functions.php");?>

<html>
	<head>
		<title>SEARCH</title>
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
			float:left;
			vertical-align:middle;
		}
		
		table{
			margin-left:3%;
			margin-top:1%;
			background-color:black;
		}
		
		td{
			color:white;
			font-size:15px;
			font-family:Sensible;
		}
		
		input[type= submit]{
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
			padding-top:0%;
			vertical-align:middle;
		}
		
		#results{
			margin-top:5%;
		}
		</style>
	</head>
	<body>
		<div id='results'>
		<?php	
			echo "<br />";
			$manager = new databaseManager;
			if(isset($_POST['keywordsearch']))	//searh by keyword
			{
				echo "<span style='margin-left:3%;'>RESULTS: </span><br />";
				$search=$manager->searchDatabase($_POST['searchKeyword'], $_POST['category']);
				if($search!=null)
					$manager->printDetails($_POST['category'], $search);
				else
					echo "<br /><span style='color:red; font-size:20px; margin-left:8%;'>".$_POST['searchKeyword']." is not in the ".$_POST['category']." table.</span><br />";
			}
			if(isset($_POST['retrievemovie']))	//retreives all the movies
			{
				$searchMovies=$manager->retrieveAllMovies();
				if($searchMovies!=null)
				{
					echo "<br /><span style='margin-left:3%;'>MOVIES: </span><br />";
					$manager->printDetails('Movie', $searchMovies);
				}
				else
					echo "<br /><span style='color:red; font-size:20px;'><center>Movie table is empty.</center></span><br />";
			}
			if(isset($_POST['retrieveactor'])) //retreives all the actors
			{
				$searchActors=$manager->retrieveAllActors();
				if($searchActors!=null)
				{
					echo "<br /><span style='margin-left:3%;'>ACTORS: </span><br />";
					$manager->printDetails('Actor', $searchActors);
				}
				else
					echo "<br /><span style='color:red; font-size:20px;'><center>Actor table is empty.</center></span><br />";
			}
			if(isset($_POST['retrievestaff']))	//retreives all the staff
			{
				$searchStaff=$manager->retrieveAllStaff();
				if($searchStaff!=null)
				{
					echo "<br /><span style='margin-left:3%;'>PRODUCTION STAFF: </span><br />";
					$manager->printDetails('Production_staff', $searchStaff);
				}
				else
					echo "<br /><span style='color:red; font-size:20px;'><center>Production_staff table is empty.</center></span><br />";
			}
			if(isset($_POST['retrieveaward']))	//retreives all the awards
			{
				$searchAward=$manager->retrieveAllAwards();
				if($searchAward!=null)
				{
					echo "<br /><span style='margin-left:3%;'>AWARDS: </span><br />";
					$manager->printDetails('Award', $searchAward);
				}
				else
					echo "<br /><span style='color:red; font-size:20px;'><center>Award table is empty.</center></span><br />";
			}
			if(isset($_POST['retrievedate']))	//retreives all the awarding dates
			{
				$searchDate=$manager->retrieveAllDates();
				if($searchDate!=null)
				{
					echo "<br /><span style='margin-left:3%;'>AWARDING DATES: </span><br />";
					$manager->printDetails('AwardingDate', $searchDate);
				}
				else
					echo "<br /><span style='color:red; font-size:20px;'><center>Receives table is empty.</center></span><br />";
			}
			if(isset($_POST['retrieverole']))	//retreives all the movie roles
			{
				$searchRoles=$manager->retrieveAllMovieRoles();
				if($searchRoles!=null)
				{
					echo "<br /><span style='margin-left:3%;'>MOVIE ROLES: </span><br />";
					$manager->printDetails('MovieRole', $searchRoles);
				}
				else
					echo "<br /><span style='color:red; font-size:20px;'><center>Acts_in table is empty.</center></span><br />";
			}
			if(isset($_POST['retrieveposition']))	//retreives all the staff positions
			{
				$searchPositions=$manager->retrieveAllPositions();
				if($searchPositions!=null)
				{
					echo "<br /><span style='margin-left:3%;'>STAFF POSITIONS: </span><br />";
					$manager->printDetails('StaffPosition', $searchPositions);
				}
				else
					echo "<br /><span style='color:red; font-size:20px;'><center>Is_produced_by table is empty.</center></span><br />";
			}
			if(isset($_POST['retrieveall']))	//retreives all
			{
				$searchMovies=$manager->retrieveAllMovies();
				if($searchMovies!=null)
				{
					echo "<br /><span style='margin-left:3%;'>MOVIES: </span><br />";
					$manager->printDetails('Movie', $searchMovies);
				}
				else
					echo "<br /><span style='color:red; font-size:20px;'><center>Movie table is empty.</center></span><br />";
				$searchActors=$manager->retrieveAllActors();
				if($searchActors!=null)
				{
					echo "<br /><span style='margin-left:3%;'>ACTORS: </span><br />";
					$manager->printDetails('Actor', $searchActors);
				}
				else
					echo "<br /><span style='color:red; font-size:20px;'><center>Actor table is empty.</center></span><br />";
				$searchStaff=$manager->retrieveAllStaff();
				if($searchStaff!=null)
				{
					echo "<br /><span style='margin-left:3%;'>PRODUCTION STAFF: </span><br />";
					$manager->printDetails('Production_staff', $searchStaff);
				}
				else
					echo "<br /><span style='color:red; font-size:20px;'><center>Production_staff table is empty.</center></span><br />";
				$searchAward=$manager->retrieveAllAwards();
				if($searchAward!=null)
				{
					echo "<br /><span style='margin-left:3%;'>AWARDS: </span><br />";
					$manager->printDetails('Award', $searchAward);
				}
				else
					echo "<br /><span style='color:red; font-size:20px;'><center>Award table is empty.</center></span><br />";
				$searchDate=$manager->retrieveAllDates();
				if($searchDate!=null)
				{
					echo "<br /><span style='margin-left:3%;'>AWARDING DATES: </span><br />";
					$manager->printDetails('AwardingDate', $searchDate);
				}
				else
					echo "<br /><span style='color:red; font-size:20px;'><center>Receives table is empty.</center></span><br />";
				$searchRoles=$manager->retrieveAllMovieRoles();
				if($searchRoles!=null)
				{
					echo "<br /><span style='margin-left:3%;'>MOVIE ROLES: </span><br />";
					$manager->printDetails('MovieRole', $searchRoles);
				}
				else
					echo "<br /><span style='color:red; font-size:20px;'><center>Acts_in table is empty.</center></span><br />";
				$searchPositions=$manager->retrieveAllPositions();
				if($searchPositions!=null)
				{
					echo "<br/><span style='margin-left:3%;'>STAFF POSITIONS: </span><br />";
					$manager->printDetails('StaffPosition', $searchPositions);
				}
				else
					echo "<br /><span style='color:red; font-size:20px;'><center>Is_produced_by table is empty.</center></span><br />";
			}
			if(isset($_POST['displaybymovie']))
			{
				echo "<center>".strtoupper($_POST['display'])."</center>";
				$searchRoles=$manager->retrieveMovieRolesByMovie($_POST['display']);
				if($searchRoles!=null)
				{
					echo "<br /><span style='margin-left:3%;'>MOVIE ROLES: </span><br />";
					$manager->printDetailsByMovie('MovieRole', $searchRoles);
				}
				else
					echo "<br /><span style='color:red; font-size:20px;'><center>No Movie Roles.</center></span><br />";
				$searchPositions=$manager->retrieveStaffByMovie($_POST['display']);
				if($searchPositions!=null)
				{
					echo "<br/><span style='margin-left:3%;'>STAFF POSITIONS: </span><br />";
					$manager->printDetailsByMovie('StaffPosition', $searchPositions);
				}
				else
					echo "<br /><span style='color:red; font-size:20px;'><center>No Production Staff.</center></span><br />";
				$searchAwards=$manager->retrieveAwardByMovie($_POST['display']);
				if($searchAwards!=null)
				{
					echo "<br/><span style='margin-left:3%;'>AWARDS: </span><br />";
					$manager->printDetailsByMovie('Award', $searchAwards);
				}
				else
					echo "<br /><span style='color:red; font-size:20px;'><center>No Awards.</center></span><br />";
			}
		?>
		</div>
		<div id='center'>
			<a href='home.php'>Home</a><a href='add.php'>&nbsp;Add</a><a href='search.php'>&nbsp;Search</a><a href='delete.php'>&nbsp;Delete </a><a href='edit.php'>&nbsp;Edit </a>
		</div>
	</body>
</html>