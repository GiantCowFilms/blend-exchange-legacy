<?php
include("getQuotaInfo.php");
$quota = getQuotaInfo();
?>
<div>
    Blend-Exchange is currently using <?php echo round(intval($quota["used"])/1000000000, 1, PHP_ROUND_HALF_UP); ?> GB of its <?php echo round(intval($quota["total"])/1000000000, 1, PHP_ROUND_HALF_UP); ?> GB of avaiable space, <?php echo round($quota["percent"], 1, PHP_ROUND_HALF_UP);  ?>%
    <div class="progressContainer" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
        <div class="progress" style="width:<?php echo $quota["percent"] ?>%;"></div>
    </div>
</div>