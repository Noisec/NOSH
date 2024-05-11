<?php

$blocked_domains = array(
    'doubleclick.net',

);

$url = $_GET['url'];

if ($url === 'https://t2.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url=http://undefined&size=16') {
    header('Content-Type: image/jpeg');
    readfile('n.jpg');
    exit;
}

foreach ($blocked_domains as $domain) {
    if (strpos($url, $domain) !== false) {
        http_response_code(403); // Forbidden
        echo json_encode(array(
            'error' => 'disallowed'
        ));
        exit;
    }
}

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true
]);
$response = curl_exec($curl);
$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($http_status === 200) {
    header('Content-Type: application/json');
    echo $response;
} else {
    http_response_code($http_status);
    echo json_encode(array(
        'error' => 'err'
    ));
}
?>
