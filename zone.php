<?php
// zone.php
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
<title>Zone - MultiBindAdmin</title>
<link rel="stylesheet" type="text/css" href="css/common.css" />
<link rel="stylesheet" type="text/css" href="css/nav.css" />
</head>

<body>
<?php
printHeader();

if(! isset($_GET['id']))
{
    echo '<p class="error">ERROR: No zone ID specified.</p>';
    printFooter();
    die();
}

$query = "SELECT z.zone_id,z.type,z.name,z.views,z.last_update_ts,z.insert_ts,z.ttl,z.origin,p.provider_name AS insideProvider,p2.provider_name AS outsideProvider FROM zones AS z LEFT JOIN providers AS p ON z.inside_provider_id=p.provider_id LEFT JOIN providers AS p2 ON z.outside_provider_id=p2.provider_id WHERE z.zone_id=".((int)$_GET['id']).";";
$result = mysql_query($query) or dberror($query, mysql_error());
if(mysql_num_rows($result) < 1)
{
    echo '<p class="error">ERROR: No zone found with ID '.$_GET['id'].'</p>';
    printFooter();
    die();
}
$zoneRow = mysql_fetch_assoc($result);
?>



<div id="content">

<?php echo '<h2>Zone '.$zoneRow['zone_id'].' - '.$zoneRow['name'].'</h2>'; ?>
<?php echo '<p>Download: <a href="download.php?zone='.$zoneRow['zone_id'].'&view=inside">Inside</a> <a href="download.php?zone='.$zoneRow['zone_id'].'&view=outside">Outside</a></p>';?>

<table class="minorTable">
<?php
echo '<tr><th>Created</th><td>'.date($config_long_date_format, $zoneRow['insert_ts']).'</td></tr>';
echo '<tr><th>Modified</th><td>'.date($config_long_date_format, $zoneRow['last_update_ts']).'</td></tr>';
echo '<tr><th>Type</th><td>'.$zoneRow['type'].'</td></tr>';
echo '<tr><th>Views</th><td>'.$zoneRow['views'].'</td></tr>';
if($zoneRow['views'] == "both")
{
    echo '<tr><th>Inside Provider</th><td>'.$zoneRow['insideProvider'].'</td></tr>';
    echo '<tr><th>Outside Provider</th><td>'.$zoneRow['outsideProvider'].'</td></tr>';
}
elseif($zoneRow['views'] == "inside")
{
    echo '<tr><th>Inside Provider</th><td>'.$zoneRow['insideProvider'].'</td></tr>';
    echo '<tr><th>Outside Provider</th><td>-</td></tr>';
}
else
{
    echo '<tr><th>Inside Provider</th><td>-</td></tr>';
    echo '<tr><th>Outside Provider</th><td>'.$zoneRow['outsideProvider'].'</td></tr>';
}
echo '<tr><th>ttl</th><td>'.$zoneRow['ttl'].'</td></tr>';
echo '<tr><th>Origin</th><td>'.$zoneRow['origin'].'</td></tr>';
?>
</table>

<?php echo '<div class="tableTitle"><h3>SOA</h3></div>'; ?>
<table class="minorTable">
<tr><td>&nbsp;</td><th>Inside</th><th>Outside</th></tr>
<?php
$in = array("soa_id" => "&nbsp;", "current_serial" => "&nbsp;", "ttl" => "&nbsp;", "class" => "&nbsp;", "name_server" => "&nbsp;", "email_addr" => "&nbsp;", "refresh" => "&nbsp;", "retry" => "&nbsp;", "expiry" => "&nbsp;", "minimum" => "&nbsp;", "insert_ts" => "&nbsp;", "last_update_ts" => "&nbsp;");
$out = array("soa_id" => "&nbsp;", "current_serial" => "&nbsp;", "ttl" => "&nbsp;", "class" => "&nbsp;", "name_server" => "&nbsp;", "email_addr" => "&nbsp;", "refresh" => "&nbsp;", "retry" => "&nbsp;", "expiry" => "&nbsp;", "minimum" => "&nbsp;", "insert_ts" => "&nbsp;", "last_update_ts" => "&nbsp;");

$query = "SELECT * FROM soa_records WHERE zone_id=".$zoneRow['zone_id'].";";
$result = mysql_query($query) or dberror($query, mysql_error());
while($row = mysql_fetch_assoc($result))
{
    if($row['view'] == "inside" || $row['view'] == "both")
    {
	$in = $row;
    }
    
    if($row['view'] == "outside" || $row['view'] == "both")
    {
	$out = $row;
    }
}

