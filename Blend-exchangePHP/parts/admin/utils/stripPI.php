<?php
include($_SERVER["DOCUMENT_ROOT"]."/parts/database.php");
echo "Preparing to remove PII";

//Goals
// Strip out IP addresses, and any data that is duplicate sorted based on IP addresses.
// Remove all accounts without breaking anything, excluding account 1 (default admin account, only contains cow's own PII).
$result = $db->prepare('DELETE `a` FROM `accesses` AS `a`, `accesses` AS `b` WHERE `a`.`id` < `b`.`id` AND `a`.`ip` <=> `b`.`ip` AND `a`.`type` <=> `b`.`type` AND `a`.`fileId` <=> `b`.`fileId`');
$result->execute();
echo 'deleted '. $result->rowCount() . ' rows <br>';
$result = $db->prepare('UPDATE `accesses` SET `ip`=SUBSTRING(MD5(RAND()) FROM 1 FOR 15)');
$result->execute();
echo 'redacted '. $result->rowCount() . ' rows <br>';
//DELETE uploaderIp from blends
$result =  $db->prepare('UPDATE `blends` SET `uploaderIp` = "REDACTED"');
$result->execute();
echo 'nulled '. $result->rowCount() . ' rows <br>';
//Delete all users except admin user
$db->prepare('DELETE FROM `users` WHERE `id` != 1');
$result->execute();
echo 'deleted '. $result->rowCount() . ' users <br>';
$db->prepare('UPDATE `blends` SET `owner` = 0 WHERE `owner` != 1 AND `owner` != 0');
$result->execute();
echo 'deleted '. $result->rowCount() . ' user references <br>';
?>