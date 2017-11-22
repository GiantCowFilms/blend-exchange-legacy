<?php
    include_once("googleDriveAuth.php");
    function getQuotaInfo () {
        global $service;
        $about = $service->about->get();
        return [
            'remaining' => $about->getQuotaBytesTotal() - $about->getQuotaBytesUsed(),
            'used' => $about->getQuotaBytesUsed(),
            'total' => $about->getQuotaBytesTotal(),
            'percent' => $about->getQuotaBytesUsed() / $about->getQuotaBytesTotal() * 100
        ];
    }
?>