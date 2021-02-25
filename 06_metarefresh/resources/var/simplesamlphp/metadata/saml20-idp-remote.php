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
//    'contacts' => [],
//    'metadata-set' => 'saml20-idp-remote',
//    'SingleSignOnService' => [
//        [
//            'Binding' => 'urn:mace:shibboleth:1.0:profiles:AuthnRequest',
//            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/Shibboleth/SSO',
//        ],
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
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
//            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/Redirect/SLO',
//        ],
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
//            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/POST/SLO',
//        ],
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST-SimpleSign',
//            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/POST-SimpleSign/SLO',
//        ],
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
//            'Location' => 'https://testidp2.aai.dfn.de:8443/idp/profile/SAML2/SOAP/SLO',
//        ],
//    ],
//    'ArtifactResolutionService' => [
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:1.0:bindings:SOAP-binding',
//            'Location' => 'https://testidp2.aai.dfn.de:8443/idp/profile/SAML1/SOAP/ArtifactResolution',
//            'index' => 1,
//        ],
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
//            'Location' => 'https://testidp2.aai.dfn.de:8443/idp/profile/SAML2/SOAP/ArtifactResolution',
//            'index' => 2,
//        ],
//    ],
//    'NameIDFormats' => [
//        'urn:mace:shibboleth:1.0:nameIdentifier',
//        'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
//        'urn:mace:shibboleth:1.0:nameIdentifier',
//        'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
//        'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',
//    ],
//    'keys' => [
//        [
//            'encryption' => false,
//            'signing' => true,
//            'type' => 'X509Certificate',
//            'X509Certificate' => "\n"
//                .'MIIKFzCCCP+gAwIBAgIMIPNyteZAFt7GQJbGMA0GCSqGSIb3DQEBCwUAMIGNMQsw'."\n"
//                .'CQYDVQQGEwJERTFFMEMGA1UECgw8VmVyZWluIHp1ciBGb2VyZGVydW5nIGVpbmVz'."\n"
//                .'IERldXRzY2hlbiBGb3JzY2h1bmdzbmV0emVzIGUuIFYuMRAwDgYDVQQLDAdERk4t'."\n"
//                .'UEtJMSUwIwYDVQQDDBxERk4tVmVyZWluIEdsb2JhbCBJc3N1aW5nIENBMB4XDTE5'."\n"
//                .'MDUwOTA5Mzg1MloXDTIxMDgxMDA5Mzg1Mlowga8xCzAJBgNVBAYTAkRFMQ8wDQYD'."\n"
//                .'VQQIDAZCZXJsaW4xDzANBgNVBAcMBkJlcmxpbjFFMEMGA1UECgw8VmVyZWluIHp1'."\n"
//                .'ciBGb2VyZGVydW5nIGVpbmVzIERldXRzY2hlbiBGb3JzY2h1bmdzbmV0emVzIGUu'."\n"
//                .'IFYuMRkwFwYDVQQLDBBHZXNjaGFlZnRzc3RlbGxlMRwwGgYDVQQDDBN0ZXN0aWRw'."\n"
//                .'Mi5hYWkuZGZuLmRlMIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAvMXP'."\n"
//                .'QpcH57g+I5qLmSHTuGewKaqg/xHSkEza7P3dAVg4sHslBdtPN5ngoA2D2x5/zz07'."\n"
//                .'8BszczYSeVlXH5Jj8nJ5EXesEdBTlWTk1eq4tWy1X2fWCcALbs6RvCVAmweWyfNM'."\n"
//                .'GBTDdk8TG/Xn58HzXLgDlpBcoNmIiVgtYQ1z7vZyTkVhy7DhmOLDHZ0BIhWJnl3w'."\n"
//                .'smBTLwkAG41vzlWqA/03R50TcTc1QKF1St5YX7AIjaruZZs2BOTKcQhk9/vqooD8'."\n"
//                .'aXZ0O2+FAtiQivbxldZUuUuuenx2dwlMY2FxCSTwEFdyW8sAapF+9YhrRKzFEtci'."\n"
//                .'hAZxLR+ggqJch8ZigAC1I/xuFH4KUXOuOdDF4mRVMRNDYw207h2s2ur9hBSw5yRg'."\n"
//                .'QG/oQVO6QFr8d6taf14QDcVF3ZC8zxYsx0Az/HdRYPBV2urSsk+ln3vg7HOMFtUu'."\n"
//                .'AACU0ejeYriMpDgGzWEji4K3m9CaFkEMT4jo6zRkOeKXpNnZsXT8tQ1huvkNG4lq'."\n"
//                .'NHVGLN5NI3tYPMSkRhdI+tHgRcYEn+gnRoTHfoSJAsZv/UeLH0gZLKDBDBmvdCAD'."\n"
//                .'P2I4uLOEYqqh5MDtIOY5/vBN3CDw4wDO3lCzF6YhWJh336AT5baVmpZvlYe35w8u'."\n"
//                .'fdAbpcKzuuB9UcvYOsYUKDBw+FucMDlttFtA5l0CAwEAAaOCBVEwggVNMFkGA1Ud'."\n"
//                .'IARSMFAwCAYGZ4EMAQICMA0GCysGAQQBga0hgiweMA8GDSsGAQQBga0hgiwBAQQw'."\n"
//                .'EQYPKwYBBAGBrSGCLAEBBAMJMBEGDysGAQQBga0hgiwCAQQDCTAJBgNVHRMEAjAA'."\n"
//                .'MA4GA1UdDwEB/wQEAwIFoDAdBgNVHSUEFjAUBggrBgEFBQcDAgYIKwYBBQUHAwEw'."\n"
//                .'HQYDVR0OBBYEFO44VdE6zfrzOckkuq5luQAEiLSZMB8GA1UdIwQYMBaAFGs6mIv5'."\n"
//                .'8lOJ2uCtsjIeCR/oqjt0MB4GA1UdEQQXMBWCE3Rlc3RpZHAyLmFhaS5kZm4uZGUw'."\n"
//                .'gY0GA1UdHwSBhTCBgjA/oD2gO4Y5aHR0cDovL2NkcDEucGNhLmRmbi5kZS9kZm4t'."\n"
//                .'Y2EtZ2xvYmFsLWcyL3B1Yi9jcmwvY2FjcmwuY3JsMD+gPaA7hjlodHRwOi8vY2Rw'."\n"
//                .'Mi5wY2EuZGZuLmRlL2Rmbi1jYS1nbG9iYWwtZzIvcHViL2NybC9jYWNybC5jcmww'."\n"
//                .'gdsGCCsGAQUFBwEBBIHOMIHLMDMGCCsGAQUFBzABhidodHRwOi8vb2NzcC5wY2Eu'."\n"
//                .'ZGZuLmRlL09DU1AtU2VydmVyL09DU1AwSQYIKwYBBQUHMAKGPWh0dHA6Ly9jZHAx'."\n"
//                .'LnBjYS5kZm4uZGUvZGZuLWNhLWdsb2JhbC1nMi9wdWIvY2FjZXJ0L2NhY2VydC5j'."\n"
//                .'cnQwSQYIKwYBBQUHMAKGPWh0dHA6Ly9jZHAyLnBjYS5kZm4uZGUvZGZuLWNhLWds'."\n"
//                .'b2JhbC1nMi9wdWIvY2FjZXJ0L2NhY2VydC5jcnQwggLmBgorBgEEAdZ5AgQCBIIC'."\n"
//                .'1gSCAtIC0AB1AFWB1MIWkDYBSuoLm1c8U/DA5Dh4cCUIFy+jqh0HE9MMAAABapv/'."\n"
//                .'1CUAAAQDAEYwRAIgT9jn1n/5vx9AhEu7I8/+zHKhj+JBgShhy2/o3CYB7JQCIBEt'."\n"
//                .'AE2Puz4Vd6H4KVVHTnkkGxWgHnBGxc9uu+Ywu/SfAHcAqucLfzy41WbIbC8Wl5yf'."\n"
//                .'RF9pqw60U1WJsvd6AwEE880AAAFqm//TJAAABAMASDBGAiEA3qsbKHAYMijk/6hG'."\n"
//                .'0aTEtWKgnjpvYBpL7cWczuLG/ZwCIQDsByIM0+Ad1weI+aY+te1fYXV5WT2aPQkR'."\n"
//                .'/Ti1+s5zhgB1AO5Lvbd1zmC64UJpH6vhnmajD35fsHLYgwDEe4l6qP3LAAABapv/'."\n"
//                .'03sAAAQDAEYwRAIgdBPpD02j/agrAUQrc6+27DRpNUPq+cywbsDNcdAjwuUCIAId'."\n"
//                .'Cg88ubs3aizEtkxa0FYax91Pq364MDS4tpjqItcwAHYAu9nfvB+KcbWTlCOXqpJ7'."\n"
//                .'RzhXlQqrUugakJZkNo4e0YUAAAFqm//TdwAABAMARzBFAiEAqGba0gkLVUegbZVi'."\n"
//                .'3ynaeToUTGyRsioxJnluIA9P7FkCIFpcEtnGdq7DTLxp2vkmQUuE6daXoqqUrLia'."\n"
//                .'FkCEAiJlAHYApLkJkLQYWBSHuxOizGdwCjw1mAT5G9+443fNDsgN3BAAAAFqm//T'."\n"
//                .'ggAABAMARzBFAiEAlMHp4XvOwiBEKW/yFWqw8Z3tYyvXA/YM984prCZvojICIDSi'."\n"
//                .'k+PqIlg+v7iNAyjUyyk51Yg+FmpeylIhjSx9JU2wAHcARJRlLrDuzq/EQAfYqP4o'."\n"
//                .'wNrmgr7YyzG1P9MzlrW2gagAAAFqm//Z3QAABAMASDBGAiEAlGjxFRvvaDdNh/CU'."\n"
//                .'a6Ci5NS6Sjyk1EdXNDchxoWHAfMCIQDBbdoy7vSwDc1cJsvBZVlR0asQwDF+D/z/'."\n"
//                .'jmZVRj24sTANBgkqhkiG9w0BAQsFAAOCAQEAZvedqNdhziPH0ev26Qc/6luDRA1A'."\n"
//                .'3ys+P4OhPy/WyAbnP4b2ciqP4IL/ohbUHVUw8jLBjJjuofaVCFKFAjZVcILhDdW4'."\n"
//                .'xEh2/445Da942VOtXY0Exp5EFao/RCwpoz96p0lsppy/RlCGla2FUMUpwyEMTS0l'."\n"
//                .'d5U0NNrYEXXbSrqpuLFkGyZUytGJkzrDPP3BrGBLNpIvuvJRd/vpdtba+kXOwQhb'."\n"
//                .'uSILs/3ygp05fFLX5Hnc0nHqOBtBP1nIpa2KvSjpiSA9phK19Atm1o/Z9t8tIZRK'."\n"
//                .'UO+LfpPqGFiu7LxjO6K8gnbPisbNSeWZk3qbUErC2F+72vxiKutzChmODw=='."\n"
//        ],
//        [
//            'encryption' => true,
//            'signing' => false,
//            'type' => 'X509Certificate',
//            'X509Certificate' => "\n"
//                .'MIIKFzCCCP+gAwIBAgIMIPNyteZAFt7GQJbGMA0GCSqGSIb3DQEBCwUAMIGNMQsw'."\n"
//                .'CQYDVQQGEwJERTFFMEMGA1UECgw8VmVyZWluIHp1ciBGb2VyZGVydW5nIGVpbmVz'."\n"
//                .'IERldXRzY2hlbiBGb3JzY2h1bmdzbmV0emVzIGUuIFYuMRAwDgYDVQQLDAdERk4t'."\n"
//                .'UEtJMSUwIwYDVQQDDBxERk4tVmVyZWluIEdsb2JhbCBJc3N1aW5nIENBMB4XDTE5'."\n"
//                .'MDUwOTA5Mzg1MloXDTIxMDgxMDA5Mzg1Mlowga8xCzAJBgNVBAYTAkRFMQ8wDQYD'."\n"
//                .'VQQIDAZCZXJsaW4xDzANBgNVBAcMBkJlcmxpbjFFMEMGA1UECgw8VmVyZWluIHp1'."\n"
//                .'ciBGb2VyZGVydW5nIGVpbmVzIERldXRzY2hlbiBGb3JzY2h1bmdzbmV0emVzIGUu'."\n"
//                .'IFYuMRkwFwYDVQQLDBBHZXNjaGFlZnRzc3RlbGxlMRwwGgYDVQQDDBN0ZXN0aWRw'."\n"
//                .'Mi5hYWkuZGZuLmRlMIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAvMXP'."\n"
//                .'QpcH57g+I5qLmSHTuGewKaqg/xHSkEza7P3dAVg4sHslBdtPN5ngoA2D2x5/zz07'."\n"
//                .'8BszczYSeVlXH5Jj8nJ5EXesEdBTlWTk1eq4tWy1X2fWCcALbs6RvCVAmweWyfNM'."\n"
//                .'GBTDdk8TG/Xn58HzXLgDlpBcoNmIiVgtYQ1z7vZyTkVhy7DhmOLDHZ0BIhWJnl3w'."\n"
//                .'smBTLwkAG41vzlWqA/03R50TcTc1QKF1St5YX7AIjaruZZs2BOTKcQhk9/vqooD8'."\n"
//                .'aXZ0O2+FAtiQivbxldZUuUuuenx2dwlMY2FxCSTwEFdyW8sAapF+9YhrRKzFEtci'."\n"
//                .'hAZxLR+ggqJch8ZigAC1I/xuFH4KUXOuOdDF4mRVMRNDYw207h2s2ur9hBSw5yRg'."\n"
//                .'QG/oQVO6QFr8d6taf14QDcVF3ZC8zxYsx0Az/HdRYPBV2urSsk+ln3vg7HOMFtUu'."\n"
//                .'AACU0ejeYriMpDgGzWEji4K3m9CaFkEMT4jo6zRkOeKXpNnZsXT8tQ1huvkNG4lq'."\n"
//                .'NHVGLN5NI3tYPMSkRhdI+tHgRcYEn+gnRoTHfoSJAsZv/UeLH0gZLKDBDBmvdCAD'."\n"
//                .'P2I4uLOEYqqh5MDtIOY5/vBN3CDw4wDO3lCzF6YhWJh336AT5baVmpZvlYe35w8u'."\n"
//                .'fdAbpcKzuuB9UcvYOsYUKDBw+FucMDlttFtA5l0CAwEAAaOCBVEwggVNMFkGA1Ud'."\n"
//                .'IARSMFAwCAYGZ4EMAQICMA0GCysGAQQBga0hgiweMA8GDSsGAQQBga0hgiwBAQQw'."\n"
//                .'EQYPKwYBBAGBrSGCLAEBBAMJMBEGDysGAQQBga0hgiwCAQQDCTAJBgNVHRMEAjAA'."\n"
//                .'MA4GA1UdDwEB/wQEAwIFoDAdBgNVHSUEFjAUBggrBgEFBQcDAgYIKwYBBQUHAwEw'."\n"
//                .'HQYDVR0OBBYEFO44VdE6zfrzOckkuq5luQAEiLSZMB8GA1UdIwQYMBaAFGs6mIv5'."\n"
//                .'8lOJ2uCtsjIeCR/oqjt0MB4GA1UdEQQXMBWCE3Rlc3RpZHAyLmFhaS5kZm4uZGUw'."\n"
//                .'gY0GA1UdHwSBhTCBgjA/oD2gO4Y5aHR0cDovL2NkcDEucGNhLmRmbi5kZS9kZm4t'."\n"
//                .'Y2EtZ2xvYmFsLWcyL3B1Yi9jcmwvY2FjcmwuY3JsMD+gPaA7hjlodHRwOi8vY2Rw'."\n"
//                .'Mi5wY2EuZGZuLmRlL2Rmbi1jYS1nbG9iYWwtZzIvcHViL2NybC9jYWNybC5jcmww'."\n"
//                .'gdsGCCsGAQUFBwEBBIHOMIHLMDMGCCsGAQUFBzABhidodHRwOi8vb2NzcC5wY2Eu'."\n"
//                .'ZGZuLmRlL09DU1AtU2VydmVyL09DU1AwSQYIKwYBBQUHMAKGPWh0dHA6Ly9jZHAx'."\n"
//                .'LnBjYS5kZm4uZGUvZGZuLWNhLWdsb2JhbC1nMi9wdWIvY2FjZXJ0L2NhY2VydC5j'."\n"
//                .'cnQwSQYIKwYBBQUHMAKGPWh0dHA6Ly9jZHAyLnBjYS5kZm4uZGUvZGZuLWNhLWds'."\n"
//                .'b2JhbC1nMi9wdWIvY2FjZXJ0L2NhY2VydC5jcnQwggLmBgorBgEEAdZ5AgQCBIIC'."\n"
//                .'1gSCAtIC0AB1AFWB1MIWkDYBSuoLm1c8U/DA5Dh4cCUIFy+jqh0HE9MMAAABapv/'."\n"
//                .'1CUAAAQDAEYwRAIgT9jn1n/5vx9AhEu7I8/+zHKhj+JBgShhy2/o3CYB7JQCIBEt'."\n"
//                .'AE2Puz4Vd6H4KVVHTnkkGxWgHnBGxc9uu+Ywu/SfAHcAqucLfzy41WbIbC8Wl5yf'."\n"
//                .'RF9pqw60U1WJsvd6AwEE880AAAFqm//TJAAABAMASDBGAiEA3qsbKHAYMijk/6hG'."\n"
//                .'0aTEtWKgnjpvYBpL7cWczuLG/ZwCIQDsByIM0+Ad1weI+aY+te1fYXV5WT2aPQkR'."\n"
//                .'/Ti1+s5zhgB1AO5Lvbd1zmC64UJpH6vhnmajD35fsHLYgwDEe4l6qP3LAAABapv/'."\n"
//                .'03sAAAQDAEYwRAIgdBPpD02j/agrAUQrc6+27DRpNUPq+cywbsDNcdAjwuUCIAId'."\n"
//                .'Cg88ubs3aizEtkxa0FYax91Pq364MDS4tpjqItcwAHYAu9nfvB+KcbWTlCOXqpJ7'."\n"
//                .'RzhXlQqrUugakJZkNo4e0YUAAAFqm//TdwAABAMARzBFAiEAqGba0gkLVUegbZVi'."\n"
//                .'3ynaeToUTGyRsioxJnluIA9P7FkCIFpcEtnGdq7DTLxp2vkmQUuE6daXoqqUrLia'."\n"
//                .'FkCEAiJlAHYApLkJkLQYWBSHuxOizGdwCjw1mAT5G9+443fNDsgN3BAAAAFqm//T'."\n"
//                .'ggAABAMARzBFAiEAlMHp4XvOwiBEKW/yFWqw8Z3tYyvXA/YM984prCZvojICIDSi'."\n"
//                .'k+PqIlg+v7iNAyjUyyk51Yg+FmpeylIhjSx9JU2wAHcARJRlLrDuzq/EQAfYqP4o'."\n"
//                .'wNrmgr7YyzG1P9MzlrW2gagAAAFqm//Z3QAABAMASDBGAiEAlGjxFRvvaDdNh/CU'."\n"
//                .'a6Ci5NS6Sjyk1EdXNDchxoWHAfMCIQDBbdoy7vSwDc1cJsvBZVlR0asQwDF+D/z/'."\n"
//                .'jmZVRj24sTANBgkqhkiG9w0BAQsFAAOCAQEAZvedqNdhziPH0ev26Qc/6luDRA1A'."\n"
//                .'3ys+P4OhPy/WyAbnP4b2ciqP4IL/ohbUHVUw8jLBjJjuofaVCFKFAjZVcILhDdW4'."\n"
//                .'xEh2/445Da942VOtXY0Exp5EFao/RCwpoz96p0lsppy/RlCGla2FUMUpwyEMTS0l'."\n"
//                .'d5U0NNrYEXXbSrqpuLFkGyZUytGJkzrDPP3BrGBLNpIvuvJRd/vpdtba+kXOwQhb'."\n"
//                .'uSILs/3ygp05fFLX5Hnc0nHqOBtBP1nIpa2KvSjpiSA9phK19Atm1o/Z9t8tIZRK'."\n"
//                .'UO+LfpPqGFiu7LxjO6K8gnbPisbNSeWZk3qbUErC2F+72vxiKutzChmODw=='."\n"
//        ],
//    ],
//    'scope' => [
//        'testscope.aai.dfn.de',
//    ],
//    'UIInfo' => [
//        'DisplayName' => [
//            'en' => 'DFN Test IdP 2',
//            'de' => 'DFN Test IdP 2',
//        ],
//        'Description' => [
//            'en' => 'IdP 2 of the DFN-AAI test environment',
//            'de' => 'IdP 2 der DFN-AAI-Testumgebung',
//        ],
//        'InformationURL' => [],
//        'PrivacyStatementURL' => [],
//        'Logo' => [
//            [
//                'url' => 'https://testidp2.aai.dfn.de/idp/images/favicon.ico',
//                'height' => 16,
//                'width' => 16,
//            ],
//            [
//                'url' => 'https://testidp2.aai.dfn.de/idp/images/logo.png',
//                'height' => 80,
//                'width' => 80,
//            ],
//        ],
//    ],
//    'name' => [
//        'en' => 'DFN Test IdP 2',
//        'de' => 'DFN Test IdP 2',
//    ],
//];
//
//$metadata['https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/metadata.php'] = [
//    'entityid' => 'https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/metadata.php',
//    'contacts' => [
//        [
//            'contactType' => 'technical',
//            'givenName' => 'Frank',
//            'surName' => 'Tröger',
//            'emailAddress' => [
//                'sso-support@fau.de',
//            ],
//        ],
//    ],
//    'metadata-set' => 'saml20-idp-remote',
//    'SingleSignOnService' => [
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
//            'Location' => 'https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/SSOService.php',
//        ],
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
//            'Location' => 'https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/SSOService.php',
//        ],
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
//            'Location' => 'https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/SSOService.php',
//        ],
//    ],
//    'SingleLogoutService' => [
//        [
//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
//            'Location' => 'https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/SingleLogoutService.php',
//        ],
//    ],
//    'ArtifactResolutionService' => [],
//    'NameIDFormats' => [
//        'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
//    ],
//    'keys' => [
//        [
//            'encryption' => false,
//            'signing' => true,
//            'type' => 'X509Certificate',
//            'X509Certificate' => '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',
//        ],
//        [
//            'encryption' => true,
//            'signing' => false,
//            'type' => 'X509Certificate',
//            'X509Certificate' => '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',
//        ],
//    ],
//];
