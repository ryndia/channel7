$(document).ready(function(){
	n =  new Date();
	y = n.getFullYear();
	m = n.getMonth() + 1;
	d = n.getDate();
	days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
	months = [
	    'January',
	    'February',
	    'March',
	    'April',
	    'May',
	    'June',
	    'July',
	    'August',
	    'September',
	    'October',
	    'November',
	    'December'
	]
	var dayName = days[n.getDay()];
	document.getElementById("date").innerHTML = dayName + " " + months[m-1] + " " + d + " " + y;
});