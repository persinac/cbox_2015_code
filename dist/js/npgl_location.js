
function checkLocation(x, y) {
	var value = "";
	
	if(isInReserveArea(x, y) == true) {
		value =  "res_area";
	} else if(isInActivesArea(x, y) == true) {
		value =  "act_area";
	} else if(isInStart(x, y) == true) {
		value =  "start";
	} else if(isInFinish(x, y) == true) {
		value =  "finish";
	} else if(isInWorkoutArea(x, y) == true) {
		value = whichWorkoutArea(x, y);
	} else if(isInSwitchArea(x, y) == true) {
		value = whichSwitchArea(x, y);
	}
	
	return value;
}

function isInReserveArea(x, y) {
	var retVal = false;
	
	if(x > 900 && x < 1325 && y > 50 && y < 135) {
		retVal = true;
	}
	
	return retVal;
}

function isInActivesArea(x, y) {
	var retVal = false;
	
	if(x > 25 && x < 900 && y > 50 && y < 135) {
		retVal = true;
	}
	
	return retVal;
}

function isInStart(x, y) {
	var retVal = false;
	
	if(x > 24 && x < 91 && y > 140 && y < 595) {
		retVal = true;
	}
	
	return retVal;
}

function isInFinish(x, y) {
	var retVal = false;
	
	if(x > 1329 && x < 1395 && y > 140 && y < 595) {
		retVal = true;
	}
	
	return retVal;
}

function isInWorkoutArea(x, y) {
	var retVal = false;
	
	if(x > 96 && x < 1325 && y > 140 && y < 525) {
		retVal = true;
	}
	
	return retVal;
}

function isInSwitchArea(x, y) {
	var retVal = false;
	
	if(x > 96 && x < 1325 && y > 530 && y < 595) {
		retVal = true;
	}
	
	return retVal;
}

function whichWorkoutArea(x, y) {
	var retVal = "";
	
	if(x > 96 && x < 400 && y > 140 && y < 525) {
		retVal = "wrk_area_1";
	} else if(x > 401 && x < 711 && y > 140 && y < 525) {
		retVal = "wrk_area_2";
	} else if(x > 712 && x < 1030& y > 140 && y < 525) {
		retVal = "wrk_area_3";
	} else if(x > 1031 && x < 1325& y > 140 && y < 525) {
		retVal = "wrk_area_4";
	}
	
	return retVal;
}

function whichSwitchArea(x, y) {
	var retVal = "";
	
	if(x > 96 && x < 400 && y > 525 && y < 595) {
		retVal = "swit_area_1";
	} else if(x > 401 && x < 711 && y > 525 && y < 595) {
		retVal = "swit_area_2";
	} else if(x > 712 && x < 1030& y > 525 && y < 595) {
		retVal = "swit_area_3";
	} else if(x > 1031 && x < 1325& y > 525 && y < 595) {
		retVal = "swit_area_4";
	}
	
	return retVal;
}
