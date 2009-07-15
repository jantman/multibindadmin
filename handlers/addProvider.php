<?php
// index.php
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

if(isset($_POST['providerName']))
{
    $name = $_POST['providerName'];
    $query = "SELECT * FROM providers WHERE provider_name='".mysql_real_escape_string($name)."';";
    $result = mysql_query($query) or dberror($query, mysql_error());
    if(mysql_num_rows($result) > 0)
    {
	printHeader();
	echo '<h2>ERROR</h2><p class="errorP">Provider already exists.</p>';
	printFooter();
	die();
    }
    $query = "INSERT INTO providers SET provider_name='".mysql_real_escape_string($name)."';";
    $result = mysql_query($query) or dberror($query, mysql_error());
    header("Location: ../admin.php");
}

?>
