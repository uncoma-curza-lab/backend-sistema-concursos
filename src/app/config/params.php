<?php

$spc = require __DIR__ . '/spc.php';
$nextcloud = require __DIR__ . '/nextcloud.php';

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'spc' => $spc,
    'nextcloud' => $nextcloud,
    'bsVersion' => '4.x',
];
