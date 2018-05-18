<?php

require_once('PrivacyManager.php');


$register_consent_requirements = new PrivacyManager();
$register_consent_requirements->addPrivacyRequirement('shareUsername','I consent to the public sharing of the username I provide.','You must consent to the public sharing of the username you provide to register an account.');
$register_consent_requirements->addPrivacyRequirement('useEmailSecurityUpdates','I consent to Blend-Exchange using the email provided to contact me about updates and events relating to the security of the blend-exchange service and my personal information.','Blend-Exchange needs to be able to contact account holders about security updates inorder to protect your privacy.');
$register_consent_requirements->addPrivacyRequirement('useEmailPolicyUpdates',' I consent to Blend-Exchange using the email I provide to notify me about updates to Blend-Exchanges Privacy Policy and Terms of Service.','Blend-Exchange needs to be able to update users on its privacy policy and terms of services.');
$register_consent_requirements->addPrivacyRequirement('useEmailServiceUpdates',' I consent to Blend-Exchange using the email I provide to notify me about updates to Blend-Exchange\'s services including termination of servies. (Services may bet terminated without notice)','To register, please consent to updates about the serivce. These could affect your ability to access your account data.');
$register_consent_requirements->addPrivacyRequirement('useOfCookies','I consent to the use of cookies to identify which account I am logged into.','Cookies are required for accounts to function.');

$upload_consent_requirements = new PrivacyManager();
$upload_consent_requirements->addPrivacyRequirement('blendDistribution','I consent to processing and public distribution by Blend-Exchange of the data (.blend file, question url) I upload with this form.','To share your blend, please consent to its distribution');
?>