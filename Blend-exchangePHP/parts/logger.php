<?php
function logger($text = "", $ip = 'NONE', $path,$file = "log.log", $addTime = true){
    if ($ip !== 'NONE') {
        $ip = crypt($ip);
    }
    $time = $addTime ? " ON:" . date('Y-m-d H:i:s') : "";
    $logString = "IP HASH: " . $ip . " " . $text . $time . PHP_EOL;
    if(!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    @file_put_contents($path.$file, $logString, FILE_APPEND | LOCK_EX);

}
?>