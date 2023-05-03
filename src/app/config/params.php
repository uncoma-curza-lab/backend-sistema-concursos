<?php

$spc = require __DIR__ . '/spc.php';
$nextcloud = require __DIR__ . '/nextcloud.php';

$metatagImage = "https://admin.curza.uncoma.edu.ar/concursos/wp-content/uploads/sites/12/2023/04/CURZA-Portada-WEB-y-YT-CONCURSO-NODOS.png";
return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'spc' => $spc,
    'nextcloud' => $nextcloud,
    'bsVersion' => '4.x',
    'metadata' => [
        'name' => 'Sistema de Concursos',
        'description' => 'Sistema para incripción y evaluación de concursos docentes de la Centro Universitario Regional Zona Atlantica de la Universidad Nacional del Comahue',
        'image' => $metatagImage,
    ],
];
