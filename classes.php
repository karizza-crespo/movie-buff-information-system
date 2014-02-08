<?php

class Movie
{
	private $moviename;
	private $filmbudget;
	private $runningtime;
	private $boxoffice;
	private $producer;
	private $releasedate;
	private $genre;
	
	function __construct($moviename, $filmbudget, $runningtime, $boxoffice, $producer, $releasedate, $genre)
	{
		$this->moviename=$moviename;
		$this->filmbudget=$filmbudget;
		$this->runningtime=$runningtime;
		$this->boxoffice=$boxoffice;
		$this->producer=$producer;
		$this->releasedate=$releasedate;
		$this->genre=$genre;
	}
	
	public function setMovieName($moviename)
	{
		$this->moviename=$moviename;
	}
	
	public function getMovieName()
	{
		return $this->moviename;
	}
	
	public function setFilmBudget($filmbudget)
	{
		$this->filmbudget=$filmbudget;
	}
	
	public function getFilmBudget()
	{
		return $this->filmbudget;
	}
	
	public function setRunningTime($runningtime)
	{
		$this->runningtime=$runningtime;
	}
	
	public function getRunningTime()
	{
		return $this->runningtime;
	}
	
	public function setBoxOffice($boxoffice)
	{
		$this->boxoffice=$boxoffice;
	}
	
	public function getBoxOffice()
	{
		return $this->boxoffice;
	}
	
	public function setProducer($producer)
	{
		$this->producer=$producer;
	}
	
	public function getProducer()
	{
		return $this->producer;
	}
	
	public function setReleaseDate($releasedate)
	{
		$this->releasedate=$releasedate;
	}
	
	public function getReleaseDate()
	{
		return $this->releasedate;
	}
	
	public function setGenre($genre)
	{
		$this->genre=$genre;
	}
	
	public function getGenre()
	{
		return $this->genre;
	}
}

class Actor
{
	private $actorname;
	private $actorage;
	private $actorgender;
	
	function __construct($actorname, $actorage, $actorgender)
	{
		$this->actorname=$actorname;
		$this->actorage=$actorage;
		$this->actorgender=$actorgender;
	}
	
	public function setActorName($actorname)
	{
		$this->actorname=$actorname;
	}
	
	public function getActorName()
	{
		return $this->actorname;
	}
	
	public function setActorAge($actorage)
	{
		$this->actorage=$actorage;
	}
	
	public function getActorAge()
	{
		return $this->actorage;
	}
	
	public function setActorGender($actorgender)
	{
		$this->actorgender=$actorgender;
	}
	
	public function getActorGender()
	{
		return $this->actorgender;
	}
}

class ProductionStaff
{
	private $staffname;
	private $department;
	private $staffgender;
	
	function __construct($staffname, $department, $staffgender)
	{
		$this->staffname=$staffname;
		$this->department=$department;
		$this->staffgender=$staffgender;
	}
	
	public function setStaffName($staffname)
	{
		$this->staffname=$staffname;
	}
	
	public function getStaffName()
	{
		return $this->staffname;
	}
	
	public function setDepartment($department)
	{
		$this->department=$department;
	}
	
	public function getDepartment()
	{
		return $this->department;
	}
	
	public function setStaffGender($staffgender)
	{
		$this->staffgender=$staffgender;
	}
	
	public function getStaffGender()
	{
		return $this->staffgender;
	}
}

class Award
{
	private $awardname;
	private $movie;
	private $awardgenre;
	private $awardstatus;
	
	function __construct($awardname, $movie, $awardgenre, $awardstatus)
	{
		$this->awardname=$awardname;
		$this->movie=$movie;
		$this->awardgenre=$awardgenre;
		$this->awardstatus=$awardstatus;
	}
	
	public function setAwardName($awardname)
	{
		$this->awardname=$awardname;
	}
	
	public function getAwardName()
	{
		return $this->awardname;
	}
	
	public function setMovie($movie)
	{
		$this->movie=$movie;
	}
	
	public function getMovie()
	{
		return $this->movie;
	}
	
	public function setAwardGenre($awardgenre)
	{
		$this->awardgenre=$awardgenre;
	}
	
	public function getAwardGenre()
	{
		return $this->awardgenre;
	}
	
	public function setAwardStatus($awardstatus)
	{
		$this->awardstatus=$awardstatus;
	}
	
	public function getAwardStatus()
	{
		return $this->awardstatus;
	}
}

class MovieRole
{
	private $actorname;
	private $moviename;
	private $amountreceivedactor;
	private $movierole;
	
	function __construct($actorname, $moviename, $amountreceivedactor, $movierole)
	{
		$this->actorname=$actorname;
		$this->moviename=$moviename;
		$this->amountreceivedactor=$amountreceivedactor;
		$this->movierole=$movierole;
	}
	
	public function getActorName()
	{
		return $this->actorname;
	}
	
	public function setActorName($actorname)
	{
		$this->actorname=$actorname;
	}
	
	public function getMovieName()
	{
		return $this->moviename;
	}
	
	public function setMovieName($moviename)
	{
		$this->moviename=$moviename;
	}
	
	public function getAmountReceived()
	{
		return $this->amountreceivedactor;
	}
	
	public function setAmountReceived($amountreceivedactor)
	{
		$this->amountreceivedactor=$amountreceivedactor;
	}
	
	public function getMovieRole()
	{
		return $this->movierole;
	}
	
	public function setMovieRole($movierole)
	{
		$this->movierole=$movierole;
	}
}

class staffPosition
{
	private $staffname;
	private $moviename;
	private $amountreceivedstaff;
	private $staffposition;
	
	function __construct($staffname, $moviename, $amountreceivedstaff, $staffposition)
	{
		$this->staffname=$staffname;
		$this->moviename=$moviename;
		$this->amountreceivedstaff=$amountreceivedstaff;
		$this->staffposition=$staffposition;
	}
	
	public function getStaffName()
	{
		return $this->staffname;
	}
	
	public function setStaffName($staffname)
	{
		$this->staffname=$staffname;
	}
	
	public function getMovieName()
	{
		return $this->moviename;
	}
	
	public function setMovieName($moviename)
	{
		$this->moviename=$moviename;
	}
	
	public function getAmountReceived()
	{
		return $this->amountreceivedstaff;
	}
	
	public function setAmountReceived($amountreceivedstaff)
	{
		$this->amountreceivedstaff=$amountreceivedstaff;
	}
	
	public function getStaffPosition()
	{
		return $this->staffposition;
	}
	
	public function setStaffPosition($staffposition)
	{
		$this->staffposition=$staffposition;
	}
}

class AwardingDate
{
	private $actorname;
	private $awardname;
	private $datereceived;
	
	function __construct($actorname, $awardname, $datereceived)
	{
		$this->actorname=$actorname;
		$this->awardname=$awardname;
		$this->datereceived=$datereceived;
	}
	
	public function getActorName()
	{
		return $this->actorname;
	}
	
	public function setActorName($actorname)
	{
		$this->actorname=$actorname;
	}
	
	public function setAwardName($awardname)
	{
		$this->awardname=$awardname;
	}
	
	public function getAwardName()
	{
		return $this->awardname;
	}
	
	public function setDateReceived($datereceived)
	{
		$this->datereceived=$datereceived;
	}
	
	public function getDateReceived()
	{
		return $this->datereceived;
	}
}
?>