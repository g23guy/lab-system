<HTML>
<?PHP
	include 'db-config.php';

	$OrderBy = $_GET['OrderBy'];
	$OrderDir = $_GET['OrderDir'];
	if ( ! $OrderBy ) { $OrderBy = 'ip_pri'; }

	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$ResourceRefresh;URL=resources.php?OrderBy=$OrderBy&OrderDir=$OrderDir\">\n";
	if ( isset($DEBUG) ) { echo "<FONT SIZE=\"-1\">Variables: ResourceRefresh='<B>$ResourceRefresh</B>' seconds</FONT><BR>\n"; }
?>
	<META HTTP-EQUIV="Content-Style-Type" CONTENT="text/css">
	<LINK REL="stylesheet" HREF="style.css">

<HEAD>
	<TITLE>WSS Linux Lab Resources</TITLE>
	<SCRIPT LANGUAGE="javascript">
		function SetOwner(orderby, resource, user) {
<?php
			if ( isset($DEBUG) ) { echo "alert(\"Variables: SetOwner -> orderby=\" + orderby + \", resource=\" + resource + \", user = \" + user)\n"; }

			print("	location.replace(\"rs-owner-set.php?OrderBy=\" + orderby + \"&Resource=\" + resource + \"&selected_owner=\" + user)");
?>
		}

		function SetStatus(orderby, resource, current_owner, status) {
<?php
			if ( isset($DEBUG) ) { echo "alert(\"Variables: SetStatus -> orderby=\" + orderby + \", resource=\" + resource + \", current_owner=\" + current_owner + \", status=\" + status)\n"; }
			print("	location.replace(\"rs-status-set.php?OrderBy=\" + orderby + \"&Resource=\" + resource + \"&current_owner=\" + current_owner + \"&selected_status=\" + status)");
?>
		}

		function SetTestOS(orderby, resource, test_os) {
<?php
			if ( isset($DEBUG) ) { echo "alert(\"Variables: SetTestOS -> orderby=\" + orderby + \", resource=\" + resource + \", test_os=\" + test_os)\n"; }
			print("	location.replace(\"rs-os-test-set.php?OrderBy=\" + orderby + \"&Resource=\" + resource + \"&selected_testos=\" + test_os)");
?>
		}
	</SCRIPT>
</HEAD>

