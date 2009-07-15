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
require_once('config/config.php');
require_once('inc/common.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin - MultiBindAdmin</title>
<link rel="stylesheet" type="text/css" href="css/common.css" />
<link rel="stylesheet" type="text/css" href="css/nav.css" />
</head>

<body>
<?php printHeader(); ?>

<div id="content">

<h2>Administration</h2>

<h3>Providers</h3>

<table class="mainTable">
<tr><th>ID</th><th>Name</th></tr>
<?php
$query = "SELECT * FROM providers;";
$result = mysql_query($query) or dberror($query, mysql_error());
while($row = mysql_fetch_assoc($result))
{
    echo '<tr><td>'.$row['provider_id'].'</td><td>'.$row['provider_name'],'</td></tr>';
}
?>
</table>

<div> <!-- provider form div -->
<p>
<form name="addProvider" action="handlers/addProvider.php" method="post">
<label for="providerName">Name: </label>
<input type="text" size="30" id="providerName" name="providerName" />
<input type="submit" name="Submit" value="Add Provider" />
</form>
</p>
</div> <!-- CLOSE provider form div -->

</div> <!-- close content div -->

<?php printFooter(); ?>

</body>

</html>
