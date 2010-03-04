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
require_once('inc/rrForm.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit RR - MultiBindAdmin</title>
<link rel="stylesheet" type="text/css" href="css/common.css" />
<link rel="stylesheet" type="text/css" href="css/nav.css" />
<script language="javascript" type="text/javascript" src="inc/forms.js"></script>
</head>

<body>
<?php
printHeader(); 

if(! isset($_GET['zone']))
{
    echo '<p class="error">ERROR: No zone ID specified.</p>';
    printFooter();
    die();
}
if(! isset($_GET['type']) && ! isset($_GET['mxname']))
{
    echo '<p class="error">ERROR: No RR type or MX name specified.</p>';
    printFooter();
    die();
}

$query = "SELECT z.zone_id,z.name,z.views FROM zones AS z WHERE z.zone_id=".((int)$_GET['zone']).";";
$result = mysql_query($query) or dberror($query, mysql_error());
if(mysql_num_rows($result) < 1)
{
    echo '<p class="error">ERROR: No zone found with ID '.$_GET['zone'].'</p>';
    printFooter();
    die();
}
$zoneRow = mysql_fetch_assoc($result);

?>

<div id="content">

<h2>Edit Record</h2>

<form name="editRecord" action="handlers/editRecord.php" method="post">

<?php
echo '<input type="hidden" name="zone_id" value="'.$zoneRow['zone_id'].'" />';
?>

<div><label for="zoneName">Zone: </label><span id="zoneName"><?php echo $zoneRow['name']." (".$zoneRow['zone_id'].")"; ?></span></div>

<?php
if(isset($_GET['mxname']))
{
    $query = "SELECT * FROM mx_records WHERE zone_id=".$zoneRow['zone_id']." AND pref=".((int)$_GET['pref'])." AND name='".mysql_real_escape_string($_GET['name'])."' AND mx_name='".mysql_real_escape_string($_GET['mxname'])."';";
    echo '<div id="rrType"><label for="rr_type">Type: </label><span id="rr_type">MX</span></div>';
    echo '<input type="hidden" name="orig_pref" value="'.((int)$_GET['pref']).'" />';
    echo '<input type="hidden" name="orig_name" value="'.mysql_real_escape_string($_GET['name']).'" />';
    echo '<input type="hidden" name="orig_mxname" value="'.mysql_real_escape_string($_GET['mxname']).'" />';
    echo '<input type="hidden" name="rr_type" value="MX" />';
}
else
{
    $query = "SELECT r.*,dh.mac_address FROM r_records AS r LEFT JOIN dhcp_hosts AS dh ON r.name=dh.rr_name AND r.value=dh.rr_value AND r.view=dh.rr_view WHERE zone_id=".$zoneRow['zone_id']." AND rr_type='".mysql_real_escape_string($_GET['type'])."' AND name='".mysql_real_escape_string($_GET['name'])."' AND value='".mysql_real_escape_string($_GET['value'])."' AND view='".mysql_real_escape_string($_GET['view'])."';";
    echo '<div id="rrType"><label for="rr_type">Type: </label><span id="rr_type">'.$_GET['type'].'</span></div>';
    echo '<input type="hidden" name="rr_type" value="'.$_GET['type'].'" />';
    echo '<input type="hidden" name="orig_name" value="'.$_GET['name'].'" />';
    echo '<input type="hidden" name="orig_value" value="'.str_replace('"', '&quot;', $_GET['value']).'" />';
    echo '<input type="hidden" name="orig_view" value="'.$_GET['view'].'" />';
}
$result = mysql_query($query) or dberror($query, mysql_error());
$row = mysql_fetch_assoc($result);

?>

<div>
<label>Views: </label>
<input type="radio" name="views" id="views_both" value="both"  <?php if($row['view'] == "both"){ echo 'checked="checked"';} ?> /><label>Both</label>
<input type="radio" name="views" id="views_in" value="inside"  <?php if($row['view'] == "inside"){ echo 'checked="checked"';} ?> /><label>Inside</label>
<input type="radio" name="views" id="views_out" value="outside"  <?php if($row['view'] == "outside"){ echo 'checked="checked"';} ?> /><label>Outside</label>
</div>

<div id="rr_form_fields">
<?php
if(isset($_GET['mxname']))
{
    editMxForm($row['name'], $row['ttl'], $row['pref'], $row['mx_name']);
}
else
{
    editForm($_GET['type'], $row['name'], $row['ttl'], $row['value'], $row['value2'], $row['mac_address']);
}
?>

</div>

<div><input type="submit" name="Submit" value="Update RR" /></div>
<br /><br /><br /><br />
<div><input type="submit" name="Submit" value="DELETE RR" /></div>
</form>

</div> <!-- close content div -->

<?php printFooter(); ?>

</body>

</html>
