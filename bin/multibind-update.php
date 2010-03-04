#!/usr/bin/php
<?php
// multibind-update.php
//
// script to update local zone files from MultiBIND Admin
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

// CONFIGURATION
$config_base_url = "https://web1.jasonantman.com/admin/multibindadmin/";
$config_inside_path = "/var/lib/named/master/internal/";
$config_outside_path = "/var/lib/named/master/external/";
$config_temp_location = "/tmp/multibind/"; // location for temporary files
// END CONFIGURATION - do not edit anything below this line

$foo = file_get_contents($config_base_url."pulldns.php");
$foo = explode("\n", $foo);

$zones = array();
foreach($foo as $num => $line)
{
  if(substr($line, 0, 1) == "#"){ continue;}
  if(trim($line) == ""){ continue; }
  if(substr($line, 0, 1) == "!") { die("Line ".$num.": ERROR: ".substr($line, 1)."\nDieing...\n");}
  
  $parts = explode("\t", $line);
  $bar = array();
  if($parts[1] != "NONE"){ $bar['inside'] = $parts[1];}
  if($parts[2] != "NONE"){ $bar['outside'] = $parts[2];}

  if(count($bar) > 0){ $zones[$parts[0]] = $bar;}

}

if(! is_dir($config_temp_location)) { mkdir($config_temp_location);}
if(! is_dir($config_temp_location."inside/")) { mkdir($config_temp_location."inside/");}
if(! is_dir($config_temp_location."outside/")) { mkdir($config_temp_location."outside/");}

foreach($zones as $name => $arr)
{
  foreach($arr as $view => $url)
    {
      // TODO - replace this!
      $fullURL = $config_base_url.$url;
      if($view == "inside"){ $path = $config_temp_location."inside/".$name.".zone"; } else { $path = $config_temp_location."outside/".$name.".zone"; }
      $cmd = 'curl -q --user-agent "multiBIND update 1.0" --insecure -o '.$path.' '.escapeshellarg($fullURL).' 2>/dev/null';
      $output = exec($cmd); // run the command
      if(! file_exists($path)){ die("ERROR: Unable to download ".$fullURL." to path: ".$path."\n");}
      
      // got the file, copy it in if not already there.
      if($view == "inside"){ $final_path = $config_inside_path;} else {$final_path = $config_outside_path; }
      $final_path .= $name.".zone";

      if(! file_exists($final_path))
	{
	  echo $name." (".$view.") - ".$final_path." not present. Copying new zone file.\n";
	  copy($path, $final_path);
	  if(! file_exists($final_path)){ echo "ERROR: could not copy to ".$final_path.".\n";}
	}
      else
	{
	  if(files_differ($path, $final_path))
	    {
	      copy($final_path, $final_path.".bak");
	      if(! file_exists($final_path.".bak")){ echo "ERROR: Unable to make backup copy of differing file: ".$final_path."\n"; continue;}
	      copy($path, $final_path);
	      echo $name." (".$view.") - Made backup copy, updated zone file.\n";
	    }
	}

    }
}

function files_differ($file1, $file2)
{
  $foo = array();
  $bar = -1;
  exec("diff ".escapeshellarg($file1)." ".escapeshellarg($file2), $foo, $bar);
  if($bar !=0){ return true;}
  return false;
}

?>