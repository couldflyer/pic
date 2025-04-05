<?php

// 生成1到258之间的随机数
$randomNumber = rand(1, 450);
$imageUrl = 'https://raw.gitmirror.com/couldflyer/allimg/main/pe/img' . $randomNumber . '.webp';

// 尝试使用cURL获取图片（比file_get_contents更可靠）
function fetchImage($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $data = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return ($httpCode == 200) ? $data : false;
}

// 尝试获取图片
$imageData = fetchImage($imageUrl);

if ($imageData !== false) {
    // 成功获取图片
    header('Content-Type: image/webp');
    echo $imageData;
} else {
    // 图片获取失败，显示错误信息或备用图片
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