<?php


// function takes BIND config file as a string and parses it
function parse_bind_config($configString, $view, $provider)
{
    $lines = explode("\n", $configString);
    $inSOA = false;
    $soa = "";
    $ttl = "";

    foreach($lines as $lineNum => $line)
    {
	$line = trim($line);
	if(strpos($line, ";"))
	{
	    $line = substr($line, 0, strpos($line, ";"));
	    $line = trim($line);
	}
	if($line == ""){ continue;}

	if(substr($line, 0, 5) == '$ttl '){ $ttl = trim(substr($line, 5)); echo "TTL=$ttl\n";}
	
	if(substr($line, 0, 1) == "$") { continue; }

	// SOA stuff
	if(strpos($line, "SOA") && strpos($line, "(") && !strpos($line, ")"))
	{
	    $soa .= " ".$line;
	    $inSOA = true;
	    continue;
	}
	elseif($inSOA && ! strpos($line, ")"))
	{
	    $soa .= " ".$line;
	    continue;
	}
	elseif($inSOA && strpos($line, ")"))
	{
	    $soa .= " ".$line;
	    $inSOA = false;
	    handleSOA($soa, $view, $provider, $lineNum);
	    continue;
	}

	// other records
	$parts = explode("\t", $line);
	$parts = normalize_array($parts);

	if($parts[2] == "A" || $parts[3] == "A"){ handleArec($parts, $view, $provider, $lineNum);}
	elseif($parts[2] == "CNAME" || $parts[3] == "CNAME"){ handleCNAMErec($parts, $view, $provider, $lineNum);}
	elseif($parts[2] == "MX" || $parts[3] == "MX"){ handleMXrec($parts, $view, $provider, $lineNum);}
	elseif($parts[2] == "NS" || $parts[3] == "NS"){ handleNSrec($parts, $view, $provider, $lineNum);}
	elseif($parts[2] == "PTR" || $parts[3] == "PTR"){ handlePTRrec($parts, $view, $provider, $lineNum);}
	elseif($parts[2] == "SRV" || $parts[3] == "SRV"){ handleSRVrec($parts, $view, $provider, $lineNum);}
	elseif($parts[2] == "TXT" || $parts[3] == "TXT"){ handleTXTrec($parts, $view, $provider, $lineNum);}

    }
}

function handleArec($arr, $view, $provider, $lineNum)
{
    if($arr[1] == "IN" && $arr[2] == "A")
    {
	$query = "DELETE FROM tbl WHERE ='".mysql_real_escape_string($arr[0])."';";
	// HANDLE A: 0=LRdell.jasonantman.com. 1=IN 2=A 3=192.168.0.67

    }
    else
    {
	echo "Problem with A record on Line ".$lineNum."\n\t";
	echo var_dump($arr)."\n";
    }
}

function handleCNAMErec($arr, $view, $provider, $lineNum)
{
    echo "HANDLE CNAME: ";
    foreach($arr as $key => $val){ echo $key."=".$val." ";}
    echo "\n";
}

function handleMXrec($arr, $view, $provider, $lineNum)
{
    echo "HANDLE MX: ";
    foreach($arr as $key => $val){ echo $key."=".$val." ";}
    echo "\n";
}

function handleNSrec($arr, $view, $provider, $lineNum)
{
    echo "HANDLE NS: ";
    foreach($arr as $key => $val){ echo $key."=".$val." ";}
    echo "\n";
}

function handlePTRrec($arr, $view, $provider, $lineNum)
{
    echo "HANDLE PTR: ";
    foreach($arr as $key => $val){ echo $key."=".$val." ";}
    echo "\n";
}

function handleSRVrec($arr, $view, $provider, $lineNum)
{
    echo "HANDLE SRV: ";
    foreach($arr as $key => $val){ echo $key."=".$val." ";}
    echo "\n";
}

function handleTXTrec($arr, $view, $provider, $lineNum)
{
    echo "HANDLE TXT: ";
    foreach($arr as $key => $val){ echo $key."=".$val." ";}
    echo "\n";
}

function handleSOA($line, $view, $provider, $lineNum)
{
    // DEBUG
    echo "Handle SOA:\n";
    echo $line."\n";
    // END DEBUG
}

function normalize_array($arr)
{
    $ret = array();
    foreach($arr as $val)
    {
	if(trim($val) != ""){ $ret[] = $val;}
    }
    return $ret;
}

?>