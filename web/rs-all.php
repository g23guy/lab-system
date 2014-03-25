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
	if ( ! $OrderBy ) { $OrderBy = 'ip_pri'; }

	include 'db-open.php';

	$query="SELECT * FROM $table_name ORDER BY $OrderBy";
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: Submitted -> <B>$query</B></FONT><BR>\n"; }
	$result=mysql_query($query);
	if ( isset($DEBUG) ) {
		if ( $result ) {
			echo "<FONT SIZE=\"-1\">Query: All Records -> <B>Success</B></FONT><BR>\n";
		} else {
			echo "<FONT SIZE=\"-1\">Query: All Records -> <B>FAILED</B></FONT><BR>\n";
		}
	}
	$num=mysql_numrows($result);
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Query: Rows Returned -> <B>$num</B></FONT><BR>\n"; }

	include 'db-close.php';

	echo "<P CLASS=\"head3b\" ALIGN=\"center\">[ <A HREF=\"check-out.html\">Check Out Procedure</A> | List <A HREF=\"resources.php?OrderBy=$OrderBy\">Active</A> Resources | <A HREF=\"rs-add.php\">Add</A> a Resource ]</P>\n";
	echo "<P CLASS=\"text\" ALIGN=\"center\">(No Auto Refresh)</P>\n";

	echo "<TABLE ALIGN=\"center\" WIDTH=\"150%\" CELLPADDING=\"2\">\n";
	echo "<TR CLASS=\"head_2\">\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=id\" CLASS=\"head_2\">ID</A></TH>\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=server\" CLASS=\"head_2\">Host Name</A></TH>\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=ip_pri\" CLASS=\"head_2\">IP Addresses</A></TH>\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=owner,ip_pri\" CLASS=\"head_2\">Assigned To</A></TH>\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=status,ip_pri\" CLASS=\"head_2\">Status</A></TH>\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=state,ip_pri\" CLASS=\"head_2\">State</A></TH>\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=static_config,ip_pri\" CLASS=\"head_2\">Static<BR>Config ID</A></TH>\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=static_part,ip_pri\" CLASS=\"head_2\">Static Partition</A></TH>\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=static_os,ip_pri\" CLASS=\"head_2\">Static OS</A></TH>\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=make,model,ip_pri\" CLASS=\"head_2\">Make/&nbsp;&nbsp;<BR>Model</A></TH>\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=arch,ip_pri\" CLASS=\"head_2\">Arch</A></TH>\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=test_os,ip_pri\" CLASS=\"head_2\">Test OS</A></TH>\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=misc,ip_pri\" CLASS=\"head_2\">Notes</A></TH>\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=location,ip_pri\" CLASS=\"head_2\">Location</A></TH>\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=memory,ip_pri\" CLASS=\"head_2\">RAM</A></TH>\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=disks,ip_pri\" CLASS=\"head_2\">Disks</A></TH>\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=cpu,ip_pri\" CLASS=\"head_2\">CPU</A></TH>\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=fibre,ip_pri\" CLASS=\"head_2\">Fibre Card</A></TH>\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=firmware,ip_pri\" CLASS=\"head_2\">Firmware</A></TH>\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=due_date,ip_pri\" CLASS=\"head_2\">Due Date</A></TH>\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=asset_tag\" CLASS=\"head_2\">Asset Tag</A></TH>\n";
	echo "  <TH><A HREF=\"rs-all.php?OrderBy=service_num\" CLASS=\"head_2\">Service Number</A></TH>\n";
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
			if ( $static_config > 0 ) { $static_config_state = "<FONT COLOR=\"red\">$static_config</FONT>"; } else { $static_config_state = "None"; }
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
		echo "  <TD><A HREF=\"rs-edit.php?OrderBy=$OrderBy&Resource=$id&CalledBy=rs-all\">$id</A></TD>\n";
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
		echo "  <TD>$state_value</TD>\n";
		echo "  <TD>$static_config_state</TD>\n";
		echo "  <TD>$static_part</TD>\n";
		echo "  <TD>$static_os</TD>\n";
		echo "  <TD>$make<BR>$model</TD>\n";
		echo "  <TD>$arch</TD>\n";
		echo "  <TD>$test_os</TD>\n";
		echo "  <TD ALIGN=\"left\">$misc</TD>\n";
		echo "  <TD>$location</TD>\n";
		echo "  <TD>$memory</TD>\n";
		echo "  <TD>$disks</TD>\n";
		echo "  <TD>$cpu</TD>\n";
		echo "  <TD>$fibre</TD>\n";
		echo "  <TD>$firmware</TD>\n";
		echo "  <TD>$due_date</TD>\n";
		echo "  <TD>$asset_tag</TD>\n";
		echo "  <TD>$service_num</TD>\n";
		echo "</TR>\n";
	}
	
	echo "</TABLE>\n";
	echo "<P CLASS=\"tdGrey\">Number of Resources: $num</P>\n";
	echo "</HTML>\n";
	echo "</BODY>\n";
?>

