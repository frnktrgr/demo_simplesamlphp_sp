<?php

$config = [
	'sets' => [
        'dfntest' => [
            'cron'		=> ['hourly'],
            'sources'	=> [
                [
                    'src' => 'http://www.aai.dfn.de/fileadmin/metadata/dfn-aai-test-metadata.xml',
                    'certificates' => ['dfn-aai.pem'],
                    //'validateFingerprint' => 'cbf57ce9e8b1bf2abd0605bd943a0ce505829325',
                    'template' => [
                        'tags' => ['dfntest'],
                    ],
                ],
            ],
            'expireAfter'   => 60*60*24*4, // Maximum 4 days cache time.
            'outputDir' 	=> 'metadata/dfntest/',
            'outputFormat'  => 'flatfile',
        ],
		'dfn' => [
			'cron'		=> ['hourly'],
			'sources'	=> [
                [
					'src' => 'http://www.aai.dfn.de/fileadmin/metadata/dfn-aai-basic-metadata.xml',
                    'certificates' => ['dfn-aai.pem'],
					//'validateFingerprint' => 'cbf57ce9e8b1bf2abd0605bd943a0ce505829325',
					'template' => [
						'tags'	    => ['dfn'],
					],
				],
			],
			'expireAfter' 	=> 60*60*24*4, // Maximum 4 days cache time.
			'outputDir' 	=> 'metadata/dfn/',
			'outputFormat'  => 'flatfile',
		],
	],
];
