<?php
include("classes.php");

//connect to the database
$db=pg_connect("host=localhost port=5432 dbname=cmsc127project user=postgres password=cmsc127");
class databaseManager
{
	public function addNewMovie($moviename, $filmbudget, $runningtime, $boxoffice, $producer, $releasedate, $genre)
	{
		//check first if the movie is already in the database
		$stmt="SELECT count(*) FROM movie WHERE Movie_name='$moviename';";
		$count=pg_fetch_array(pg_query($stmt));

		//if count is 0, movie is not yet in the database
		if($count[0]==0)
		{
			//insert values to the table movie
			$stmt="INSERT INTO movie VALUES ('$moviename', $filmbudget , $runningtime, $boxoffice, '$releasedate');";
			$success=pg_query($stmt);
			if($success)
			{
				//if inserting to the table movie is successful, insert the multivalued attributes to their specific tables
				for($i=0; $i<count($producer); $i++)
				{
					$stmt="INSERT INTO movie_producer VALUES ('$moviename','$producer[$i]');";
					pg_query($stmt);
				}
				for($i=0; $i<count($genre); $i++)
				{
					$stmt="INSERT INTO movie_genre VALUES ('$moviename','$genre[$i]');";
					pg_query($stmt);
				}
				return 1;
			}
			else
				return 0;
		}
		//else, the movie is already in the database
		else
			return 2;
	}
	
	public function addNewActor($actorname, $age, $actorgender)
	{
		//checks if the actor is already in the database
		$stmt="SELECT count(*) FROM actor WHERE Actor_name='$actorname';";
		$count=pg_fetch_array(pg_query($stmt));
		
		//count is 0, add the actor
		if($count[0]==0)
		{
			//insert the values into the actor table
			$stmt="INSERT INTO actor VALUES ('$actorname', $age, '$actorgender');";
			pg_query($stmt);
			return  1;
		}
		else
			return 2;
	}
	
	public function addNewStaff($staffname, $department, $staffgender)
	{
		//check if the staff is already in the database
		$stmt="SELECT count(*) FROM production_staff WHERE Staff_name='$staffname';";
		$count=pg_fetch_array(pg_query($stmt));
		
		//if not, add it
		if($count[0]==0)
		{
			//insert the values to the production_staff table
			$stmt="INSERT INTO production_staff VALUES ('$staffname', '$department', '$staffgender');";
			pg_query($stmt);
			return  1;
		}
		else
			return 2;
	}
	
	public function addNewAward($awardname, $movie, $awardstatus)
	{
		//check if the award and movie is already in the database
		$stmt="SELECT count(*) FROM award WHERE Award_name='$awardname' and Movie='$movie';";
		$count=pg_fetch_array(pg_query($stmt));
		
		//if not. add it
		if($count[0]==0)
		{
			//insert the values to the award table
			$stmt="INSERT INTO award VALUES ('$awardname', '$movie' , '$awardstatus');";
			$success=pg_query($stmt);
			
			if($success)
			{
				//if insertion to the award table was successful, insert the multi-valued attributes to their specific tables
				$stmt="SELECT genre from movie_genre WHERE Movie_name='".$movie."';";
				$result=pg_query($stmt);
				while($row=pg_fetch_assoc($result))
				{
					$stmt="INSERT INTO award_genre VALUES ('$awardname', '$movie', '".$row['genre']."');";
					pg_query($stmt);
				}
				return 1;
			}
			else
				return 0;
		}
		else
			return 2;
	}
	
	public function addNewReceives($actorname, $awardname, $date)
	{
		//check if it is already in the database
		$stmt="select count(*) from receives where actor_name = '$actorname' and award_name='$awardname';";
		$count=pg_fetch_array(pg_query($stmt));
		
		//if not, add it
		if($count[0]==0)
		{
			//insert the values into the receives table
			$stmt="INSERT INTO receives VALUES ('$actorname', '$awardname', '$date');";
			pg_query($stmt);
			return  1;
		}
		else
			return 2;
	}
	
	public function addNewMovieRole($actorname, $moviename, $amount, $movierole)
	{
		//check if the actor and the movie is already in the database
		$stmt="select count(*) from acts_in where actor_name = '$actorname' and movie_name='$moviename';";
		$count=pg_fetch_array(pg_query($stmt));
		
		//if not, add it
		if($count[0]==0)
		{
			//insert values into the acts_in table
			$stmt="INSERT INTO acts_in VALUES ('$moviename', '$actorname', '$amount');";
			pg_query($stmt);
			for($i=0; $i<count($movierole); $i++)
			{
				//if insertion to the acts_in table was successful, insert the movie roles to the movie_role table
				$stmt="INSERT INTO acts_in_movie_role VALUES ('$moviename', '$actorname', '$movierole[$i]');";
				pg_query($stmt);
			}
			return  1;
		}
		else
			return 2;
	}

