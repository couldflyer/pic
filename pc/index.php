<?php
$testUrl = 'https://raw.gitmirror.com/couldflyer/allimg/main/pc/img1.webp';
echo file_get_contents($testUrl) ? '成功' : '失败';
?>