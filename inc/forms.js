// forms.js
//
// +----------------------------------------------------------------------+
// | MultiBindAdmin      http://multibindadmin.jasonantman.com            |
// +----------------------------------------------------------------------+
// | Copyright (c) 2009 Jason Antman.                                     |
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

function viewChange()
{
  if(document.getElementById("views_both").checked)
    {
      document.getElementById("insideProviderDiv").style.display = 'block';
      document.getElementById("outsideProviderDiv").style.display = 'block';
    }
  else if(document.getElementById("views_in").checked)
    {
      document.getElementById("insideProviderDiv").style.display = 'block';
      document.getElementById("outsideProviderDiv").style.display = 'none';
    }
  else
    {
      document.getElementById("insideProviderDiv").style.display = 'none';
      document.getElementById("outsideProviderDiv").style.display = 'block';
    }
}

function updateRRform()
{
  var v = document.getElementById("rr_type").value;
  doHTTPrequest(('rrFormPart.php?type=' + v), handleUpdateRRform);
}

function handleUpdateRRform()
{
  if(http.readyState == 4)
  {
    var response = http.responseText;
    document.getElementById('rr_form_fields').innerHTML = response;
  }
}

function updateIPstuff()
{
  var cidr = parseInt(document.getElementById("netmask_cidr").value);
  document.getElementById("option_subnet_mask").value = getNetMask(cidr);
  var firstThree = document.getElementById("firstThree").value;
  var start_ip = parseInt(document.getElementById("start_ip").value);
  document.getElementById("end_ip").value = start_ip + (getNetworkSize(cidr) - 1);
  document.getElementById("pool_start").value = firstThree + "." + (start_ip + 3);
  document.getElementById("pool_end").value = firstThree + "." + ((start_ip + getNetworkSize(cidr)) - 2);
  document.getElementById("option_log_server").value = firstThree + "." + (start_ip);
  document.getElementById("option_time_server").value = firstThree + "." + (start_ip);
  document.getElementById("option_dns_server").value = firstThree + "." + (start_ip);
  document.getElementById("option_broadcast_address").value = firstThree + "." + (start_ip + (getNetworkSize(cidr) - 1));
  document.getElementById("option_routers").value = firstThree + "." + (start_ip+1);
}

//
// UTILITY FUNCTIONS
//

function getNetworkSize(CIDR)
{
  switch(CIDR)
  {
    case 0:
      return 4294967296;
    case 1:
      return 2147483648;
    case 2:
      return 1073741824;
    case 3:
      return 536870912;
    
    case 24:
      return 256;
    case 25:
      return 128;
    case 26:
      return 64;
    case 27:
      return 32;
    case 28:
      return 16;
    case 29:
      return 8;
    case 30:
      return 4;
    case 31:
      return 2;
    case 32:
      return 1;
  }
  return 0;
}

function getNetMask(CIDR)
{
  switch(CIDR)
  {
    case 0:
      return "0.0.0.0";
    case 1:
      return "128.0.0.0";
    case 2:
      return "192.0.0.0";
    case 3:
      return "224.0.0.0";
    
    case 24:
      return "255.255.255.0";
    case 25:
      return "255.255.255.128";
    case 26:
      return "255.255.255.192";
    case 27:
      return "255.255.255.224";
    case 28:
      return "255.255.255.240";
    case 29:
      return "255.255.255.248";
    case 30:
      return "255.255.255.252";
    case 31:
      return "255.255.255.254";
    case 32:
      return "255.255.255.255";
  }
  return "Unknown " + CIDR;
}

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

function doHTTPrequest($url, $handler)
{
  // TODO - get this working with older Firefox, using abort()
  http.open('get', $url);
  http.onreadystatechange = $handler;
  http.send(null);
}
