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
<title>Add Zone - MultiBindAdmin</title>
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

<h2>Add Record to Zone <?php echo $zoneRow['name']." (".$zoneRow['zone_id'].")"; ?></h2>

<form name="addRecord" action="handlers/addRecord.php" method="post">

<?php
echo '<input type="hidden" name="zone_id" value="'.$zoneRow['zone_id'].'" />';
?>

<div id="rrType">
<label for="rr_type">Type: </label>
<select name="rr_type" id="rr_type" onchange="updateRRform()">
<option value="" selected="selected">&nbsp;</option>
<option value="A">A</option>
<option value="CNAME">CNAME</option>
<option value="MX">MX</option>
<option value="NS">NS</option>
<option value="PTR">PTR</option>
<option value="SRV">SRV</option>
<option value="TXT">TXT</option>
</select>
</div> <!-- close rrType div -->
<div>
<label>Views: </label>
<input type="radio" name="views" id="views_both" value="both" onclick="viewChange()" checked="checked" /><label>Both</label>
<input type="radio" name="views" id="views_in" value="inside" onclick="viewChange()" /><label>Inside</label>
<input type="radio" name="views" id="views_out" value="outside" onclick="viewChange()" /><label>Outside</label>
</div>

<!-- this div is filled in via the updateRRform() JS function -->
<!-- the form fields are pulled via rrFormPart.php -->
<div id="rr_form_fields"></div>

<div>
<input type="submit" name="Submit" value="Add RR" /></div>
</form>

</div> <!-- close content div -->

<?php printFooter(); ?>

</body>

</html>
