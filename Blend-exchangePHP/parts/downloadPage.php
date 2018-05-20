        <?php
            //Include login check
            include($_SERVER["DOCUMENT_ROOT"]."/parts/checkLogin.php");
            //Process flags
            $virusAlert = false;
            $copyrightAlert = false;
            if(count($blend->flags) != 0) {
                foreach ($blend->flags as $flag)
                {
                    if ($flag["accept"] == 2) {
                        continue;
                    }
                    if ($flag["val"] == "virus"){
                        $virusAlert = true;
                    };
                     if ($flag["val"] == "copyright"){
                        $copyrightAlert = true;
                    };
                }
            }
        ?>
        <div id="mainContainer">
            <?php
            if ($blend->adminComment != ""){
                echo "<div class=\"noticeWarning nwInfo bodyStack\">
                ".$blend->adminComment."
                </div>";
            }
            if ($blend->deleted == 1) {
                echo "            <div class=\"noticeWarning nwDanger bodyStack\">
                    This file was deleted.
                </div>";
            if ($admin != true){
                exit();
            };
            }
            if ($copyrightAlert){
                echo "            <div class=\"noticeWarning nwNotice bodyStack\">
                NOTICE: This file has been removed on a copyright claim!
                </div>";
                if ($admin != true){
                    exit();
                };
            };
            if ($virusAlert){
                echo "            <div class=\"noticeWarning nwDanger bodyStack\">
                WARNING: This blend has been reported as containing maleware. Download at your own risk. The report is unconfirmed.
                </div>";
            };
            ?>
            <div id="fileStats" class="bodyStack contentTarget">
                <div style="text-align: center;">
                        <img class="blendDisplayIcon" src="/blenderFileIcon.png"/>
                        <div class="blendDisplayContainer" style="display: inline-block; margin-top: 25px; text-align: left;">
                            <h2 class="blendDisplayTitle">
                                <?php echo $blend->fileName;  ?>
                            </h2>
                            <span class="downloadQuestionLink">
                                 <a href="<?php echo $blend->questionLink ?>">View Question</a>
                                <br />
                                <?php echo round(intval($blend->fileSize)/1000000, 1, PHP_ROUND_HALF_UP); ?> MB
                                <br />
                                <?php echo $blend->views ?> views <br />
                                <?php echo $blend->downloads ?> downloads<br />
                                <?php echo $blend->favorites ?> favorites
                            </span>
                        </div>
                </div>
            </div>
            <div id="favPrompt" style="display: none;" class="bodyStack noticeWarning nwInfo">
                Found this file useful? <b>Give it a favorite </b>using the button below!
            </div>
            <div class="bodyStack">
                <div id="flagBtn" class="btnBlue downloadBtnRow">
                    Flag
                </div><div id="favoriteBtn" class="btnBlue downloadBtnRow">
                    Favorite
                </div><div id="downloadFile" class="btnBlue downloadBtnRow" style="margin-right: 0">
                    <a href="/d/<?php echo $blend->id ?>/<?php echo $blend->fileName ?>">Download</a>
                </div>
            </div>
            <?php include("flagForm.php"); ?>
            <?php
                if ($admin == true){
                    include("adminTools.php");
                };
            ?>
            <h2 style="margin-top: 5px; margin-bottom: 5px;">Share this file:</h2>
            <div>Add this text into your post:</div>
            <textarea id="embedCode" class="txtBlue">[<img src="https://blend-exchange.giantcowfilms.com/embedImage.png?bid=<?php echo $blend->id; ?>" />](https://blend-exchange.giantcowfilms.com/b/<?php echo $blend->id; ?>/)</textarea>
            <div id="usageNotice">
                <h2>
                    Disclaimer:
                </h2>
                Download this file at your own risk. It could contain viruses or other harmful material.
                <span>By using this service you agree to our <a href="/terms">terms of service</a></span>
            </div>
           <h2>
                Flags:
           </h2>
        </div>
        <script src="/jquery.js"></script>
        <script src="/dropzone.js"></script>
        <script type="text/javascript">
            <?php             
            if ($virusAlert){
                echo '            $(document).on("click", "#downloadFile a", function (e) {
                if (confirm("I understand that I do this at my own risk, and Blend-Exchange is not liable for any damage this file may cause?") != true) {
                    e.preventDefault();
                }
            });';
            };
            ?>
            //Propt download
            $(document).on('click', "#downloadFile", function () {
                $("#favPrompt").show();
                setTimeout(function () {
                    $("#favPrompt").hide();
                }, 12000);
            });

            //Only on finish page
            if (window.location.pathname == "/") {
                var embed = $("#embedCode")
                embed.focus()
                embed.select()
                $("#embedCode").addClass('attention');
            }
            $("#flagBtn").click(function () {
                $("#flagFile").show();
            });
            $("#flagCancel").click(function () {
                $("#flagFile").hide();
            });
            $("#flagFileBtn").click(function () {
                var value = $("input:radio[name=offense]:checked").val();
                if (value === "Other") {
                   var custom = $("input[name=custom_offense]").val();
                   value = (custom.length > 5) ? custom : value;
                }
                if (value === "") {
                     alert(["Please provide a reason for flagging this file."]);
                }
                $.ajax({
                    url: "/flag",
                    type: "get",
                    success: function (result) {
                        $("#flagFile").hide();
                        alert([result]);
                    },
                    data: { id: "<?php echo $blend->id ?>", flag: value }
                });
            });
            $("#favoriteBtn").click(function () {
                $.ajax({
                    url: "/favorite",
                    type: "get",
                    success: function (result) {
                        alert([result]);
                    },
                    data: { id: "<?php echo $blend->id ?>"}
                });
            });
            //Events for embed

            //Alert for iframe
            window.parent.postMessage({ name: "embedSource", content: $("#embedCode").val() }, "*");
            //Alert for popup
            if (window.opener != null && !window.opener.closed) {
                window.opener.postMessage({ name: "embedSource", content: $("#embedCode").val() }, "*");
            }
        </script>
        <script>
            $(document).on("click", "#deleteFile", function () {
                $.ajax({
                    url: "/admin/adminTools/",
                    type: "POST",
                    data: { fileId: "<?php echo $blend->id ?>", act: "delete"},
                    success: function (r) {
                        alert([r]);
                    }
                });
            });
            $(document).on("click", "#adminComment", function () {
                $("#adminCommentForm").show();
            });
            $(document).on("click", "#adminCommentPost", function () {
                comment = $("#adminCommentText").val();
                $.ajax({
                    url: "/admin/adminTools/",
                    type: "POST",
                    data: { fileId: "<?php echo $blend->id ?>", act: "Comment", text: comment },
                    success: function () {

                    }
                });
            });
            $(document).on("click", "#setValid", function () {
                var valid = 2;
                if (confirm('Is this valid?')) {
                    valid = 1;
                }
                $.ajax({
                    url: "/admin/adminTools/",
                    type: "POST",
                    data: { fileId: "<?php echo $blend->id ?>", act: "setValid", type: valid },
                    success: function (r) {
                        alert([r]);
                    }
                });
            });
            $(document).on("click", "#adminDeclineFlag", function () {
                actOnFlag("decline");
            });
            $(document).on("click", "#adminAcceptFlag", function () {
                actOnFlag("accept");
            });
            function actOnFlag(action) {
                $("#adminFlagForm").show();

                var flagId = $("#adminFlagSelect option:selected").val();

                $(document).on("click", "#adminFlagContinue", function () {
                    flagId = $("#adminFlagSelect").val();
                    $.ajax({
                        url: "/admin/adminTools/",
                        type: "POST",
                        data: { fileId: "<?php echo $blend->id ?>", act: "actOnFlag", flagId: flagId, type: action },
                        success: function (r) {
                            alert([r]);
                        }
                    });
                });
            }
        </script>