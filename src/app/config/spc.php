<?php

defined('SPC_API_URL') or define('SPC_API_URL', $_ENV['SPC_API_URL'] ?? 'http://spc_api_failed');

return [
    'url' => SPC_API_URL
];
