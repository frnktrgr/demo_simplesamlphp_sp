<?php

/**
 * SAML 2.0 remote IdP metadata for SimpleSAMLphp.
 *
 * Remember to remove the IdPs you don't use from this file.
 *
 * See: https://simplesamlphp.org/docs/stable/simplesamlphp-reference-idp-remote
 */

include('/var/simplesamlphp/metadata/dfntest/saml20-idp-remote.php');
include('/var/simplesamlphp/metadata/dfn/saml20-idp-remote.php');

$overrides = [
    'https://sso-dev.fau.de/devssp/module.php/saml/sp/metadata.php/default-sp' => [
        'authproc' => [
            // ...
        ],
    ],
];

$attributes = [
    'https://sso-dev.fau.de/devssp/module.php/saml/sp/metadata.php/default-sp' => ['mail'],
];

foreach ($metadata as $entityId => &$sp) {
    if (isset($overrides[$entityId])) {
        $sp = array_merge($sp, $overrides[$entityId]);
    } else {
        if (isset($attributes[$entityId])) {
            // example
            $sp['authproc'][35] = array_merge(array('class' => 'core:AttributeLimit'), $attributes[$entityId]);
        } else {
            unset($metadata[$entityId]);
        }
    }
}
