
function generateHeroes(data) {
	var html = '';
	
	for(var i =0; i < data.length; i++) {
		html += '<h4><a href="http://www.crossfit.com/cf-info/faq.html#WOD1" target="_blank">'+data[i].name+'</a></h4>';
		html += ''+data[i].workout+'';
		html += '<br/><br/>Score: <input type="text" name="hro_'+i+'_input" class="_time" id="score_'+i+'_input"/> <input type="checkbox" class="chkBox" name="level_'+i+'" id="level_'+i+'" value="rx">RX\'d    ';
		html += '<br/>Date Achieved: <input type="text" name="date" class="_datepicker" id="hro_'+i+'_datepicker"/><br/><br/>';
	}
	return html;

}

/*
 * Returns name of Hero based on numeric ID passed
 *
 * @params:
 *	hero_id - numerical representation of Hero
 *  data - json feed from cf_heroes.json
 */
function nameOfHero(hero_id, data) {

	var value = "Unknown Movement"; 
	console.log(hero_id);
	if(hero_id > -1 && hero_id < data.length) {
		value = data[hero_id].name;
	} else {
		value = "Invalid ID";
	}
	return value; 
}

function loadJSON(path, success, error)
{
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                if (success)
                    success(JSON.parse(xhr.responseText));
            } else {
                if (error)
                    error(xhr);
            }
        }
    };
    xhr.open("GET", path, true);
    xhr.send();
}