	public function addNewStaffRole($moviename, $staffname, $amount, $staffrole)
	{
		//check if the staff and the movie is already in the database
		$stmt="select count(*) from is_produced_by where staff_name = '$staffname' and movie_name='$moviename';";
		$count=pg_fetch_array(pg_query($stmt));
		
		//if not, add it
		if($count[0]==0)
		{
			//insert the values to the is_produced_by table
			$stmt="INSERT INTO is_produced_by VALUES ('$moviename', '$staffname', '$amount');";
			pg_query($stmt);
			for($i=0; $i<count($staffrole); $i++)
			{
				//insert positions to the is_produced_by_position table
				$stmt="INSERT INTO is_produced_by_position VALUES ('$moviename', '$staffname', '$staffrole[$i]');";
				pg_query($stmt);
			}
			return  1;
		}
		else
			return 2;
	}
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
	//function for searching values in the database
	public function searchDatabase($keyword, $category)
	{
		$keyword=strtolower($keyword);
		$array = array();
		if($category=='Movie')
		{
			//check if the values are in the database
			$stmt="SELECT count(*) FROM $category WHERE lower(Movie_name) LIKE '%$keyword%';";
			$result=pg_fetch_array(pg_query($stmt));
			
			//if yes, select the values, add it to an array and return the array
			if($result[0]!=0)
			{
				$stmt="SELECT * FROM movie WHERE lower(Movie_name) LIKE '%$keyword%';";
				$result=pg_query($stmt);
				while($row=pg_fetch_assoc($result))
				{
					$anotherStmt="SELECT producer FROM movie_producer WHERE Movie_name='".$row['movie_name']."';";
					$anotherResult=pg_query($anotherStmt);
					$producer="";
					while($anotherRow=pg_fetch_assoc($anotherResult))
						$producer.="'".$anotherRow['producer']."' ";
					$anotherStmt="SELECT genre FROM movie_genre WHERE Movie_name='".$row['movie_name']."';";
					$anotherResult=pg_query($anotherStmt);
					$genre="";
					while($anotherRow=pg_fetch_assoc($anotherResult))
						$genre.="'".$anotherRow['genre']."' ";
					$array[] = new Movie($row['movie_name'], $row['film_budget'], $row['running_time'], $row['box_office'], $producer, $row['release_date'], $genre);
				}
				return $array;
			}
			else
				return null;
		}
		else if ($category=='Actor')
		{
			//check if the values are in the database
			$stmt="SELECT count(*) FROM $category WHERE lower(Actor_name) LIKE '%$keyword%';";
			$result=pg_fetch_array(pg_query($stmt));
			
			//if yes, select the values, add it to an array and return the array
			if($result[0]!=0)
			{
				$n=0;
				$stmt="SELECT * FROM $category WHERE lower(Actor_name) LIKE '%$keyword%';";
				$result=pg_query($stmt);
				while ($row=pg_fetch_assoc($result))
					$array[$n++] = new Actor($row['actor_name'], $row['age'], $row['gender']);
				return $array;
			}
			else
				return null;
		}
		else if ($category=='Production_staff')
		{
			//check if the values are in the database
			$stmt="SELECT count(*) FROM $category WHERE lower(Staff_name) LIKE '%$keyword%';";
			$result=pg_fetch_array(pg_query($stmt));
			
			//if yes, select the values, add it to an array and return the array
			if($result[0]!=0)
			{
				$n=0;
				$stmt="SELECT * FROM $category WHERE lower(Staff_name) LIKE '%$keyword%';";
				$result=pg_query($stmt);
				while ($row=pg_fetch_assoc($result))
					$array[$n++] = new ProductionStaff($row['staff_name'], $row['department'], $row['gender']);
				return $array;
			}
			else
				return null;
		}
		else if ($category=='Award')
		{
			//check if the values are in the database
			$stmt="SELECT count(*) FROM $category WHERE lower(Award_name) LIKE '%$keyword%' or lower(Movie) LIKE '%$keyword%';";
			$result=pg_fetch_array(pg_query($stmt));
			
			//if yes, select the values, add it to an array and return the array
			if($result[0]!=0)
			{
				$n=0;
				$stmt="SELECT * FROM $category WHERE lower(Award_name) LIKE '%$keyword%' or lower(Movie) LIKE '%$keyword%';";
				$result=pg_query($stmt);
				while($row=pg_fetch_assoc($result))
				{
					$anotherStmt="SELECT genre FROM award_genre WHERE Award_name='".$row['award_name']."' and Movie='".$row['movie']."';";
					$anotherResult=pg_query($anotherStmt);
					$genre="";
					while($anotherRow=pg_fetch_assoc($anotherResult))
						$genre.="'".$anotherRow['genre']."' ";
					$array[$n++] = new Award($row['award_name'], $row['movie'], $genre, $row['award_status']);
				}
				return $array;
			}
			else
				return null;
		}
		else if ($category=='MovieRole')
		{	
			//check if the values are in the database
			$stmt="SELECT count(*) FROM acts_in_movie_role WHERE lower(Movie_role) LIKE '%$keyword%';";
			$result=pg_fetch_array(pg_query($stmt));
			
			//if yes, select the values, add it to an array and return the array
			if($result[0]!=0)
			{
				$n=0;
				$stmt="SELECT * FROM acts_in_movie_role WHERE lower(Movie_role) LIKE '%$keyword%';";
				$result=pg_query($stmt);
				while($row=pg_fetch_assoc($result))
				{
					$anotherStmt="SELECT Movie_role FROM acts_in_movie_role WHERE Actor_name='".$row['actor_name']."' and Movie_name='".$row['movie_name']."';";
					$anotherResult=pg_query($anotherStmt);
					$roles="";
					while($anotherRow=pg_fetch_assoc($anotherResult))
						$roles.="'".$anotherRow['movie_role']."' ";
					$anotherStmt="SELECT amount_received from acts_in WHERE Actor_name='".$row['actor_name']."' and Movie_name='".$row['movie_name']."';";
					$anotherResult=pg_query($anotherStmt);
					while($anotherRow=pg_fetch_assoc($anotherResult))
						$array[$n++] = new MovieRole($row['actor_name'], $row['movie_name'], $anotherRow['amount_received'], $roles);
				}
				return $array;
			}
			else
				return null;
		}
		else if ($category=='AwardingDate')
		{
			//check if the values are in the database
			$stmt="SELECT count(*) FROM receives WHERE lower(Award_name) LIKE '%$keyword%' or lower(Actor_name) LIKE '%$keyword%';";
			$result=pg_fetch_array(pg_query($stmt));
			
			//if yes, select the values, add it to an array and return the array
			if($result[0]!=0)
			{
				$n=0;
				$stmt="SELECT * FROM receives WHERE lower(Award_name) LIKE '%$keyword%' or lower(Actor_name) LIKE '%$keyword%';";
				$result=pg_query($stmt);
				while ($row=pg_fetch_assoc($result))
					$array[$n++] = new AwardingDate($row['actor_name'], $row['award_name'], $row['date_received']);
				return $array;
			}
			else
				return null;
		}
		else
		{
			//check if the values are in the database
			$stmt="SELECT count(*) FROM is_produced_by_position WHERE lower(Staff_position) LIKE '%$keyword%';";
			$result=pg_fetch_array(pg_query($stmt));
			
			//if yes, select the values, add it to an array and return the array
			if($result[0]!=0)
			{
				$n=0;
				$stmt="SELECT * FROM is_produced_by_position WHERE lower(Staff_position) LIKE '%$keyword%';";
				$result=pg_query($stmt);
				while($row=pg_fetch_assoc($result))
				{
					$anotherStmt="SELECT Staff_position FROM is_produced_by_position WHERE Staff_name='".$row['staff_name']."' and Movie_name='".$row['movie_name']."';";
					$anotherResult=pg_query($anotherStmt);
					$positions="";
					while($anotherRow=pg_fetch_assoc($anotherResult))
						$positions.="'".$anotherRow['staff_position']."' ";
					$anotherStmt="SELECT amount_received from is_produced_by WHERE Staff_name='".$row['staff_name']."' and Movie_name='".$row['movie_name']."';";
					$anotherResult=pg_query($anotherStmt);
					while($anotherRow=pg_fetch_assoc($anotherResult))
						$array[$n++] = new staffPosition($row['staff_name'], $row['movie_name'], $anotherRow['amount_received'], $positions);
				}
				return $array;
			}
			else
				return null;
		}
	}
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	public function retrieveAllMovies()
	{
		//select all the values from the table, add it to the array and return the array
		$allMovie = array();
		$stmt="SELECT * FROM movie;";
		$result=pg_query($stmt);
		while($row=pg_fetch_assoc($result))
		{
			$anotherStmt="SELECT producer FROM movie_producer WHERE Movie_name='".$row['movie_name']."';";
			$anotherResult=pg_query($anotherStmt);
			$producer="";
			while($anotherRow=pg_fetch_assoc($anotherResult))
				$producer.="'".$anotherRow['producer']."' ";
			$anotherStmt="SELECT genre FROM movie_genre WHERE Movie_name='".$row['movie_name']."';";
			$anotherResult=pg_query($anotherStmt);
			$genre="";
			while($anotherRow=pg_fetch_assoc($anotherResult))
				$genre.="'".$anotherRow['genre']."' ";
			$allMovie[] = new Movie($row['movie_name'], $row['film_budget'], $row['running_time'], $row['box_office'], $producer, $row['release_date'], $genre);
		}
		return $allMovie;
	}
	
	public function retrieveAllActors()
	{
		//select all the values from the table, add it to the array and return the array
		$allActor = array();
		$stmt="SELECT * FROM actor;";
		$result=pg_query($stmt);
		while($row=pg_fetch_assoc($result))
			$allActor[]=new Actor($row['actor_name'], $row['age'], $row['gender']);
		return $allActor;
	}
	
	public function retrieveAllStaff()
	{
		//select all the values from the table, add it to the array and return the array
		$allStaff = array();
		$stmt="SELECT * FROM production_staff;";
		$result=pg_query($stmt);
		while($row=pg_fetch_assoc($result))
			$allStaff[]=new ProductionStaff($row['staff_name'], $row['department'], $row['gender']);
		return $allStaff;
	}
	
	public function retrieveAllAwards()
	{
		//select all the values from the table, add it to the array and return the array
		$allAward = array();
		$stmt="SELECT * FROM award;";
		$result=pg_query($stmt);
		while($row=pg_fetch_assoc($result))
		{
			$anotherStmt="SELECT genre FROM award_genre WHERE Award_name='".$row['award_name']."' and Movie='".$row['movie']."';";
			$anotherResult=pg_query($anotherStmt);
			$genre="";
			while($anotherRow=pg_fetch_assoc($anotherResult))
				$genre.="'".$anotherRow['genre']."' ";
			$allAward[] = new Award($row['award_name'], $row['movie'], $genre, $row['award_status']);
		}
		return $allAward;
	}
	
