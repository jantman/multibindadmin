<?php
// inc/bindConfig.php - BIND zone file reading and writing
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

function makeZoneFile($zone_id, $view)
{
    $str = "; BIND zone data generated by MultiBIND Admin on ".trim(shell_exec('hostname'))."\n";
    $str .= ";\tat ".date("Y-m-d H:i:s")."\n";
    $str .= "; \n; WARNING WARNING WARNING WARNING WARNING\n";
    $str .= "; this file was generated from a database.\n; any changes made by hand WILL BE LOST.\n";
    $str .= ";MultiBINDAdmin zone_id=$zone_id view=$view\n";
    $str .= "; \n\n";

    $query = "SELECT * FROM zones WHERE zone_id=".$zone_id." AND (views='".$view."' OR views='both');";
    $result = mysql_query($query) or dberror($query, mysql_error());
    while($row = mysql_fetch_assoc($result))
    {
	if(isset($row['ttl']))
	{
	    $str .= '$TTL '.$row['ttl']."\n";
	}
	if(isset($row['origin']) && trim($row['origin']) != "")
	{
	    $str .= '$ORIGIN '.$row['origin']."\n";
	}
    }

    $query = "SELECT * FROM soa_records WHERE zone_id=".$zone_id." AND (view='".$view."' OR view='both');";
    $result = mysql_query($query) or dberror($query, mysql_error());
    while($row = mysql_fetch_assoc($result))
    {
	$str .= "@\tIN\tSOA\t".$row['name_server']."\t".$row['email_addr']." (\n";
	$str .= "\t\t\t".$row['current_serial']." ; serial\n";
	$str .= "\t\t\t".$row['refresh']."\n";
	$str .= "\t\t\t".$row['retry']."\n";
	$str .= "\t\t\t".$row['expiry']."\n";
	$str .= "\t\t\t".$row['minimum'].")\n\n";
    }

    $str .= "; NS records\n";
    $query = "SELECT name,ttl,class,value FROM r_records WHERE rr_type='NS' AND zone_id=".$zone_id." AND (view='".$view."' OR view='both');";
    $result = mysql_query($query) or dberror($query, mysql_error());
    while($row = mysql_fetch_assoc($result))
    {
	if($row['class'] == null || $row['class'] == ""){ $row['class'] = "IN";}
	$str .= $row['name']."\t".$row['ttl']."\t".$row['class']."\t"."NS"."\t".$row['value']."\n";
    }

    $str .= "\n\n; MX records\n";
    $query = "SELECT name,ttl,class,pref,mx_name FROM mx_records WHERE zone_id=".$zone_id." AND (view='".$view."' OR view='both');";
    $result = mysql_query($query) or dberror($query, mysql_error());
    while($row = mysql_fetch_assoc($result))
    {
	if($row['class'] == null || $row['class'] == ""){ $row['class'] = "IN";}
	$str .= $row['name']."\t".$row['ttl']."\t".$row['class']."\t"."MX"."\t".$row['pref']."\t".$row['mx_name']."\n";
    }

    $str .= "\n\n; A records\n";
    $query = "SELECT name,ttl,class,value,value2 FROM r_records WHERE rr_type='A' AND zone_id=".$zone_id." AND (view='".$view."' OR view='both');";
    $result = mysql_query($query) or dberror($query, mysql_error());
    while($row = mysql_fetch_assoc($result))
    {
	if($row['class'] == null || $row['class'] == ""){ $row['class'] = "IN";}
	$val = "";
	if($view == "outside" && $row['value2'] != null){ $val = $row['value2'];} else { $val = $row['value'];}
	$str .= $row['name']."\t".$row['ttl']."\t".$row['class']."\t"."A"."\t".$val."\n";
    }

    $str .= "\n\n; CNAMEs\n";
    $query = "SELECT name,ttl,class,value FROM r_records WHERE rr_type='CNAME' AND zone_id=".$zone_id." AND (view='".$view."' OR view='both');";
    $result = mysql_query($query) or dberror($query, mysql_error());
    while($row = mysql_fetch_assoc($result))
    {
	if($row['class'] == null || $row['class'] == ""){ $row['class'] = "IN";}
	$str .= $row['name']."\t".$row['ttl']."\t".$row['class']."\t"."CNAME"."\t".$row['value']."\n";
    }

    $str .= "\n\n; TXT records\n";
    $query = "SELECT name,ttl,class,value FROM r_records WHERE rr_type='TXT' AND zone_id=".$zone_id." AND (view='".$view."' OR view='both');";
    $result = mysql_query($query) or dberror($query, mysql_error());
    while($row = mysql_fetch_assoc($result))
    {
	if($row['class'] == null || $row['class'] == ""){ $row['class'] = "IN";}
	$str .= $row['name']."\t".$row['ttl']."\t".$row['class']."\t"."TXT"."\t".$row['value']."\n";
    }

    $str .= "\n\n; PTR records\n";
    $query = "SELECT name,ttl,class,ptr_address FROM ptr_records WHERE zone_id=".$zone_id." AND (view='".$view."' OR view='both');";
    $result = mysql_query($query) or dberror($query, mysql_error());
    while($row = mysql_fetch_assoc($result))
    {
	if($row['class'] == null || $row['class'] == ""){ $row['class'] = "IN";}
	$str .= $row['ptr_address']."\t".$row['ttl']."\t".$row['class']."\t"."PTR"."\t".$row['name']."\n";
    }

    $str .= "\n;\n;END MultiBIND Admin output\n;\n";

    return $str;
}



?>