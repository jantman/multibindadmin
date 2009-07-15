<?php
// editSOA.php handler
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

$zone_id = (int)$_POST['zone_id'];

// find out if we're updating or inserting
$query = "SELECT * FROM soa_records WHERE zone_id=".$zone_id." AND view='".mysql_real_escape_string($_POST['view'])."';";
$result = mysql_query($query) or dberror($query, mysql_error());
if(mysql_num_rows($result) < 1)
{
    $is_insert = true;
    $query = "INSERT INTO soa_records SET ";
}
else
{
    $query = "UPDATE soa_records SET ";
}


$query .= "ttl=".((int)$_POST['ttl']).",class='".mysql_real_escape_string($_POST['class'])."',name_server='".mysql_real_escape_string($_POST['name-server'])."',email_addr='".mysql_real_escape_string($_POST['email-addr'])."',refresh=".((int)$_POST['refresh']).",retry=".((int)$_POST['retry']).",expiry=".((int)$_POST['expiry']).",minimum=".((int)$_POST['minimum']).",zone_id=".$zone_id.",view='".mysql_real_escape_string($_POST['view'])."',current_serial=".date("Ymds").",";

$query .= "last_update_ts=".time();
if($is_insert)
{
    $query .= ",insert_ts=".time();
}
else
{
    $query .= " WHERE zone_id=".$zone_id." AND view='".mysql_real_escape_string($_POST['view'])."'";
}

$query .= ";";
$result = mysql_query($query) or dberror($query, mysql_error());
header("Location: ../zone.php?id=".$_POST['zone_id']);

?>