	public function retrieveAllMovieRoles()
	{
		//select all the values from the table, add it to the array and return the array
		$allRoles = array();
		$stmt="SELECT * FROM acts_in;";
		$result=pg_query($stmt);
		while($row=pg_fetch_assoc($result))
		{
			$anotherStmt="SELECT movie_role FROM acts_in_movie_role WHERE Actor_name='".$row['actor_name']."' and Movie_name='".$row['movie_name']."';";
			$anotherResult=pg_query($anotherStmt);
			$movieRoles="";
			while($anotherRow=pg_fetch_assoc($anotherResult))
				$movieRoles.="'".$anotherRow['movie_role']."' ";
			$allRoles[] = new MovieRole($row['actor_name'], $row['movie_name'], $row['amount_received'], $movieRoles);
		}
		return $allRoles;
	}
	
	public function retrieveAllPositions()
	{
		//select all the values from the table, add it to the array and return the array
		$allPositions = array();
		$stmt="SELECT * FROM is_produced_by;";
		$result=pg_query($stmt);
		while($row=pg_fetch_assoc($result))
		{
			$anotherStmt="SELECT staff_position FROM is_produced_by_position WHERE Movie_name='".$row['movie_name']."' and Staff_name='".$row['staff_name']."';";
			$anotherResult=pg_query($anotherStmt);
			$staffPosition="";
			while($anotherRow=pg_fetch_assoc($anotherResult))
				$staffPosition.="'".$anotherRow['staff_position']."' ";
			$allPositions[] = new staffPosition($row['staff_name'], $row['movie_name'], $row['amount_received'], $staffPosition);
		}
		return $allPositions;
	}
	
	public function retrieveAllDates()
	{
		//select all the values from the table, add it to the array and return the array
		$allDates = array();
		$stmt="SELECT * FROM receives;";
		$result=pg_query($stmt);
		while($row=pg_fetch_assoc($result))
			$allDates[] = new AwardingDate($row['actor_name'], $row['award_name'], $row['date_received']);
		return $allDates;
	}
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	//function for retrieving by movie
	public function retrieveAwardByMovie($keyword)
	{
		$array=array();
		//check if the values are in the database
		$stmt="SELECT count(*) FROM award WHERE Movie LIKE '%$keyword%';";
		$result=pg_fetch_array(pg_query($stmt));
	
		//if yes, select the values, add it to an array and return the array
		if($result[0]!=0)
		{
			$n=0;
			$stmt="SELECT * FROM award WHERE Movie LIKE '%$keyword%';";
			$result=pg_query($stmt);
			while($row=pg_fetch_assoc($result))
			{
				$anotherStmt="SELECT genre FROM award_genre WHERE Award_name='".$row['award_name']."' and Movie='".$row['movie']."';";
				$anotherResult=pg_query($anotherStmt);
				$genre="";
				while($anotherRow=pg_fetch_assoc($anotherResult))
					$genre.="'".$anotherRow['genre']."' ";
				$array[$n++] = new Award($row['award_name'], $row['movie'], $genre, $row['award_status']);
			}
			return $array;
		}
		else
			return null;
	}
	
	public function retrieveMovieRolesByMovie($keyword)
	{	
		$array=array();
		//check if the values are in the database
		$stmt="SELECT count(*) FROM acts_in_movie_role WHERE Movie_name LIKE '%$keyword%';";
		$result=pg_fetch_array(pg_query($stmt));
			
		//if yes, select the values, add it to an array and return the array
		if($result[0]!=0)
		{
			$n=0;
			$stmt="SELECT * FROM acts_in_movie_role WHERE Movie_name LIKE '%$keyword%';";
			$result=pg_query($stmt);
			$actorName="";
			while($row=pg_fetch_assoc($result))
			{
				if(strcmp($actorName, $row['actor_name'])!=0)
				{
					$anotherStmt="SELECT Movie_role FROM acts_in_movie_role WHERE Actor_name='".$row['actor_name']."' and Movie_name='".$row['movie_name']."';";
					$anotherResult=pg_query($anotherStmt);
					$roles="";
					while($anotherRow=pg_fetch_assoc($anotherResult))
						$roles.="'".$anotherRow['movie_role']."' ";
					$anotherStmt="SELECT amount_received from acts_in WHERE Actor_name='".$row['actor_name']."' and Movie_name='".$row['movie_name']."';";
					$anotherResult=pg_query($anotherStmt);
					while($anotherRow=pg_fetch_assoc($anotherResult))
						$array[$n++] = new MovieRole($row['actor_name'], $row['movie_name'], $anotherRow['amount_received'], $roles);
					$actorName=$row['actor_name'];
				}
			}
			return $array;
		}
		else
			return null;
	}
	
