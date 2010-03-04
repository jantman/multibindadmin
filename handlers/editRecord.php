<?php
// handlers/addRecord.php
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
require_once('../config/config.php');
require_once('../inc/common.php');

/*
echo '<pre>';
echo var_dump($_POST);
echo '</pre>';
die();
*/

if(! isset($_POST['zone_id']) || ! isset($_POST['rr_type']))
{
    die("Zone ID and rr_type must be specified.");
}

$zone = $_POST['zone_id'];
$type = $_POST['rr_type'];

if($_POST['Submit'] == "DELETE RR")
{
    if($type == "MX")
    {
	$query = "DELETE FROM mx_records WHERE zone_id=".((int)$zone)." AND name='".mysql_real_escape_string($_POST['orig_name'])."' AND mx_name='".mysql_real_escape_string($_POST['orig_mxname'])."' AND pref=".((int)$_POST['orig_pref']).";";
	$result = mysql_query($query) or dberror($query, mysql_error());
    }
    elseif($type == "PTR")
    {

    }
    elseif($type == "SRV")
    {

    }
    else
    {
	$query = "DELETE FROM r_records WHERE zone_id=".((int)$zone)." AND rr_type='".$type."' AND name='".mysql_real_escape_string($_POST['orig_name'])."' AND value='".mysql_real_escape_string($_POST['orig_value'])."' AND view='".mysql_real_escape_string($_POST['orig_view'])."';";
	$result = mysql_query($query) or dberror($query, mysql_error());
    }
}
else
{
    if($type == "A")
    {
	$query = "DELETE FROM dhcp_hosts WHERE (rr_view='".mysql_real_escape_string($_POST['views'])."' AND rr_name='".mysql_real_escape_string($_POST['name'])."' AND rr_value='".mysql_real_escape_string($_POST['value'])."') OR mac_address='".mysql_real_escape_string($_POST['mac_addr'])."';";
	$result = mysql_query($query) or dberror($query, mysql_error());

	$query = "UPDATE r_records SET view='".mysql_real_escape_string($_POST['views'])."',name='".mysql_real_escape_string($_POST['name'])."',value='".mysql_real_escape_string($_POST['value'])."',ttl=".((int)$_POST['ttl'])." ";
	if(trim($_POST['value2']) != ""){ $query .= ",value2='".mysql_real_escape_string($_POST['value2'])."'";}
	$query .= " WHERE zone_id=".((int)$zone)." AND rr_type='A' AND name='".mysql_real_escape_string($_POST['orig_name'])."' AND value='".mysql_real_escape_string($_POST['orig_value'])."' AND view='".mysql_real_escape_string($_POST['orig_view'])."';";
	$result = mysql_query($query) or dberror($query, mysql_error());

	if(trim($_POST['mac_addr']) != "")
	{
	    $query = "INSERT INTO dhcp_hosts SET rr_view='".mysql_real_escape_string($_POST['views'])."',rr_name='".mysql_real_escape_string($_POST['name'])."',rr_value='".mysql_real_escape_string($_POST['value'])."',mac_address='".mysql_real_escape_string($_POST['mac_addr'])."';";
	    $result = mysql_query($query) or dberror($query, mysql_error());
	}

    }
    elseif($type == "CNAME")
    {
	$query = "UPDATE r_records SET view='".mysql_real_escape_string($_POST['views'])."',name='".mysql_real_escape_string($_POST['name'])."',value='".mysql_real_escape_string($_POST['value'])."',ttl=".((int)$_POST['ttl'])." WHERE zone_id=".((int)$zone)." AND rr_type='CNAME' AND name='".mysql_real_escape_string($_POST['orig_name'])."' AND value='".mysql_real_escape_string($_POST['orig_value'])."' AND view='".mysql_real_escape_string($_POST['orig_view'])."';";
	$result = mysql_query($query) or dberror($query, mysql_error());
    }
    elseif($type == "MX")
    {
	$query = "UPDATE mx_records SET view='".mysql_real_escape_string($_POST['views'])."',name='".mysql_real_escape_string($_POST['name'])."',mx_name='".mysql_real_escape_string($_POST['value'])."',ttl=".((int)$_POST['ttl']).",pref=".((int)$_POST['pref'])." WHERE zone_id=".((int)$zone)." AND name='".mysql_real_escape_string($_POST['orig_name'])."' AND mx_name='".mysql_real_escape_string($_POST['orig_mxname'])."' AND pref=".((int)$_POST['orig_pref']).";";
	$result = mysql_query($query) or dberror($query, mysql_error());
    }
    elseif($type == "NS")
    {
	$query = "UPDATE r_records SET view='".mysql_real_escape_string($_POST['views'])."',name='".mysql_real_escape_string($_POST['name'])."',value='".mysql_real_escape_string($_POST['value'])."',ttl=".((int)$_POST['ttl']).",last_update_ts=".time()." WHERE zone_id=".((int)$zone)." AND rr_type='NS' AND name='".mysql_real_escape_string($_POST['orig_name'])."' AND value='".mysql_real_escape_string($_POST['orig_value'])."' AND view='".mysql_real_escape_string($_POST['orig_view'])."';";
	$result = mysql_query($query) or dberror($query, mysql_error());
    }
    elseif($type == "PTR")
    {
	
    }
    elseif($type == "SRV")
    {
	
    }
    elseif($type == "TXT")
    {
	$query = "UPDATE r_records SET view='".mysql_real_escape_string($_POST['views'])."',name='".mysql_real_escape_string($_POST['name'])."',value='".mysql_real_escape_string($_POST['value'])."',ttl=".((int)$_POST['ttl']).",last_update_ts=".time()." WHERE zone_id=".((int)$zone)." AND rr_type='TXT' AND name='".mysql_real_escape_string($_POST['orig_name'])."' AND value='".mysql_real_escape_string($_POST['orig_value'])."' AND view='".mysql_real_escape_string($_POST['orig_view'])."';";
	error_log($query);
	$result = mysql_query($query) or dberror($query, mysql_error());
    }
    elseif($type == "SPF")
    {
	$query = "UPDATE r_records SET view='".mysql_real_escape_string($_POST['views'])."',name='".mysql_real_escape_string($_POST['name'])."',value='".mysql_real_escape_string($_POST['value'])."',ttl=".((int)$_POST['ttl']).",last_update_ts=".time()." WHERE zone_id=".((int)$zone)." AND rr_type='SPF' AND name='".mysql_real_escape_string($_POST['orig_name'])."' AND value='".mysql_real_escape_string($_POST['orig_value'])."' AND view='".mysql_real_escape_string($_POST['orig_view'])."';";
	error_log($query);
	$result = mysql_query($query) or dberror($query, mysql_error());
    }
}


updateZoneSerial($zone, $_POST['views']);

header("Location: ../zone.php?id=".$zone);

?>
