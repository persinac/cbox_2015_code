<?php require_once('Connections/cboxConn.php'); ?>
<?php
session_start();
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
####Set for debugging purposes
#	$_SESSION['MM_Username'] = "kellintc";
####
if(!(isset($_SESSION['MM_Username'])))
{
	header("Location: Error401UnauthorizedAccess.php");
}
mysql_select_db($database_cboxConn, $cboxConn);
$colname_getUserBox = "-1";
$userBoxID = "";

####Set for debugging purposes
#	$_SESSION['MM_UserID'] = "2";
####
if (isset($_SESSION['MM_UserID'])) {
  $colname_getUserBox = $_SESSION['MM_UserID'];
  
  $LoginRS__query="select box.box_id from box JOIN athletes AS a ON box.box_id=a.box_id where user_id='{$colname_getUserBox}'"; 
   
  $LoginRS = mysql_query($LoginRS__query, $cboxConn) or die(mysql_error());
  $loginFoundBox = mysql_num_rows($LoginRS);
  if ($loginFoundBox) {
    $row = mysql_fetch_row($LoginRS);
	if (PHP_VERSION >= 5.1) {
		session_regenerate_id(true);
	} 
	else {
			session_regenerate_id();
	}
    //declare boxID session variable and assign them
    $_SESSION['MM_BoxID'] = $row[0];   

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Administrator</title>

<!-- Bootstrap core CSS -->
     <!--<link href="dist/css/jquery.datepick.css" rel="stylesheet">-->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <!--<link href="dist/css/admin_page.css" rel="stylesheet">
    -->
 	<link href="dist/css/bootstrap-combined.min.css" rel="stylesheet">
    <link href="dist/css/admin_page.css" rel="stylesheet">
    <link href="dist/css/jquery.datepick.css" rel="stylesheet">
<!--

-->
</head>

<body>

<div id="div_container">

    <hr class="featurette-divider">
    <h1>Past WODs</h1>
    <div id="past_wods">
        <table id="tbl_past_wod" rules="cols">
        	<tbody class="tbl_body_past_wods">
			</tbody>
        </table>
    </div><!-- END OF past_wods -->
    
    <hr class="featurette-divider">
    <h1>Past Strength</h1>
    <div id="past_strength">
    	<table id="tbl_past_str" rules="cols">
        	<tbody class="tbl_body_past_str">
			</tbody>
        </table>
    </div><!-- END OF past_strength -->
    
    <hr class="featurette-divider">
    <h1>Past Post WODs</h1>
    <div id="past_post_wods">
    	<table id="tbl_past_pwod" rules="cols">
        	<tbody class="tbl_body_past_pwod">
			</tbody>
        </table>
    </div><!-- END OF past_post_wods -->
    
    <hr class="featurette-divider">
    <h1>New WOD</h1>
    <div id="new_wod_container">
    <form method="POST" id="new_wod_form" class="new_wod">
    <p id="date_type_p">
    	Date: <input type="text" name="date" class="datepicker" id="datepicker"/> 
        Type of WOD: <select id="wod_type_selector" name="wod_type_selector">
          <option value="RFT">RFT</option>
          <option value="AMRAP">AMRAP</option>
          <option value="TABATA">TABATA</option>
          <option value="GIRLS">GIRLS</option>
          <option value="HERO">HEROES</option>
		</select>
        <div id="specific_to_wod"></div>
        <div>
        <p>
        Buy In: <input type="text" name="buy_in" class="extra_wod_stuff" id="buy_in" placeholder="optional"/>
        Cash Out: <input type="text" name="cash_out" class="extra_wod_stuff" id="cash_out" placeholder="optional"/>
        Penalty: <input type="text" name="penalty" class="extra_wod_stuff" id="penalty" placeholder="Everytime you drop the bar..."/>
        Special: <input type="text" name="special" class="extra_wod_stuff" id="special" placeholder="Every minute on the minute..."/>
        </p>
        </div>
	</p>
        <div id="new_wod_row">
            Movement: <input type="text" name="movement[]" class="movement" id="movement_0"/> 
            Weight (leave blank if bodyweight): <input type="text" name="weight[]" class="weight" id="weight_0" placeholder="Guys/Girls"/> 
            Reps: <input type="text" name="reps[]" class="reps" id="reps_0"/>
            <p></p>
        </div> <!-- END OF new_wod -->
        <input onclick="addRow(this.form);" type="button" value="Add row" />
        <input onclick="submitWOD(this.form);" type="button" value="Submit WOD" />
     </form>
     </div> <!-- END OF new_wod_container -->
    
   
	<div id="example_modal" class="modal" style="display:none; ">
        <div class="modal-header">
          <a class="close" data-dismiss="modal">×</a>
          <h3>Scale for Intermediate and Novice</h3>
        </div>
        <div class="modal-body">
        	<!-- Grab number of rows and place that many into here -->  
            <form method="POST" id="inter_new_wod_form" class="new_wod">
                <div id="inter_new_wod_row">
                <h4>Intermediate</h4>
                    Movement: <input type="text" name="inter_movement[]" class="inter_movement" id="inter_movement_0"/> 
                    Weight (leave blank if bodyweight): <input type="text" name="inter_weight[]" class="inter_weight" id="inter_weight_0" placeholder="Guys/Girls"/> 
                    Reps: <input type="text" name="inter_reps[]" class="inter_reps" id="inter_reps_0"/>
                    <p></p>
                    
                </div> <!-- END OF new_wod -->
             </form> 
             <hr class="featurette-divider"> 
             <form method="POST" id="nov_new_wod_form" class="new_wod">
                <div id="novice_new_wod_row">
                <h4>Novice</h4>
                    Movement: <input type="text" name="nov_movement[]" class="nov_movement" id="nov_movement_0"/> 
                    Weight (leave blank if bodyweight): <input type="text" name="nov_weight[]" class="nov_weight" id="nov_weight_0" placeholder="Guys/Girls"/> 
                    Reps: <input type="text" name="nov_reps[]" class="nov_reps" id="nov_reps_0"/>
                    <p></p>
                    
                </div> <!-- END OF new_wod -->
             </form>          
        </div>
        <div class="modal-footer">
          <button class="btn btn-success" id="load">Load RX Data</button>
          <button class="btn btn-success" id="submit">submit</button>
          <a href="#" class="btn" data-dismiss="modal">Close</a>
        </div>
    </div>
<p><a data-toggle="modal" href="#example_modal" class="btn btn-primary btn-small">Set Scaled Movements</a></p>
   
    
    <hr class="featurette-divider">
    <div id="new_strength">
    	<p>NEW STRENGTH FORM HERE</p>
    </div><!-- END OF past_post_wods -->
    
    <hr class="featurette-divider">
    <div id="new_post_wod">
    	<p>NEW POST WOD FORM HERE</p>
    </div><!-- END OF past_post_wods -->

</div> <!-- END OF DIV_CONTAINER -->

<!-- JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="dist/js/jquery.plugin.min.js"></script>
<script src="dist/js/jquery.datepick.min.js"></script>
<script src="dist/js/bootstrap.min.js"></script>

<!--

<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
-->
<script id="source" language="javascript" type="text/javascript">

var movementArray = new Array();
var weightArray = new Array();
var repArray = new Array();

var data_one;
var data_two;
var data_three;

var rowNum = 0;

var previousVal = "";
var currentVal = "";

/*
* Once the document is  loaded, grab the WoD information
*
*/
$(document).ready(function() {
	//event.preventDefault();
	getPastWODS(<?php echo $_SESSION['MM_BoxID'] ?>);
	getPastStrength(<?php echo $_SESSION['MM_BoxID'] ?>);
	getPastPostWODS(<?php echo $_SESSION['MM_BoxID'] ?>);
});

/*
* Set up the datepicker object
*
*/
$(function() {
	//event.preventDefault();
    $("#datepicker").datepick({dateFormat: 'yyyy-mm-dd', alignment: 'bottom', changeMonth: false, autoSize: true});
	
  });
  
/*
* Catches when the user presses submit on the 
* scaled modal (known as the example_modal - needs to be renamed)
*
* Serializes the forms into separate arrays, and then
* concatenate to be processed later
*/
$(function() {
	//twitter bootstrap script
	$("button#submit").click(function(){
		
		//need to error check these values
		data_one = $('#inter_new_wod_form').serializeArray();
		data_two = $('#nov_new_wod_form').serializeArray();
		data_three = data_one.concat(data_two);
		
		$.each(data_three, function(i, field) {
		//alert("DATA: " +field.name + ":" + field.value + " ");
		});
	});
});

/*
* Catches typos in the forms
* 
* Movement inputs: only alphabetical characters
* Weight inputs: only numerical
* Rep inputs: only numerical
*
* Should eventually prevent user from submitting
*/
$( this ).focusout(function (event) {
	var id = event.target.id;
	var value = "";
	var mvmReg = /^[a-zA-Z\s]*$/;
	var weightReg = /^[0-9\/]*$/;
	var repsReg = /^[0-9]*$/;
	/* RX Form */
	if ( id.indexOf("movement_") >= 0 )
	{
		value = $("#" + id).val();
		if(id == "movement_0") {
			currentVal = value
		}
		if(!mvmReg.test(value))
		{
			$("#"+id).addClass("big_input_wod_error");
		} else {
			$("#"+id).removeClass("big_input_wod_error");
		}
    } else if( id.indexOf("weight_") >= 0 ) {
		value = $("#" + id).val();
		if(!weightReg.test(value))
		{
			$("#"+id).addClass("big_input_wod_error");
		} else {
			$("#"+id).removeClass("big_input_wod_error");
		}
	} else if( id.indexOf("reps_") >= 0 ) {
		value = $("#" + id).val();
		//alert("ID: "+id+", value: "+ value);
		if(!repsReg.test(value))
		{
			$("#"+id).addClass("big_input_wod_error");
		} else {
			$("#"+id).removeClass("big_input_wod_error");
		}
	}
	
	/* Intermediate Form */
	if ( id.indexOf("inter_movement_") >= 0 )
	{
		value = $("#" + id).val();
		if(!mvmReg.test(value))
		{
			$("#"+id).addClass("big_input_wod_error");
		} else {
			$("#"+id).removeClass("big_input_wod_error");
		}
    } else if( id.indexOf("inter_weight_") >= 0 ) {
		value = $("#" + id).val();
		if(!weightReg.test(value))
		{
			$("#"+id).addClass("big_input_wod_error");
		} else {
			$("#"+id).removeClass("big_input_wod_error");
		}
	} else if( id.indexOf("inter_reps_") >= 0 ) {
		value = $("#" + id).val();
		//alert("ID: "+id+", value: "+ value);
		if(!repsReg.test(value))
		{
			$("#"+id).addClass("big_input_wod_error");
		} else {
			$("#"+id).removeClass("big_input_wod_error");
		}
	}
	
	/* Novice Form */
	if ( id.indexOf("nov_movement_") >= 0 )
	{
		value = $("#" + id).val();
		if(!mvmReg.test(value))
		{
			$("#"+id).addClass("big_input_wod_error");
		} else {
			$("#"+id).removeClass("big_input_wod_error");
		}
    } else if( id.indexOf("nov_weight_") >= 0 ) {
		value = $("#" + id).val();
		if(!weightReg.test(value))
		{
			$("#"+id).addClass("big_input_wod_error");
		} else {
			$("#"+id).removeClass("big_input_wod_error");
		}
	} else if( id.indexOf("nov_reps_") >= 0 ) {
		value = $("#" + id).val();
		//alert("ID: "+id+", value: "+ value);
		if(!repsReg.test(value))
		{
			$("#"+id).addClass("big_input_wod_error");
		} else {
			$("#"+id).removeClass("big_input_wod_error");
		}
	}
	
});

/*
* Load RX button clicked in example_modal
*
* Call the function addScaledRows
*/
$(function() {
	$("button#load").click(function() {
    	//alert("CLICKEDDDDD!!!!!");
		//add rows equal to RX
		addScaledRows();
		//load the data from RX into fresh rows
		loadRxIntoScale();
    });
});

/*
* WoD type Dropdown changes values
*
* Change the specifics of each type of wod 
* according to the dropdown selection
*
* Need to update: 
*	Finish girls
*	Add heroes
*   change girls' values
*/
$( "#wod_type_selector" ).change(function() {
    var str = "";
    $( "#wod_type_selector option:selected" ).each(function() 
	{
		$('#specific_to_wod').empty();
		if($( this ).text() == "RFT"){
		str = "Rounds: <input type=\"text\" name=\"num_of_rounds\" class=\"num_of_rounds\" id=\"num_of_rounds\"/>";
		} else if($( this ).text() == "AMRAP") {
			str = "Time: <input type=\"text\" name=\"num_of_rounds\" class=\"num_of_rounds\" id=\"num_of_rounds\"/>";
			} else if($( this ).text() == "TABATA") {
				str = "Number of Intervals: <input type=\"text\" name=\"num_of_rounds\" class=\"num_of_rounds\" id=\"num_of_rounds\"/>";
			} else if($( this ).text() == "GIRLS") {
				str = "Girls: <select id=\"girl_selector\" name=\"girl_selector\">";
				str +="<option value=\"Angie\">Angie</option>";
				str += "<option value=\"Angie\">Barbara</option>";
				str +="<option value=\"Angie\">Chelsea</option>";
				str +="<option value=\"Angie\">Cindy</option>";
				str +="<option value=\"Angie\">Diane</option>";
				str +="<option value=\"Angie\">Elizabeth</option>";
				str +="<option value=\"Angie\">Fran</option>";
				str +="<option value=\"Angie\">Grace</option>";
				str +="<option value=\"Angie\">Helen</option>";
				str +="<option value=\"Angie\">Isabel</option>";
				str +="<option value=\"Angie\">Jackie</option>";
				str +="<option value=\"Angie\">Karen</option>";
				str +="<option value=\"Angie\">Linda</option>";
				str +="<option value=\"Angie\">Mary</option>";
				str +="<option value=\"Angie\">Nancy</option>";
				str +="</select>";
		
			}else if($( this ).text() == "HEROES") {
				str = "";
			}
		//Update html content
		$('#specific_to_wod').append(str);
    });
  }).trigger( "change" );

  
/********************************* GETTER METHODS *********************************/

/*
* Called when page is finished loading
* Used to gather all the WoDs specific to Admin's
* box. 
*
*/
function getPastWODS(box_id)
{
	var boxID = box_id;

	var html = "";
	$('.tbl_past_wod').html(html);
	//now load data into table
	$.ajax(
	{ 
	  type:"POST",                                     
	  url:"getAdminWODs.php",         
	  data: { "dataString" : boxID }, //insert argumnets here to pass to getAdminWODs
	  dataType: "json",                //data format      
	  success: function(response_wods) //on recieve of reply
	  {
		  //alert("response_wods: " + response_wods);
		loadPastWODS(response_wods);
	  },
  	  error: function(){
    		alert('error loading wods!');
  		}
	});
	//alert("Past WODs FIN");
}

/*
* Called when page is finished loading
* Used to gather all the Strength specific to Admin's
* box. 
*
*/
function getPastStrength(box_id)
{
	var boxID = box_id;
	
	//$('.tbl_past_wod').empty();
	var html = "";
	

	//alert("HTML: " + html )
	$('.tbl_past_str').html(html);
	//now load data into table
	$.ajax(
	{ 
	  type:"POST",                                     
	  url:"getAdminStrength.php",         
	  data: { "dataString" : boxID }, //insert argumnets here to pass to getAdminWODs
	  dataType: "json",                //data format      
	  success: function(response) //on recieve of reply
	  {
		loadPastStr(response);
	  },
  	  error: function(){
    		alert('error loading strength!');
  		}
	});
	//alert("Past WODs FIN");
}

/*
* Called when page is finished loading
* Used to gather all the Post WoDs specific to Admin's
* box. 
*
*/
function getPastPostWODS(box_id)
{
	var boxID = box_id;
	
	//$('.tbl_past_wod').empty();
	var html = "";
	

	//alert("HTML: " + html )
	$('.tbl_past_pwod').html(html);
	//now load data into table
	$.ajax(
	{ 
	  type:"POST",                                     
	  url:"getAdminPWODs.php",         
	  data: { "dataString" : boxID }, //insert argumnets here to pass to getAdminWODs
	  dataType: "json",                //data format      
	  success: function(response_wods) //on recieve of reply
	  {
		  //alert("response_wods: " + response_wods);
		loadPastPWODS(response_wods);
	  },
  	  error: function(){
    		alert('error loading wods!');
  		}
	});
}

/******************************** LOAD TABLES **************************************/

/*
* Called in getPastWODS function.
* Parses the ajax request - JSON - format, and
* places the results in descending order in a table 
* in the appropriate DOM.
*
*/
function loadPastWODS(data_wods)
{
	var t_data = data_wods;
	
	var html_sec1 = "";
	var sec1_classID = "pastwod_sec1_data"; 
	var wod_id = "";
	var dow = "";
	var wodname;
	var type_of_wod = "";
	var descrip = "";
	//alert("loadPastWODS PRE-FOR LOOP");
	//alert("DATA: " + data_wods);
	//alert("t_DATA: " + t_data);
	for(var i = 0; i < data_wods.length; i++) {
		wod_id = data_wods[i].wod_id;
		dow = data_wods[i].date_of_wod;
		wodname = data_wods[i].name_of_wod;
		type_of_wod = data_wods[i].type_of_wod;
		descrip = data_wods[i].rx_descrip;
		
		html_sec1 += "<tr class="+sec1_classID+">";
		html_sec1 += "<td>"+wod_id+"</td>";
		html_sec1 += "<td>"+dow+"</td>";
		html_sec1 +="<td>"+wodname+"</td>";
		html_sec1 +="<td>"+type_of_wod+"</td>";
		html_sec1 +="<td class=\"pastwod_descrip\">"+descrip+"</td>";
		html_sec1 += "</tr>";
	}
	//Update html content
	//alert("HTML: " + html);
	$('.tbl_body_past_wods').empty();
	$('.tbl_body_past_wods').html(html_sec1);
	
}

/*
* Called in getPastStrength function.
* Parses the ajax request - JSON - format, and
* places the results in descending order in a table 
* in the appropriate DOM.
*
*/
function loadPastStr(data)
{
	var t_data = data;
	
	var html_sec1 = "";
	var sec1_classID = "str_sec1_data"; 
	var str_id = "";
	var dos = "";
	var movement = "";
	var descrip = "";

	for(var i = 0; i < data.length; i++) {
		str_id = data[i].str_id;
		dos = data[i].date_of_str;
		movement = data[i].movement;
		descrip = data[i].descrip;
		
		html_sec1 += "<tr class="+sec1_classID+">";
		html_sec1 += "<td>"+str_id+"</td>";
		html_sec1 += "<td>"+dos+"</td>";
		html_sec1 +="<td>"+movement+"</td>";
		html_sec1 +="<td class=\"paststr_descrip\">"+descrip+"</td>";
		html_sec1 += "</tr>";
	}
	//Update html content
	$('.tbl_body_past_str').empty();
	$('.tbl_body_past_str').html(html_sec1);
	
}

/*
* Called in getPastPostWODS function.
* Parses the ajax request - JSON - format, and
* places the results in descending order in a table 
* in the appropriate DOM.
*
*/
function loadPastPWODS(data)
{
	var t_data = data;
	
	var html_sec1 = "";
	var sec1_classID = "pwod_sec1_data"; 
	var pwod_id = "";
	var dop = "";
	var type_of_pwod = "";
	var descrip = "";

	for(var i = 0; i < data.length; i++) {
		pwod_id = data[i].pwod_id;
		dop = data[i].date_of_pwod;
		type_of_pwod = data[i].type_of_pwod;
		descrip = data[i].descrip;
		
		html_sec1 += "<tr class="+sec1_classID+">";
		html_sec1 += "<td>"+pwod_id+"</td>";
		html_sec1 += "<td>"+dop+"</td>";
		html_sec1 +="<td>"+type_of_pwod+"</td>";
		html_sec1 +="<td class=\"pastpwod_descrip\">"+descrip+"</td>";
		html_sec1 += "</tr>";
	}
	//Update html content
	$('.tbl_body_past_pwod').empty();
	$('.tbl_body_past_pwod').html(html_sec1);
}

/************************************** DYNAMIC CONTENT **********************************/

/*
* Called from the  new_wod_form in the input div
* Creates a new <p> which holds the new rows of input
* Increments rowNum by 1 each time the button is pressed,
* and uses rowNum to id the paragraph and input text fields
*
*/
function addRow(frm) {
	rowNum ++;
	var row = '<p id="rowNum'+rowNum+'">Movement: <input type="text" name="movement[]" class="movement" id="movement_'+rowNum+'"> Weight (leave blank if bodyweight): <input type="text" name="weight[]" class="weight" id="weight_'+rowNum+'"> Reps: <input type="text" name="reps[]" class="reps" id="reps_'+rowNum+'"> <input type="button" value="Remove" onclick="removeRow('+rowNum+');"></p>';
	$('#new_wod_row').append(row);
	frm.add_qty.value = '';
	frm.add_name.value = '';
}

/*
* Called from the  new_wod_form in the input div
* Removes a <p> which holds the rows of input. 
* Decrements rowNum by 1 each time the button is pressed
* 
* Cannot remove the first line of inputs
*
*/
function removeRow(rnum) {
	$('#rowNum'+rnum).remove();
	$('#inter_rowNum'+rnum).remove();
	$('#nov_rowNum'+rnum).remove();
	
	//alert("Exercise to remove: " + movementArray[rnum] + " " +weightArray[rnum]+ " " +repArray[rnum]);

	if(rowNum > 0) {
		//pop the top value from each array
		//movementArray.pop();
		//weightArray.pop();
		//repArray.pop();
		rowNum = rowNum -1;	
		for(var i = movementArray.length-1; i >= 0; i--)
		{
			alert("Pre remove: " + movementArray[i] + " " +weightArray[i]+ " " +repArray[i])
		}
		alert("To remove: " + movementArray.splice(rowNum+1, 1) +" "+ weightArray.splice(rowNum+1, 1) +" "+ repArray.splice(rowNum+1, 1));
		movementArray.splice(rowNum+1, 1);
		weightArray.splice(rowNum+1, 1);
		repArray.splice(rowNum+1, 1);
		for(var i = movementArray.length-1; i >= 0; i--)
		{
			alert("Post remove: " + movementArray[i] + " " +weightArray[i]+ " " +repArray[i])
		}
	}
}

/*
* Called from the  example_modal when user presses Load RX Data.
* Creates a new <p> which holds the new rows of input, uses for 
* loop to populate the forms based on RX data. Loads RX movements
* and weight automatically in form for better user experience
* 
*/
function addScaledRows()
{
	var length = 0;
	/*
	* The following loops need to dynamically check for duplicate row entries
	* It would be ideal if this is done using the #movement_i value
	*
	* Maybe create a method to get the max id for each input value currently on
	* the modal and use that in the for loops? 
	*/
	
	$('.movement').each(function(i, item) {
        var movement =  $('#movement_'+(i)+'').val();
		var weight =  $('#weight_'+(i)+'').val();
		var reps =  $('#reps_'+(i)+'').val();
		currentVal = movement;
		if($.inArray(currentVal, movementArray) < 0) {
			alert("NOT IN Movement: "+movement+", weight: "+weight + ", reps: " + reps);
			movementArray.push(movement);
			weightArray.push(weight);
			repArray.push(reps);
			//length = i;
		}
		
		length = i;
    });
	
	$('.weight').each(function(i, item) {
        var weight =  $('#weight_'+(i)+'').val();
		
		if($.inArray(currentVal, movementArray) < 0) {
			//weightArray.push(weight);
		}
		//alert("weight: "+weight);
    });
	
	//alert("Post weight check");
	
	$('.reps').each(function(i, item) {
        var reps =  $('#reps_'+(i)+'').val();
		
		if($.inArray(currentVal, movementArray) < 0) {
			//repArray.push(reps);
		}
		//alert("reps: "+reps);
    });
	
	$('#inter_movement_0').val(movementArray[0])
	$('#inter_weight_0').val(weightArray[0])
	$('#inter_reps_0').val(repArray[0])
	$('#nov_movement_0').val(movementArray[0])
	$('#nov_weight_0').val(weightArray[0])
	$('#nov_reps_0').val(repArray[0])
	
	var row = "";
	//first intermediate
	if(length > 0) {
		for(var i = length; i < movementArray.length; i++) 
		{	
		row = '<p id="inter_rowNum'+i+'">Movement: <input type="text" name="inter_movement[]" class="inter_movement" id="inter_movement_'+i+'" value="'+ movementArray[i] +'"> Weight (leave blank if bodyweight): <input type="text" name="inter_weight[]" class="inter_weight" id="inter_weight_'+i+'" value="'+weightArray[i]+'"> Reps: <input type="text" name="inter_reps[]" class="inter_reps" id="inter_reps_'+i+'" value="'+repArray[i]+'"></p>';
		$('#inter_new_wod_row').append(row);
		//alert("Movement["+i+"] = " + movementArray[i]);
		}
		
		for(var j = length; j < movementArray.length; j++) {
		row = '<p id="nov_rowNum'+j+'">Movement: <input type="text" name="nov_movement[]" class="nov_movement" id="nov_movement_'+j+'" value="'+ movementArray[j] +'"> Weight (leave blank if bodyweight): <input type="text" name="nov_weight[]" class="nov_weight" id="nov_weight_'+j+'" value="'+weightArray[j]+'"> Reps: <input type="text" name="nov_reps[]" class="nov_reps" id="nov_reps_'+j+'" value="'+repArray[j]+'"></p>';
		$('#novice_new_wod_row').append(row);
		}
	}
	length += movementArray.length;
}

/*
* Not used...
*/
function loadRxIntoScale()
{
	//alert("Load RX data into Scaled form");
}

/*********************************** FINAL SUBMIT *****************************************/

/*
* Called when the user submits the form on the main page.
* Serializes the RX form and the concatenates it with the 
* concatenated intermediate and novice arrays. Submit via
* ajax call. 
*
* Performs final input checking to ensure invalid characters
* are not present
*
* Returns a popup notification of whatever the MySQL result
* is.
*
*/
function submitWOD() {
	
	if($("#datepicker").val().length == 0){
		sendRequest = false;
	}
	
	var datastring = $("#new_wod_form").serializeArray();
	var sendRequest = true;

	//alert("DATASTRING: " + datastring.toString());
	//alert("data_three: " + data_three.toString());
	
	var data_four = datastring.concat(data_three);
	//alert("data_four: " + data_four.toString());
	//WORKING
	$('.movement').each(function(i, item) {
        var movement =  $('#movement_'+i+'').val();
		var characterReg = /^[a-zA-Z\s]*$/;
		if(!characterReg.test(movement)) {
			sendRequest = false;
			//alert("Invalid character at: Movement " + (i+1));
			$('#movement_'+i+'').addClass("big_input_wod_error");
		} else if (movement.length == 0) {
			$('#movement_'+i+'').addClass("big_input_wod_error");
			sendRequest = false;
		}
		//else { movementArray.push(movement); }
        //alert(movement);
    });
	
	//alert("Post Movement check");
	
	$('.weight').each(function(i, item) {
		//alert("Inside weight check");
        var weight =  $('#weight_'+i+'').val();
		//var characterReg = /^\d+$/;
		var characterReg = /^[0-9]*$/;
		if(!characterReg.test(weight)) {
			sendRequest = false;
			//alert("Invalid character at: Weight " + (i+1));
			$('#weight_'+i+'').addClass("big_input_wod_error ");
		}
		//else { weightArray.push(weight); }
        //alert(weight);
    });
	
	//alert("Post weight check");
	
	$('.reps').each(function(i, item) {
		//alert("Inside reps check");
        var reps =  $('#reps_'+i+'').val();
		var characterReg = /^[0-9]*$/;
		if(!characterReg.test(reps)) {
			sendRequest = false;
			//alert("Invalid character at: Reps " + (i+1));
			$('#reps_'+i+'').addClass("big_input_wod_error ");
		} else if (reps.length == 0) {
			$('#reps_'+i+'').addClass("big_input_wod_error");
			sendRequest = false;
		}
		//else { repArray.push(reps); }
        //alert(reps);
    });
	
	
	$.each(data_four, function(i, field){
    	//alert("DATA: " +field.name + ":" + field.value + " ");
  	});
	
	
	//sendRequest = false;
	if(sendRequest == true) {
        $.ajax({
            type: "POST",
            url: "php_form_test.php",
            data: data_four,
            success: function(data) {
                 alert('Data send:' + data);
            }
        });
	}
}



</script>

</body>
</html>