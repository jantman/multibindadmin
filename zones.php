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
<title>Zones - MultiBindAdmin</title>
<link rel="stylesheet" type="text/css" href="css/common.css" />
<link rel="stylesheet" type="text/css" href="css/nav.css" />
</head>

<body>
<?php printHeader(); ?>

<div id="content">

<h2>Zones</h2>

<table class="mainTable">
<tr><th rowspan="2">ID</th><th rowspan="2">Name</th><th rowspan="2">Views</th><th colspan="3">Inside</th><th colspan="3">Outside</th></tr>
<tr><th>Serial</th><th>RRs</th><th>Provider</th><th>Serial</th><th>RRs</th><th>Provider</th></tr>
<?php
$query = "SELECT z.zone_id,z.name,z.views,p.provider_name AS insideProvider,p2.provider_name AS outsideProvider FROM zones AS z LEFT JOIN providers AS p ON z.inside_provider_id=p.provider_id LEFT JOIN providers AS p2 ON z.outside_provider_id=p2.provider_id;";
$result = mysql_query($query);
while($row = mysql_fetch_assoc($result))
{
    echo '<tr><td><a href="zone.php?id='.$row['zone_id'].'">'.$row['zone_id'].'</a></td><td>'.$row['name'].'</td><td>'.$row['views'].'</td>';
    if($row['views'] == "both")
    {
	// inside
	$q2 = "SELECT current_serial FROM soa_records WHERE zone_id=".$row['zone_id']." AND (view='inside' OR view='both');";
	$res2 = mysql_query($q2);
	$row2 = mysql_fetch_assoc($res2);
	echo '<td>'.$row2['current_serial'].'</td>';

	$q2 = "SELECT COUNT(*) FROM r_records WHERE zone_id=".$row['zone_id']." AND (view='inside' OR view='both');";
	$res2 = mysql_query($q2);
	$row2 = mysql_fetch_assoc($res2);
	$count = (int)$row2['COUNT(*)'];
	$q2 = "SELECT COUNT(*) FROM mx_records WHERE zone_id=".$row['zone_id']." AND (view='inside' OR view='both');";
	$res2 = mysql_query($q2);
	$row2 = mysql_fetch_assoc($res2);
	$count += (int)$row2['COUNT(*)'];
	$q2 = "SELECT COUNT(*) FROM srv_records WHERE zone_id=".$row['zone_id']." AND (view='inside' OR view='both');";
	$res2 = mysql_query($q2);
	$row2 = mysql_fetch_assoc($res2);
	$count += (int)$row2['COUNT(*)'];
	$q2 = "SELECT COUNT(*) FROM ptr_records WHERE zone_id=".$row['zone_id']." AND (view='inside' OR view='both');";
	$res2 = mysql_query($q2);
	$row2 = mysql_fetch_assoc($res2);
	$count += (int)$row2['COUNT(*)'];
	echo '<td>'.$count.'</td>';
	echo '<td>'.$row['insideProvider'].'</td>';

	// outside
	$q2 = "SELECT current_serial FROM soa_records WHERE zone_id=".$row['zone_id']." AND (view='outside' OR view='both');";
	$res2 = mysql_query($q2);
	$row2 = mysql_fetch_assoc($res2);
	echo '<td>'.$row2['current_serial'].'</td>';

	$q2 = "SELECT COUNT(*) FROM r_records WHERE zone_id=".$row['zone_id']." AND (view='outside' OR view='both');";
	$res2 = mysql_query($q2);
	$row2 = mysql_fetch_assoc($res2);
	$count = (int)$row2['COUNT(*)'];
	$q2 = "SELECT COUNT(*) FROM mx_records WHERE zone_id=".$row['zone_id']." AND (view='outside' OR view='both');";
	$res2 = mysql_query($q2);
	$row2 = mysql_fetch_assoc($res2);
	$count += (int)$row2['COUNT(*)'];
	$q2 = "SELECT COUNT(*) FROM srv_records WHERE zone_id=".$row['zone_id']." AND (view='outside' OR view='both');";
	$res2 = mysql_query($q2);
	$row2 = mysql_fetch_assoc($res2);
	$count += (int)$row2['COUNT(*)'];
	$q2 = "SELECT COUNT(*) FROM ptr_records WHERE zone_id=".$row['zone_id']." AND (view='outside' OR view='both');";
	$res2 = mysql_query($q2);
	$row2 = mysql_fetch_assoc($res2);
	$count += (int)$row2['COUNT(*)'];
	echo '<td>'.$count.'</td>';
	echo '<td>'.$row['outsideProvider'].'</td>';
    }
    elseif($row['views'] == "inside")
    {
	$q2 = "SELECT current_serial FROM soa_records WHERE zone_id=".$row['zone_id']." AND (view='inside' OR view='both');";
	$res2 = mysql_query($q2);
	$row2 = mysql_fetch_assoc($res2);
	echo '<td>'.$row2['current_serial'].'</td>';

	$q2 = "SELECT COUNT(*) FROM r_records WHERE zone_id=".$row['zone_id']." AND (view='inside' OR view='both');";
	$res2 = mysql_query($q2);
	$row2 = mysql_fetch_assoc($res2);
	$count = (int)$row2['COUNT(*)'];
	$q2 = "SELECT COUNT(*) FROM mx_records WHERE zone_id=".$row['zone_id']." AND (view='inside' OR view='both');";
	$res2 = mysql_query($q2);
	$row2 = mysql_fetch_assoc($res2);
	$count += (int)$row2['COUNT(*)'];
	$q2 = "SELECT COUNT(*) FROM srv_records WHERE zone_id=".$row['zone_id']." AND (view='inside' OR view='both');";
	$res2 = mysql_query($q2);
	$row2 = mysql_fetch_assoc($res2);
	$count += (int)$row2['COUNT(*)'];
	$q2 = "SELECT COUNT(*) FROM ptr_records WHERE zone_id=".$row['zone_id']." AND (view='inside' OR view='both');";
	$res2 = mysql_query($q2);
	$row2 = mysql_fetch_assoc($res2);
	$count += (int)$row2['COUNT(*)'];
	echo '<td>'.$count.'</td>';
	echo '<td>'.$row['insideProvider'].'</td>';
	echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
    }
    else
    {
	echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
	$q2 = "SELECT current_serial FROM soa_records WHERE zone_id=".$row['zone_id']." AND (view='outside' OR view='both');";
	$res2 = mysql_query($q2);
	$row2 = mysql_fetch_assoc($res2);
	echo '<td>'.$row2['current_serial'].'</td>';

	$q2 = "SELECT COUNT(*) FROM r_records WHERE zone_id=".$row['zone_id']." AND (view='outside' OR view='both');";
	$res2 = mysql_query($q2);
	$row2 = mysql_fetch_assoc($res2);
	$count = (int)$row2['COUNT(*)'];
	$q2 = "SELECT COUNT(*) FROM mx_records WHERE zone_id=".$row['zone_id']." AND (view='outside' OR view='both');";
	$res2 = mysql_query($q2);
	$row2 = mysql_fetch_assoc($res2);
	$count += (int)$row2['COUNT(*)'];
	$q2 = "SELECT COUNT(*) FROM srv_records WHERE zone_id=".$row['zone_id']." AND (view='outside' OR view='both');";
	$res2 = mysql_query($q2);
	$row2 = mysql_fetch_assoc($res2);
	$count += (int)$row2['COUNT(*)'];
	$q2 = "SELECT COUNT(*) FROM ptr_records WHERE zone_id=".$row['zone_id']." AND (view='outside' OR view='both');";
	$res2 = mysql_query($q2);
	$row2 = mysql_fetch_assoc($res2);
	$count += (int)$row2['COUNT(*)'];
	echo '<td>'.$count.'</td>';
	echo '<td>'.$row['outsideProvider'].'</td>';
    }
    echo '</tr>'."\n";
}
?>
</table>

<p class="tableBottomLink"><a href="addZone.php">&#43; Add Zone</a></p>

</div> <!-- close content div -->

<?php printFooter(); ?>

</body>

</html>
