<?php
// rrFormPart.php
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

function editMxForm($name, $ttl, $pref, $value)
{
    global  $config_default_rr_ttl;
	echo '<div><label for="name">Name: </label><input type="text" size="30" name="name" id="name" value="'.$name.'" /> <em>(should be domain name)</em></div>'."\n";
	echo '<div><label for="ttl">TTL: </label><input type="text" size="10" name="ttl" id="ttl" value="'.$ttl.'" /> <em>( default '.$config_default_rr_ttl.')</em></div>'."\n";
	echo '<div><label for="pref">Pref: </label><input type="text" size="16" name="pref" id="pref" value="'.$pref.'" /> <em>(integer value 0 to 65535)</em></div>'."\n";
	echo '<div><label for="value">Points To: </label><input type="text" size="30" name="value" id="value" value="'.$value.'" /> <em>(should be an A record)</em></div>'."\n";
}

function editForm($type, $name, $ttl, $value, $value2, $mac_addr)
{
    global  $config_default_rr_ttl;
    if($type == "A")
    {
	echo '<div><label for="name">Name: </label><input type="text" size="30" name="name" id="name" value="'.$name.'" /></div>'."\n";
	echo '<div><label for="ttl">TTL: </label><input type="text" size="10" name="ttl" id="ttl" value="'.$ttl.'"  /> <em>( default '.$config_default_rr_ttl.')</em></div>'."\n";
	echo '<div><label for="value">Inside IP: </label><input type="text" size="16" name="value" id="value" value="'.$value.'" /> <em>(inside or both if not specified differently below)</em></div>'."\n";
	echo '<div><label for="value2">Outside IP: </label><input type="text" size="16" name="value2" id="value2" value="'.$value2.'" /> <em>(outside)</em></div>'."\n";
	echo '<div><label for="mac_addr">MAC Address for DHCP: </label><input type="text" size="18" name="mac_addr" id="mac_addr" value="'.$mac_addr.'" /></div>'."\n";
    }
    elseif($type == "CNAME")
    {
	echo '<div><label for="name">Name: </label><input type="text" size="30" name="name" id="name" value="'.$name.'" /></div>'."\n";
	echo '<div><label for="ttl">TTL: </label><input type="text" size="10" name="ttl" id="ttl" value="'.$ttl.'" /> <em>( default '.$config_default_rr_ttl.')</em></div>'."\n";
	echo '<div><label for="value">Points To: </label><input type="text" size="30" name="value" id="value" value="'.$value.'" /></div>'."\n";
    }
    elseif($type == "NS")
    {
	echo '<div><label for="name">Name: </label><input type="text" size="30" name="name" id="name" value="'.$name.'"  /> <em>(should be domain name)</em></div>'."\n";
	echo '<div><label for="ttl">TTL: </label><input type="text" size="10" name="ttl" id="ttl" value="'.$ttl.'" /> <em>( default '.$config_default_rr_ttl.')</em></div>'."\n";
	echo '<div><label for="value">Name-server: </label><input type="text" size="30" name="value" id="value" value="'.$value.'" /></div>'."\n";
    }
    elseif($type == "PTR")
    {
	echo '<div><label for="ip">IP: </label><input type="text" size="16" name="ip" id="ip" value="'.$name.'" /> <em>(should be last octet only)</em></div>'."\n";
	echo '<div><label for="ttl">TTL: </label><input type="text" size="10" name="ttl" id="ttl" value="'.$ttl.'" /> <em>( default '.$config_default_rr_ttl.')</em></div>'."\n";
	echo '<div><label for="name">Name: </label><input type="text" size="30" name="name" id="name" value="'.$value.'" /> <em>Should be A name ending in ".".</em></div>'."\n";
    }
    elseif($type == "TXT")
    {
	echo '<div><label for="name">Name: </label><input type="text" size="30" name="name" id="name" value="'.$name.'" /></div>'."\n";
	echo '<div><label for="ttl">TTL: </label><input type="text" size="10" name="ttl" id="ttl" value="'.$ttl.'" /> <em>( default '.$config_default_rr_ttl.')</em></div>'."\n";
	$value = str_replace('"', '&quot;', $value);
	echo '<div><label for="value">Text: </label><input type="text" size="40" name="value" id="value" value="'.$value.'" /></div>'."\n";
    }
    elseif($type == "SPF")
    {
	echo '<div><label for="name">Name: </label><input type="text" size="30" name="name" id="name" value="'.$name.'" /></div>'."\n";
	echo '<div><label for="ttl">TTL: </label><input type="text" size="10" name="ttl" id="ttl" value="'.$ttl.'" /> <em>( default '.$config_default_rr_ttl.')</em></div>'."\n";
	$value = str_replace('"', '&quot;', $value);
	echo '<div><label for="value">Text: </label><input type="text" size="40" name="value" id="value" value="'.$value.'" /></div>'."\n";
    }
    else
    {
	echo "&nbsp;";
    }
}

