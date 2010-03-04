<?php
// networks.php
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
<title>Networks - MultiBindAdmin</title>
<link rel="stylesheet" type="text/css" href="css/common.css" />
<link rel="stylesheet" type="text/css" href="css/nav.css" />
</head>

<body>
<?php printHeader(); ?>

<div id="content">

<h2>Networks</h2>

<table class="mainTable">
<tr><th>ID</th><th>Name</th><th>Address</th><th>Usable IPs</th><th>Views</th><th>VLAN</th></tr>
<?php
$query = "SELECT * FROM subnets;";
$result = mysql_query($query);
while($row = mysql_fetch_assoc($result))
{
    echo '<tr>';
    echo '<td><a href="network.php?id='.$row['subnet_id'].'">'.$row['subnet_id'].'</a></td>';
    echo '<td>'.$row['name'].'</td>';
    echo '<td>'.$row['firstThree'].'.'.$row['start_ip']."/".$row['netmask_cidr'].'</td>';
    echo '<td>'.$row['firstThree'].".".($row['start_ip']+2)." - ".($row['end_ip']-1).'</td>';
    echo '<td>'.$row['view'].'</td>';
    echo '<td>'.$row['vlan_number'].'</td>';
    echo '</tr>'."\n";
}
?>
</table>

<p class="tableBottomLink"><a href="addNetwork.php">&#43; Add Network</a></p>

</div> <!-- close content div -->

<?php printFooter(); ?>

</body>

</html>
