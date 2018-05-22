    <?php 
    $requireAdmin = true;
    include("../../parts/requireLogin.php"); 
    ?>
    <?php include("../../parts/header.php"); ?>
    <?php     
    $utilsDir = "../../parts/admin/utils/";
                if (!isset( $_GET["utilName"])) {
                    $files = array_slice(scandir($utilsDir),2);
                    foreach($files as $file) {
                        echo '<a href="?utilName='.basename($file, ".php").'">'.$file.'</a>', '<br>';
                    }
              } else {
                  $utilName = $_GET["utilName"];
                  include($utilsDir .$utilName.".php");
              } ?>
        <?php include("../../parts/footer.php"); ?>
        <script src="jquery.js"></script>
        <script src="dropzone.js"></script>
        <script src="upload.js"></script>
    </body>
</html>