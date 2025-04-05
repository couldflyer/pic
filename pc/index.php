<?php
error_reporting(0);
$randomNumber = rand(1, 258);
$imageUrl = 'https://raw.gitmirror.com/couldflyer/allimg/main/pc/img' . $randomNumber . '.webp';

// 使用 file_get_contents 替代 cURL
function fetchImage($url) {
    // 禁用 SSL 验证（避免 HTTPS 证书问题）
    $context = stream_context_create([
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
        'http' => [
            'ignore_errors' => true,  // 即使 404 也返回内容
        ],
    ]);
    
    $data = @file_get_contents($url, false, $context);
    return ($data !== false) ? $data : false;
}

$imageData = fetchImage($imageUrl);

if ($imageData !== false) {
    // 检查是否是有效的图片
    if (@imagecreatefromstring($imageData) !== false) {
        header('Content-Type: image/webp');
        echo $imageData;
    } else {
        header('Content-Type: text/html');
        echo '图片数据无效';
    }
} else {
    header('Content-Type: text/html');
    echo '图片加载失败 (URL: ' . htmlspecialchars($imageUrl) . ')';
}
?>