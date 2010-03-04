<?php
// download.php
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

if($_GET['view'] == "inside"){ $view = "inside";} elseif($_GET['view'] == "outside") {$view = "outside";} else {$view == "both";}

require_once('inc/bindConfig.php');

if(isset($_GET['zone']))
{
    $zone = ((int)$_GET['zone']);
    if(isset($_GET['nodl']))
    {
	echo '<pre>';
	echo makeZoneFile($zone, $view);
	echo '</pre>';
    }
    else
    {
	$output = makeZoneFile($zone, $view);
	// output the CSV and force download
	header ( "Content-Type: application/force-download" );
	header ( "Content-Type: application/octet-stream" );
	header ( "Content-Type: application/download" );
	header ( "Content-Type: text/plain" );
	header ( "Content-Disposition: attachment; filename=".makeZoneFileName($zone, $view));
	header ( "Content-Transfer-Encoding: binary" );
	header ( "Accept-Ranges: bytes" );
	header ( "Content-Length: ".strlen ( $output ) );
	echo $output;
    }
}
else
{
    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
    echo '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
    echo '<head>'."\n";
    echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />'."\n";
    echo '<title>Download - MultiBindAdmin</title>'."\n";
    echo '<link rel="stylesheet" type="text/css" href="css/common.css" />'."\n";
    echo '<link rel="stylesheet" type="text/css" href="css/nav.css" />'."\n";
    echo '</head>'."\n";
    echo '<body>'."\n";
    printHeader();
    echo '<div id="content">'."\n";
    echo '<h2>Download Zone Files</h2>'."\n";

    echo '<table class="mainTable">'."\n";
    echo '<tr><th>ID</th><th>Name</th><th>Inside</th><th>Outside</th></tr>'."\n";
    $query = "SELECT zone_id,name,views FROM zones ORDER BY name;";
    $result = mysql_query($query);
    while($row = mysql_fetch_assoc($result))
    {
	echo '<tr>'."\n";
	echo '<td>'.$row['zone_id'].'</td>';
	echo '<td><a href="zone.php?id='.$row['zone_id'].'">'.$row['name'].'</a></td>';
	if($row['views'] == "both")
	{
	    echo '<td><a href="download.php?view=inside&zone='.$row['zone_id'].'">Download</a>   <a href="download.php?view=inside&zone='.$row['zone_id'].'&nodl=true">View</a></td>';
	    echo '<td><a href="download.php?view=outside&zone='.$row['zone_id'].'">Download</a>   <a href="download.php?view=outside&zone='.$row['zone_id'].'&nodl=true">View</a></td>';
	}
	elseif($row['views'] == "inside")
	{
	    echo '<td><a href="download.php?view=inside&zone='.$row['zone_id'].'">Download</a>   <a href="download.php?view=inside&zone='.$row['zone_id'].'&nodl=true">View</a></td>';
	    echo '<td>&nbsp;</td>';
	}
	else
	{
	    echo '<td>&nbsp;</td>';
	    echo '<td><a href="download.php?view=outside&zone='.$row['zone_id'].'">Download</a>   <a href="download.php?view=outside&zone='.$row['zone_id'].'&nodl=true">View</a></td>';
	}
	echo '</tr>'."\n";
    }
    echo '</table>'."\n";

    echo '</div>'."\n";
    printFooter();
    echo '</body>'."\n";
    echo '</html>'."\n";
}

?>