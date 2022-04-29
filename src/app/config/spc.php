<?php
use yii\helpers\Url;
defined('SPC_API_URL') or define('SPC_API_URL', $_ENV['SPC_API_URL'] ?? 'http://spc_api_failed');
defined('BASE_URL') or define('BASE_URL', $_ENV['BASE_URL'] ?? 'http://127.0.0.1:8000');

return [
    'url' => SPC_API_URL,
    'local' => BASE_URL . '/api',
];
