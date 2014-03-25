<HTML>
	<META HTTP-EQUIV="Content-Style-Type" CONTENT="text/css">
	<LINK REL="stylesheet" HREF="style.css">

<?PHP
if (isset($_POST['add-resource'])) {
	include 'db-config.php';

	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$StatusRefresh;URL=resources.php?OrderBy=ip_pri\">\n";
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
	$test_os = $_POST['form_testos'];

	if ( $owner == "Unassigned" ) {
		$owner = '';
		$status='Available';
	}

	if ( $server && $ip_pri ) {
		$query = "INSERT INTO $table_name VALUES ('','$server','$ip_pri','$ip_sec','$ip_drac','$owner','$make','$model','$asset_tag','$service_num','$firmware','$arch','$memory','$disks','$fibre','$cpu','$static_config','$static_part','$static_os','$misc','$location','$status','$due_date','$state','$test_os')";
		if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: Submitted -> <B>$query</B></FONT><BR>\n"; }
		$result=mysql_query($query);
		if ($result) {
			if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: Resource Add -> <B>Success</B></FONT><BR>\n"; }
			echo "<H2 ALIGN=\"center\">Resource Add: <FONT COLOR=\"green\">Success</FONT></H2>\n";
		} else {
			if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: <B>ERROR</B>, Resource Add -> <B>FAILED</B></FONT><BR>\n"; }
			echo "<H2 ALIGN=\"center\">Resource Add: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
			echo "<P ALIGN=\"center\"><B>ERROR:</B> " . mysql_error() . "</P>\n";
		}
	} else {
		if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Form: <B>ERROR</B>, Variable server undefined</FONT><BR>\n"; }
		echo "<H2 ALIGN=\"center\">Resource Add: <FONT COLOR=\"red\">FAILED</FONT></H2>\n";
		echo "<P ALIGN=\"center\"><B>ERROR:</B> Missing Required Field(s)</P>\n";
	}

	include 'db-close.php';

	if ( isset($DEBUG) ) { echo "<P ALIGN=\"center\">Return to <A HREF=\"resources.php?OrderBy=ip_pri\">List of Resources</A></P>\n"; }
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
<BODY>

	<H2 ALIGN="center">Add Lab Resource</H2>
	<P ALIGN="center">Return to <A HREF="resources.php?OrderBy=ip_pri">List of Resources</A></P>
	<FORM METHOD="post">
		<TABLE ALIGN="center" WIDTH="40%" BORDER=0>
		<TR>
			<TD>Hostname:</TD>
			<TD><INPUT TYPE="text" NAME="form_server"><FONT COLOR="red">*</FONT></TD>
		</TR>
		<TR>
			<TD>Primary IP Address:</TD>
			<TD><INPUT TYPE="text" NAME="form_ip_pri"><FONT COLOR="red">*</FONT></TD>
		</TR>
		<TR>
			<TD>Secondary IP Address:</TD>
			<TD><INPUT TYPE="text" NAME="form_ip_sec"></TD>
		</TR>
		<TR>
			<TD>DRAC Card IP Address:</TD>
			<TD><INPUT TYPE="text" NAME="form_ip_drac"></TD>
		</TR>
		<TR>
			<TD>Make:</TD>
			<TD><INPUT TYPE="text" NAME="form_make"></TD>
		</TR>
		<TR>
			<TD>Model:</TD>
			<TD><INPUT TYPE="text" NAME="form_model"></TD>
		</TR>
		<TR>
			<TD>Novell Asset Tag:</TD>
			<TD><INPUT TYPE="text" NAME="form_asset_tag"></TD>
		</TR>
		<TR>
			<TD>Service Number:</TD>
			<TD><INPUT TYPE="text" NAME="form_service_num"></TD>
		</TR>
		<TR>
			<TD>Firmware:</TD>
			<TD><INPUT TYPE="text" NAME="form_firmware"></TD>
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
			<TD><INPUT TYPE="text" NAME="form_memory"></TD>
		</TR>
		<TR>
			<TD>Disks:</TD>
			<TD><INPUT TYPE="text" NAME="form_disks"></TD>
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
			<TD>Number of CPUs:</TD>
			<TD><INPUT TYPE="text" NAME="form_cpu"></TD>
		</TR>
		<TR>
			<TD>Static Configuration ID Number:</TD>
			<TD><INPUT TYPE="text" NAME="form_static_config" VALUE=0></TD>
		</TR>
		<TR>
			<TD>Resource State:</TD>
			<TD><INPUT TYPE="radio" NAME="form_state" VALUE=1 CHECKED>Active &nbsp; <INPUT TYPE="radio" NAME="form_state" VALUE=0>Passive</TD>
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
			<TD>Static Partition:</TD>
			<TD><INPUT TYPE="text" NAME="form_static_part" VALUE="None"></TD>
		</TR>
		<TR>
			<TD>Notes:</TD>
			<TD><TEXTAREA NAME="form_misc" ROWS="3" COLS="30"></TEXTAREA></TD>
		</TR>
		<TR>
			<TD>Location:</TD>
			<TD><INPUT TYPE="text" NAME="form_location"></TD>
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
			echo "<TD><script>DateInput('form_due_date', false, 'YYYY-MM-DD')</script></TD>\n";
?>
		</TR>
		<TR>
			<TD><INPUT TYPE="submit" NAME="add-resource" ID="add-resource" VALUE="Add Resource"></TD>
			<TD>&nbsp;</TD>
		</TR>
		</TABLE>
	</FORM>
<?PHP
}
?> 

</BODY>
</HTML>

