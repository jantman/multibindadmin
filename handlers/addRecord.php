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
*/

if(! isset($_POST['zone_id']) || ! isset($_POST['rr_type']))
{
    die("Zone ID and rr_type must be specified.");
}

$zone = $_POST['zone_id'];
$type = $_POST['rr_type'];

if($type == "A")
{
    $query = "INSERT INTO r_records SET zone_id=".((int)$zone).",view='".mysql_real_escape_string($_POST['views'])."',name='".mysql_real_escape_string($_POST['name'])."',value='".mysql_real_escape_string($_POST['value'])."',ttl=".((int)$_POST['ttl']).",rr_type='A',insert_ts=".time().",last_update_ts=".time();
    if(trim($_POST['value2']) != ""){ $query .= ",value2='".mysql_real_escape_string($_POST['value2'])."'";}
    $query .= ";";
    $query2 = "INSERT INTO dhcp_hosts SET rr_view='".mysql_real_escape_string($_POST['views'])."',rr_name='".mysql_real_escape_string($_POST['name'])."',rr_value='".mysql_real_escape_string($_POST['value'])."',mac_address='".mysql_real_escape_string($POST['mac_addr'])."';";
}
elseif($type == "CNAME")
{
    $query = "INSERT INTO r_records SET zone_id=".((int)$zone).",view='".mysql_real_escape_string($_POST['views'])."',name='".mysql_real_escape_string($_POST['name'])."',value='".mysql_real_escape_string($_POST['value'])."',ttl=".((int)$_POST['ttl']).",rr_type='CNAME',insert_ts=".time().",last_update_ts=".time().";";
}
elseif($type == "MX")
{
    $query = "INSERT INTO mx_records SET zone_id=".((int)$zone).",view='".mysql_real_escape_string($_POST['views'])."',name='".mysql_real_escape_string($_POST['name'])."',mx_name='".mysql_real_escape_string($_POST['value'])."',ttl=".((int)$_POST['ttl']).",pref=".((int)$_POST['pref']).",insert_ts=".time().",last_update_ts=".time().";";
}
elseif($type == "NS")
{
    $query = "INSERT INTO r_records SET zone_id=".((int)$zone).",view='".mysql_real_escape_string($_POST['views'])."',name='".mysql_real_escape_string($_POST['name'])."',value='".mysql_real_escape_string($_POST['value'])."',ttl=".((int)$_POST['ttl']).",rr_type='NS',insert_ts=".time().",last_update_ts=".time().";";
}
elseif($type == "PTR")
{

}
elseif($type == "SRV")
{

}
elseif($type == "TXT")
{
    $query = "INSERT INTO r_records SET zone_id=".((int)$zone).",view='".mysql_real_escape_string($_POST['views'])."',name='".mysql_real_escape_string($_POST['name'])."',value='".mysql_real_escape_string($_POST['value'])."',ttl=".((int)$_POST['ttl']).",rr_type='TXT',insert_ts=".time().",last_update_ts=".time().";";
}
elseif($type == "SPF")
{
    $query = "INSERT INTO r_records SET zone_id=".((int)$zone).",view='".mysql_real_escape_string($_POST['views'])."',name='".mysql_real_escape_string($_POST['name'])."',value='".mysql_real_escape_string($_POST['value'])."',ttl=".((int)$_POST['ttl']).",rr_type='SPF',insert_ts=".time().",last_update_ts=".time().";";
}

$result = mysql_query($query) or dberror($query, mysql_error());

if(isset($query2)){ $result = mysql_query($query2) or dberror($query2, mysql_error());}

updateZoneSerial($zone, $_POST['views']);

header("Location: ../zone.php?id=".$zone);

?>
