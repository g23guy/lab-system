<HTML>
<?PHP
	include 'db-config.php';
?>
	<META HTTP-EQUIV="Content-Style-Type" CONTENT="text/css">
	<LINK REL="stylesheet" HREF="style.css">

<HEAD>
	<TITLE>WSS Linux Lab Resources</TITLE>
</HEAD>

<BODY BGPROPERTIES=FIXED BGCOLOR="#FFFFFF" TEXT="#000000">

<?PHP
	$OrderBy = $_GET['OrderBy'];
	$selected_static_config = $_GET['StaticID'];

	include 'db-open.php';

	$query="SELECT * FROM $table_name WHERE static_config=$selected_static_config";
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: Submitted -> <B>$query</B></FONT><BR>\n"; }
	$result=mysql_query($query);
	if ( isset($DEBUG) ) {
		if ( $result ) {
			echo "<FONT SIZE=\"-1\">Query: Record -> <B>Success</B></FONT><BR>\n";
		} else {
			echo "<FONT SIZE=\"-1\">Query: Record -> <B>FAILED</B></FONT><BR>\n";
		}
	}
	$num=mysql_numrows($result);
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: Rows Returned -> <B>$num</B></FONT><BR>\n"; }

	include 'db-close.php';

	echo "<P CLASS=\"head3b\" ALIGN=\"center\">[ <A HREF=\"check-out.html\">Check Out Procedure</A> | List <A HREF=\"resources.php?OrderBy=$OrderBy\">Active</A> Resources ]</P>\n";
	echo "<P CLASS=\"text\" ALIGN=\"center\">(No Auto Refresh)</P>\n";
	echo "<H2 ALIGN=\"center\">Static Configuration Information<BR>for Configuration ID: $selected_static_config</H2>\n";

	echo "<TABLE ALIGN=\"center\" WIDTH=\"100%\" CELLPADDING=\"2\">\n";
	echo "<TR CLASS=\"head_2\">\n";
	echo "  <TH>Server</TH>\n";
	echo "  <TH>IP Addresses</TH>\n";
	echo "  <TH>Assigned To</TH>\n";
	echo "  <TH>Status</TH>\n";
	echo "  <TH>Static Partition(s)</TH>\n";
	echo "  <TH>Static OS</TH>\n";
	echo "  <TH>Notes</TH>\n";
	echo "  <TH>Make/&nbsp;&nbsp;<BR>Model</TH>\n";
	echo "  <TH>Arch</TH>\n";
	echo "  <TH>Loc</TH>\n";
	echo "  <TH>RAM</TH>\n";
	echo "  <TH>Disks</TH>\n";
	echo "  <TH>CPU</TH>\n";
	echo "  <TH>Fibre Card</TH>\n";
	echo "</TR>\n";

	for ( $i=0; $i < $num; $i++ ) {
		$row_cell = mysql_fetch_row($result);
		$id = $row_cell[0];
		$server = $row_cell[1];
		$ip_pri = $row_cell[2];
		$ip_sec = $row_cell[3];
		$ip_drac = $row_cell[4];
		$owner = $row_cell[5];
			if ( $owner == "" ) { $owner="Unassigned"; }
		$make = $row_cell[6];
		$model = $row_cell[7];
		$asset_tag = $row_cell[8];
		$service_num = $row_cell[9];
		$firmware = $row_cell[10];
		$arch = $row_cell[11];
		$memory = $row_cell[12];
		$disks = $row_cell[13];
		$fibre = $row_cell[14];
		$cpu = $row_cell[15];
		$static_config = $row_cell[16];
		$static_part = $row_cell[17];
		$static_os = $row_cell[18];
		$misc = $row_cell[19];
		$location = $row_cell[20];
		$status = $row_cell[21];
		$due_date = $row_cell[22];
			if ( $due_date == 0 ) { $due_date = "&nbsp;"; }
		$state = $row_cell[23];
			if ( $state > 0 ) { $state_value = "Active"; } else { $state_value = "Passive"; }
		$test_os = $row_cell[24];

		if ( $i%2 == 0 ) { $row_color="tdGrey"; } else { $row_color="tdGreyLight"; }

		// Create table row with data
		echo "<TR ALIGN=\"center\" CLASS=\"$row_color\">\n";
		echo "  <TD>$server</TD>\n";
		echo "  <TD>\n";
		echo "    <TABLE WIDTH=\"100%\">\n";
		echo "      <TR CLASS=\"$row_color\"><TD ALIGN=\"left\">Pri:</TD><TD ALIGN=\"right\"><A HREF=\"http://$ip_pri/\" TARGET=\"$ip_pri\">$ip_pri</A></TD></TR>\n";
		if ( $ip_sec != "" ) {
			echo "      <TR CLASS=\"$row_color\"><TD ALIGN=\"left\">Sec:</TD><TD ALIGN=\"right\"><A HREF=\"http://$ip_sec/\" TARGET=\"$ip_sec\">$ip_sec</A></TD></TR>\n";
		}
		if ( $ip_drac != "" ) {
			echo "      <TR CLASS=\"$row_color\"><TD ALIGN=\"left\">DRAC:</TD><TD ALIGN=\"right\"><A HREF=\"http://$ip_drac/\" TARGET=\"$ip_drac\">$ip_drac</A></TD></TR>\n";
		}
		echo "    </TABLE>\n";
		echo "  </TD>\n";
		echo "  <TD>$owner</TD>\n";
		echo "  <TD>$status</TD>\n";
		echo "  <TD>$static_part</TD>\n";
		echo "  <TD>$static_os</TD>\n";
		echo "  <TD ALIGN=\"left\">$misc</TD>\n";
		echo "  <TD>$make<BR>$model</TD>\n";
		echo "  <TD>$arch</TD>\n";
		echo "  <TD>$location</TD>\n";
		echo "  <TD>$memory</TD>\n";
		echo "  <TD>$disks</TD>\n";
		echo "  <TD>$cpu</TD>\n";
		echo "  <TD>$fibre</TD>\n";
		echo "</TR>\n";
	}
	
	echo "</TABLE>\n";
	echo "</HTML>\n";
	echo "</BODY>\n";
?>

