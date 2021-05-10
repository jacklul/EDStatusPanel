<?php

include_once("./inc.php");
include_once("./func.php");

function ED_getLocation()
{
	$r = array();
	
	$r[0] = ED_getContentFromEvent("Location", "StarSystem");
	$r[1] = ED_getContentFromEvent("Location", "StarPos");

	if (ED_doesEventParameterExist("FSDJump", "StarSystem") == true)
	{
		$r[0] = ED_getContentFromEvent("FSDJump", "StarSystem");
		$r[1] = ED_getContentFromEvent("FSDJump", "StarPos");
		$r[2] = ED_getContentFromEvent("FSDJump", "JumpDist");
	}
	
	if (!isset($r[2])) {
		$r[2] = 0;
	}

	if (ED_doesEventParameterExist("ApproachBody", "Body") == true)
	{ $r[3] = ED_getContentFromEvent("ApproachBody", "Body"); }
	
	$sol_x = 200 - 5;
	$sol_y = 335 - 5;
	
	$xp = $r[1][0] / 400; $yp = $r[1][2] / 400; 
	$posptr_x = $sol_x + $xp;
	$posptr_y = $sol_y + $yp;
	$r[] = array($posptr_x, $posptr_y);

	return $r;
}


function ED_getNextJump()
{
	$j = array();

	$routefile = $GLOBALS["ed_journal_folder"]."/NavRoute.json";
	if (file_exists($routefile) == true)
	{
		$locdata = ED_getLocation();
		$loc = $locdata[0];

		$routedata = file_get_contents($routefile);
		$route = json_decode($routedata, true);

		for ($i=0; $i<count($route["Route"])-1; $i++)
		{
			if ($route["Route"][$i]["StarSystem"] == $loc && $i <= count($route["Route"])-1)
			{ $j[] = $route["Route"][$i+1]["StarSystem"]; $j[] = $route["Route"][$i+1]["StarClass"]; break; }
		}
	}

	return $j;
}


function ED_getDockedStation()
{
	$e = ED_getContentFromEvent("Docked", "StationName");
	return $e;
}


function ED_DistToSol()
{
	$p = ED_getLocation();
	$d = sqrt
	(
		pow($p[1][0] - 0.0, 2) +  
		pow($p[1][1] - 0.0, 2) +  
		pow($p[1][2] - 0.0, 2)
		* 1.0
	);

	return $d;
}


function ED_getBody()
{
	$p = ED_getLocation();
	if (isset($p[3]) && !is_array($p[3])) {
		return $p[3];
	}

	return null;
}


?>
