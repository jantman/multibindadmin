<?php
// search.php
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
<title>Search - MultiBindAdmin</title>
<link rel="stylesheet" type="text/css" href="css/common.css" />
<link rel="stylesheet" type="text/css" href="css/nav.css" />
</head>

<body>
<?php
printHeader();

if(isset($_GET['hostname']))
{
    searchHostname($_GET['hostname']);
}
else
{
    showSearchForm();
}

function searchHostname($hostname)
{
    $hostname = mysql_real_escape_string($hostname);
    echo '<div id="content">'."\n";

    echo '<h2>Search Result: hostname "'.$hostname.'"</h2>';

    // A records
    echo '<div class="tableTitle"><h3>A Records</h3></div>';
    echo '<table class="minorTableWide">'."\n";
    echo '<tr><th>Zone</th><th>Name</th><th>Type</th><th>Points To/Value</th><th>View</th><th>ttl</th></tr>'."\n";
    $query = "SELECT r.*,z.name AS zone_name FROM r_records AS r LEFT JOIN zones AS z ON r.zone_id=z.zone_id WHERE r.rr_type='A' AND r.name LIKE '%".$hostname."%' ORDER BY r.name ASC,r.view ASC;";
    $result = mysql_query($query) or dberror($query, mysql_error());
    while($row = mysql_fetch_assoc($result))
    {
	echo '<tr>';
	echo '<td><a href="zone.php?id='.$row['zone_id'].'">'.$row['zone_name'].' ('.$row['zone_id'].')</a></td>';
	echo '<td>'.$row['name'].'</td>';
	echo '<td>'.$row['rr_type'].'</td>';
	echo '<td>'.$row['value'].'</td>';
	if($row['value2'] != null && trim($row['value2']) != "" && $row['value2'] != $row['value1'] && $row['view'] == "both")
	{
	    echo '<td>*inside*</td>';
	    echo '<td>'.$row['ttl'].'</td>';
	    echo '</tr>'."\n";
	    
	    // outside side
	    echo '<tr><td>&nbsp;</td><td>&nbsp;</td>';
	    echo '<td>'.$row['value2'].'</td>';
	    echo '<td>*outside*</td>';
	    echo '<td>&nbsp;</td>';
	    echo '</tr>'."\n";
	}
	else
	{
	    echo '<td>'.$row['view'].'</td>';
	    echo '<td>'.$row['ttl'].'</td>';
	    echo '</tr>'."\n";
	}
    }
    echo '</table>'."\n";

    // CNAMES
    echo '<div class="tableTitle"><h3>CNAME Records</h3></div>';
    echo '<table class="minorTableWide">'."\n";
    echo '<tr><th>Zone</th><th>Name</th><th>Type</th><th>Points To/Value</th><th>View</th><th>ttl</th></tr>'."\n";
    $query = "SELECT r.*,z.name AS zone_name FROM r_records AS r LEFT JOIN zones AS z ON r.zone_id=z.zone_id WHERE r.rr_type='CNAME' AND (r.name LIKE '%".$hostname."%' OR r.value LIKE '%".$hostname."%' ) ORDER BY r.name ASC,r.view ASC;";
    $result = mysql_query($query) or dberror($query, mysql_error());
    while($row = mysql_fetch_assoc($result))
    {
	echo '<tr>';
	echo '<td><a href="zone.php?id='.$row['zone_id'].'">'.$row['zone_name'].' ('.$row['zone_id'].')</a></td>';
	echo '<td>'.$row['name'].'</td>';
	echo '<td>'.$row['rr_type'].'</td>';
	echo '<td>'.$row['value'].'</td>';
	echo '<td>'.$row['view'].'</td>';
	echo '<td>'.$row['ttl'].'</td>';
	echo '</tr>'."\n";
    }
    echo '</table>'."\n";

    // TXT records
    echo '<div class="tableTitle"><h3>TXT Records</h3></div>';
    echo '<table class="minorTableWide">'."\n";
    echo '<tr><th>Zone</th><th>Name</th><th>Type</th><th>Points To/Value</th><th>View</th><th>ttl</th></tr>'."\n";
    $query = "SELECT r.*,z.name AS zone_name FROM r_records AS r LEFT JOIN zones AS z ON r.zone_id=z.zone_id WHERE r.rr_type='TXT' AND (r.name LIKE '%".$hostname."%' OR r.value LIKE '%".$hostname."%' ) ORDER BY r.name ASC,r.view ASC;";
    $result = mysql_query($query) or dberror($query, mysql_error());
    while($row = mysql_fetch_assoc($result))
    {
	echo '<tr>';
	echo '<td><a href="zone.php?id='.$row['zone_id'].'">'.$row['zone_name'].' ('.$row['zone_id'].')</a></td>';
	echo '<td>'.$row['name'].'</td>';
	echo '<td>'.$row['rr_type'].'</td>';
	echo '<td>'.$row['value'].'</td>';
	echo '<td>'.$row['view'].'</td>';
	echo '<td>'.$row['ttl'].'</td>';
	echo '</tr>'."\n";
    }
    echo '</table>'."\n";

    // NS records
    echo '<div class="tableTitle"><h3>NS Records</h3></div>';
    echo '<table class="minorTableWide">'."\n";
    echo '<tr><th>Zone</th><th>Name</th><th>Type</th><th>Points To/Value</th><th>View</th><th>ttl</th></tr>'."\n";
    $query = "SELECT r.*,z.name AS zone_name FROM r_records AS r LEFT JOIN zones AS z ON r.zone_id=z.zone_id WHERE r.rr_type='NS' AND (r.name LIKE '%".$hostname."%' OR r.value LIKE '%".$hostname."%' ) ORDER BY r.name ASC,r.view ASC;";
    $result = mysql_query($query) or dberror($query, mysql_error());
    while($row = mysql_fetch_assoc($result))
    {
	echo '<tr>';
	echo '<td><a href="zone.php?id='.$row['zone_id'].'">'.$row['zone_name'].' ('.$row['zone_id'].')</a></td>';
	echo '<td>'.$row['name'].'</td>';
	echo '<td>'.$row['rr_type'].'</td>';
	echo '<td>'.$row['value'].'</td>';
	echo '<td>'.$row['view'].'</td>';
	echo '<td>'.$row['ttl'].'</td>';
	echo '</tr>'."\n";
    }
    echo '</table>'."\n";

    // MX records
    echo '<div class="tableTitle"><h3>MX Records</h3></div>'."\n";
    echo '<table class="minorTableWide">'."\n";
    echo '<tr><th>Zone</th><th>Name</th><th>Pref</th><th>Points To/Value</th><th>View</th><th>ttl</th></tr>'."\n";
    $query = "SELECT m.*,z.name AS zone_name FROM mx_records AS m LEFT JOIN zones AS z ON m.zone_id=z.zone_id WHERE m.name LIKE '%".$hostname."%' OR m.mx_name LIKE '%".$hostname."%' ORDER BY m.view,m.name,m.pref;";
    $result = mysql_query($query) or dberror($query, mysql_error());
    while($row = mysql_fetch_assoc($result))
    {
	echo '<tr>';
	echo '<td><a href="zone.php?id='.$row['zone_id'].'">'.$row['zone_name'].' ('.$row['zone_id'].')</a></td>';
	echo '<td>'.$row['name'].'</td>';
	echo '<td>'.$row['pref'].'</td>';
	echo '<td>'.$row['mx_name'].'</td>';
	echo '<td>'.$row['view'].'</td>';
	echo '<td>'.$row['ttl'].'</td>';
	echo '</tr>'."\n";
    }
    echo '</table>'."\n";
    echo '</div> <!-- close content div -->'."\n";
}

function showSearchForm()
{
    echo '<div id="content">'."\n";
    echo '<div>'."\n";
    echo '<form name="hostSearch" method="get">'."\n";
    echo '<h2>Search By Hostname</h2>'."\n";
    echo '<input type="text" name="hostname" size="30" />';
    echo '<input type="submit" name="Submit" value="Search" />';
    echo '</form>';
    echo '</div>'."\n";
    echo '</div> <!-- close content div -->'."\n";
}

?>

<?php printFooter(); ?>

</body>

</html>
