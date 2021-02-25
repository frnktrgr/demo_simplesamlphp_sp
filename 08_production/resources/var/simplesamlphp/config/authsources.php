<?php

$config = [
    /*
     * When multiple authentication sources are defined, you can specify one to use by default
     * in order to authenticate users. In order to do that, you just need to name it "default"
     * here. That authentication source will be used by default then when a user reaches the
     * SimpleSAMLphp installation from the web browser, without passing through the API.
     *
     * If you already have named your auth source with a different name, you don't need to change
     * it in order to use it as a default. Just create an alias by the end of this file:
     *
     * $config['default'] = &$config['your_auth_source'];
     */

    // This is a authentication source which handles admin authentication.
    'admin' => [
        // The default is to use core:AdminPassword, but it can be replaced with
        // any authentication source.

        'core:AdminPassword',
    ],


    // An authentication source which can authenticate against both SAML 2.0
    // and Shibboleth 1.3 IdPs.
    'default-sp' => [
        'saml:SP',

        // The entity ID of this SP.
        // Can be NULL/unset, in which case an entity ID is generated based on the metadata URL.
        'entityID' => 'https://sso-dev.fau.de/devssp/module.php/saml/sp/metadata.php/default-sp',

        'privatekey' => 'sso-dev.fau.de.pem',
        'certificate' => 'sso-dev.fau.de.crt',

        'NameIDPolicy' => ['Format' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent', 'allowcreate' => true],

        'sign.logout' => true,

        // The entity ID of the IdP this SP should contact.
        // Can be NULL/unset, in which case the user will be shown a list of available IdPs.
        'idp' => null,

        // The URL to the discovery service.
        // Can be NULL/unset, in which case a builtin discovery service will be used.
        'discoURL' => 'https://wayf.aai.dfn.de/DFN-AAI-Test/wayf',

        /*
         * The attributes parameter must contain an array of desired attributes by the SP.
         * The attributes can be expressed as an array of names or as an associative array
         * in the form of 'friendlyName' => 'name'. This feature requires 'name' to be set.
         * The metadata will then be created as follows:
         * <md:RequestedAttribute FriendlyName="friendlyName" Name="name" />
         */
        'name' => [
            'en' => 'My Awesome PHP App',
            'de' => 'Meine tolle PHP Anwendung',
        ],

        'attributes' => [
            'eduPersonPrincipalName' => 'urn:oid:1.3.6.1.4.1.5923.1.1.1.6',
        ],
        'attributes.required' => [
            'urn:oid:1.3.6.1.4.1.5923.1.1.1.6',
        ],
        'attributes.NameFormat' => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
        'UIInfo' => [
            'DisplayName' => [
                'en' => 'Meine tolle PHP Anwendung',
                'de' => 'Meine tolle PHP Anwendung',
            ],
            'Description' => [
                'de' => 'Tolle Beschreibung',
                'en' => 'Awesome description',
            ],
            'InformationURL' => [
                'de' => 'https://sso-dev.fau.de',
                'en' => 'https://sso-dev.fau.de',
            ],
            'PrivacyStatementURL' => [
                'de' => 'https://sso-dev.fau.de/data-protection',
                'en' => 'https://sso-dev.fau.de/en/data-protection',
            ],
            'Logo' => [
                [
                    'url'    => 'https://sso-dev.fau.de/logo.jpg',
                    'height' => 236,
                    'width'  => 50,
                ]
            ],
        ],
    ],
];
