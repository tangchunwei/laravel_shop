<?php
return [
    'alipay' => [
        'app_id'         => '2016092000555469',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAsg/lq1SWlmW3ZVNge93N5G9GJbRQwckMU1veNH38E9kcjKNkdB2l+qEVzthzU+cxw6Bum63biY2bfb9NjDgSp8wpe9aUGLQl3OnEPdG4nL8+Qc9UFTx0pDMmOxqXgVGi0IAcad7HSa0mmmp0KD7wqU2LmOkKAAy+NX8A3JGl3co87sfPeCEn+z71wlHqDNGab0DxdmJmNYkifLExZWiD1oArprQ15SWIWMuopaZ3gXxnNiN96QmL03bDiHenrepBZdW3wDHfrS9/nDmbA1mYTrCnzvf8/VQcBU4rWdNTQBKh7uj3HopwVrxnuxDiHrmpykNXjjWvgsEJb9aD/jJx4wIDAQAB',
        'private_key'    => 'MIIEpAIBAAKCAQEA8HqW7YybZsmwr9q0ODLUet6ROCdCb2EcUYduQeyPNSErjrzc0btay90Z1XtSJ/0Z2TbV6TKgV+Y+csO+M6j8WkJCVAVSw9XHbSW0Mn9AX9JCIblwQyVljOzvhEc6UL4hsQ6DQ/jUoWyQcUz+bd2iFBM8xKRbWeEvYsUo9MadbVSvYMOWbfb/sgsaUMiSBfl4jJTqJB/0EGLcjn0nPDZor/qY0OnSf+3IWFG5KROIkU4kEO2EsXn5pcpIM7PKd70V0SvHmKDR9e5dvHfscyL8Xg5FBsQmgTb7/pZ6D8zqpJ+cl3CDlGxVF/VcZMELe62eHvBU+m/uTNYRmQDkUNNjswIDAQABAoIBAEpsBe16SFWlMZMawg9qW6uy2YphTAQgL51jplGsnh05KLvB4yzdKJpS0L3qrmBFygwZFlZXHpxVWxo1TdW7BG4Cd3h9NUH6FP/IXV4LV6bP8TtyojWFi0nzwaRUTs3SKacb8K/GgDd8267UvyDNKG3CDlpk6wiD0iBlF+m41duRciRvDif3VOGeG2wpbBfKXk85cqA86Svy+HP4fW//ssdN33vyCGZpjzkZG8Z5B1MgX3Fi+YGMk6wmhE5G/AVqpq+okqOFVP38nRZVO9m2vu+sJuvVkhyDjaZCWMfdcep0OjN4KCcPh7ANVF5sz6c2fhnQV3WI/iWUA7ANf/nOIyECgYEA/FoSe3wpJ/G+2AL1KoMyyG4+T5SQqHmVJFGGSsOIDZT7ozRYlnD7nBVZ4DyTrV/Blfm+Ga6Cc6twrIbP3WOQu0zl6TX979FXyZJ45SjS0IGUeeV9+z7nq7pODm/BOUP87ho+CRvFyQxCnVHVn+QvSJ8hEvBJxPch41UjDL6NptsCgYEA8/STo1NHITmB47YMQDDHELuPtSwHPLwWV320EqoLS3EE+5jC9gaXOSC1MSg3e+um7YqYhePQjmzuMFpTc1jNqWz7ZRyVmTiv/Gj54Fobwad5iJY5PqU4Y87Y+uHuCKw24ZY8GeW78c9NNZ+DnaAMpLYUKH6Eus8gLx9fuO8RcgkCgYEA7MTOJpJeQx4tA5vyz8p9cVUOnbg06f35kzPynl9LXgL0/zH0FGM5kD7wLtZncPoxNjg2xv3XZBPtCdMLYRs0Bqil5uRDuClhBr2pNMnS0tNhreVHCN8CmzuYVS9ByisiO3zfy8gFERexwM2xc+2y955md9CARo/hedy9oA2B9pUCgYEA0hirYXhiBMobA/oPmOSpO87cV8IgRX0SnKzEfWJ2sbUW/ns0RF+usuNpSHmDNzTeoSrAamalgVNs2rWfsvIixKv34b95UujQH0hlEoNn7iKGd0ww5rOx2bsVgRM8RbnS1frlrcP9VaYbr3e+CO0CloO83pb/RkcFR6/0Zzd0xckCgYBv0Yf+dYOOFNINbpHM6P3C9W/6xy3DKCaFlngTAgEkP1viPIrfPQ7UDa2H6WDvaCRsrUT21qcI5MUNETUZtTQoJS2nUaY5ofHMyIP03u3Q2+p6WfWA7hD7SCF+kNATRhU4Y6XEtVhS9O9OWehywSt+MClSorWWly8cfbYjmm1BFw==',
        'log'            => [
            'file' => storage_path('logs/alipay.log'),
        ],
    ],

    'wechat' => [
        'app_id'      => 'wx4cbc0a5a5e78d748',
        'mch_id'      => '1511187271',
        'key'         => '8934e7d15453e97507ef794cf7b0519d',
        'cert_client' => resource_path('wechat_pay/apiclient_cert.pem'),
        'cert_key'    => resource_path('wechat_pay/apiclient_key.pem'),
        'log'         => [
            'file' => storage_path('logs/wechat_pay.log'),
        ],
    ],
];