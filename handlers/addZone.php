<?php
// handlers/addZone.php
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

if(isset($_POST['name']))
{
    $name = $_POST['name'];
    $query = "SELECT * FROM zones WHERE name='".mysql_real_escape_string($name)."';";
    $result = mysql_query($query) or dberror($query, mysql_error());
    if(mysql_num_rows($result) > 0)
    {
	printHeader();
	echo '<h2>ERROR</h2><p class="errorP">Zone with name "'.$name.'" already exists.</p>';
	printFooter();
	die();
    }

    if($_POST['views'] == "both" && ($_POST['insideProviderId'] == "" || $_POST['outsideProviderId'] == ""))
    {
	printHeader();
	echo '<h2>ERROR</h2><p class="errorP">You must specify both prodiver names to use both views.</p>';
	printFooter();
	die();
    }
    if($_POST['views'] == "inside" && $_POST['insideProviderId'] == "")
    {
	printHeader();
	echo '<h2>ERROR</h2><p class="errorP">You must specify a prodiver name.</p>';
	printFooter();
	die();
    }
    if($_POST['views'] == "outside" && $_POST['outsideProviderId'] == "")
    {
	printHeader();
	echo '<h2>ERROR</h2><p class="errorP">You must specify a prodiver name.</p>';
	printFooter();
	die();
    }
    $query = "INSERT INTO zones SET name='".mysql_real_escape_string($name)."',type='".mysql_real_escape_string($_POST['type'])."',views='".mysql_real_escape_string($_POST['views'])."',";
    if($_POST['views'] == "both"){ $query .= "inside_provider_id=".((int)$_POST['insideProviderId']).",outside_provider_id=".((int)$_POST['outsideProviderId']).",";}
    elseif($_POST['views'] == "inside"){ $query .= "inside_provider_id=".((int)$_POST['insideProviderId']).",";}
    else { $query .= "outside_provider_id=".((int)$_POST['outsideProviderId']).",";}
    // handle reverse
    if($_POST['type'] == "reverse")
    {
	$foo = explode(".", $name);
	$bar = "";
	for($i = count($foo)-1; $i >=0; $i--)
	{
	    $bar .= $foo[$i].".";
	}
	$_POST['origin'] = $bar."IN-ADDR.ARPA.";
    }
    else
    {
	if(! isset($_POST['origin']) || trim($_POST['origin']) == ""){ $_POST['origin'] = $_POST['name'];}
	if(substr($_POST['origin'], strlen($_POST['origin'])-1) != "."){ $_POST['origin'] .= ".";}
    }
    $query .= "origin='".$_POST['origin']."',ttl=".((int)$_POST['ttl']).",last_update_ts=".time().",insert_ts=".time().";";
    $result = mysql_query($query) or dberror($query, mysql_error());
    header("Location: ../zones.php");
}

?>
