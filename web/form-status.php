<?PHP

$status_array = array(
'Available',
'Quick Test',
'Short Test',
'Long Test',
'Checked Out',
'Static',
'Shared',
'Console',
'Extended',
'Appliance',
'Broken',
'Busy',
'Call'
);

if ( isset($status) ) {
	foreach ( $status_array as $this_status ) {
		if ( $status == $this_status ) {
			echo "    <OPTION SELECTED>$this_status</OPTION>\n";
		} else {
			echo "    <OPTION>$this_status</OPTION>\n";
		}
	}
} else {
	foreach ( $status_array as $this_status ) {
		echo "    <OPTION>$this_status</OPTION>\n";
	}
}
echo "  </SELECT>\n";
?>
