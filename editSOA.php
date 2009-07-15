<?php
// editSOA.php
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
<title>Edit SOA - MultiBindAdmin</title>
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

if(! isset($_GET['type'])) { echo '<p class="error">ERROR: No type specified.</p>'; printFooter(); die(); }
$type = $_GET['type'];

$query = "SELECT z.zone_id,z.name,z.views,z.last_update_ts,z.insert_ts,p.provider_name AS insideProvider,p2.provider_name AS outsideProvider FROM zones AS z LEFT JOIN providers AS p ON z.inside_provider_id=p.provider_id LEFT JOIN providers AS p2 ON z.outside_provider_id=p2.provider_id WHERE z.zone_id=".((int)$_GET['id']).";";
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

<?php 
echo '<h2>Edit SOA - Zone '.$zoneRow['zone_id'].' - '.$zoneRow['name'].' - '.$type.'</h2>'."\n";

$query = "SELECT * FROM soa_records WHERE zone_id=".$zoneRow['zone_id']." AND view='".mysql_real_escape_string($type)."';";
$result = mysql_query($query) or dberror($query, mysql_error());
if(mysql_num_rows($result) < 1)
{
    $query = "SELECT * FROM soa_records WHERE zone_id=0 AND view='".mysql_real_escape_string($type)."';";
    $result = mysql_query($query) or dberror($query, mysql_error());
    echo '<p><strong>NOTICE:</strong> No SOA record found for this zone in this view. Populating with values from default '.$type.' SOA record.</p>'."\n";
}

echo '<form name="editSOA" action="handlers/editSOA.php" method="post">'."\n";
echo '<input type="hidden" name="zone_id" value="'.$zoneRow['zone_id'].'" />'."\n";
echo '<input type="hidden" name="view" value="'.$type.'" />'."\n";

echo '<table class="minorTable">'."\n";

$row = mysql_fetch_assoc($result);
echo '<tr><th>ID</th><td>'.$row['soa_id'].'</td></tr>'."\n";
echo '<tr><th>serial</th><td>'.$row['current_serial'].'</td></tr>'."\n";
echo '<tr><th>ttl</th><td><input type="text" name="ttl" size="10" value="'.$row['ttl'].'" /></td></tr>'."\n";
echo '<tr><th>Class</th><td><input type="text" size="10" name="class" value="'.$row['class'].'" /></td></tr>'."\n";
echo '<tr><th>name-server</th><td><input type="text" size="40" name="name-server" value="'.$row['name_server'].'" /></td></tr>'."\n";
echo '<tr><th>email-addr</th><td><input type="text" size="40" name="email-addr" value="'.$row['email_addr'].'" /></td></tr>'."\n";
echo '<tr><th>refresh</th><td><input type="text" size="10" name="refresh" value="'.$row['refresh'].'" /></td></tr>'."\n";
echo '<tr><th>retry</th><td><input type="text" size="10" name="retry" value="'.$row['retry'].'" /></td></tr>'."\n";
echo '<tr><th>expiry</th><td><input type="text" size="10" name="expiry" value="'.$row['expiry'].'" /></td></tr>'."\n";
echo '<tr><th>minimum</th><td><input type="text" size="10" name="minimum" value="'.$row['minimum'].'" /></td></tr>'."\n";
echo '<tr><th>Created</th><td>'.date($config_long_date_format, $row['insert_ts']).'</td></tr>'."\n";
echo '<tr><th>Modified</th><td>'.date($config_long_date_format, $row['last_update_ts']).'</td></tr>'."\n";

?>
</table>

<div>
<input type="submit" name="submit" value="Update Record" />
</div>

</form>

</div> <!-- close content div -->

<?php printFooter(); ?>

</body>

</html>
