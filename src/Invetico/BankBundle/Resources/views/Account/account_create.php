<?php

/*
'prefix' is the start of the CC number as a string, any number of digits.
'length' is the length of the CC number to generate. Typically 13 or 16
*/
function completed_number($prefix, $length) {
    $ccnumber = $prefix;
    # generate digits
    while ( strlen($ccnumber) < ($length - 1) ) {
        $ccnumber .= rand(0,9);
    }
    # Calculate sum
    $sum = 0;
    $pos = 0;
    $reversedCCnumber = strrev( $ccnumber );
    while ( $pos < $length - 1 ) {
        $odd = $reversedCCnumber[ $pos ] * 2;
        if ( $odd > 9 ) {
            $odd -= 9;
        }
        $sum += $odd;
        if ( $pos != ($length - 2) ) {
            $sum += $reversedCCnumber[ $pos +1 ];
        }
        $pos += 2;
    }
    # Calculate check digit
    $checkdigit = (( floor($sum/10) + 1) * 10 - $sum) % 10;
    $ccnumber .= $checkdigit;
    return $ccnumber;
}
function credit_card_number($prefixList, $length, $howMany) {
    for ($i = 0; $i < $howMany; $i++) {
        $ccnumber = $prefixList[ array_rand($prefixList) ];
        $result[] = completed_number($ccnumber, $length);
    }
    return $result;
}


    $bin = 'boabramah';
    $length = 16;	

    //$bin = $_POST['bin'];
	//$length = $_POST['length'];
	if ( $length == 0 )
		$length = 16;
	if ( $bin != '' )
		$cardNumber = completed_number( $bin, $length );
	echo "Generate card number<br>";
	echo "<form action='index.php' method='post'>";
	echo "<table>";
	echo "<tr><td>BIN:</td><td> <input name='bin' value='$bin' onfocus='select()'/></td></tr>";
	echo "<tr><td>Length:</td><td> <input name='length' value='$length'/></td></tr>";
	echo "<tr><td>Card Number:</td><td> <input name='cardNumber' value='$cardNumber'/></td></tr>";
	echo "<input type='submit'>";
	echo "</form>";
	echo "<br>BINs: MC:51/16 to 55/16; VISA:4/13 and 4/16; AMEX: 34/15 and 37/15; VIAS: 9528/16";

    echo '</table>';
