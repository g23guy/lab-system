<HTML>
<HEAD>
	<META HTTP-EQUIV="Content-Style-Type" CONTENT="text/css">
	<LINK REL="stylesheet" HREF="style.css">
<?PHP
	include 'db-config.php';
	$OrderBy = $_GET['OrderBy'];

	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$StatusRefresh;URL=resources.php?OrderBy=$OrderBy\">\n";
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Variables: StatusRefresh='<B>$StatusRefresh</B>' seconds</FONT><BR>\n"; }
?>
</HEAD>
<BODY>

<?PHP
	$Resource = $_GET['Resource'];
	$static_os = $_GET['selected_staticos'];

	include 'db-open.php';

	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Variables: OrderBy='<B>$OrderBy</B>', Resource='<B>$Resource</B>', static_os='<B>$static_os</B>'</FONT><BR>\n"; }

	$query = "LOCK TABLES $table_name WRITE";
	mysql_query($query) or die("<FONT SIZE=\"-1\"><B><B>ERROR</B></B>: Database: Table $table_name Lock -> <B>FAILED</B></FONT><BR>\n");
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Database: Table $table_name -> <B>Locked</B></FONT><BR>\n"; }

	$query = "UPDATE $table_name SET static_os='$static_os' WHERE id=$Resource";
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: Submitted -> <B>$query</B></FONT><BR>\n"; }
	if ( $Resource && $static_os ) {
		$result=mysql_query($query);
		if ($result) {
			if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: Resource Update -> <B>Success</B></FONT><BR>\n"; }
			echo "<H2 ALIGN=\"center\">Static OS Change: <FONT COLOR=\"green\">Success</FONT></H2>\n";
		} else {
			if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: <B>ERROR</B>, Resource Update -> <B>FAILED</B></FONT><BR>\n"; }
			echo "<H2 ALIGN=\"center\">Static OS Change: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
			echo "<P ALIGN=\"center\"><B>ERROR:</B> " . mysql_error() . "</P>\n";
		}
	} else {
		if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\"><B>ERROR</B>: Undefined Variable(s); Resource or static_os</FONT><BR>\n"; }
		echo "<H2 ALIGN=\"center\">Static OS Change: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
		echo "<P ALIGN=\"center\"><B>ERROR:</B> Undefined Variable(s)</P>\n";
	}

	$query = "UNLOCK TABLES";
	mysql_query($query) or die("<FONT SIZE=\"-1\">Database: <B>ERROR</B>, Table $table_name Unlock -> <B>FAILED</B></FONT><BR>\n");
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Database: Table $table_name -> <B>Unlocked</B></FONT><BR>\n"; }

	include 'db-close.php';
	if ( isset($DEBUG) ) { echo "<P ALIGN=\"center\">Return to <A HREF=\"resources.php?OrderBy=ip_pri\">List of Resources</A></P>\n"; }
?> 

</BODY>
</HTML>
