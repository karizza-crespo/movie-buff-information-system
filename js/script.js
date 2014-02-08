function validateAddMovie()
{
	var form=document.addMovie;
	var i=0;
	var ctr=0;
	var box;
	
	for(i=0; i<6; i++)
	{
		box=form.elements[i];
		if(!box.value)
		{
			alert('You haven\'t filled in the ' + box.name + '!');
			box.focus();
			return false;
		}
	}
	
	for (i = 6; i <28; i++)
	{
		box=form.elements[i];
		if(box.checked)
			ctr++;
	}
	if(ctr==0)
	{
		alert('Please select a genre!');
		return false;
	}
	return true;
}

function validateAddActor()
{
	var form=document.addActor;
	var box=form.elements[0];
	if(!box.value)
	{
		alert('You haven\'t filled in the ' + box.name + '!');
		box.focus();
		return false;
	}
	return true;
}

function validateAddStaff()
{
	var form=document.addStaff;
	var box;
	var i=0;
	
	for(i=0; i<2; i++)
	{
		box=form.elements[i];
		if(!box.value)
		{
			alert('You haven\'t filled in the ' + box.name + '!');
			box.focus();
			return false;
		}
	}
	return true;
}

function validateAddAward()
{
	var form=document.addAward;
	var box=form.elements[0];
	if(!box.value)
	{
		alert('You haven\'t filled in the ' + box.name + '!');
		box.focus();
		return false;
	}
	return true;
}

function validateAddAwardingDate()
{
	var form=document.addAwardingDate;
	var box=form.elements[2];
	if(!box.value)
	{
		alert('You haven\'t filled in the ' + box.name + '!');
		box.focus();
		return false;
	}
	return true;
}

function validateAddMovieRole()
{
	var form=document.addMovieRole;
	var box=form.elements[3];
	if(!box.value)
	{
		alert('You haven\'t filled in the ' + box.name + '!');
		box.focus();
		return false;
	}
	return true;
}

function validateAddStaffPosition()
{
	var form=document.submitStaffRole;
	var box=form.elements[3];
	if(!box.value)
	{
		alert('You haven\'t filled in the ' + box.name + '!');
		box.focus();
		return false;
	}
	return true;
}

function validateEdit()
{
	var form=document.updateDetails;
	var i=0;
	var ctr=0;
	var box;
	
	for(i=0; i<6; i++)
	{
		box=form.elements[i];
		if(!box.value)
		{
			alert('You haven\'t filled in the ' + box.name + '!');
			box.focus();
			return false;
		}
	}
	
	for (i = 6; i <28; i++)
	{
		box=form.elements[i];
		if(box.checked)
			ctr++;
	}
	if(ctr==0)
	{
		alert('Please select a genre!');
		return false;
	}
	return true;
}