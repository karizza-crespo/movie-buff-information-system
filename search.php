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
		
		#searchbar{
			margin-top:5%;
		}
		</style>
	</head>
	<body>
		<div id='searchbar'>
		<center>
		<form name="searchdb" action="searchResults.php" method="post">
			<br />
			<label for="keyword">Key: </label>
			<input type="text" name="searchKeyword" id="keyword" />
			<select name="category">
				<option value="Movie">Movies</option>
				<option value="MovieRole">Movie Roles</option>
				<option value="Actor">Actors</option>
				<option value="Production_staff">Production Staff</option>
				<option value="Award">Awards</option>
				<option value="AwardingDate">Awarding Dates</option>
				<option value="StaffPosition">Staff Positions</option>
			</select>
			<input type="submit" value="Search" name="keywordsearch" />
		</form>
		</center>
		<br />
		<center>
		<form name="searchbymovie" action="searchResults.php" method="post">
			<label for="display">Movie Name:</label>
			<select name="display">
				<?php $manager=new databaseManager; $manager->printMovies();?>
			</select>
			<input type="submit" value="Display by Movie" name="displaybymovie" />
		</form>
		</center>
		<br />
		<center>
		<form name="retrieveAll" action="searchResults.php" method="post">
			<input type="submit" value="Retrieve All" name="retrieveall" />
			<input type="submit" value="Retrieve Movies" name="retrievemovie" />
			<input type="submit" value="Retrieve Actors" name="retrieveactor" />
			<input type="submit" value="Retrieve Staff" name="retrievestaff" />
			<input type="submit" value="Retrieve Awards" name="retrieveaward" />
			<input type="submit" value="Retrieve Awarding Dates" name="retrievedate" />
			<input type="submit" value="Retrieve Movie Roles" name="retrieverole" />
			<input type="submit" value="Retrieve Staff Positions" name="retrieveposition" />
		</form>
		</center>
		</div>
		<div id='center'>
			<a href='home.php'>Home</a><a href='add.php'>&nbsp;Add</a><a href='search.php'>&nbsp;Search</a><a href='delete.php'>&nbsp;Delete </a><a href='edit.php'>&nbsp;Edit </a>
		</div>
	</body>
</html>