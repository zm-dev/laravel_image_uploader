<?php

return [
    'table_name' => 'images',
    'disk' => 'local',
    'url' => [
        'imageproxy' => [
            'imageproxy_host' => 'http://localhost:8080',
            'base_url' => 'http://minio:9000',
            'bucket_name' => 'bucket',
            'omit_base_url' => false
        ]
    ],
];