<?php

return [

    // Remove from logs sensitive keys
    'logs' => [
        // When set empty whitelist array, all config values will be redacted.
        // When set min one value only this value will be redacted.
        'whitelist' => [
          //  'app.key',
          //  'mail.mailers.smtp.password',
     //       'database.connections.mysql.password'
        ],
        'blacklist' => [
            'app.name'
        ],
    ]
];