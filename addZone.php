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
<?php printHeader(); ?>

<div id="content">

<h2>Add Zone</h2>

<form name="addZone" action="handlers/addZone.php" method="post">

<div><label for="name">Name: </label><input type="text" size="30" name="name" id="name" /></div>
<div>
<label>Views: </label>
<input type="radio" name="views" id="views_both" value="both" onclick="viewChange()" checked="checked" /><label>Both</label>
<input type="radio" name="views" id="views_in" value="inside" onclick="viewChange()" /><label>Inside</label>
<input type="radio" name="views" id="views_out" value="outside" onclick="viewChange()" /><label>Outside</label>
</div>
<div id="insideProviderDiv">
<label for="insideProviderId">Inside Provider: </label>
<select name="insideProviderId" id="insideProviderId">
<option value="">&nbsp;</option>
<?php
$query = "SELECT * FROM providers;";
$result = mysql_query($query) or dberror($query, mysql_error());
while($row = mysql_fetch_assoc($result))
{
    if($row['default_for'] == "inside")
    {
	echo '<option value="'.$row['provider_id'].'" selected="selected">'.$row['provider_name'].'</option>'."\n";
    }
    else
    {
	echo '<option value="'.$row['provider_id'].'">'.$row['provider_name'].'</option>'."\n";
    }
}
?>
</select>
</div> <!-- close insideProvider div -->

<div id="outsideProviderDiv">
<label for="outsideProviderId">Outside Provider: </label>
<select name="outsideProviderId" id="outsideProviderId">
<option value="">&nbsp;</option>
<?php
$query = "SELECT * FROM providers;";
$result = mysql_query($query) or dberror($query, mysql_error());
while($row = mysql_fetch_assoc($result))
{
    if($row['default_for'] == "outside")
    {
	echo '<option value="'.$row['provider_id'].'" selected="selected">'.$row['provider_name'].'</option>'."\n";
    }
    else
    {
	echo '<option value="'.$row['provider_id'].'">'.$row['provider_name'].'</option>'."\n";
    }
}
?>
</select>
</div> <!-- close outsideProvider div -->

<div><label for="ttl">Ttl: </label><input type="text" size="10" name="ttl" id="ttl" value="3600" /></div>
<div><label for="origin">Origin: </label><input type="text" size="30" name="origin" id="origin" /> <em>(if different from name)</em></div>

<div><input type="submit" name="Submit" value="Add Zone" /></div>
</form>

</div> <!-- close content div -->

<?php printFooter(); ?>

</body>

</html>
