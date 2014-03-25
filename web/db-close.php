<?PHP
	mysql_close($dbconn) or die("<FONT SIZE=\"-1\"><B>ERROR</B>: Unable to close database: $database</FONT><BR>");
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Database: Status -> <B>Closed</B></FONT><BR>\n"; }
?>
