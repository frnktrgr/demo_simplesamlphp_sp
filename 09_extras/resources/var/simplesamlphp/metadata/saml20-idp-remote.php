<?php

/**
 * SAML 2.0 remote IdP metadata for SimpleSAMLphp.
 *
 * Remember to remove the IdPs you don't use from this file.
 *
 * See: https://simplesamlphp.org/docs/stable/simplesamlphp-reference-idp-remote
 */

//$metadata['https://testidp2.aai.dfn.de/idp/shibboleth'] = [
//    'entityid' => 'https://testidp2.aai.dfn.de/idp/shibboleth',
//    'description' => [
//        'de' => 'e15',
//        'en' => 'e15',
//    ],
//    'OrganizationName' => [
//        'de' => 'e15',
//        'en' => 'e15',
//    ],
//    'name' => [
//        'de' => 'DFN: Offizieller öffentlicher Test-IdP',
//        'en' => 'DFN: Official public test IdP',
//    ],
//    'OrganizationDisplayName' => [
//        'de' => 'DFN-Verein - Deutsches Forschungsnetz',
//        'en' => 'German National Research and Education Network, DFN',
//    ],
//    'url' => [
//        'de' => 'http://www.dfn.de',
//        'en' => 'http://www.dfn.de/en/',
//    ],
//    'OrganizationURL' => [
//        'de' => 'http://www.dfn.de',
//        'en' => 'http://www.dfn.de/en/',
//    ],
//    'contacts' => [
//        [
//            'contactType' => 'administrative',
//            'givenName' => 'DFN-AAI',
//            'surName' => 'Hotline',
//            'emailAddress' => [
//                'hotline@aai.dfn.de',
//            ],
//        ],
//        [
//            'contactType' => 'other',
//            'givenName' => 'DFN-AAI Team',
//            'emailAddress' => [
//                'hotline@aai.dfn.de',
//            ],
//        ],
//        [
//            'contactType' => 'support',
//            'givenName' => 'DFN AAI',
//            'surName' => 'Hotline',
//            'emailAddress' => [
//                'hotline@aai.dfn.de',
//            ],
//        ],
//        [
//            'contactType' => 'technical',
//            'givenName' => 'DFN-AAI',
//            'surName' => 'Hotline',
//            'emailAddress' => [
//                'hotline@aai.dfn.de',
//            ],
//        ],
//    ],
//    'metadata-set' => 'saml20-idp-remote',
//    'SingleSignOnService' => [
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
//            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/POST/SSO',
//        ],
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST-SimpleSign',
//            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/POST-SimpleSign/SSO',
//        ],
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
//            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/Redirect/SSO',
//        ],
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
//            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/SOAP/ECP',
//        ],
//    ],
//    'SingleLogoutService' => [
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
//            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/POST/SLO',
//        ],
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST-SimpleSign',
//            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/POST-SimpleSign/SLO',
//        ],
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
//            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/Redirect/SLO',
//        ],
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
//            'Location' => 'https://testidp2.aai.dfn.de:8443/idp/profile/SAML2/SOAP/SLO',
//        ],
//    ],
//    'ArtifactResolutionService' => [
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
//            'Location' => 'https://testidp2.aai.dfn.de:8443/idp/profile/SAML2/SOAP/ArtifactResolution',
//            'index' => 2,
//        ],
//    ],
//    'NameIDFormats' => [
//        'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',
//        'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
//    ],
//    'keys' => [
//        [
//            'encryption' => true,
//            'signing' => true,
//            'type' => 'X509Certificate',
//            'X509Certificate' => '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',
//        ],
//    ],
//    'scope' => [
//        'test.dfn.de',
//        'testscope.aai.dfn.de',
//    ],
//    'RegistrationInfo' => [
//        'authority' => 'https://www.aai.dfn.de',
//        'instant' => 1243326902,
//        'policies' => [
//            'de' => 'https://www.aai.dfn.de/teilnahme/',
//            'en' => 'https://www.aai.dfn.de/en/join/',
//        ],
//    ],
//    'UIInfo' => [
//        'DisplayName' => [
//            'de' => 'DFN: Offizieller öffentlicher Test-IdP',
//            'en' => 'DFN: Official public test IdP',
//        ],
//        'Description' => [
//            'de' => 'IdP der DFN-AAI-Testumgebung (SAML2 Web-SSO)',
//            'en' => 'IdP of the DFN-AAI test environment (SAML2 Web-SSO)',
//        ],
//        'InformationURL' => [
//            'de' => 'https://www.dfn.de',
//            'en' => 'https://www.dfn.de',
//        ],
//        'PrivacyStatementURL' => [
//            'de' => 'https://www.aai.dfn.de/fileadmin/documents/datenschutz/test-idp.html',
//        ],
//        'Logo' => [
//            [
//                'url' => 'https://testidp2.aai.dfn.de/idp/images/logo.png',
//                'height' => 131,
//                'width' => 236,
//            ],
//            [
//                'url' => 'https://testidp2.aai.dfn.de/idp/images/favicon.ico',
//                'height' => 16,
//                'width' => 16,
//            ],
//        ],
//    ],
//];
//
//$metadata['https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/metadata.php'] = [
//    'entityid' => 'https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/metadata.php',
//    'contacts' => [
//        [
//            'contactType' => 'other',
//            'givenName' => 'Security Response',
//            'surName' => 'Team',
//            'emailAddress' => [
//                'abuse@fau.de',
//            ],
//        ],
//        [
//            'contactType' => 'support',
//            'givenName' => 'WebSSO-Support',
//            'surName' => 'Team',
//            'emailAddress' => [
//                'sso@fau.de',
//            ],
//        ],
//        [
//            'contactType' => 'administrative',
//            'givenName' => 'WebSSO-Admins',
//            'surName' => 'Team',
//            'emailAddress' => [
//                'sso-admins@fau.de',
//            ],
//        ],
//        [
//            'contactType' => 'technical',
//            'givenName' => 'WebSSO-Admins',
//            'surName' => 'Team',
//            'emailAddress' => [
//                'sso-admins@fau.de',
//            ],
//        ],
//        [
//            'contactType' => 'technical',
//            'givenName' => 'WebSSO-Admins RRZE FAU',
//            'emailAddress' => [
//                'sso-support@fau.de',
//            ],
//        ],
//    ],
//    'metadata-set' => 'saml20-idp-remote',
//    'SingleSignOnService' => [
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
//            'Location' => 'https://www.sso.uni-erlangen.de/simplesaml/module.php/saml/idp/singleSignOnService',
//        ],
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
//            'Location' => 'https://www.sso.uni-erlangen.de/simplesaml/module.php/saml/idp/singleSignOnService',
//        ],
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
//            'Location' => 'https://www.sso.uni-erlangen.de/simplesaml/module.php/saml/idp/singleSignOnService',
//        ],
//    ],
//    'SingleLogoutService' => [
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
//            'Location' => 'https://www.sso.uni-erlangen.de/simplesaml/module.php/saml/idp/singleLogout',
//        ],
//    ],
//    'ArtifactResolutionService' => [],
//    'NameIDFormats' => [
//        'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
//        'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',
//    ],
//    'keys' => [
//        [
//            'encryption' => false,
//            'signing' => true,
//            'type' => 'X509Certificate',
//            'X509Certificate' => 'MIIEFzCCAn+gAwIBAgIUZu6JGUynt+HmkDyTBVufV8brvfIwDQYJKoZIhvcNAQELBQAwIjEgMB4GA1UEAxMXd3d3LnNzby51bmktZXJsYW5nZW4uZGUwHhcNMjIxMDI1MTI0NDIzWhcNMjUxMTE5MTI0NDIzWjAiMSAwHgYDVQQDExd3d3cuc3NvLnVuaS1lcmxhbmdlbi5kZTCCAaIwDQYJKoZIhvcNAQEBBQADggGPADCCAYoCggGBAKV+3afbJg5B5r94ZuQMPRfFJdmixpAPiRqqif0hoXC4GAAd09txIWp2sMLWOEseiBYfSndBOz5OUHfyxvQ3IKubucP26leZxvyEDBymlaMw6ad2pi5JdCycJegGgkH2rThiNRK9rYLjyO5oUuCNumMBwqN1rCxaTsf6vC97cv5sEAoH551jNSPDYVvbn1/uUNw15GQuvvU43N3N3efiLnbRjUE8Ih/qDYp6v63/nxExINt7xgErgvD82k0gHrBJv7BIOMe7WmTQ2yQYC8FnzvCwHdHnZ8i1vRzPDYFTktxxn6Vsu1YMeNdd2K4Q+LLb/ljdoSxrNMKiwz9ls1Mj059hxlo3Q1g6JAYSZc9Lzqo26iTYLlq/LfF259OENIZX6FeQqDExK8BPLX6OXlneeksTxl9Bohsga3QPtRMRlGF415hmtpunW9LSiF1VewcKwpvjoEcDK+wutI/N7RNRhLNauUPQz16v1gZJDim4/zLB3Nfh19kLfJnlcRVnIkpKQQIDAQABo0UwQzAiBgNVHREEGzAZghd3d3cuc3NvLnVuaS1lcmxhbmdlbi5kZTAdBgNVHQ4EFgQUPB7olQAUEMwG9ImXfbDXtdLNPeUwDQYJKoZIhvcNAQELBQADggGBAEiIFXch6BzXOeU4S5/YgTQ/dHYpwHAc93YYP6WmlzEambSx+HGu4c6eav9zSrRhIVxwHkPE1nGJzBvtcM0FMML9/5U7keOtAcD7jkcHfnrC5cz9bWEbVpu4pSGVK1OWvC24gqwLn7++W3lx7prwpN7fO1uCSsudT3oOhSjy3oEJvtnBS26pqf/FFBUl6slZ4M3uVGUuf4q0PVXRIjK04oM8AwSO2Bb3tYU4u1lTBJkXJ+nFZGd8BcyYpFkQVY9/8iElY2qDWS6q1hNJ4c/phS7heJlk98MqtBeFw/Jo4juukdfIAtGmRpLg2xN3FzO2eoIzFgwQKrMrwMrTlovL71MEYkX/2NJ+TUCMcwseeAQaa8IgCXWfP7eD/RnS3DNj6su3Zes7W9HIpUJP33Ds3I+h0+QU9OYTnsjhxfOZOUm8BxNLvtBwVxKUmtJkh3zX/8F/exHXRaB2h0jx7iQ8bjpsGGnTE0izn0b/R3YuhH6yzt5nW8FaoHVQC/A7NVOfhg==',
//        ],
//        [
//            'encryption' => true,
//            'signing' => false,
//            'type' => 'X509Certificate',
//            'X509Certificate' => 'MIIEFzCCAn+gAwIBAgIUZu6JGUynt+HmkDyTBVufV8brvfIwDQYJKoZIhvcNAQELBQAwIjEgMB4GA1UEAxMXd3d3LnNzby51bmktZXJsYW5nZW4uZGUwHhcNMjIxMDI1MTI0NDIzWhcNMjUxMTE5MTI0NDIzWjAiMSAwHgYDVQQDExd3d3cuc3NvLnVuaS1lcmxhbmdlbi5kZTCCAaIwDQYJKoZIhvcNAQEBBQADggGPADCCAYoCggGBAKV+3afbJg5B5r94ZuQMPRfFJdmixpAPiRqqif0hoXC4GAAd09txIWp2sMLWOEseiBYfSndBOz5OUHfyxvQ3IKubucP26leZxvyEDBymlaMw6ad2pi5JdCycJegGgkH2rThiNRK9rYLjyO5oUuCNumMBwqN1rCxaTsf6vC97cv5sEAoH551jNSPDYVvbn1/uUNw15GQuvvU43N3N3efiLnbRjUE8Ih/qDYp6v63/nxExINt7xgErgvD82k0gHrBJv7BIOMe7WmTQ2yQYC8FnzvCwHdHnZ8i1vRzPDYFTktxxn6Vsu1YMeNdd2K4Q+LLb/ljdoSxrNMKiwz9ls1Mj059hxlo3Q1g6JAYSZc9Lzqo26iTYLlq/LfF259OENIZX6FeQqDExK8BPLX6OXlneeksTxl9Bohsga3QPtRMRlGF415hmtpunW9LSiF1VewcKwpvjoEcDK+wutI/N7RNRhLNauUPQz16v1gZJDim4/zLB3Nfh19kLfJnlcRVnIkpKQQIDAQABo0UwQzAiBgNVHREEGzAZghd3d3cuc3NvLnVuaS1lcmxhbmdlbi5kZTAdBgNVHQ4EFgQUPB7olQAUEMwG9ImXfbDXtdLNPeUwDQYJKoZIhvcNAQELBQADggGBAEiIFXch6BzXOeU4S5/YgTQ/dHYpwHAc93YYP6WmlzEambSx+HGu4c6eav9zSrRhIVxwHkPE1nGJzBvtcM0FMML9/5U7keOtAcD7jkcHfnrC5cz9bWEbVpu4pSGVK1OWvC24gqwLn7++W3lx7prwpN7fO1uCSsudT3oOhSjy3oEJvtnBS26pqf/FFBUl6slZ4M3uVGUuf4q0PVXRIjK04oM8AwSO2Bb3tYU4u1lTBJkXJ+nFZGd8BcyYpFkQVY9/8iElY2qDWS6q1hNJ4c/phS7heJlk98MqtBeFw/Jo4juukdfIAtGmRpLg2xN3FzO2eoIzFgwQKrMrwMrTlovL71MEYkX/2NJ+TUCMcwseeAQaa8IgCXWfP7eD/RnS3DNj6su3Zes7W9HIpUJP33Ds3I+h0+QU9OYTnsjhxfOZOUm8BxNLvtBwVxKUmtJkh3zX/8F/exHXRaB2h0jx7iQ8bjpsGGnTE0izn0b/R3YuhH6yzt5nW8FaoHVQC/A7NVOfhg==',
//        ],
//    ],
//    'scope' => [
//        'fau.de',
//        'uni-erlangen.de',
//    ],
//    'UIInfo' => [
//        'DisplayName' => [
//            'en' => 'Friedrich-Alexander-Universität Erlangen-Nürnberg (FAU)',
//            'de' => 'Friedrich-Alexander-Universität Erlangen-Nürnberg (FAU)',
//        ],
//        'Description' => [
//            'en' => 'Identity Provider of Friedrich-Alexander-Universität Erlangen-Nürnberg (FAU)',
//            'de' => 'Identity Provider der Friedrich-Alexander-Universität Erlangen-Nürnberg (FAU)',
//        ],
//        'InformationURL' => [
//            'en' => 'https://www.sso.fau.de/imprint',
//            'de' => 'https://www.sso.fau.de/impressum',
//        ],
//        'PrivacyStatementURL' => [
//            'en' => 'https://www.sso.fau.de/privacy',
//            'de' => 'https://www.sso.fau.de/datenschutz',
//        ],
//        'Keywords' => [
//            'en' => [
//                'university',
//                'friedrich-alexander',
//                'erlangen',
//                'nuremberg',
//                'fau',
//            ],
//            'de' => [
//                'universität',
//                'friedrich-alexander',
//                'erlangen',
//                'nürnberg',
//                'fau',
//            ],
//        ],
//        'Logo' => [
//            [
//                'url' => 'https://idm.fau.de/static/images/logos/fau_kernmarke_q_rgb_blue.svg',
//                'height' => 32,
//                'width' => 32,
//            ],
//            [
//                'url' => 'https://idm.fau.de/static/images/logos/fau_kernmarke_q_rgb_blue.svg',
//                'height' => 192,
//                'width' => 192,
//            ],
//        ],
//    ],
//    'DiscoHints' => [
//        'IPHint' => [],
//        'DomainHint' => [
//            'fau.de',
//            'www.fau.de',
//        ],
//        'GeolocationHint' => [
//            'geo:49.59793616990235,11.004654332497283',
//        ],
//    ],
//    'name' => [
//        'en' => 'Friedrich-Alexander-Universität Erlangen-Nürnberg (FAU)',
//        'de' => 'Friedrich-Alexander-Universität Erlangen-Nürnberg (FAU)',
//    ],
//];