function addForm($type)
{
    global $config_default_rr_ttl;

    if($type == "A")
    {
	echo '<div><label for="name">Name: </label><input type="text" size="30" name="name" id="name" /></div>'."\n";
	echo '<div><label for="ttl">TTL: </label><input type="text" size="10" name="ttl" id="ttl" value="'.$config_default_rr_ttl.'" /> <em>( default '.$config_default_rr_ttl.')</em></div>'."\n";
	echo '<div><label for="value">Inside IP: </label><input type="text" size="16" name="value" id="value" /> <em>(inside or both if not specified differently below)</em></div>'."\n";
	echo '<div><label for="value2">Outside IP: </label><input type="text" size="16" name="value2" id="value2" /> <em>(outside)</em></div>'."\n";
	echo '<div><label for="mac_addr">MAC Address for DHCP: </label><input type="text" size="18" name="mac_addr" id="mac_addr" /></div>'."\n";
    }
    elseif($type == "CNAME")
    {
	echo '<div><label for="name">Name: </label><input type="text" size="30" name="name" id="name" /></div>'."\n";
	echo '<div><label for="ttl">TTL: </label><input type="text" size="10" name="ttl" id="ttl" value="'.$config_default_rr_ttl.'" /> <em>( default '.$config_default_rr_ttl.')</em></div>'."\n";
	echo '<div><label for="value">Points To: </label><input type="text" size="30" name="value" id="value" /></div>'."\n";
    }
    elseif($type == "MX")
    {
	echo '<div><label for="name">Name: </label><input type="text" size="30" name="name" id="name" value="@" /> <em>(should be domain name)</em></div>'."\n";
	echo '<div><label for="ttl">TTL: </label><input type="text" size="10" name="ttl" id="ttl" value="'.$config_default_rr_ttl.'" /> <em>( default '.$config_default_rr_ttl.')</em></div>'."\n";
	echo '<div><label for="pref">Pref: </label><input type="text" size="16" name="pref" id="pref" /> <em>(integer value 0 to 65535)</em></div>'."\n";
	echo '<div><label for="value">Points To: </label><input type="text" size="30" name="value" id="value" /> <em>(should be an A record)</em></div>'."\n";
    }
    elseif($type == "NS")
    {
	echo '<div><label for="name">Name: </label><input type="text" size="30" name="name" id="name" value="@" /> <em>(should be domain name)</em></div>'."\n";
	echo '<div><label for="ttl">TTL: </label><input type="text" size="10" name="ttl" id="ttl" value="'.$config_default_rr_ttl.'" /> <em>( default '.$config_default_rr_ttl.')</em></div>'."\n";
	echo '<div><label for="value">Name-server: </label><input type="text" size="30" name="value" id="value" /></div>'."\n";
    }
    elseif($type == "PTR")
    {
	echo '<div><label for="ip">IP: </label><input type="text" size="16" name="ip" id="ip" /> <em>(should be last octet only)</em></div>'."\n";
	echo '<div><label for="ttl">TTL: </label><input type="text" size="10" name="ttl" id="ttl" value="'.$config_default_rr_ttl.'" /> <em>( default '.$config_default_rr_ttl.')</em></div>'."\n";
	echo '<div><label for="name">Name: </label><input type="text" size="30" name="name" id="name" /> <em>Should be A name ending in ".".</em></div>'."\n";
    }
    elseif($type == "SRV")
    {
	echo '<div><label for="srvce">srvce: </label><input type="text" size="15" name="srvce" id="srvce" value="_" /> <em>Symbolic name for a service, preceded by an "_".</em></div>'."\n";
	echo '<div><label for="prot">prot: </label><select name="prot"><option value="_tcp">TCP</option><option value="_udp">UDP</option></select></div>'."\n";
	echo '<div><label for="name">Name: </label><input type="text" size="30" name="name" id="name" /> <em>(should be domain name, followed by a dot)</em></div>'."\n";
	echo '<div><label for="ttl">TTL: </label><input type="text" size="10" name="ttl" id="ttl" value="'.$config_default_rr_ttl.'" /> <em>( default '.$config_default_rr_ttl.')</em></div>'."\n";
	echo '<div><label for="pri">pri: </label><input type="text" size="16" name="pri" id="pri" /> <em>(integer value 0 to 65535)</em></div>'."\n";
	echo '<div><label for="weight">weight: </label><input type="text" size="16" name="weight" id="weight" /> <em>(integer value 0 to 65535)</em></div>'."\n";
	echo '<div><label for="port">port: </label><input type="text" size="16" name="port" id="port" /> <em>(port number)</em></div>'."\n";
	echo '<div><label for="target">target: </label><input type="text" size="40" name="target" id="target" /></div>'."\n";
    }
    elseif($type == "TXT")
    {
	echo '<div><label for="name">Name: </label><input type="text" size="30" name="name" id="name" /></div>'."\n";
	echo '<div><label for="ttl">TTL: </label><input type="text" size="10" name="ttl" id="ttl" value="'.$config_default_rr_ttl.'" /> <em>( default '.$config_default_rr_ttl.')</em></div>'."\n";
	echo '<div><label for="value">Text: </label><input type="text" size="40" name="value" id="value" /></div>'."\n";
    }
    elseif($type == "SPF")
    {
	echo '<div><label for="name">Name: </label><input type="text" size="30" name="name" id="name" /></div>'."\n";
	echo '<div><label for="ttl">TTL: </label><input type="text" size="10" name="ttl" id="ttl" value="'.$config_default_rr_ttl.'" /> <em>( default '.$config_default_rr_ttl.')</em></div>'."\n";
	echo '<div><label for="value">Text: </label><input type="text" size="40" name="value" id="value" value="&quot;v=spf1 &quot;" /></div>'."\n";
    }
    else
    {
	echo "&nbsp;";
    }
}
?>