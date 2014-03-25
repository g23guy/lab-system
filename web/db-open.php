<?PHP
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Database: Connecting -> <B>$database</B></FONT><BR>\n"; }
	$dbconn = mysql_connect($db_host,$user,$password);
	@mysql_select_db($database) or die("<FONT SIZE=\"-1\"><B>ERROR</B>: Unable to select database: $database</FONT><BR>");
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Database: Status -> <B>Open</B></FONT><BR>\n"; }
?>
