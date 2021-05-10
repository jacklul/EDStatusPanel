<?php

include_once("./inc.php");

if ((float)PHP_VERSION < 8) {
	include_once("./polyfills.php");
}

function ED_getCurrentJournalFile()
{
	$jnlfl = "NONE";
	
	$files = scandir($GLOBALS["ed_journal_folder"], SCANDIR_SORT_DESCENDING);
	
	for ($i=0; $i<=count($files); $i++)
	{
		if (str_contains($files[$i], "Journal."))
		{ $jnlfl = $GLOBALS["ed_journal_folder"] . "/" . $files[$i]; break; }
	}
	
	return $jnlfl;
}

function ED_getContentFromEvent($event, $parameter)
{
	$jf = ED_getCurrentJournalFile();
	$handle = fopen($jf, "r");
	$res = "";
	if ($handle)
	{
		while (($line = fgets($handle)) !== false)
		{
		    $json = json_decode($line, true);
		    if ($json["event"] == $event)
		    { $res = $json[$parameter]; }
		}

		fclose($handle);
	}
	
	return $res;
}

function ED_doesEventParameterExist($e, $p)
{
	$exist = false;
	$jf = ED_getCurrentJournalFile();
	$handle = fopen($jf, "r");
	$res = "";
	if ($handle)
	{
		while (($line = fgets($handle)) !== false)
		{
		    $json = json_decode($line, true);
		    if ($json["event"] == $e) { $exist = true; }
		}

		fclose($handle);
	}
	
	return $exist;
}

function ED_getContentFromSpecifiedEvents($events)
{
	$jf = ED_getCurrentJournalFile();
	$handle = fopen($jf, "r");
	$res = array();
	if ($handle)
	{
		while (($line = fgets($handle)) !== false)
		{
		    $json = json_decode($line, true);
		    for ($i=0; $i<count($events); $i++)
		    { if ($json["event"] == $events[$i]) { $res[] = $json; } }
		}

		fclose($handle);
	}
	
	return $res;
}

function ED_displayStatusBox($text, $c)
{
	echo "<div class='".$c."'>".$text."</div>";
}

function ED_getStatusFlags()
{
	$statuscontent = file_get_contents($GLOBALS["ed_journal_folder"]."\Status.json");
	$status = json_decode($statuscontent, true);
	$bin = decbin($status["Flags"]);

	$fullbin = "";
	if (strlen($bin) < 32)
	{ $diff = 32-strlen($bin); for ($i=0; $i<$diff; $i++) { $fullbin = $fullbin . "0"; } $fullbin = $fullbin.$bin; }

	return $fullbin;
}

function ED_isDocked()
{
	$fullbin = ED_getStatusFlags();
	
	return $fullbin[31] == 1;
}

function ED_isPlanetSide()
{
	$fullbin = ED_getStatusFlags();

	return $fullbin[10] == 1 && $fullbin[1] == 0;
}

function ED_populateStatusPanel()
{
	$fullbin = ED_getStatusFlags();
	
	$texts = array(
	"SRV HIGHB",
	"FSD JUMP",
	"ALTITUDE",
	"NIGHT VSN",
	
	"ANALYSIS",
	"IN SRV",
	"IN FGHT",
	"IN SHIP",
	
	"INTERDCTN",
	"DANGER",
	"PLANETSIDE",
	"OVERHEAT",
	
	"LOW FL",
	"FSD CLD",
	"FSD CHRG",
	"MASS LOCK",
	
	"SRV D.A.",
	"SRV TRT D",
	"SRV TRRT",
	"SRV HNDB",
	
	"FUEL SCP",
	"SILENT",
	"CARGO SCP",
	"LIGHTS",
	
	"WING",
	"HARD PTS.",
	"FLT AST",
	"SUPERCRUISE",
	
	"SHIELDS",
	"LND GEAR",
	"LANDED",
	"DOCKED"
	);
	
	$c = "";
	
	$n = 31;
	echo "
	<table width=100% height=100% border=0 cellspacing=0 cellpadding=5>
	<tr>
	<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_green"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_green"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_red"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_green"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	
	echo "</tr><tr>";
	
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_yellow"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_green"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_green"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_green"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	
	echo "</tr><tr>";
	
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_green"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_green"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_red"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_yellow"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	
	echo "</tr><tr>";
	
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_red"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_green"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_red"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_green"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	
	echo "</tr><tr>";
	
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_red"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_yellow"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_yellow"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_red"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	
	echo "</tr><tr>";
	
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_red"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_yellow"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_red"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_red"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	
	echo "</tr><tr>";
	
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_green"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_green"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_green"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_green"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	
	echo "</tr><tr>";
	
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_green"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_red"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_green"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	$n = $n-1;
	echo "<td valign=top align=left>";
	if ($fullbin[$n] == 1) { ED_displayStatusBox($texts[$n], "ed_statusbox_red"); } else { ED_displayStatusBox($texts[$n], "ed_statusbox_off"); }
	echo "</td>";
	
	echo "</tr></table>";
	
}

?>
