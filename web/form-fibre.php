<?PHP

$fibre_array = array(
'None',
'QLogic 1 Port',
'QLogic 2 Port',
'Emulex 1 Port',
'Emulex 2 Port',
'Other 1 Port',
'Other 2 Port'
);

echo "  <SELECT NAME=\"form_fibre\" CLASS=\"text\">\n";
if ( isset($fibre) ) {
	foreach ( $fibre_array as $this_fibre ) {
		if ( $fibre == $this_fibre ) {
			echo "    <OPTION SELECTED>$this_fibre</OPTION>\n";
		} else {
			echo "    <OPTION>$this_fibre</OPTION>\n";
		}
	}
} else {
	foreach ( $fibre_array as $this_fibre ) {
		echo "    <OPTION>$this_fibre</OPTION>\n";
	}
}
echo "  </SELECT>\n";
?>
