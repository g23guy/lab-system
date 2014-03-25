<?PHP

$arch_array = array(
'x86_64',
'ppc64',
'ia64',
'i386',
's390x',
'StaticIP',
'Appliance',
'Switch',
'SAN',
'Other'
);

echo "  <SELECT NAME=\"form_arch\" CLASS=\"text\">\n";
if ( isset($arch) ) {
	foreach ( $arch_array as $this_arch ) {
		if ( $arch == $this_arch ) {
			echo "    <OPTION SELECTED>$this_arch</OPTION>\n";
		} else {
			echo "    <OPTION>$this_arch</OPTION>\n";
		}
	}
} else {
	foreach ( $arch_array as $this_arch ) {
		echo "    <OPTION>$this_arch</OPTION>\n";
	}
}
echo "  </SELECT>\n";
?>
