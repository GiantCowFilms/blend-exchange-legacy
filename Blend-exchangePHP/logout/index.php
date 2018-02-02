<?php 
    $requireAdmin = false;
    include("../parts/requireLogin.php"); ?>
<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION["loggedIn"] = false;
$_SESSION["userId"] = null;
$_SESSION["admin"] = false;
?>    
    <?php include("../parts/header.php"); ?>
    <?php //include("../parts/admin/getFlaggedFiles.php"); ?>
    <?php if(isset($_GET["returnUrl"])){
                  header('Location: '.$_GET["returnUrl"]);
      };?>
        <div id="mainContainer">
            <div class="noticeWarning nwInfo">
                You have been logged out!
            </div>
            <a href="/">Homepage>></a>
        </div>
        <?php include("../parts/footer.php"); ?>
        <script src="/jquery.js"></script>
        <script src="/dropzone.js"></script>
        <script src="/upload.js"></script>
    </body>
</html>