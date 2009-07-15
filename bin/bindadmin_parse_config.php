#!/usr/bin/php
<?php
// script to parse existing BIND config files into database
require_once('inc/parseBIND.php.inc');
require_once('config/config.php');

$argA = array();
array_shift($argv);
foreach($argv as $val)
{
    if(strpos($val, "="))
    {
	$foo = explode("=", $val);
	$foo[0] = trim($foo[0], "-= ");
	$argA[$foo[0]] = $foo[1];
    }
    else
    {
	$argA[trim($val, "-= ")] = null;
    }
}

if(! isset($argA["view"]) || ! isset($argA["provider"]) || ! isset($argA["file"]) || isset($argA["help"]) || isset($argA["h"]) || ($argA["view"] != "inside" && $argA['view'] != "outside"))
{
    usage();
    die();
}

$contents = file_get_contents($argA['file']);

parse_bind_config($contents, $argA["view"], $argA["provider"]);

function usage()
{
    echo "bindadmin_parse_config - script to parse existing BIND config.\n";
    echo " USAGE: \n";
    echo "bindadmin_parse_config --view=(inside|outside) --provider=ProviderName --file=Path/To/File\n";
}

?>