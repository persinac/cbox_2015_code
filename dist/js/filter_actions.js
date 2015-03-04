
function loadWhoFilterBasedOnVSOption(data) {
	var html = '<h3>Filter</h3>';
	
	if(data == 'YRBX') {
		html += '<input type="checkbox" name="everyone" value="EVRY"> Everyone <br>';
		html += '<hr>';
		html += '<h4>Gender</h4>';
		html += '<input type="radio" name="sex" value="all">All<br>';
		html += '<input type="radio" name="sex" value="male">Male<br>';
		html += '<input type="radio" name="sex" value="female">Female';
		html += '<hr>';
		html += '<h4>Only Athletes that have completed: </h4>';
		html += '<input type="checkbox" name="all_wod_level" value="all"> All <br>';
		html += '<input type="checkbox" name="rx_wod_level" value="rx">RX WoDs<br>';
		html += '<input type="checkbox" name="inter_wod_level" value="inter">Intermediate WoDs<br>';
		html += '<input type="checkbox" name="nov_wod_level" value="nov">Novice WoDs<br>';
		html += '<hr>';
		html += '<h4>Only Athletes that ___ experience: </h4>';
		html += '<input type="checkbox" name="all_wod_level" value="all"> All <br>';
		html += '<input type="checkbox" name="zero_exp" value="zero">0-3 months<br>';
		html += '<input type="checkbox" name="three_exp" value="inter">3-6 months<br>';
		html += '<input type="checkbox" name="six_exp" value="nov">6-12 months<br>';
		html += '<input type="checkbox" name="one_plus_exp" value="nov">1+ years<br>';
	} else if(data == 'ANBX') {
		html += '';
	}
	return html;
}

function loadWhatFilterBasedOnVSOption(data) {
	var html = '';
	
	if(data == 'CORE') {
		html += '<h3>Core Movements</h3>';
		html += '<input type="radio" name="movements" value="bs">Back Squat<br>';
		html += '<input type="radio" name="movements" value="fs">Front Squat<br>';
		html += '<input type="radio" name="movements" value="ohs">Overhead squat<br>';
		html += '<input type="radio" name="movements" value="dl">Deadlift<br>';
		html += '<input type="radio" name="movements" value="sdlhp">Sumo Deadlift High Pull<br>';
		html += '<input type="radio" name="movements" value="pc">Power Clean<br>';
		html += '<input type="radio" name="movements" value="ohp">Overhead Press<br>';
		html += '<input type="radio" name="movements" value="pp">Push Press<br>';
		html += '<input type="radio" name="movements" value="pj">Push Jerk<br>';
	} else if(data == 'OLY') {
		html += '<h3>Olympic Lifts</h3>';
		html += '<input type="radio" name="movements" value="snatch">Snatch<br>';
		html += '<input type="radio" name="movements" value="caj">Clean and Jerk<br>';
	}
	return html;
}