	public function retrieveStaffByMovie($keyword)
	{
		$array=array();
		//check if the values are in the database
		$stmt="SELECT count(*) FROM is_produced_by_position WHERE Movie_name LIKE '%$keyword%';";
		$result=pg_fetch_array(pg_query($stmt));
		
		//if yes, select the values, add it to an array and return the array
		if($result[0]!=0)
		{
			$n=0;
			$stmt="SELECT * FROM is_produced_by_position WHERE Movie_name LIKE '%$keyword%';";
			$result=pg_query($stmt);
			$staffName="";
			while($row=pg_fetch_assoc($result))
			{
				if(strcmp($staffName, $row['staff_name'])!=0)
				{
					$anotherStmt="SELECT Staff_position FROM is_produced_by_position WHERE Staff_name='".$row['staff_name']."' and Movie_name='".$row['movie_name']."';";
					$anotherResult=pg_query($anotherStmt);
					$positions="";
					while($anotherRow=pg_fetch_assoc($anotherResult))
						$positions.="'".$anotherRow['staff_position']."' ";
					$anotherStmt="SELECT amount_received from is_produced_by WHERE Staff_name='".$row['staff_name']."' and Movie_name='".$row['movie_name']."';";
					$anotherResult=pg_query($anotherStmt);
					while($anotherRow=pg_fetch_assoc($anotherResult))
						$array[$n++] = new staffPosition($row['staff_name'], $row['movie_name'], $anotherRow['amount_received'], $positions);
					$staffName=$row['staff_name'];
				}
			}
			return $array;
		}
		else
			return null;
	}
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	public function printDetailsByMovie($category, $details)
	{
		echo "<table border='1'>";
		if ($category=='Award')
		{
			echo "<tr>
				<th>Award Name</th>
				<th>Genre(s)</th>
				<th>Status</th>
			</tr>";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td>".$details[$ctr]->getAwardName()."</td>
				<td>".$details[$ctr]->getAwardGenre()."</td>
				<td>".$details[$ctr]->getAwardStatus()."</td>
				</tr>";
			}
		}
		else if($category=='MovieRole')
		{
			echo "<tr>
				<th>Actor Name</th>
				<th>Movie Role</th>
				<th>Amount Received</th>
			</tr>";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td>".$details[$ctr]->getActorName()."</td>
				<td>".$details[$ctr]->getMovieRole()."</td>
				<td>".$details[$ctr]->getAmountReceived()."</td>
				</tr>";
			}
		}
		else
		{
			echo "<tr>
				<th>Staff Name</th>
				<th>Position</th>
				<th>Amount Received</th>
			</tr>";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td>".$details[$ctr]->getStaffName()."</td>
				<td>".$details[$ctr]->getStaffPosition()."</td>
				<td>".$details[$ctr]->getAmountReceived()."</td>
				</tr>";
			}
		}
		echo "</table>";
	}
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	//function for printing all the details of the objects passed based on their category
	public function printDetails($category, $details)
	{
		echo "<table border='1'>";
		if($category=='Movie')
		{
			echo "<tr>
				<th>Movie Name</th>
				<th>Film Budget</th>
				<th>Running Time</th>
				<th>Box Office</th>
				<th>Producer(s)</th>
				<th>Release Date(s)</th>
				<th>Genre(s)</th>
			</tr>";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td>".$details[$ctr]->getMovieName()."</td>
				<td>".$details[$ctr]->getFilmBudget()."</td>
				<td>".$details[$ctr]->getRunningTime()."</td>
				<td>".$details[$ctr]->getBoxOffice()."</td>
				<td>".$details[$ctr]->getProducer()."</td>
				<td>".$details[$ctr]->getReleaseDate()."</td>
				<td>".$details[$ctr]->getGenre()."</td>
				</tr>";
			}
		}
		else if($category=='Actor')
		{
			echo "<tr>
				<th>Actor Name</th>
				<th>Age</th>
				<th>Gender</th>
			</tr>";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td>".$details[$ctr]->getActorName()."</td>
				<td>".$details[$ctr]->getActorAge()."</td>
				<td>".$details[$ctr]->getActorGender()."</td>
				</tr>";
			}
		}
		else if($category=='Production_staff')
		{
			echo "<tr>
				<th>Staff Name</th>
				<th>Department</th>
				<th>Gender</th>
			</tr>";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td>".$details[$ctr]->getStaffName()."</td>
				<td>".$details[$ctr]->getDepartment()."</td>
				<td>".$details[$ctr]->getStaffGender()."</td>
				</tr>";
			}
		}
		else if ($category=='Award')
		{
			echo "<tr>
				<th>Award Name</th>
				<th>Movie</th>
				<th>Genre(s)</th>
				<th>Status</th>
			</tr>";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td>".$details[$ctr]->getAwardName()."</td>
				<td>".$details[$ctr]->getMovie()."</td>
				<td>".$details[$ctr]->getAwardGenre()."</td>
				<td>".$details[$ctr]->getAwardStatus()."</td>
				</tr>";
			}
		}
		else if ($category=='AwardingDate')
		{
			echo "<tr>
				<th>Actor Name</th>
				<th>Award Name</th>
				<th>Date Received</th>
			</tr>";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td>".$details[$ctr]->getActorName()."</td>
				<td>".$details[$ctr]->getAwardName()."</td>
				<td>".$details[$ctr]->getDateReceived()."</td>
				</tr>";
			}
		}
		else if($category=='MovieRole')
		{
			echo "<tr>
				<th>Movie Name</th>
				<th>Actor Name</th>
				<th>Movie Role</th>
				<th>Amount Received</th>
			</tr>";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td>".$details[$ctr]->getMovieName()."</td>
				<td>".$details[$ctr]->getActorName()."</td>
				<td>".$details[$ctr]->getMovieRole()."</td>
				<td>".$details[$ctr]->getAmountReceived()."</td>
				</tr>";
			}
		}
		else
		{
			echo "<tr>
				<th>Movie Name</th>
				<th>Staff Name</th>
				<th>Position</th>
				<th>Amount Received</th>
			</tr>";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td>".$details[$ctr]->getMovieName()."</td>
				<td>".$details[$ctr]->getStaffName()."</td>
				<td>".$details[$ctr]->getStaffPosition()."</td>
				<td>".$details[$ctr]->getAmountReceived()."</td>
				</tr>";
			}
		}
		echo "</table>";
	}
	
	public function printMovies()
	{
		$stmt="SELECT Movie_name from movie;";
		$result=pg_query($stmt);
		
		while($row=pg_fetch_assoc($result))
			echo "<option value='".$row['movie_name']."'>".$row['movie_name']."</option>";
	}
	
	public function printAwards()
	{
		$stmt="SELECT DISTINCT award_name from award;";
		$result=pg_query($stmt);
		
		while($row=pg_fetch_assoc($result))
			echo "<option value='".$row['award_name']."'>".$row['award_name']."</option>";
	}
	
	public function printActors()
	{
		$stmt="SELECT actor_name from actor;";
		$result=pg_query($stmt);
		
		while($row=pg_fetch_assoc($result))
			echo "<option value='".$row['actor_name']."'>".$row['actor_name']."</option>";
	}
	
	public function printStaff()
	{
		$stmt="SELECT staff_name from production_staff;";
		$result=pg_query($stmt);
		
		while($row=pg_fetch_assoc($result))
			echo "<option value='".$row['staff_name']."'>".$row['staff_name']."</option>";
	}
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
	//function for printing the delete form
	public function printDelete($category, $details)
	{
		echo "<table border='1'>";
		if($category=='Movie')
		{
			echo "<tr>
				<th></th>
				<th>Movie Name</th>
				<th>Film Budget</th>
				<th>Running Time</th>
				<th>Box Office</th>
				<th>Producer(s)</th>
				<th>Release Date(s)</th>
				<th>Genre(s)</th>
			</tr>";
			echo "<input type='hidden' value='0' name='movie' />";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td><input type='checkbox' value='".$details[$ctr]->getMovieName()."' name='movie[]' id='movie".$ctr."' /></td>
				<td><label for='movie".$ctr."'>".$details[$ctr]->getMovieName()."</label></td>
				<td>".$details[$ctr]->getFilmBudget()."</td>
				<td>".$details[$ctr]->getRunningTime()."</td>
				<td>".$details[$ctr]->getBoxOffice()."</td>
				<td>".$details[$ctr]->getProducer()."</td>
				<td>".$details[$ctr]->getReleaseDate()."</td>
				<td>".$details[$ctr]->getGenre()."</td>
				</tr>";
			}
		}
		else if($category=='Actor')
		{
			echo "<tr>
				<th></th>
				<th>Actor Name</th>
				<th>Age</th>
				<th>Gender</th>
			</tr>";
			echo "<input type='hidden' value='0' name='actor' />";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td><input type='checkbox' value='".$details[$ctr]->getActorName()."' name='actor[]' id='actor".$ctr."'/></td>
				<td><label for='actor".$ctr."'>".$details[$ctr]->getActorName()."</label></td>
				<td>".$details[$ctr]->getActorAge()."</td>
				<td>".$details[$ctr]->getActorGender()."</td>
				</tr>";
			}
		}
		else if($category=='Production_staff')
		{
			echo "<tr>
				<th></th>
				<th>Staff Name</th>
				<th>Department</th>
				<th>Gender</th>
			</tr>";
			echo "<input type='hidden' value='0' name='prodstaff' />";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td><input type='checkbox' value='".$details[$ctr]->getStaffName()."' name='prodstaff[]' id='prodstaff".$ctr."'/></td>
				<td><label for='prodstaff".$ctr."'>".$details[$ctr]->getStaffName()."</label></td>
				<td>".$details[$ctr]->getDepartment()."</td>
				<td>".$details[$ctr]->getStaffGender()."</td>
				</tr>";
			}
		}
		else if($category=='Award')
		{
			echo "<tr>
				<th></th>
				<th>Award Name</th>
				<th>Movie</th>
				<th>Genre(s)</th>
				<th>Status</th>
			</tr>";
			echo "<input type='hidden' value='0' name='award' />";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td><input type='checkbox' value='".$details[$ctr]->getAwardName().",".$details[$ctr]->getMovie()."' name='award[]' id='award".$ctr."'/></td>
				<td><label for='award".$ctr."'>".$details[$ctr]->getAwardName()."</label></td>
				<td>".$details[$ctr]->getMovie()."</td>
				<td>".$details[$ctr]->getAwardGenre()."</td>
				<td>".$details[$ctr]->getAwardStatus()."</td>
				</tr>";
			}
		}
		else if ($category=='AwardingDate')
		{
			echo "<tr>
				<th></th>
				<th>Actor Name</th>
				<th>Award Name</th>
				<th>Date Received</th>
			</tr>";
			echo "<input type='hidden' value='0' name='awardingdate' />";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td><input type='checkbox' value='".$details[$ctr]->getActorName().",".$details[$ctr]->getAwardName()."' name='awardingdate[]' id='date".$ctr."'/></td>
				<td><label for='date".$ctr."'>".$details[$ctr]->getActorName()."</label></td>
				<td>".$details[$ctr]->getAwardName()."</td>
				<td>".$details[$ctr]->getDateReceived()."</td>
				</tr>";
			}
		}
		else if($category=='MovieRole')
		{
			echo "<tr>
				<th></th>
				<th>Movie Name</th>
				<th>Actor Name</th>
				<th>Movie Role</th>
				<th>Amount Received</th>
			</tr>";
			echo "<input type='hidden' value='0' name='movierole' />";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td><input type='checkbox' value='".$details[$ctr]->getMovieName().",".$details[$ctr]->getActorName()."' name='movierole[]' id='role".$ctr."'/></td>
				<td><label for='role".$ctr."'>".$details[$ctr]->getMovieName()."</label></td>
				<td>".$details[$ctr]->getActorName()."</td>
				<td>".$details[$ctr]->getMovieRole()."</td>
				<td>".$details[$ctr]->getAmountReceived()."</td>
				</tr>";
			}
		}
		else
		{
			echo "<tr>
				<th></th>
				<th>Movie Name</th>
				<th>Staff Name</th>
				<th>Position</th>
				<th>Amount Received</th>
			</tr>";
			echo "<input type='hidden' value='0' name='position' />";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td><input type='checkbox' value='".$details[$ctr]->getMovieName().",".$details[$ctr]->getStaffName()."' name='position[]' id='pos".$ctr."'/></td>
				<td><label for='pos".$ctr."'>".$details[$ctr]->getMovieName()."</label></td>
				<td>".$details[$ctr]->getStaffName()."</td>
				<td>".$details[$ctr]->getStaffPosition()."</td>
				<td>".$details[$ctr]->getAmountReceived()."</td>
				</tr>";
			}
		}
		echo "</table>";
	}
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
	public function deleteDatabase($delMovie, $delActor, $delProdStaff, $delAward, $delDate, $delRole, $delPos)
	{
		for($i=0; $i<count($delDate); $i++)
		{
			$key = array();
			$token=strtok($delDate[$i], ',');
			while($token)
			{
				$key[]=$token;
				$token=strtok(',');
			}
			//check if values are in the database
			$stmt="select count(*) FROM receives WHERE actor_name='$key[0]' and Award_name='$key[1]'";
			$result=pg_fetch_array(pg_query($stmt));
			
			//if yes, delete it from the table
			if($result[0]!=0)
			{
				$stmt="DELETE FROM receives WHERE actor_name='$key[0]' and Award_name='$key[1]'";
				pg_query($stmt);
			}
		}
		for($i=0; $i<count($delRole); $i++)
		{
			$key = array();
			$token=strtok($delRole[$i], ',');
			while($token)
			{
				$key[]=$token;
				$token=strtok(',');
			}
			//check if the values are in the database
			$stmt="select count(*) FROM acts_in WHERE Movie_name='$key[0]' and Actor_name='$key[1]'";
			$result=pg_fetch_array(pg_query($stmt));
			
			//if yes, delete first the values from the acts_in_movie_role table, then delete  from the acts_in table
			if($result[0]!=0)
			{
				$stmt="DELETE FROM acts_in_movie_role WHERE Movie_name='$key[0]' and Actor_name='$key[1]'";
				pg_query($stmt);
				$stmt="DELETE FROM acts_in WHERE Movie_name='$key[0]' and Actor_name='$key[1]'";
				pg_query($stmt);
			}
		}
		for($i=0; $i<count($delPos); $i++)
		{
			$key = array();
			$token=strtok($delPos[$i], ',');
			while($token)
			{
				$key[]=$token;
				$token=strtok(',');
			}
			//check if the values are in the database
			$stmt="select count(*) FROM is_produced_by WHERE Movie_name='$key[0]' and Staff_name='$key[1]'";
			$result=pg_fetch_array(pg_query($stmt));
			
			//if yes, delete first the values from the is_produced_by_position table, then delete  from the is_produced_by table
			if($result[0]!=0)
			{
				$stmt="DELETE FROM is_produced_by_position WHERE Movie_name='$key[0]' and Staff_name='$key[1]'";
				pg_query($stmt);
				$stmt="DELETE FROM is_produced_by WHERE Movie_name='$key[0]' and Staff_name='$key[1]'";
				pg_query($stmt);
			}
		}
		for($i=0; $i<count($delMovie); $i++)
		{
			//check if the values are in the database
			$stmt="select count(*) FROM movie WHERE Movie_name='$delMovie[$i]'";
			$result=pg_fetch_array(pg_query($stmt));
			
			//delete first the values from all the tables related to movie, then delete it from the table movie
			if($result[0]!=0)
			{
				$stmt="DELETE from movie_genre WHERE Movie_name='$delMovie[$i]';";
				pg_query($stmt);
				$stmt="DELETE from movie_producer WHERE Movie_name='$delMovie[$i]';";
				pg_query($stmt);
				$stmt="DELETE from acts_in_movie_role WHERE Movie_name='$delMovie[$i]';";
				pg_query($stmt);
				$stmt="DELETE from acts_in WHERE Movie_name='$delMovie[$i]';";
				pg_query($stmt);
				$stmt="DELETE from is_produced_by_position WHERE Movie_name='$delMovie[$i]';";
				pg_query($stmt);
				$stmt="DELETE from is_produced_by WHERE Movie_name='$delMovie[$i]';";
				pg_query($stmt);
				$stmt="DELETE from movie WHERE Movie_name='$delMovie[$i]';";
				pg_query($stmt);
			}
		}
		for($i=0; $i<count($delActor); $i++)
		{
			////check if the values are in the database
			$stmt="select count(*) FROM actor WHERE actor_name='$delActor[$i]'";
			$result=pg_fetch_array(pg_query($stmt));
			
			//delete first from all the tables related to actor, then delete if from the actor table
			if($result[0]!=0)
			{
				$stmt="DELETE FROM receives WHERE actor_name='$delActor[$i]'";
				pg_query($stmt);
				$stmt="DELETE from acts_in_movie_role WHERE Actor_name='$delActor[$i]';";
				pg_query($stmt);
				$stmt="DELETE from acts_in WHERE Actor_name='$delActor[$i]';";
				pg_query($stmt);
				$stmt="DELETE FROM actor WHERE actor_name='$delActor[$i]'";
				pg_query($stmt);
			}
		}
		for($i=0; $i<count($delProdStaff); $i++)
		{
			//check if the values are in the database
			$stmt="select count(*) FROM production_staff WHERE staff_name='$delProdStaff[$i]'";
			$result=pg_fetch_array(pg_query($stmt));
			
			//delete first from all the tables related to production_staff, then delete if from the production_staff table
			if($result[0]!=0)
			{
				$stmt="DELETE from is_produced_by_position WHERE Staff_name='$delProdStaff[$i]';";
				pg_query($stmt);
				$stmt="DELETE from is_produced_by WHERE Staff_name='$delProdStaff[$i]';";
				pg_query($stmt);
				$stmt="DELETE FROM production_staff WHERE staff_name='$delProdStaff[$i]'";
				pg_query($stmt);
			}
		}
		for($i=0; $i<count($delAward); $i++)
		{
			$key = array();
			$token=strtok($delAward[$i], ',');
			while($token)
			{
				$key[]=$token;
				$token=strtok(',');
			}
			//check if the values are in the database
			$stmt="select count(*) FROM award WHERE award_name='$key[0]' and Movie='$key[1]'";
			$result=pg_fetch_array(pg_query($stmt));
			
			//delete first from all the tables related to award, then delete if from the award table
			if($result[0]!=0)
			{
				$stmt="DELETE FROM receives WHERE award_name='$delAward[$i]'";
				pg_query($stmt);
				$stmt="DELETE FROM award_genre WHERE award_name='$key[0]' and Movie='$key[1]'";
				pg_query($stmt);
				$stmt="DELETE FROM award WHERE award_name='$key[0]' and Movie='$key[1]'";
				pg_query($stmt);
			}
		}
	}
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
	//prints the form for editing the details
	public function printEditForm($category, $details)
	{
		echo "<table>";
			if($category=='Movie')
			{
				//get the value(s) of the producer(s) and parse it, then display it in the textbox producer
				$producers = array();
				$token=strtok($details->getProducer(), "'");
				while($token)
				{
					if($token!="" && $token!=" ")
						$producers[]=$token;
					$token=strtok("'");
				}
				$string="";
				for($i=0; $i<count($producers); $i++)
				{
					if($i==(count($producers)-1))
						$string.=$producers[$i];
					else
						$string.=$producers[$i].",";
				}
				
				echo "<tr>
					<td><label for='moviename'>Movie Name: </label></td>
					<td><input type='text' name='moviename' id='moviename' value='".$details->getMovieName()."' disabled='disabled' /></td>
					<td><input type='hidden' name='moviename' value='".$details->getMovieName()."' /></td>
				</tr>
				<tr>
					<td><label for='producer'>Producer(s): </label></td>
					<td><input type='text' id='producer' name='producer' value='".$string."'/></td>
					<td>separate values by comma(,)</td>
				</tr>
				<tr>
					<td><label for='runningtime'>Running Time: </td>
					<td><input type='number' id='runningtime' name='runningtime' min='30' max='180' step='5' value='".$details->getRunningTime()."'/></td>
					<td>mins (approx)</td>
				</tr>
				<tr>
					<td><label for='filmbudget'>Film Budget: </label></td>
					<td><input type='number' id='filmbudget' name='filmbudget' step='any' value='".$details->getFilmBudget()."'/></td>
					<td>US Dollars</td>
				</tr>
				<tr>
					<td><label for='boxoffice'>Box Office: </label></td>
					<td><input type='number' name='boxoffice' id='boxoffice' min='0' step='any' value='".$details->getBoxOffice()."'/></td>
					<td>US Dollars</td>
				</tr>
				<tr>
					<td><label for='releasedate'>Release Date: </label></td>
					<td><input type='date' id='releasedate' name='releasedate' value='".$details->getReleaseDate()."'/></td>
					<td>MM/DD/YYYY</td>
				</tr>
				<tr>
					<td>Genre: </td>
					<td><span style='color:gold'><i>(Selected Genre(s): </i></span></td>
					<td><span style='color:gold'><i>".$details->getGenre().")</i></span></td>
				</tr>
				</table>
				<table>
					<tr>
						<td><input type='checkbox' value='Action' name='genre[]' id='Action'/><label for='Action'>Action</label></td>
						<td><input type='checkbox' value='Adventure' name='genre[]' id='Adventure'/><label for='Adventure'>Adventure</label></td>
						<td><input type='checkbox' value='Animation' name='genre[]' id='Animation'/><label for='Animation'>Animation</label></td>
						<td><input type='checkbox' value='Comedy' name='genre[]' id='Comedy'/><label for='Comedy'>Comedy</label></td>
						<td><input type='checkbox' value='Crime' name='genre[]' id='Crime'/><label for='Crime'>Crime</label></td>
						<td><input type='checkbox' value='Drama' name='genre[]' id='Drama'/><label for='Drama'>Drama</label></td>
					</tr>
					<tr>
						<td><input type='checkbox' value='Documentary' name='genre[]' id='Documentary'/><label for='Documentary'>Documentary</label></td>
						<td><input type='checkbox' value='Family' name='genre[]' id='Family'/><label for='Family'>Family</label></td>
						<td><input type='checkbox' value='Fantasy' name='genre[]' id='Fantasy'/><label for='Fantasy'>Fantasy</label></td>
						<td><input type='checkbox' value='Horror' name='genre[]' id='Horror'/><label for='Horror'>Horror</label></td>
						<td><input type='checkbox' value='Musical' name='genre[]' id='Musical'/><label for='Musical'>Musical</label></td>
						<td><input type='checkbox' value='Mystery' name='genre[]' id='Mystery'/><label for='Mystery'>Mystery</label></td>
					</tr>
					<tr>
						<td><input type='checkbox' value='Romance' name='genre[]' id='Romance'/><label for='Romance'>Romance</label></td>
						<td><input type='checkbox' value='Sci-Fi' name='genre[]' id='Sci-Fi'/><label for='Sci-Fi'>Sci-Fi</label></td>
						<td><input type='checkbox' value='Serial' name='genre[]' id='Serial'/><label for='Serial'>Serial</label></td>
						<td><input type='checkbox' value='Short' name='genre[]' id='Short'/><label for='Short'>Short</label></td>
						<td><input type='checkbox' value='Silent' name='genre[]' id='Silent'/><label for='Silent'>Silent</label></td>
					</tr>
					<tr>
						<td><input type='checkbox' value='War' name='genre[]' id='War'/><label for='War'>War</label></td>
						<td><input type='checkbox' value='Western' name='genre[]' id='Western'/><label for='Western'>Western</label></td>
						<td><input type='checkbox' value='Biography' name='genre[]' id='Biography'/><label for='Biography'>Biography</label></td>
						<td><input type='checkbox' value='Thriller' name='genre[]' id='Thriller'/><label for='Thriller'>Thriller</label></td>
						<td><input type='checkbox' value='History' name='genre[]' id='History'/><label for='History'>History</label></td>
					</tr>
					<tr>
					<td><input type='submit' value='Edit Movie' name='editMovie' /></td>
				</tr>";
			}
			else if($category=='Actor')
			{
				$gender=$details->getActorGender();
				echo "<tr>
					<td><label for='actorname'>Actor Name: </label></td>
					<td><input type='text' name='actorname' id='actorname' value='".$details->getActorName()."' disabled='disabled'/></td>
					<td><input type='hidden' name='actorname' value='".$details->getActorName()."'/></td>
				</tr>
				<tr>
					<td><label for='actorage'>Age: </label></td>
					<td><input type='number' name='actorage' id='actorage' min='13' max='115' value='".$details->getActorAge()."'/></td>
				</tr>
				<tr>
					<td>Gender</td>";
					if($gender=='M')
						echo "<td><input type='radio' name='actorGender' id='genderM' value='M' checked='checked'/><label for='genderM'>Male</label><input type='radio' name='actorGender' id='genderF' value='F' /><label for='genderF'>Female</label></td>";
					else
						echo "<td><input type='radio' name='actorGender' id='genderM' value='M' /><label for='genderM'>Male</label><input type='radio' name='actorGender' id='genderF' value='F' checked='checked'/><label for='genderF'>Female</label></td>";
				echo "</tr>
				<tr>
					<td><input type='submit' value='Edit Actor' name='editActor' /></td>
				</tr>";
			}
			else if($category=='Production_staff')
			{
				$gender=$details->getStaffGender();
				echo "<tr>
					<td><label for='staffname'>Staff Name:</label></td>
					<td><input type='text' name='staffname' id='staffname' value='".$details->getStaffName()."' disabled='disabled' /></td>
					<td><input type='hidden' name='staffname' value='".$details->getStaffName()."' /></td>
				</tr>
				<tr>
					<td><label for='department'>Department: </label></td>
					<td><input type='text' name='department' id='department' value='".$details->getDepartment()."'</td>
				</tr>
				<tr>
					<td>Gender</td>";
					if($gender=='M')
						echo "<td><input type='radio' name='staffGender' id='genderM' value='M' checked='checked'/><label for='genderM'>Male</label><input type='radio' name='staffGender' id='genderF' value='F' /><label for='genderF'>Female</label></td>";
					else
						echo "<td><input type='radio' name='staffGender' id='genderM' value='M' /><label for='genderM'>Male</label><input type='radio' name='staffGender' id='genderF' value='F' checked='checked'/><label for='genderF'>Female</label></td>";
				echo "</tr>
				<tr>
					<td><input type='submit' value='Edit Staff' name='editStaff' /></td>
				</tr>";
			}
			else if($category=='Award')
			{
				$status=$details->getAwardStatus();
				echo "<tr>
					<td><label for='awardname'>Award Name: </label></td>
					<td><input type='text' id='awardname' name='awardname' value='".$details->getAwardName()."' disabled='disabled'/></td>
					<td><input type='hidden' name='awardname' value='".$details->getAwardName()."'/></td>
				</tr>
				<tr>
					<td><label for='movie'>Movie: </label></td>
					<td><input type='text' id='movie' name='movie' value='".$details->getMovie()."' disabled='disabled'/></td>
					<td><input type='hidden' name='movie' value='".$details->getMovie()."'/></td>
				</tr>
				<tr>
					<td>Award Status: </td>";
					if($status=='W')
						echo "<td><input type='radio' name='awardstatus' id='statusW' value='W' checked='checked'/><label for='statusW'>Won</label><input type='radio' name='awardstatus' id='statusN' value='N' /><label for='statusN'>Nominated</label></td>";
					else
						echo "<td><input type='radio' name='awardstatus' id='statusW' value='W'/><label for='statusW'>Won</label><input type='radio' name='awardstatus' id='statusN' value='N' checked='checked'/><label for='statusN'>Nominated</label></td>";
				echo "</tr>
				<tr>
					<td><input type='submit' value='Edit Award' name='editAward' /></td>
				</tr>";
			}
			else if($category=='AwardingDate')
			{
				echo "<tr>
					<td><label for='awardname'>Award Name: </label></td>
					<td><input type='text' name='awardname' id='awardname' value='".$details->getAwardName()."' disabled='disabled'/></td>
					<td><input type='hidden' name='awardname' id='awardname' value='".$details->getAwardName()."' /></td>
				</tr>
				<tr>
					<td><label for='actorname'>Actor Name: </label></td>
					<td><input type='text' name='actorname' id='actorname' value='".$details->getActorName()."' disabled='disabled' /></td>
					<td><input type='hidden' name='actorname' id='actorname' value='".$details->getActorName()."'/></td>
				</tr>
				<tr>
					<td><label for='datereceived'>Date Received: </label></td>
					<td><input type='date' name='datereceived' id='datereceived' value='".$details->getDateReceived()."'</td>
				</tr>
				<tr>
					<td><input type='submit' value='Edit Awarding Date' name='awardingDate' /></td>
				</tr>";
			}
			else if ($category=='MovieRole')
			{
				//get the value(s) of the movie role(s) and parse it, then display it in the textbox movie roles
				$roles = array();
				$token=strtok($details->getMovieRole(), "'");
				while($token)
				{
					if($token!="" && $token!=" ")
						$roles[]=$token;
					$token=strtok("'");
				}
				$string="";
				for($i=0; $i<count($roles); $i++)
				{
					if($i==(count($roles)-1))
						$string.=$roles[$i];
					else
						$string.=$roles[$i].",";
				}
				echo "<tr>
					<td><label for='actorname'>Actor Name: </label></td>
					<td><input type='text' name='actorname' id='actorname' value='".$details->getActorName()."' disabled='disabled' /></td>
					<td><input type='hidden' name='actorname' id='actorname' value='".$details->getActorName()."'/></td>
				</tr>
				<tr>
					<td><label for='actorname'>Movie Name: </label></td>
					<td><input type='text' name='moviename' id='moviename' value='".$details->getMovieName()."' disabled='disabled' /></td>
					<td><input type='hidden' name='moviename' id='moviename' value='".$details->getMovieName()."'/></td>
				</tr>
				<tr>
					<td><label for='movieroles'>Movie Role(s): </label></td>
					<td><input type='text' name='movieroles' id='movieroles' value='".$string."' /></td>
					<td>separate values by comma(,)</td>
				</tr>
				<tr>
					<td><label for='amountreceived'>Amount Received: </label></td>
					<td><input type='number' name='amountreceived' id='amountreceived' min='0' max='1000000000' value='".$details->getAmountReceived()."'</td>
				</tr>
				<tr>
					<td><input type='submit' value='Edit Movie Role' name='movieRole' /></td>
				</tr>";
			}
			else if($category=='StaffPosition')
			{
				//get the value(s) of the position(s) and parse it, then display it in the textbox position
				$positions = array();
				$token=strtok($details->getStaffPosition(), "'");
				while($token)
				{
					if($token!="" && $token!=" ")
						$positions[]=$token;
					$token=strtok("'");
				}
				$string="";
				for($i=0; $i<count($positions); $i++)
				{
					if($i==(count($positions)-1))
						$string.=$positions[$i];
					else
						$string.=$positions[$i].",";
				}
				echo "<tr>
					<td><label for='staffname'>Staff Name: </label></td>
					<td><input type='text' name='staffname' id='staffname' value='".$details->getStaffName()."' disabled='disabled' /></td>
					<td><input type='hidden' name='staffname' id='staffname' value='".$details->getStaffName()."'/></td>
				</tr>
				<tr>
					<td><label for='actorname'>Movie Name: </label></td>
					<td><input type='text' name='moviename' id='moviename' value='".$details->getMovieName()."' disabled='disabled' /></td>
					<td><input type='hidden' name='moviename' id='moviename' value='".$details->getMovieName()."'/></td>
				</tr>
				<tr>
					<td><label for='staffpositions'>Staff Position(s): </label></td>
					<td><input type='text' name='staffpositions' id='staffpositions' value='".$string."' /></td>
					<td>separate values by comma(,)</td>
				</tr>
				<tr>
					<td><label for='amountreceived'>Amount Received: </label></td>
					<td><input type='number' name='amountreceived' id='amountreceived' min='0' max='1000000000' value='".$details->getAmountReceived()."'</td>
				</tr>
				<tr>
					<td><input type='submit' value='Edit Staff Position' name='staffPosition' /></td>
				</tr>";
			}
		echo "</table>";
	}
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/	
	public function editDatabaseMovie($moviename, $producer, $runningtime, $filmbudget, $boxoffice, $releasedate, $genre)
	{
		$producers = array();
		$token=strtok($producer, ',');
		while($token)
		{
			$producers[]=$token;
			$token=strtok(',');
		}
		//delete all the multivalued attributes
		$stmt="DELETE FROM movie_producer WHERE Movie_name='$moviename';";
		pg_query($stmt);
		$stmt="DELETE FROM movie_genre WHERE Movie_name='$moviename';";
		pg_query($stmt);
		for($i=0; $i<count($producers); $i++)
		{
			//insert the new details into their specific tables
			$stmt="INSERT INTO movie_producer values ('$moviename', '$producers[$i]');";
			pg_query($stmt);
		}
		for($i=0; $i<count($genre); $i++)
		{
			$stmt="INSERT INTO movie_genre values ('$moviename', '$genre[$i]');";
			pg_query($stmt);
		}
		//update the movie table
		$stmt="UPDATE movie set running_time=$runningtime, box_office=$boxoffice, film_budget=$filmbudget, release_date='$releasedate' WHERE movie_name='$moviename';";
		return pg_query($stmt);
	}
	public function editDatabaseActor($actorname, $actorage, $actorgender)
	{
		//updates the actor table
		$stmt="UPDATE actor set age=$actorage, gender='$actorgender' WHERE Actor_name='$actorname';";
		return pg_query($stmt);
	}
	
	public function editDatabaseStaff($staffname, $department, $staffgender)
	{
		//updates the production_staff table
		$stmt="UPDATE production_staff set department='$department', gender='$staffgender' WHERE Staff_name='$staffname';";
		return pg_query($stmt);
	}
	public function editDatabaseAward($awardname, $movie, $awardstatus, $awardgenre)
	{
		//delete all the multivalued attributes
		$stmt="DELETE FROM award_genre WHERE Award_name='$awardname' AND Movie='$movie';";
		pg_query($stmt);
		for($i=0; $i<count($awardgenre); $i++)
		{
			//insert the new details into their specific tables
			$stmt="INSERT INTO award_genre values ('$awardname', '$movie', '$awardgenre[$i]')";
			pg_query($stmt);
		}
		//update the award table
		$stmt="UPDATE award set award_status='$awardstatus' WHERE Award_name='$awardname' AND Movie='$movie'";
		return pg_query($stmt);
	}
	public function editDatabaseDate($actorname, $awardname, $date)
	{
		//update the receives table
		$stmt="UPDATE receives set date_received='$date' WHERE actor_name='$actorname' AND award_name='$awardname';";
		return pg_query($stmt);
	}
	
	public function editDatabaseRole($actorname, $moviename, $role, $amountreceived)
	{
		$roles = array();
		$token=strtok($role, ',');
		while($token)
		{
			$roles[]=$token;
			$token=strtok(',');
		}
		//delete all the multivalued attributes
		$stmt="DELETE FROM acts_in_movie_role WHERE Actor_name='$actorname' AND Movie_name='$moviename';";
		pg_query($stmt);
		for($i=0; $i<count($roles); $i++)
		{
			//insert the new details into their specific tables
			$stmt="INSERT INTO acts_in_movie_role values ('$moviename', '$actorname', '$roles[$i]');";
			pg_query($stmt);
		}
		//update the acts_in table
		$stmt="UPDATE acts_in set amount_received=$amountreceived WHERE Actor_name='$actorname' AND Movie_name='$moviename';";
		return pg_query($stmt);
	}
	
	public function editDatabasePosition($staffname, $moviename, $position, $amountreceived)
	{
		$positions = array();
		$token=strtok($position, ',');
		while($token)
		{
			$positions[]=$token;
			$token=strtok(',');
		}
		//delete all the multivalued attributes
		$stmt="DELETE FROM is_produced_by_position WHERE Staff_name='$staffname' AND Movie_name='$moviename';";
		pg_query($stmt);
		for($i=0; $i<count($positions); $i++)
		{
			//insert the new details into their specific tables
			$stmt="INSERT INTO is_produced_by_position values ('$moviename', '$staffname', '$positions[$i]');";
			pg_query($stmt);
		}
		//update the is_produced_by table
		$stmt="UPDATE is_produced_by set amount_received=$amountreceived WHERE Staff_name='$staffname' AND Movie_name='$moviename';";
		return pg_query($stmt);
	}
