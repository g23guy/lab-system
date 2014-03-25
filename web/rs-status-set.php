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
	$status = $_GET['selected_status'];
	$check_owner = $_GET['current_owner'];

	include 'db-open.php';

	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Variables: Resource='<B>$Resource</B>', owner='<B>$check_owner</B>', status='<B>$status</B>'</FONT><BR>\n"; }
	switch ($status) {
		case "Quick Test":
			if ( $check_owner != "" ) {
				$new_due_date=",due_date=DATE_ADD(CURDATE(), INTERVAL 1 DAY)";
			} else {
				$new_due_date="";
			}
			break;
		case "Checked Out":
			if ( $check_owner != "" ) {
				$new_due_date=",due_date=DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
			} else {
				$new_due_date="";
			}
			break;
		case "Short Test":
			if ( $check_owner != "" ) {
				$new_due_date=",due_date=DATE_ADD(CURDATE(), INTERVAL 14 DAY)";
			} else {
				$new_due_date="";
			}
			break;
		case "Long Test":
			if ( $check_owner != "" ) {
				$new_due_date=",due_date=DATE_ADD(CURDATE(), INTERVAL 28 DAY)";
			} else {
				$new_due_date="";
			}
			break;
		case "Static":
			$new_due_date=",due_date=''";
			break;
		case "Call":
			$new_due_date=",due_date=''";
			break;
		case "Available":
			if ( $check_owner != "" ) {
				$new_due_date="";
			} else {
				$new_due_date=",due_date=''";
			}
			break;
		default:
			$new_due_date="";
			break;
	}

	$query = "LOCK TABLES $table_name WRITE";
	mysql_query($query) or die("<FONT SIZE=\"-1\"><B><B>ERROR</B></B>: Database: Table $table_name Lock -> <B>FAILED</B></FONT><BR>\n");
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Database: Table $table_name -> <B>Locked</B></FONT><BR>\n"; }

	$query = "UPDATE $table_name SET status='$status'$new_due_date WHERE id=$Resource";
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: Submitted -> <B>$query</B></FONT><BR>\n"; }
	if ( $Resource && $status ) {
		$result=mysql_query($query);
		if ($result) {
			if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: Resource Update -> <B>Success</B></FONT><BR>\n"; }
			echo "<H2 ALIGN=\"center\">Resource Status Change: <FONT COLOR=\"green\">Success</FONT></H2>\n";
		} else {
			if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: <B>ERROR</B>, Resource Update -> <B>FAILED</B></FONT><BR>\n"; }
			echo "<H2 ALIGN=\"center\">Resource Status Change: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
			echo "<P ALIGN=\"center\"><B>ERROR:</B> " . mysql_error() . "</P>\n";
		}
	} else {
		if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\"><B>ERROR</B>: Undefined Variable; See /var/log/apache2/error_log</FONT><BR>\n"; }
		echo "<H2 ALIGN=\"center\">Resource Status Change: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
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
