<?php
// common.php - common functions
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


// setup MySQL connection
$conn = mysql_connect($config_db_host, $config_db_user, $config_db_pass) or die("Unable to connect to MySQL database.<br />");
mysql_select_db($config_db_name) or die("Unable to select database: ".$config_db_name.".<br />");

function printHeader()
{
    $links = array();
    $links["#"] = "&nbsp;";
    $links["index.php"] = "Home";
    $links["zones.php"] = "Zones";
    $links["networks.php"] = "Networks";
    $links["hosts.php"] = "Hosts";

    $links["search.php"] = "Search";
    $links["download.php"] = "Download";
    $links["admin.php"] = "Admin";
    $links["push.php"] = "Trigger Pull";

    $currentScript = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/")+1);    

    echo '<div id="headerContainer">'."\n";
    echo '<div id="header">'."\n";
    echo '	<h1>MultiBIND Admin</h1>'."\n";
    echo '</div>'."\n";
    echo '<ul id="nav">'."\n";

    $count = 0;
    foreach($links as $url => $name)
    {
	$count++;
	if($url == $currentScript)
	{
	    echo '	<li id="nav-'.$count.'" class="activeNav"><a href="'.$url.'">'.$name.'</a></li>'."\n";
	}
	else
	{
	    echo '	<li id="nav-'.$count.'"><a href="'.$url.'">'.$name.'</a></li>'."\n";
	}
    }
    echo '</ul>'."\n";
    echo '</div> <!-- close headerContainer DIV -->'."\n";
    echo '<div class="clearing"></div>'."\n";
}

function printFooter()
{
    echo '<div id="footer">'."\n";
    
    echo '</div> <!-- close footer DIV -->'."\n";
}

function dberror($query, $error)
{
    error_log("Database error!\nQuery: $query\nError: $error\n");
    die("Database error. Script dieing...<br />");
}

function makeZoneSerial($current)
{
    if(substr($current, 0, 8) == date("Ymd"))
    {
	$ser = (int)substr($current, 8);
	$ser++;
	return date("Ymd").sprintf("%'02u", $ser);
    }
    else
    {
	$ser = 0;
	return date("Ymd").sprintf("%'02u", $ser);
    }

}

function updateZoneSerial($zone_id, $view)
{
    if($view == "both" || $view == "inside")
    {
	$query = "SELECT current_serial FROM soa_records WHERE zone_id=".((int)$zone_id)." AND view='inside';";
	$result = mysql_query($query) or dberror($query, mysql_error());
	$row = mysql_fetch_assoc($result);
	$new = makeZoneSerial($row['current_serial']);
	$query = "UPDATE soa_records SET current_serial=".$new." WHERE zone_id=".((int)$zone_id)." AND view='inside';";
	$result = mysql_query($query) or dberror($query, mysql_error());
    }
    if($view == "both" || $view == "outside")
    {
	$query = "SELECT current_serial FROM soa_records WHERE zone_id=".((int)$zone_id)." AND view='outside';";
	$result = mysql_query($query) or dberror($query, mysql_error());
	$row = mysql_fetch_assoc($result);
	$new = makeZoneSerial($row['current_serial']);
	$query = "UPDATE soa_records SET current_serial=".$new." WHERE zone_id=".((int)$zone_id)." AND view='outside';";
	$result = mysql_query($query) or dberror($query, mysql_error());
    }
}

/**
 * For a given zone_id, gets an associative array of all PTR records for the zone
 *
 * @param $zone_id int
 * @return array
 */
function getPTRarray($zone_id)
{
    // TODO - need to implement second/EXTERNAL IPs also
    $query = "SELECT * FROM zones WHERE zone_id=".$zone_id.";";
    $result = mysql_query($query) or dberror($query, mysql_error());
    $row = mysql_fetch_assoc($result);
    
    $name = $row['name'];
    $nameLen = strlen($name);

    $ret = array();

    $query = "SELECT r.name,r.ttl,r.value,SUBSTR(r.value,".($nameLen+2).") AS value_host,r.view,z.name AS zoneName FROM r_records AS r LEFT JOIN zones AS z ON r.zone_id=z.zone_id WHERE r.rr_type='A' AND SUBSTR(r.value,1,".$nameLen.")='".$name."' ORDER BY value_host;";

    $result = mysql_query($query) or dberror($query, mysql_error());
    while($row = mysql_fetch_assoc($result))
    {
	$ret[(int)$row['value_host']] = $row;
    }
    ksort($ret);
    return $ret;
}

?>