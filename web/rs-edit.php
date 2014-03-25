<HTML>
	<META HTTP-EQUIV="Content-Style-Type" CONTENT="text/css">
	<LINK REL="stylesheet" HREF="style.css">

<?PHP
$Resource = $_GET['Resource'];
$OrderBy = $_GET['OrderBy'];
$CalledBy = $_GET['CalledBy'];

include 'db-config.php';

if (isset($_POST['edit-resource'])) {
	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$StatusRefresh;URL=$CalledBy.php?OrderBy=$OrderBy\">\n";
	echo "<BODY>\n";
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Variables: StatusRefresh='<B>$StatusRefresh</B>' seconds</FONT><BR>\n"; }

	include 'db-open.php';

	$server = $_POST['form_server'];
	$ip_pri = $_POST['form_ip_pri'];
	$ip_sec = $_POST['form_ip_sec'];
	$ip_drac = $_POST['form_ip_drac'];
	$owner = $_POST['form_owner'];
	$make = $_POST['form_make'];
	$model = $_POST['form_model'];
	$asset_tag = $_POST['form_asset_tag'];
	$service_num = $_POST['form_service_num'];
	$firmware = $_POST['form_firmware'];
	$arch = $_POST['form_arch'];
	$test_os = $_POST['form_testos'];
	$memory = $_POST['form_memory'];
	$disks = $_POST['form_disks'];
	$fibre = $_POST['form_fibre'];
	$cpu = $_POST['form_cpu'];
	$static_config = $_POST['form_static_config'];
	$static_part = $_POST['form_static_part'];
	$static_os = $_POST['form_static_os'];
	$misc = $_POST['form_misc'];
	$location = $_POST['form_location'];
	$status = $_POST['form_status'];
	$due_date = $_POST['form_due_date'];
	$state = $_POST['form_state'];

	if ( $owner == "Unassigned" ) {
		$owner = '';
		$status='Available';
		$due_date='';
	}

	$query = "LOCK TABLES $table_name WRITE";
	mysql_query($query) or die("<FONT SIZE=\"-1\"><B><B>ERROR</B></B>: Database: Table $table_name Lock -> <B>FAILED</B></FONT><BR>\n");
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Database: Table $table_name -> <B>Locked</B></FONT><BR>\n"; }

	$query = "UPDATE $table_name SET server='$server', ip_pri='$ip_pri', ip_sec='$ip_sec', ip_drac='$ip_drac',owner='$owner',make='$make',model='$model',asset_tag='$asset_tag',service_num='$service_num',firmware='$firmware',arch='$arch',memory='$memory',disks='$disks',fibre='$fibre',cpu='$cpu',static_config='$static_config',static_part='$static_part',static_os='$static_os',misc='$misc',location='$location',status='$status',due_date='$due_date',state='$state',test_os='$test_os' WHERE id=$Resource";
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: Submitted -> <B>$query</B></FONT><BR>\n"; }
	if ( $server && $ip_pri ) {
		$result=mysql_query($query);
		if ($result) {
			if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: Resource Update -> <B>Success</B></FONT><BR>\n"; }
			echo "<H2 ALIGN=\"center\">Resource Edit: <FONT COLOR=\"green\">Success</FONT></H2>\n";
		} else {
			if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: <B>ERROR</B>, Resource Update -> <B>FAILED</B></FONT><BR>\n"; }
			echo "<H2 ALIGN=\"center\">Resource Edit: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
			echo "<P ALIGN=\"center\"><B>ERROR:</B> " . mysql_error() . "</P>\n";
		}
	} else {
		if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\"><B>ERROR</B>: Variable server undefined; See /var/log/apache2/error_log</FONT><BR>\n"; } 
		echo "<H2 ALIGN=\"center\">Resource Edit: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
		echo "<P ALIGN=\"center\"><B>ERROR:</B> Missing Required Field(s)</P>\n";
	}

	$query = "UNLOCK TABLES";
	mysql_query($query) or die("<FONT SIZE=\"-1\">Database: <B>ERROR</B>, Table $table_name Unlock -> <B>FAILED</B></FONT><BR>\n");
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Database: Table $table_name -> <B>Unlocked</B></FONT><BR>\n"; } 

	include 'db-close.php';

	if ( isset($DEBUG) ) { echo "<P ALIGN=\"center\">Return to <A HREF=\"$CalledBy.php?OrderBy=$OrderBy\">List of Resources</A></P>\n"; }
} else {
?>
<HEAD>
<script type="text/javascript" src="calendarDateInput.js">

/***********************************************
* Jason's Date Input Calendar - By Jason Moon http://calendar.moonscript.com/dateinput.cfm
* Script featured on and available at http://www.dynamicdrive.com
* Keep this notice intact for use.
***********************************************/

</script>
</HEAD>
<?PHP
	echo "<BODY>\n";

	include 'db-open.php';

	if ( ! $Resource ) {
		die("<B>ERROR</B>: Undefined Variable \"Resource\" -> <B>FAILED</B>\n");
	}
	$query = "SELECT * FROM $table_name WHERE id=$Resource";
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: Submitted -> <B>$query</B></FONT><BR>\n"; }
	$result = mysql_query($query) or die("<FONT SIZE=\"-1\"><B>ERROR</B>: Query -> <B>FAILED</B></FONT><BR>\n");
	$row = 0;

	$id=mysql_result($result, $row, "id");
	$server=mysql_result($result, $row, "server");
	$ip_pri=mysql_result($result, $row, "ip_pri");
	$ip_sec=mysql_result($result, $row, "ip_sec");
	$ip_drac=mysql_result($result, $row, "ip_drac");
	$owner=mysql_result($result, $row, "owner");
	$make=mysql_result($result, $row, "make");
	$model=mysql_result($result, $row, "model");
	$asset_tag=mysql_result($result, $row, "asset_tag");
	$service_num=mysql_result($result, $row, "service_num");
	$firmware=mysql_result($result, $row, "firmware");
	$arch=mysql_result($result, $row, "arch");
	$memory=mysql_result($result, $row, "memory");
	$disks=mysql_result($result, $row, "disks");
	$fibre=mysql_result($result, $row, "fibre");
	$cpu=mysql_result($result, $row, "cpu");
	$static_config=mysql_result($result, $row, "static_config");
	$static_part=mysql_result($result, $row, "static_part");
	$static_os=mysql_result($result, $row, "static_os");
	$misc=mysql_result($result, $row, "misc");
	$location=mysql_result($result, $row, "location");
	$status=mysql_result($result, $row, "status");
	$due_date=mysql_result($result, $row, "due_date");
	$state=mysql_result($result, $row, "state");
	$test_os=mysql_result($result, $row, "test_os");
	
	include 'db-close.php';

?>
	<H2 ALIGN="center">Edit Lab Resource</H2>
<?PHP
	echo "<P ALIGN=\"center\">Return to <A HREF=\"$CalledBy.php?OrderBy=$OrderBy\">List of Resources</A></P>\n";
?>
	<FONT SIZE="+1">
	<FORM METHOD="post">
		<TABLE ALIGN="center" WIDTH="40%" BORDER=0>
		<TR>
			<TD>Hostname:</TD>
<?PHP
			echo "<TD><INPUT TYPE=\"text\" NAME=\"form_server\" VALUE=\"$server\"><FONT COLOR=\"red\">*</FONT></TD>";
?>
		</TR>
		<TR>
			<TD>Primary IP Address:</TD>
<?PHP
			echo "<TD><INPUT TYPE=\"text\" NAME=\"form_ip_pri\" VALUE=\"$ip_pri\"><FONT COLOR=\"red\">*</FONT></TD>";
?>
		</TR>
		<TR>
			<TD>Secondary IP Address:</TD>
<?PHP
			echo "<TD><INPUT TYPE=\"text\" NAME=\"form_ip_sec\" VALUE=\"$ip_sec\"></TD>";
?>
		</TR>
		<TR>
			<TD>DRAC Card IP Address:</TD>
<?PHP
			echo "<TD><INPUT TYPE=\"text\" NAME=\"form_ip_drac\" VALUE=\"$ip_drac\"></TD>";
?>
		</TR>
		<TR>
			<TD>Make:</TD>
<?PHP
			echo "<TD><INPUT TYPE=\"text\" NAME=\"form_make\" VALUE=\"$make\"></TD>";
?>
		<TR>
			<TD>Model:</TD>
<?PHP
			echo "<TD><INPUT TYPE=\"text\" NAME=\"form_model\" VALUE=\"$model\"></TD>";
?>
		</TR>
		<TR>
			<TD>Novell Asset Tag:</TD>
<?PHP
			echo "<TD><INPUT TYPE=\"text\" NAME=\"form_asset_tag\" VALUE=\"$asset_tag\"></TD>";
?>
		</TR>
		<TR>
			<TD>Service Number:</TD>
<?PHP
			echo "<TD><INPUT TYPE=\"text\" NAME=\"form_service_num\" VALUE=\"$service_num\"></TD>";
?>
		</TR>
		<TR>
			<TD>Firmware:</TD>
<?PHP
			echo "<TD><INPUT TYPE=\"text\" NAME=\"form_firmware\" VALUE=\"$firmware\"></TD>";
?>
		</TR>
		<TR>
			<TD>Architecture:</TD>
			<TD>
<?PHP
			include 'form-arch.php';
?>
			</TD>
		</TR>
		<TR>
			<TD>Memory:</TD>
<?PHP
			echo "<TD><INPUT TYPE=\"text\" NAME=\"form_memory\" VALUE=\"$memory\"></TD>";
?>
		</TR>
		<TR>
			<TD>Disks:</TD>
<?PHP
			echo "<TD><INPUT TYPE=\"text\" NAME=\"form_disks\" VALUE=\"$disks\"></TD>";
?>
		</TR>
		<TR>
			<TD>Fibre Card:</TD>
			<TD>
<?PHP
			include 'form-fibre.php';
?>
			</TD>
		</TR>
		<TR>
			<TD>CPUs:</TD>
<?PHP
			echo "<TD><INPUT TYPE=\"text\" NAME=\"form_cpu\" VALUE=\"$cpu\"></TD>";
?>
		</TR>
		<TR>
			<TD>Static Configuration ID Number:</TD>
<?PHP
			echo "<TD><INPUT TYPE=\"text\" NAME=\"form_static_config\" VALUE=\"$static_config\"></TD>";
?>
		</TR>
		<TR>
			<TD>Resource State:</TD>
<?PHP
			if ( $state > 0 ) {
				echo "<TD><INPUT TYPE=\"radio\" NAME=\"form_state\" VALUE=1 CHECKED>Active &nbsp; <INPUT TYPE=\"radio\" NAME=\"form_state\" VALUE=0>Passive</TD>";
			} else {
				echo "<TD><INPUT TYPE=\"radio\" NAME=\"form_state\" VALUE=1>Active &nbsp; <INPUT TYPE=\"radio\" NAME=\"form_state\" VALUE=0 CHECKED>Passive</TD>";
			}
?>
		</TR>
		<TR>
			<TD>Static Partitions:</TD>
<?PHP
			echo "<TD><INPUT TYPE=\"text\" NAME=\"form_static_part\" VALUE=\"$static_part\"></TD>";
?>
		</TR>
		<TR>
			<TD>Static Configuration OS:</TD>
			<TD>
<?PHP
			echo "  <SELECT NAME=\"form_static_os\" CLASS=\"text\">\n";
			include 'form-os-static.php';
?>
			</TD>
		</TR>
		<TR>
			<TD>Notes:</TD>
<?PHP
			echo "<TD><TEXTAREA NAME=\"form_misc\" ROWS=\"3\" COLS=\"30\">$misc</TEXTAREA></TD>";
?>
		</TR>
		<TR>
			<TD>Location:</TD>
<?PHP
			echo "<TD><INPUT TYPE=\"text\" NAME=\"form_location\" VALUE=\"$location\"></TD>";
?>
		</TR>
		<TR>
			<TD>Owner:</TD>
			<TD>
<?PHP
			echo "  <SELECT NAME=\"form_owner\" CLASS=\"text\">\n";
			include 'form-owners.php';
?>
			</TD>
		</TR>
		<TR>
			<TD>Status:</TD>
			<TD>
<?PHP
			echo "  <SELECT NAME=\"form_status\" CLASS=\"text\">\n";
			include 'form-status.php';
?>
			</TD>
		</TR>
		<TR>
			<TD>Current Test OS:</TD>
			<TD>
<?PHP
			echo "  <SELECT NAME=\"form_testos\" CLASS=\"text\">\n";
			include 'form-os-test.php';
?>
			</TD>
		</TR>
		<TR>
			<TD>Due Date:</TD>
<?PHP
			if ( $due_date > 0 ) {
				$due_date_value=", '$due_date'";
			} else {
				$due_date_value="";
			}
			echo "<TD><script>DateInput('form_due_date', false, 'YYYY-MM-DD'$due_date_value)</script></TD>\n";
?>
		</TR>
		<TR>
			<TD><INPUT TYPE="submit" NAME="edit-resource" ID="edit-resource" VALUE="Update Resource"></TD>
			<TD>&nbsp;</TD>
		</TR>
		</TABLE>
		</FONT>
	</FORM>
<?PHP
}
?> 

</BODY>
</HTML>
