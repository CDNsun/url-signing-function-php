<?php 
function UrlSigning($scheme="http", $cdnResourceUrl, $filePath="/", $secretKey="", $expiryTimestamp = "", $clientIp = "") {
    
    if (empty($scheme) || empty($cdnResourceUrl)) {
        exit("First argument \"scheme\" and/or second argument \"cdnResourceUrl\" cannot be empty.");
    }

    // NOTE: We adhere to ngx_secure_link_module hashing strategy
    // Ref: http://nginx.org/en/docs/http/ngx_http_secure_link_module.html#secure_link
    $searchChars = array('+', '/', '=');
    $replaceChars = array('-', '_', '');
    
    // 1. Setup Token Key
    // 1.1 Append leading slash if missing
    if ($filePath[0] != '/') {    
        $filePath = "/{$filePath}";
    }
    // 1.2 Extract uri, ignore arguments
    if ($pos = strpos($filePath, '?')) {    
        $filePath = substr($filePath, 0, $pos);
    }
    // 1.3 Formulate the token key
    $tokenKey = $expiryTimestamp . $filePath . $secretKey . $clientIp;
    
    // 2. Setup URL
    // 2.1 Append argument - secure (compulsory)
    $urlStr = "{$scheme}://{$cdnResourceUrl}?secure=" . str_replace($searchChars, $replaceChars, base64_encode(md5($tokenKey, TRUE)));   
    // 2.2 Append argument - expires
    if (!empty($expiryTimestamp) || $expiryTimestamp === "0" || $expiryTimestamp === 0){
        $urlStr .= "&expires={$expiryTimestamp}";
    }
    // 2.3 Append argument - ip
    if (!empty($clientIp)) {
        $urlStr .= "&ip={$clientIp}";
    }
    
    return $urlStr;
}
?>