/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
	//prints the list of all the values that could be edited
	public function printEdit($category, $details)
	{
		echo "<table border='1'>";
		if($category=='Movie')
		{
			echo "<tr>
				<th>Movie Name</th>
				<th>Film Budget</th>
				<th>Running Time</th>
				<th>Box Office</th>
				<th>Producer(s)</th>
				<th>Release Date(s)</th>
				<th>Genre(s)</th>
				<th></th>
			</tr>";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td>".$details[$ctr]->getMovieName()."</td>
				<td>".$details[$ctr]->getFilmBudget()."</td>
				<td>".$details[$ctr]->getRunningTime()."</td>
				<td>".$details[$ctr]->getBoxOffice()."</td>
				<td>".$details[$ctr]->getProducer()."</td>
				<td>".$details[$ctr]->getReleaseDate()."</td>
				<td>".$details[$ctr]->getGenre()."</td>
				<td><input type='submit' value='Edit' name='movie$ctr' /></td>
				</tr>";
			}
		}
		else if($category=='Actor')
		{
			echo "<tr>
				<th>Actor Name</th>
				<th>Age</th>
				<th>Gender</th>
				<th></th>
			</tr>";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td>".$details[$ctr]->getActorName()."</td>
				<td>".$details[$ctr]->getActorAge()."</td>
				<td>".$details[$ctr]->getActorGender()."</td>
				<td><input type='submit' value='Edit' name='actor$ctr' /></td>
				</tr>";
			}
		}
		else if($category=='Production_staff')
		{
			echo "<tr>
				<th>Staff Name</th>
				<th>Department</th>
				<th>Gender</th>
				<th></th>
			</tr>";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td>".$details[$ctr]->getStaffName()."</td>
				<td>".$details[$ctr]->getDepartment()."</td>
				<td>".$details[$ctr]->getStaffGender()."</td>
				<td><input type='submit'  value='Edit' name='prodstaff$ctr' /></td>
				</tr>";
			}
		}
		else if($category=='Award')
		{
			echo "<tr>
				<th>Award Name</th>
				<th>Movie</th>
				<th>Genre(s)</th>
				<th>Status</th>
				<th></th>
			</tr>";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td>".$details[$ctr]->getAwardName()."</td>
				<td>".$details[$ctr]->getMovie()."</td>
				<td>".$details[$ctr]->getAwardGenre()."</td>
				<td>".$details[$ctr]->getAwardStatus()."</td>
				<td><input type='submit' value='Edit' name='award$ctr' /></td>
				</tr>";
			}
		}
		else if ($category=='AwardingDate')
		{
			echo "<tr>
				<th>Actor Name</th>
				<th>Award Name</th>
				<th>Date Received</th>
				<th></th>
			</tr>";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td>".$details[$ctr]->getActorName()."</td>
				<td>".$details[$ctr]->getAwardName()."</td>
				<td>".$details[$ctr]->getDateReceived()."</td>
				<td><input type='submit' value='Edit' name='awardingdate$ctr' /></td>
				</tr>";
			}
		}
		else if($category=='MovieRole')
		{
			echo "<tr>
				<th>Movie Name</th>
				<th>Actor Name</th>
				<th>Movie Role</th>
				<th>Amount Received</th>
				<th></th>
			</tr>";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>				
				<td>".$details[$ctr]->getMovieName()."</td>
				<td>".$details[$ctr]->getActorName()."</td>
				<td>".$details[$ctr]->getMovieRole()."</td>
				<td>".$details[$ctr]->getAmountReceived()."</td>
				<td><input type='submit' value='Edit' name='movierole$ctr' /></td>
				</tr>";
			}
		}
		else
		{
			echo "<tr>
				<th>Movie Name</th>
				<th>Staff Name</th>
				<th>Position</th>
				<th>Amount Received</th>
				<th></th>
			</tr>";
			for($ctr=0; $ctr<count($details); $ctr++)
			{
				echo "<tr>
				<td>".$details[$ctr]->getMovieName()."</td>
				<td>".$details[$ctr]->getStaffName()."</td>
				<td>".$details[$ctr]->getStaffPosition()."</td>
				<td>".$details[$ctr]->getAmountReceived()."</td>
				<td><input type='submit' value='Edit' name='position$ctr' /></td>
				</tr>";
			}
		}
		echo "</table>";
	}
}
?>