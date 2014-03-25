<?PHP

include 'form-os-array.php';

if ( isset($static_os) ) {
	foreach ( $os_array as $this_os ) {
		if ( $static_os == $this_os ) {
			echo "    <OPTION SELECTED>$this_os</OPTION>\n";
		} else {
			echo "    <OPTION>$this_os</OPTION>\n";
		}
	}
} else {
	foreach ( $os_array as $this_os ) {
		echo "    <OPTION>$this_os</OPTION>\n";
	}
}
echo "  </SELECT>\n";
?>
