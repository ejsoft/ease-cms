<?php
/**
 * Entry point
 */

/* PHP version validation */
if (!defined('PHP_VERSION_ID') || !(PHP_VERSION_ID >= 70000)) {
    if (PHP_SAPI == 'cli') {
        echo 'This script requires PHP 7 or later, but you&rsquo;re running ' . PHP_VERSION . '. Please talk to your host/IT department about upgrading PHP or your server.' . PHP_EOL;
    } else {
        $version = PHP_VERSION;
        echo <<<HTML
<div style="font:12px/1.35em arial, helvetica, sans-serif;">
    <p>This script requires PHP 7 or later, but you&rsquo;re running {$version}. Please talk to your host/IT department about upgrading PHP or your server.</p>
</div>
HTML;
    }
    exit(1);
}

define('PROTECTED_DIR', dirname(__DIR__) . '/protected');
define('VENDOR_DIR', PROTECTED_DIR . '/vendor');

if (file_exists(dirname(__DIR__) . '/.dev')) {
    define('YII_ENV', 'dev');
}

$bootstrap = VENDOR_DIR . '/ejsoft/ej-core/bootstrap.php';

try {
    if (!file_exists($bootstrap)) {
        throw new \Exception(
            'We can\'t read some files that are required to run the application. '
            . 'This usually means file permissions are set incorrectly.'
        );
    }
    require $bootstrap;
} catch (\Exception $e) {
    echo <<<HTML
<!DOCTYPE html>   
<html>
    <head>
        <meta charset="UTF-8">
        <title>Autoload error - #{$e->getCode()}</title>
    </head>
    <body>
        <div style="font:12px/1.35em arial, helvetica, sans-serif;">
            <div style="margin:0 0 15px 0; border-bottom:1px solid #ccc;">
                <h3 style="margin:12px 0;font-size:1.7em;font-weight:normal;text-transform:none;text-align:left;color:#2f2f2f;">Autoload error</h3>
            </div>
            <p>{$e->getMessage()}</p>
        </div>
    </body>
</html>
HTML;
    exit(1);
}

(new \ej\base\Boot())
    ->apply('\ej\web\Application')
    ->run();