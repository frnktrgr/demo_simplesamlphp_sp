<?php

$config = [
    /*
     * Global blacklist: entityIDs that should be excluded from ALL sets.
     */
    #'blacklist' = array(
    #    'http://my.own.uni/idp'
    #),

    /*
     * Conditional GET requests
     * Efficient downloading so polling can be done more frequently.
     * Works for sources that send 'Last-Modified' or 'Etag' headers.
     * Note that the 'data' directory needs to be writable for this to work.
     */
    #'conditionalGET' => true,

    'sets' => [

        'dfntest' => [
            'cron' => ['hourly'],
            'sources' => [
                [
                    /*
                     * entityIDs that should be excluded from this src.
                     */
                    #'blacklist' => array(
                    #    'http://some.other.uni/idp',
                    #),

                    /*
                     * Whitelist: only keep these EntityIDs.
                     */
                    #'whitelist' => array(
                    #    'http://some.uni/idp',
                    #    'http://some.other.uni/idp',
                    #),

                    #'conditionalGET' => true,
                    'src' => 'http://www.aai.dfn.de/fileadmin/metadata/dfn-aai-test-metadata.xml',
                    'certificates' => ['dfn-aai.pem'],
                    'template' => [
                        'tags' => ['dfntest'],
                        'authproc' => [
                            40 => ['class' => 'saml:FilterScopes'],
                            50 => ['class' => 'core:GenerateGroups', 'eduPersonScopedAffiliation'],
                        ],
                    ],
                ],
            ],

            'expireAfter' => 34560060, // Maximum 4 days cache time (3600*24*4)
            'outputDir' => 'metadata/dfntest/',
            'outputFormat' => 'flatfile',
            'types' => ['saml20-idp-remote'],
        ],
        'dfn' => [
            'cron' => ['hourly'],
            'sources' => [
                [
                    'src' => 'http://www.aai.dfn.de/metadata/dfn-aai-idp-metadata.xml',
                    'certificates' => ['dfn-aai.pem'],
                    'template' => [
                        'tags' => ['dfn'],
                        'authproc' => [
                            40 => ['class' => 'saml:FilterScopes'],
                            50 => ['class' => 'core:GenerateGroups', 'eduPersonScopedAffiliation'],
                        ],
                    ],
                ],
            ],

            'expireAfter' => 34560060, // Maximum 4 days cache time (3600*24*4)
            'outputDir' => 'metadata/dfn/',
            'outputFormat' => 'flatfile',
            'types' => ['saml20-idp-remote'],
        ],
    ],
];
