<HTML>
<HEAD>
	<META HTTP-EQUIV="Content-Style-Type" CONTENT="text/css">
	<LINK REL="stylesheet" HREF="style.css">
<?PHP
	include 'db-config.php';
	$OrderBy = $_GET['OrderBy'];
	if ( ! $OrderBy ) { $OrderBy = 'ip_pri'; }

	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$StatusRefresh;URL=resources.php?OrderBy=$OrderBy\">\n";
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Variables: StatusRefresh='<B>$StatusRefresh</B>' seconds</FONT><BR>\n"; }
?>
</HEAD>
<BODY>

<?PHP
	$Resource = $_GET['Resource'];
	$owner = $_GET['selected_owner'];

	include 'db-open.php';

	$query = "LOCK TABLES $table_name WRITE";
	mysql_query($query) or die("<FONT SIZE=\"-1\"><B><B>ERROR</B></B>: Database: Table $table_name Lock -> <B>FAILED</B></FONT><BR>\n");
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Database: Table $table_name -> <B>Locked</B></FONT><BR>\n"; }

	if ( $owner == "Unassigned" ) {
		$query = "UPDATE $table_name SET owner='',status='Available',due_date='' WHERE id=$Resource";
	} else {
		$query = "UPDATE $table_name SET owner='$owner',status='Checked Out',due_date=DATE_ADD(CURDATE(), INTERVAL 7 DAY) WHERE id=$Resource";
	}
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: Submitted -> <B>$query</B></FONT><BR>\n"; }
	if ( $Resource ) {
		$result=mysql_query($query);
		if ($result) {
			if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: Resource Update -> <B>Success</B></FONT><BR>\n"; }
			echo "<H2 ALIGN=\"center\">Resource Assigned: <FONT COLOR=\"green\">Success</FONT></H2>\n";
		} else {
			if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: <B>ERROR</B>, Resource Update -> <B>FAILED</B></FONT><BR>\n"; } 
			echo "<H2 ALIGN=\"center\">Resource Assigned: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
			echo "<P ALIGN=\"center\"><B>ERROR:</B> " . mysql_error() . "</P>\n";
		}
	} else {
		if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\"><B>ERROR</B>: Undefined Variable; See /var/log/apache2/error_log</FONT><BR>\n"; }
		echo "<H2 ALIGN=\"center\">Resource Assigned: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
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