echo '<tr><th>ID</th><td>'.$in['soa_id'].'</td><td>'.$out['soa_id'].'</td></tr>';
echo '<tr><th>serial</th><td>'.$in['current_serial'].'</td><td>'.$out['current_serial'].'</td></tr>';
echo '<tr><th>ttl</th><td>'.$in['ttl'].'</td><td>'.$out['ttl'].'</td></tr>';
echo '<tr><th>Class</th><td>'.$in['class'].'</td><td>'.$out['class'].'</td></tr>';
echo '<tr><th>name-server</th><td>'.$in['name_server'].'</td><td>'.$out['name_server'].'</td></tr>';
echo '<tr><th>email-addr</th><td>'.$in['email_addr'].'</td><td>'.$out['email_addr'].'</td></tr>';
echo '<tr><th>refresh</th><td>'.$in['refresh'].'</td><td>'.$out['refresh'].'</td></tr>';
echo '<tr><th>retry</th><td>'.$in['retry'].'</td><td>'.$out['retry'].'</td></tr>';
echo '<tr><th>expiry</th><td>'.$in['expiry'].'</td><td>'.$out['expiry'].'</td></tr>';
echo '<tr><th>minimum</th><td>'.$in['minimum'].'</td><td>'.$out['minimum'].'</td></tr>';
echo '<tr><th>Created</th><td>'.date($config_long_date_format, $in['insert_ts']).'</td><td>'.date($config_long_date_format, $out['insert_ts']).'</td></tr>';
echo '<tr><th>Modified</th><td>'.date($config_long_date_format, $in['last_update_ts']).'</td><td>'.date($config_long_date_format, $out['last_update_ts']).'</td></tr>';
echo '<tr><td>&nbsp;</td><td><a href="editSOA.php?id='.$_GET['id'].'&type=inside">Edit</a></td><td><a href="editSOA.php?id='.$_GET['id'].'&type=outside">Edit</a></td></tr>';
?>
</table>

<?php echo '<div class="tableTitle"><h3>Resource Records</h3><a href="addRecord.php?zone='.$_GET['id'].'">&#43; Add Record</a></div>'; ?>
<table class="minorTableWide">
<tr><th>Name</th><th>Type</th><th>Points To/Value</th><th>View</th><th>ttl</th></tr>
<?php
$query = "SELECT * FROM r_records WHERE zone_id=".$zoneRow['zone_id']." ORDER BY find_in_set(rr_type, 'NS,MX') DESC,name ASC,view ASC;";
$result = mysql_query($query) or dberror($query, mysql_error());
while($row = mysql_fetch_assoc($result))
{
    echo '<tr>';
    echo '<td><a href="editRecord.php?zone='.$zoneRow['zone_id'].'&name='.urlencode($row['name']).'&value='.urlencode($row['value']).'&type='.urlencode($row['rr_type']).'&view='.urlencode($row['view']).'">'.$row['name'].'</a></td>';
    if($row['rr_type'] == "SPF")
    {
	echo '<td>SPF (&amp; TXT)</td>';
    }
    else
    {
	echo '<td>'.$row['rr_type'].'</td>';
    }
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
?>
</table>

<?php
if($zoneRow['type'] == "forward")
{
    echo '<div class="tableTitle"><h3>MX Records</h3><a href="addRecord.php?zone='.$_GET['id'].'">&#43; Add Record</a></div>';
    echo '<table class="minorTableWide">'."\n";
    echo '<tr><th>Name</th><th>Pref</th><th>Points To/Value</th><th>View</th><th>ttl</th></tr>'."\n";
    $query = "SELECT * FROM mx_records WHERE zone_id=".$zoneRow['zone_id']." ORDER BY view,name,pref;";
    $result = mysql_query($query) or dberror($query, mysql_error());
    while($row = mysql_fetch_assoc($result))
    {
	echo '<tr>';
	echo '<td><a href="editRecord.php?zone='.$zoneRow['zone_id'].'&name='.urlencode($row['name']).'&pref='.$row['pref'].'&mxname='.urlencode($row['mx_name']).'">'.$row['name'].'</a></td>';
	echo '<td>'.$row['pref'].'</td>';
	echo '<td>'.$row['mx_name'].'</td>';
	echo '<td>'.$row['view'].'</td>';
	echo '<td>'.$row['ttl'].'</td>';
	echo '</tr>'."\n";
    }
    echo '</table>'."\n";
}
else
{
    // reverse zone
    echo '<div class="tableTitle"><h3>PTR Records</h3></div>';
    $PTRs = getPTRarray($zoneRow['zone_id']);

    echo '<table class="minorTableWide">'."\n";
    echo '<tr><th>Address</th><th>Type</th><th>Points To</th><th>View</th><th>ttl</th><th>Zone</th></tr>'."\n";
    foreach($PTRs as $arr)
    {
	echo '<tr>';
	echo '<td>'.$arr['value_host'].'</td>';
	echo '<td>PTR</td>';
	echo '<td>'.$arr['name'].'</td>';
	echo '<td>'.$arr['view'].'</td>';
	echo '<td>'.$arr['ttl'].'</td>';
	echo '<td>'.$arr['zoneName'].'</td>';
	echo '</tr>'."\n";
    }
    echo '</table>'."\n";
}
echo "<br />";
?>

</div> <!-- close content div -->

<?php printFooter(); ?>

</body>

</html>
