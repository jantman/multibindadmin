<?php
// addNetwork.php
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
<title>Add Network - MultiBindAdmin</title>
<link rel="stylesheet" type="text/css" href="css/common.css" />
<link rel="stylesheet" type="text/css" href="css/nav.css" />
<script language="javascript" type="text/javascript" src="inc/forms.js"></script>
</head>

<body>
<?php printHeader(); ?>

<div id="content">

<h2>Add Network</h2>

<form name="addNetwork" action="handlers/addNetwork.php" method="post">

<div><label for="name">Name: </label><input type="text" size="30" name="name" id="name" /><em> (descriptive)</em></div>
<div>
<label>Views: </label>
<input type="radio" name="views" id="views_both" value="both" onclick="viewChange()" checked="checked" /><label>Both</label>
<input type="radio" name="views" id="views_in" value="inside" onclick="viewChange()" /><label>Inside</label>
<input type="radio" name="views" id="views_out" value="outside" onclick="viewChange()" /><label>Outside</label>
</div>

<div><label for="firstThree">First Three Octets: </label><input type="text" size="12" name="firstThree" id="firstThree" /> <em>(i.e. xxx.xxx.xxx)</em></div>

<div><label for="start_ip">Starting IP: </label><input type="text" size="3" name="start_ip" id="start_ip" /> <em>(last octet of network address)</em></div>

<div><label for="netmask_cidr">CIDR Netmask: </label><input type="text" size="3" name="netmask_cidr" id="netmask_cidr" /></div>

<div><a href="javascript:updateIPstuff()">Update Values</a></div>

<div><label for="end_ip">Ending IP: </label><input type="text" size="3" name="end_ip" id="end_ip" /> <em>(last octet)</em></div>

<div><label for="vlan_number">VLAN Number: </label><input type="text" size="4" name="vlan_number" id="vlan_number" /></div>

<div><label for="authoritative">Authoritative: </label><input type="checkbox" name="authoritative" id="authoritative" checked="checked"/></div>

<div><label for="allow_unknown">Allow Unknown Clients: </label><input type="checkbox" name="allow_unknown" id="allow_unknown" checked="checked"/></div>

<div><label for="ddns_update">Allow DDNS Updates: </label><input type="checkbox" name="ddns_update" id="ddns_update" checked="checked"/></div>

<div><label for="pool_start">Pool Start: </label><input type="text" size="15" name="pool_start" id="pool_start" /> <label for="pool_end">End: </label><input type="text" size="15" name="pool_end" id="pool_end" /></div>

<h3>Options</h3>

<div><label for="option_log_server">Log Server: </label><input type="text" size="15" name="option_log_server" id="option_log_server" /></div>

<div><label for="option_time_server">Time Server: </label><input type="text" size="15" name="option_time_server" id="option_time_server" /></div>

<div><label for="option_dns_server">DNS Server: </label><input type="text" size="15" name="option_dns_server" id="option_dns_server" /></div>

<div><label for="option_domain_name">Domain Name: </label><input type="text" size="15" name="option_domain_name" id="option_domain_name" value="jasonantman.com" /></div>

<div><label for="option_broadcast_address">Broadcast Address: </label><input type="text" size="15" name="option_broadcast_address" id="option_broadcast_address" /></div>

<div><label for="option_subnet_mask">Subnet Mask: </label><input type="text" size="15" name="option_subnet_mask" id="option_subnet_mask" /></div>

<div><label for="option_routers">Routers: </label><input type="text" size="15" name="option_routers" id="option_routers" /></div>

<div><input type="submit" name="Submit" value="Add Network" /></div>

</form>

</div> <!-- close content div -->

<?php printFooter(); ?>

</body>

</html>