<BODY BGPROPERTIES=FIXED BGCOLOR="#FFFFFF" TEXT="#000000">
<?PHP
	include 'db-open.php';

	$query="SELECT id,server,ip_pri,ip_sec,ip_drac,owner,arch,location,memory,fibre,status,static_config,due_date,state,test_os FROM $table_name WHERE state>0 ORDER BY $OrderBy";
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

	// Menu
	echo "<P CLASS=\"head3b\" ALIGN=\"center\">[ <A HREF=\"check-out.html\">Check Out Procedure</A> | <A HREF=\"rs-all.php?OrderBy=$OrderBy\">List</A> All Resources | <A HREF=\"rs-add.php\">Add</A> a Resource ]</P>\n";
	echo "<P CLASS=\"text\" ALIGN=\"center\">(Auto Refreshes Every $ResourceRefresh Seconds)</P>\n";

	// Create table header
	echo "<TABLE ALIGN=\"center\" WIDTH=90% CELLPADDING=2>\n";
	echo "<TR CLASS=\"head_2\">\n";
	echo "  <TH CLASS=\"head_2\">Edit</TH>\n";
	echo "  <TH><A HREF=\"resources.php?OrderBy=server&OrderDir=$OrderDir\" CLASS=\"head_2\">Host Name</A></TH>\n";
	echo "  <TH><A HREF=\"resources.php?OrderBy=ip_pri\" CLASS=\"head_2\">IP Addresses</A></TH>\n";
	echo "  <TH><A HREF=\"resources.php?OrderBy=owner,ip_pri\" CLASS=\"head_2\">Assigned To</A></TH>\n";
	echo "  <TH><A HREF=\"resources.php?OrderBy=status,arch,ip_pri\" CLASS=\"head_2\">Status</A></TH>\n";
	echo "  <TH><A HREF=\"resources.php?OrderBy=test_os,ip_pri\" CLASS=\"head_2\">Current OS</A></TH>\n";
	echo "  <TH><A HREF=\"resources.php?OrderBy=arch,ip_pri\" CLASS=\"head_2\">Arch</A></TH>\n";
	echo "  <TH><A HREF=\"resources.php?OrderBy=static_config,ip_pri\" CLASS=\"head_2\">Used in<BR>Static<BR>Config</A></TH>\n";
	echo "  <TH><A HREF=\"resources.php?OrderBy=location,ip_pri\" CLASS=\"head_2\">Location</A></TH>\n";
	echo "  <TH><A HREF=\"resources.php?OrderBy=memory,ip_pri\" CLASS=\"head_2\">RAM</A></TH>\n";
	echo "  <TH><A HREF=\"resources.php?OrderBy=fibre,ip_pri\" CLASS=\"head_2\">Fibre Card</A></TH>\n";
	echo "  <TH><A HREF=\"resources.php?OrderBy=due_date,ip_pri\" CLASS=\"head_2\">Due Date</A></TH>\n";
	echo "</TR>\n";

	for ( $i=0, $active_num=0; $i < $num; $i++ ) {
		$row_cell = mysql_fetch_row($result);
		$state = $row_cell[13];

		// Skip Passive resources
		if ( $state == 0 ) { continue; } else { $active_num++; }

		$id = $row_cell[0];
		$server = $row_cell[1];
		$ip_pri = $row_cell[2];
		$ip_sec = $row_cell[3];
		$ip_drac = $row_cell[4];
		$owner = $row_cell[5];
		$arch = $row_cell[6];
		$location = $row_cell[7];
			if ( $location == "" ) { $location="&nbsp;"; }
		$memory = $row_cell[8];
			if ( $memory == "" ) { $memory="&nbsp;"; }
		$fibre = $row_cell[9];
			if ( $fibre == "" ) { $fibre="&nbsp;"; }
		$status = $row_cell[10];
		$static_config = $row_cell[11];
			if ( $static_config > 0 ) { $static_config_state = "<A HREF=\"rs-static-show.php?StaticID=$static_config&OrderBy=$OrderBy\"><FONT COLOR=\"red\">Yes</FONT></A>"; } else { $static_config_state = "No"; }
		$due_date = $row_cell[12];
			if ( $due_date == 0 ) { $due_date="&nbsp;"; }
		$test_os = $row_cell[14];

		// Set row color
		if ( $i%2 == 0 ) {
			$row_color="tdGrey";
		} else {
			$row_color="tdGreyLight";
		}

		//Create table rows with data
		echo "<TR ALIGN=\"center\" CLASS=\"$row_color\">\n";
		echo "  <TD><A HREF=\"rs-edit.php?OrderBy=$OrderBy&Resource=$id&CalledBy=resources\">Edit</A></TD>\n";
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
		echo "  <TD>";
			if ( $owner ) {
				echo "<FONT COLOR=\"red\">$owner</FONT><BR>";
				switch ( $status ) {
				case "Call":
					break;
				case "Appliance":
					break;
				case "Console":
					break;
				default:
					echo "<A HREF=\"rs-owner-clear.php?OrderBy=$OrderBy&Resource=$id\">Clear</A>";
					break;
				}
			} else {
				echo "\n  <SELECT CLASS=\"formtext\" NAME=\"form_owner\" CLASS=\"text\" onChange=\"SetOwner('" . $OrderBy . "', '" . $id . "', this.options[this.selectedIndex].value);\">\n";
				include 'form-owners.php';
			}
		echo "  </TD>\n";
		echo "  <TD>";
		switch ( $status ) {
		case "Call":
			echo "<FONT COLOR=\"red\">$status</FONT>";
			break;
		case "Appliance":
			echo "$status";
			break;
		case "Console":
			echo "$status";
			break;
		default:
			echo "\n  <SELECT NAME=\"form_status\" CLASS=\"text\" onChange=\"SetStatus('" . $OrderBy . "', '" . $id . "', '" . $owner . "', this.options[this.selectedIndex].value);\">\n";
			include 'form-status.php';
			break;
		}
		echo "  </TD>\n";
		echo "  <TD>";
			echo "\n  <SELECT NAME=\"form_testos\" CLASS=\"text\" onChange=\"SetTestOS('" . $OrderBy . "', '" . $id . "', this.options[this.selectedIndex].value);\">\n";
			include 'form-os-test.php';
		echo "  </TD>\n";
		echo "  <TD>$arch</TD>\n";
		echo "  <TD>$static_config_state</TD>\n";
		echo "  <TD>$location</TD>\n";
		echo "  <TD>$memory</TD>\n";
		echo "  <TD>$fibre</TD>\n";
		echo "  <TD>$due_date</TD>\n";
		echo "</TR>\n";
	}
	
	echo "</TABLE>\n";
	$num = $active_num;
	echo "<P CLASS=\"tdGrey\">Number of Active Resources: $num</P>\n";

	echo "</HTML>\n";
	echo "</BODY>\n";
?>

