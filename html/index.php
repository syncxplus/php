<?php

define('HTML', __DIR__);
define('ROOT', dirname(HTML));
define('RUNTIME', ROOT . '/runtime');

require_once ROOT . '/vendor/autoload.php';

call_user_func(function (Base $f3) {
    $f3->config([
        ROOT . '/cfg/system.ini',
        ROOT . '/cfg/map.ini',
        ROOT . '/cfg/route.ini',
        ROOT . '/cfg/local.ini',
    ]);

    $sysDirs = [
        'logs' => ROOT . '/runtime/logs/',
        'uploads' => ROOT . '/runtime/uploads/',
    ];

    foreach ($sysDirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, Base::MODE, true);
        }
    }

    $f3->mset([
        'AUTOLOAD' => ROOT . '/src/',
        'LOCALES' => ROOT . '/dict/',
        'LOGS' => $sysDirs['logs'],
        'UI' => ROOT . '/tpl/',
        'UPLOADS' => $sysDirs['uploads'],
    ]);

    if ($f3->get('AJAX')) {
        $f3->set('ONERROR', function (Base $f3) {
            echo json_encode($f3->get('ERROR'), JSON_UNESCAPED_UNICODE);
        });
    } else {
        if (!$f3->get('DEBUG')) {
            $f3->set('ONERROR', function () {
                echo Template::instance()->render('error.html');
            });
        }
    }

    $f3->set('LOGGER', new Log(date('Y-m-d.\l\o\g')));

    if (PHP_SAPI != 'cli') {
        $f3->run();
    }
}, Base::instance());
