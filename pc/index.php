<?php
error_reporting(0);
$randomNumber = rand(1, 258);
$imageUrl = 'https://cdn.jsdelivr.net/gh/couldflyer/allimg@main/pc/img' . $randomNumber . '.webp';

// 使用file_get_contents替代
function fetchImage($url) {
    $context = stream_context_create([
        'http' => ['ignore_errors' => true],
        'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
    ]);
    $data = @file_get_contents($url, false, $context);
    return ($data !== false) ? $data : false;
}

$imageData = fetchImage($imageUrl);
if ($imageData !== false) {
    header('Content-Type: image/webp');
    echo $imageData;
} else {
    header('Content-Type: text/html');
    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>图片加载失败</title>
        <style>
            body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
            .error { color: #d9534f; margin-bottom: 20px; }
        </style>
    </head>
    <body>
        <div class="error">图片加载失败 (URL: '.htmlspecialchars($imageUrl).')</div>
        <div>尝试刷新页面或稍后再试</div>
    </body>
    </html>';
}
?>