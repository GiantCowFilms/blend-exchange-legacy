<?php

require_once('PrivacyManager.php');


$register_consent_requirements = new PrivacyManager();
$register_consent_requirements->addPrivacyRequirement('tos','I agree to the Blend-Exchange <a href="/terms">Terms of Service</a> and have read the <a href="/privacy">Privacy Policy</a>','Please accept the terms and conditions');
$register_consent_requirements->addPrivacyRequirement('useOfCookies','I understand that Blend-Exchange uses cookies to identify which account I am logged into.','Cookies are required for accounts to function.');

$upload_consent_requirements = new PrivacyManager();
$upload_consent_requirements->addPrivacyRequirement('blendDistribution','I agree to the Blend-Exchange <a href="/terms">Terms of Service</a> and have read the <a href="/privacy">Privacy Policy</a>','Please accept the terms and conditions');
?>