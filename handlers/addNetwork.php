<?php
// handlers/addNetwork.php
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
    $query = "SELECT * FROM networks WHERE name='".mysql_real_escape_string($name)."';";
    $result = mysql_query($query) or dberror($query, mysql_error());
    if(mysql_num_rows($result) > 0)
    {
	printHeader();
	echo '<h2>ERROR</h2><p class="errorP">Network with name "'.$name.'" already exists.</p>';
	printFooter();
	die();
    }

    $query = "SET AUTOCOMMIT=0;";
    $result = mysql_query($query) or dberror($query, mysql_error());
    $query = "START TRANSACTION;";
    $result = mysql_query($query) or dberror($query, mysql_error());

    $query = "INSERT INTO subnets SET name='".mysql_real_escape_string($name)."',firstThree='".mysql_real_escape_string($_POST['firstThree'])."',view='".mysql_real_escape_string($_POST['views'])."',vlan_number=".((int)$_POST['vlan_number']).",start_ip=".((int)$_POST['start_ip']).",end_ip=".((int)$_POST['end_ip']).",netmask_cidr=".((int)$_POST['netmask_cidr']).",last_update_ts=".time().",insert_ts=".time();
    if(isset($_POST['authoritative'])){ $query .= ",authoritative=1";}
    if(isset($_POST['allow_unknown'])){ $query .= ",allow_unknown=1";}
    if(isset($_POST['ddns_update'])){ $query .= ",allow_ddns=1";}
    $query .= ";";
    $result = mysql_query($query) or dberror($query, mysql_error());
    $subnet_id = mysql_insert_id();

    $query = "INSERT INTO dhcp_pools SET subnet_id=$subnet_id,start_ip='".mysql_real_escape_string($_POST['start_ip'])."',end_ip='".mysql_real_escape_string($_POST['end_ip'])."';";
    $result = mysql_query($query) or dberror($query, mysql_error());

    foreach($_POST as $key => $val)
    {
	if(substr($key, 0, 7) != "option_"){ continue;}
	$opt = substr($key, 7);
	$query = "INSERT INTO dhcp_subnet_options SET subnet_id=$subnet_id,option_name='".mysql_real_escape_string($opt)."',option_value='".mysql_real_escape_string($val)."';";
    }

    /* DEBUG
    echo $query;
    mysql_query("ROLLBACK;");
    die();
     END DEBUG
    */



    $query = "COMMIT;";
    $result = mysql_query($query) or dberror($query, mysql_error());

    header("Location: ../networks.php");

}

?>
