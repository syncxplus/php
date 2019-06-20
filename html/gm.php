<?php

$fontName = 'SourceHanSansSC-Normal.otf';
$fontFile = "/tmp/$fontName";
if (!is_file($fontFile)) {
    curlFile("https://github.com/adobe-fonts/source-han-sans/raw/release/OTF/SimplifiedChinese/$fontName", $fontFile);
}

$imageName = 'onlymaker.png';
$imageFile = "/tmp/$imageName";
if (is_file($imageFile)) {
    unlink($imageFile);
}
curlFile("https://qiniu.syncxplus.com/logo/$imageName", $imageFile);

try {
    $draw = new GmagickDraw;
    $draw->setfont($fontFile);
    $draw->setfontsize(50);
    $draw->setfillcolor('red');
    $draw->annotate(100, 100, '思源黑体');
    $gm = new Gmagick($imageFile);
    $data = $gm->drawimage($draw);
    if (PHP_SAPI == 'cli') {
        file_put_contents($imageFile, $data);
        echo $imageFile, PHP_EOL;
    } else {
        header('Content-type: image/png');
        echo $data;
    }
} catch (Throwable $t) {
    print_r($t);
}

function curlFile($url, $path)
{
    ini_set('max_execution_time', 1800);
    $cl = curl_init();
    curl_setopt($cl, CURLOPT_URL, $url);
    curl_setopt($cl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($cl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($cl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($cl, CURLOPT_RETURNTRANSFER, true);
    file_put_contents($path, curl_exec($cl));
    curl_close($cl);
}
