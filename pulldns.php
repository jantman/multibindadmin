<?php
// pulldns.php
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

$view = "both";

require_once('inc/bindConfig.php');

if(! in_array($_SERVER["REMOTE_ADDR"], $config_allow_dnspull))
{
    die("! ".$_SERVER["REMOTE_ADDR"]." not allowed to pull DNS.\n");
}

echo "#zoneName\tinside\toutside\ttype\n";
echo "#inside or outside is a URL or 'NONE'\n";
echo "#type is forward or reverse\n";

$query = "SELECT zone_id,name,views,type FROM zones ORDER BY name;";
$result = mysql_query($query);
while($row = mysql_fetch_assoc($result))
{
    echo $row['name']."\t";

    if($row['views'] == "inside" | $row['views'] == "both")
    {
	echo "download.php?zone=".$row['zone_id']."&view=inside\t";
    }
    else
    {
	echo "NONE\t";
    }

    if($row['views'] == "outside" | $row['views'] == "both")
    {
	echo "download.php?zone=".$row['zone_id']."&view=outside";
    }
    else
    {
	echo "NONE";
    }
    echo "\t".$row['type'];
    echo "\n";
}

?>