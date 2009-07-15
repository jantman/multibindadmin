//
// inc/scheduleDHTML.js
//
// JavaScript Functions for DHTML/Ajax functionality
//
// Time-stamp: "2009-03-11 12:07:46 jantman"
// +----------------------------------------------------------------------+
// | PHP EMS Tools      http://www.php-ems-tools.com                      |
// +----------------------------------------------------------------------+
// | Copyright (c) 2006, 2007 Jason Antman.                               |
// |                                                                      |
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License as published by |
// | the Free Software Foundation; either version 3 of the License, or    |
// | (at your option) any later version.                                  |
// |                                                                      |
// | This program is distributed in the hope that it will be useful,      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the        |
// | GNU General Public License for more details.                         |
// |                                                                      |
// | You should have received a copy of the GNU General Public License    |
// | along with this program; if not, write to:                           |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+
// |Please use the above URL for bug reports and feature/support requests.|
// +----------------------------------------------------------------------+
// | Authors: Jason Antman <jason@jasonantman.com>                        |
// +----------------------------------------------------------------------+
// | $LastChangedRevision::                                             $ |
// | $HeadURL::                                                         $ |
// +----------------------------------------------------------------------+


var http = createRequestObject(); 

function createRequestObject()
{
	var request_o;
	var browser = navigator.appName;
	if(browser == "Microsoft Internet Explorer")
	{
		request_o = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else
	{
		request_o = new XMLHttpRequest();
	}
	return request_o;
}

//
// SCHEDULE-SPECIFIC FUNCTIONS
//

function showSignonForm($ts, $shift)
{
  // shows the form to add a new signon

  // DEBUG
  var ffxVer = getFirefoxVersion();
  if(ffxVer > 0 && ffxVer < 3)
  {
    alert("These functions will throw an unhandled JS exception in Firefox " + ffxVer);
  }
  // END DEBUG

  var myDate = new Date($ts*1000);
  document.getElementById("popuptitle").innerHTML = "Sign On - " + myDate.toLocaleFormat("%a, %b %e %Y") + " " + $shift;
  
  newSignonFormRequest($ts);
}

function showMessageForm($ts, $id)
{
  // shows the form to edit a daily message

  var myDate = new Date($ts*1000);
  document.getElementById("popuptitle").innerHTML = "Edit Daily Message - " + myDate.toLocaleFormat("%a, %b %e %Y");
  messageFormRequest($ts, $id);
}

function showEditForm($id, $ts)
{
  // shows the form to edit or remove a signon

  var myDate = new Date($ts*1000);
  document.getElementById("popuptitle").innerHTML = "Edit Sign On - " + myDate.toLocaleFormat("%a, %b %e %Y");
  
  editSignonFormRequest($id, $ts);
}


//
// HTTPrequest senders and handlers
//

// TODO: are ts AND monthTS needed here? where is monthTS needed?
// TODO: only pass the minimum variables needed
// TODO: in PHP, have a central tsToYearMonthDateShift() that returns a string
// TODO: move all of these forms to inc/ named like form{type}.php

function newSignonFormRequest($ts)
{
  doHTTPrequest(('signOn.php?ts=' + $ts), handleNewSignonFormRequest);
	// TODO: add an error var to reload the form if we have errors
}

function handleNewSignonFormRequest()
{
  if(http.readyState == 4)
  {
    var response = http.responseText;
    document.getElementById('popupbody').innerHTML = response;
    showPopup();
  }
}

function editSignonFormRequest($id, $ts)
{
  doHTTPrequest(('signOn.php?action=edit&id=' + $id + "&ts=" + $ts), handleEditSignonFormRequest);
  // TODO: add an error var to reload the form if we have errors
}

function handleEditSignonFormRequest()
{
  if(http.readyState == 4)
  {
    var response = http.responseText;
    document.getElementById('popupbody').innerHTML = response;
    showPopup();
  }
}

function messageFormRequest($ts, $id)
{
  // request the HTML for the message form
  doHTTPrequest(('dailyMessage.php?ts=' + $ts+'&id='+$id), handleMessageFormRequest);
  // TODO: add an error var to reload the form if we have errors
}

function handleMessageFormRequest()
{
  if(http.readyState == 4)
  {
    var response = http.responseText;
    document.getElementById('popupbody').innerHTML = response;
    showPopup();
  }
}

//
// HTTPrequest stuff
//

function doHTTPrequest($url, $handler)
{
  // TODO - get this working with older Firefox, using abort()
  http.open('get', $url);
  http.onreadystatechange = $handler;
  http.send(null);
}

//
// POPUP STUFF
//

function showPopup()
{
        grayOut(true);
        document.getElementById("popup").style.display = 'block';
}

function hidePopup()
{
        grayOut(false);
        document.getElementById("popup").style.display = 'none';
}

// UTIITY FUNCTIONS

// DEVELOPMENT ONLY???
function getFirefoxVersion()
{
  var userAgentStr = navigator.userAgent;
  // returns the version number for firefox (as an integer)
  var startIndex = userAgentStr.indexOf("Firefox/");
  if(startIndex < 0)
  {
    // not Firefox
    return 0;    
  }
  
  var version = userAgentStr.substring(startIndex); // start from / next
  version = userAgentStr.substring(userAgentStr.lastIndexOf("/")+1);
  version = parseFloat(version);
  
  return version;
  
}

//
// FORM SUBMISSION
//

function submitForm()
{
  // radio buttons
  var action = "";
  var postData = "";
  if(document.signon_form.action[2].checked == true)
  {
    action = "remove";
    postData = "id="+document.getElementById("id").value+"&";
  }
  else if(document.signon_form.action[1].checked == true)
  {
    action = "edit";
    postData = "id="+document.getElementById("id").value+"&";
  }
  else
  {
    action = "signOn";
  }

  postData = postData+"ts="+document.getElementById("ts").value+"&action="+action+"&EMTid="+document.getElementById("EMTid").value+"&start="+document.getElementById("start").value+"&end="+document.getElementById("end").value+"&adminID="+document.getElementById("adminID").value+"&adminPW="+document.getElementById("adminPW").value;

  var url = "handlers/signOn.php";
  http.open("POST", url, true);
  
  //Send the proper header information along with the request
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.setRequestHeader("Content-length", postData.length);
  http.setRequestHeader("Connection", "close");  
  http.onreadystatechange = handleSubmitURL; 
  http.send(postData);
}

function handleSubmitURL()
{
	if(http.readyState == 4)
	{
		var response = http.responseText;
		if(response.substr(0, 6) == "ERROR:")
		{
			// TODO: handle error condition by triggering a popup or changing content of existing one
			var errorMessage = response.substr(6, (response.length - 6));
			hidePopup();
			document.getElementById("popuptitle").innerHTML = "ERROR: ";
			document.getElementById("popupbody").innerHTML = errorMessage;
			showPopup();
		}
		else
		{
			var ts = document.getElementById('ts').value;
			reloadDay('inc/getDay.php?ts=' + ts);
		}
	}
}

function reloadDay(url)
{
	http.open('get', url);
	http.onreadystatechange = handleReloadDay; 
	http.send(null);
}

function handleReloadDay()
{
	if(http.readyState == 4)
	{
		var response = http.responseText;
		var ts = document.getElementById('ts').value;
		var elemID = 'day_' + ts;
		document.getElementById(elemID).innerHTML = response;
		hidePopup();
	}
}

function submitMessageForm()
{
  // radio buttons
  var postData = "";
  if(document.message_form.action[1].checked == true)
  {
    var action = "remove";
  }
  else
  {
    var action = "edit";
  }
  
  postData = "ts="+document.getElementById("ts").value+"&action="+action+"&adminID="+document.getElementById("adminID").value+"&adminPW="+document.getElementById("adminPW").value+"&message_text="+document.getElementById("message_text").value;
  if(document.message_form.showAllShifts.checked == true)
  {
    postData = postData+"&showAllShifts=1";
  }

  if(document.getElementById("id").value != null)
  {
    postData = postData + "&id=" + document.getElementById("id").value;
  }
  
  var url = "handlers/messageForm.php";
  http.open("POST", url, true);
  
  //Send the proper header information along with the request
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.setRequestHeader("Content-length", postData.length);
  http.setRequestHeader("Connection", "close");  
  http.onreadystatechange = handleSubmitMessageURL; 
  http.send(postData);
}

function handleSubmitMessageURL()
{
	if(http.readyState == 4)
	{
		var response = http.responseText;
		if(response.substr(0, 6) == "ERROR:")
		{
			// TODO: handle error condition by triggering a popup or changing content of existing one
			var errorMessage = response.substr(6, (response.length - 6));
			hidePopup();
			document.getElementById("popuptitle").innerHTML = "ERROR: ";
			document.getElementById("popupbody").innerHTML = errorMessage;
			showPopup();
		}
		else
		{
			var ts = document.getElementById('ts').value;
			reloadDate('inc/getDayHeader.php?ts=' + ts);
		}
	}
}

function reloadDate(url)
{
	http.open('get', url);
	http.onreadystatechange = handleReloadDate; 
	http.send(null);
}

function handleReloadDate()
{
	if(http.readyState == 4)
	{
		var response = http.responseText;
		var ts = document.getElementById('ts').value;
		var elemID = 'message_' + ts;
		document.getElementById(elemID).innerHTML = response;
		hidePopup();
	}
}

