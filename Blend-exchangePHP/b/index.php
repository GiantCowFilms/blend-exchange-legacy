<html>
    <?php
    $blendId = $_GET["blendId"];
    $secretKeys = json_decode(file_get_contents("../secret/secret.json"));
    $db = new PDO("mysql:host=".$secretKeys->mysql->host.";dbname=".$secretKeys->mysql->database,$secretKeys->mysql->user,$secretKeys->mysql->password);
    $blendData = $db->query("SELECT `id`, `fileName`, `fileUrl`, `flags`, `views`, `downloads`, `password`, `uploaderIp`, `questionLink`, `fileSize` FROM `blends` WHERE `id`=" . $blendId);
    $blendData = $blendData->fetchAll(PDO::FETCH_ASSOC)["0"];
    $blendData["views"] = intval($blendData["views"]);
    $blendData["views"]++;
    $db->prepare("UPDATE `blends` SET `views`='".$blendData["views"]."' WHERE `id`='".$blendId."'")->execute();
    $blendId = $db->lastInsertId("Id");
    
    ?>
    <?php include("../parts/header.php"); ?>

    <?php include("../parts/downloadPage.php"); ?>
    <?php include("../parts/footer.php"); ?>