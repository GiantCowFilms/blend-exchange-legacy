            <form id="uploadTarget" class="bodyStack contentTarget">
                <div id="uploadText">
                    <div class="centerText">
                        Drag a file here to upload a .blend<br>or click to browse
                    </div>
                </div>
                    <div id="uploadArea">

                    </div>
            </form>
            <div class="bodyStack">
                <p>
<b>Terms of Service:</b></p>
                <div id="privacyAgreements">
                    <?php include("privacy/consentRequirements.php");
                          echo $upload_consent_requirements->generateConsentFormSegement();
                    ?>                   
                    </div>
  Please see the
            <a href="/privacy">privacy policy for further details.</a>
            </div>
            <div id="uploadOptions" class="bodyStack">
                <?php if ($loggedIn == true){
                        echo "
                        <div style='height: auto;' class='noticeWarning nwInfo bodyStack'>
                                            You are logged in, Any uploaded files will be attached to this account.
                        </div>
                        ";
                    } 
                ?>
                <div id="uploadUrlError" style="display: none; height: auto;" class="noticeWarning nwDanger bodyStack">

                </div>

                  <div>
                      <input class="txtBlue bodyStack" <?php if(isset($embedUpload) && ($embedUpload == true)){echo 'style="display: none;"';}?> id="questionUrl" placeholder="Enter the url of the question on blender.stackexchange" value="<?php if(isset($questionLink)) { echo $questionLink; }?>" />
                     <div id="upload" class="btnBlue bodyStack">
                        Upload
                     </div>
                  </div>
            </div>

               
