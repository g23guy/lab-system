<HTML>
<HEAD>
	<META HTTP-EQUIV="Content-Style-Type" CONTENT="text/css">
	<LINK REL="stylesheet" HREF="style.css">
<?PHP
	include 'db-config.php';

	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$StatusRefresh;URL=index.html\">\n";
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Variables: StatusRefresh='<B>$StatusRefresh</B>' seconds</FONT><BR>\n"; }
?>
</HEAD>
<BODY>
	<P CLASS="head_1" ALIGN="center">WSS Linux Lab Resources</P>

<?PHP
	$Resource = $_GET['Resource'];
	$notice_owner = $_GET['Assigned'];

	include 'db-open.php';

	$query = "SELECT owner FROM servers WHERE id=$Resource";
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: Submitted -> <B>$query</B></FONT><BR>\n"; }
	$result=mysql_query($query);
	if ( isset($DEBUG) ) {
		if ( $result ) {
			echo "<FONT SIZE=\"-1\">Query: All Records -> <B>Success</B></FONT><BR>\n";
		} else {
			echo "<FONT SIZE=\"-1\">Query: All Records -> <B>FAILED</B></FONT><BR>\n";
		}
	}

	$owner=mysql_result($result, 0, "owner");

	if ( $notice_owner == $owner || ! $owner ) {
		$query = "LOCK TABLES $table_name WRITE";
		mysql_query($query) or die("<FONT SIZE=\"-1\"><B><B>ERROR</B></B>: Database: Table $table_name Lock -> <B>FAILED</B></FONT><BR>\n");
		if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Database: Table $table_name -> <B>Locked</B></FONT><BR>\n"; }

		$query = "UPDATE $table_name SET owner='',status='Available',due_date='' WHERE id=$Resource";
		if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: Submitted -> <B>$query</B></FONT><BR>\n"; }
		if ( $Resource ) {
			$result=mysql_query($query);
			if ($result) {
				if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: Resource Update -> <B>Success</B></FONT><BR>\n"; }
				echo "<H2 ALIGN=\"center\">Resource Cleared: <FONT COLOR=\"green\">Success</FONT></H2>\n";
			} else {
				if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: <B>ERROR</B>, Resource Update -> <B>FAILED</B></FONT><BR>\n"; }
				echo "<H2 ALIGN=\"center\">Resource Cleared: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
				echo "<P ALIGN=\"center\"><B>ERROR:</B> " . mysql_error() . "</P>\n";
			}
		} else {
			if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\"><B>ERROR</B>: Variable Resource undefined; See /var/log/apache2/error_log</FONT><BR>\n"; }
			echo "<H2 ALIGN=\"center\">Resource Cleared: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
			echo "<P ALIGN=\"center\"><B>ERROR:</B> Undefined Variable -> \"Resource\"</P>\n";
		}

		$query = "UNLOCK TABLES";
		mysql_query($query) or die("<FONT SIZE=\"-1\">Database: <B>ERROR</B>, Table $table_name Unlock -> <B>FAILED</B></FONT><BR>\n");
		if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Database: Table $table_name -> <B>Unlocked</B></FONT><BR>\n"; }
	} else {
		echo "<H2 ALIGN=\"center\">Resource Clear: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
		echo "<P ALIGN=\"center\"><B>NOTICE:</B> The resource is already owned by $owner, not cleared.</P>\n";
	}

	include 'db-close.php';
	if ( isset($DEBUG) ) { echo "<P ALIGN=\"center\">Return to <A HREF=\"index.html\">List of Resources</A></P>\n"; }
?> 

</BODY>
</HTML>
