 $(document).ready(function()
{

	$("#center").hide();
	$("#center").fadeIn("slow");
	
	$("#top").delay(1000).animate({
		left:'-20%'
		}, 1000, function() {
	});	
	
	$("#top").delay(3000).animate({
		left:'-40%'
		}, 1000, function() {
	});	
	
	$("#top").delay(5000).animate({
		left:'-60%'
		}, 1000, function() {
	});	
	
		$("#top").delay(7000).animate({
		left:'-80%'
		}, 1000, function() {
	});	
	
		$("#top").delay(9000).animate({
		left:'-100%'
		}, 1000, function() {
	});	
	
	
	$("#bottom").delay(1500).animate({
		left:'-80%'
		}, 1000, function() {
	});	
	
	$("#bottom").delay(3500).animate({
		left:'-60%'
		}, 1000, function() {
	});	
	
	$("#bottom").delay(5500).animate({
		left:'-40%'
		}, 1000, function() {
	});	
	
		$("#bottom").delay(7500).animate({
		left:'-20%'
		}, 1000, function() {
	});	
	
		$("#bottom").delay(9500).animate({
		left:'0%'
		}, 1000, function() {
	});	
			
});