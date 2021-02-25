<?php

$config = [
	'sets' => [
        'dfntest' => [
            'cron'		=> ['hourly'],
            'sources'	=> [
                [
                    'whitelist'     => [
                        'https://testidp.aai.dfn.de/idp/shibboleth',
                        'https://testidp2-dev.aai.dfn.de/idp/shibboleth',
                        'https://testidp3-dev.aai.dfn.de/idp/shibboleth',
                    ],
                    'src' => 'http://www.aai.dfn.de/fileadmin/metadata/dfn-aai-test-metadata.xml',
                    'certificates' => ['dfn-aai.pem'],
                    //'validateFingerprint' => 'cbf57ce9e8b1bf2abd0605bd943a0ce505829325',
                    'template' => [
                        'tags' => ['dfntest'],
                        'authproc'  => [
                            50 => array(
                                'class' => 'core:GenerateGroups',
                                'eduPersonScopedAffiliation',
                            ),
                            90 => [
                                'class' => 'saml:FilterScopes',
                            ],
                        ],
                    ],
                ],
            ],
            'types'         => ['saml20-idp-remote'],
            'expireAfter'   => 60*60*24*4, // Maximum 4 days cache time.
            'outputDir' 	=> 'metadata/dfntest/',
            'outputFormat'  => 'flatfile',
        ],
		'dfn' => [
			'cron'		=> ['hourly'],
			'sources'	=> [
                [
                    'whitelist'     => [
                        'https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/metadata.php',
                    ],
					'src' => 'http://www.aai.dfn.de/fileadmin/metadata/dfn-aai-basic-metadata.xml',
                    'certificates' => ['dfn-aai.pem'],
					//'validateFingerprint' => 'cbf57ce9e8b1bf2abd0605bd943a0ce505829325',
					'template' => [
						'tags'	    => ['dfn'],
                        'authproc'  => [
                            50 => array(
                                'class' => 'core:GenerateGroups',
                                'eduPersonScopedAffiliation',
                            ),
                            90 => [
                                'class' => 'saml:FilterScopes',
                            ],
                        ],
					],
				],
			],
            'types'         => ['saml20-idp-remote'],
			'expireAfter' 	=> 60*60*24*4, // Maximum 4 days cache time.
			'outputDir' 	=> 'metadata/dfn/',
			'outputFormat'  => 'flatfile',
		],
	],
];
