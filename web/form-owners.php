<?PHP

$owners_array = array(
'BMEMMOTT_1-7414',
'BSNOW_1-7413',
'DEHARRIS_1-2972',
'DMETHESON_1-2986',
'GMELO_1-7843',
'JHODGE_1-3936',
'JMORTENSON_1-7307',
'JNORRIS_1-9142',
'JPETERSEN_1-9346',
'JRECORD_1-5955',
'JSHORT_1-9284',
'JSUMSION_1-8269',
'KPENROSE_1-9477',
'LDLEWIS_1-9334',
'MHASLETON_1-2632',
'MLATIMER_1-7609',
'MPOST_248-630-6135',
'LVANCE_1-7359',
'RBRUNT_1-8203',
'RHASLETON_1-9333',
);

echo "    <OPTION>Unassigned</OPTION>\n";
if ( isset($owner) ) {
	foreach ( $owners_array as $this_owner ) {
		if ( $owner == $this_owner ) {
			echo "    <OPTION SELECTED>$this_owner</OPTION>\n";
		} else {
			echo "    <OPTION>$this_owner</OPTION>\n";
		}
	}
} else {
	foreach ( $owners_array as $this_owner ) {
		echo "    <OPTION>$this_owner</OPTION>\n";
	}
}
echo "  </SELECT>\n";
?>
