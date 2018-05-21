<h1>Register</h1>
<form id="registerForm" style="width: 400px;">
    <div id="registerFormError" class="nwDanger noticeWarning" style="display: none; margin-bottom: 10px;">
        Register failed
    </div>
    <div class="bodyStack">
        <div style="margin-bottom: 10px;">
            Please do not register for an account if your are a citizen of the european union.
        </div>
        <input id="username" class="txtBlue bodyStack" placeholder="Username" />
        <input id="email" class="txtBlue bodyStack" placeholder="Email" />
        <input type="password" id="password" class="txtBlue bodyStack" placeholder="Password" />
        <input type="password" id="confirmPassword" class="txtBlue bodyStack" placeholder="Confirm Password" />
        <?php include(dirname(__FILE__) . "/privacy/consentRequirements.php");
              echo $register_consent_requirements->generateConsentFormSegement();
        ?>
        For more information on how Blend-Exchange collects, stores, and processes your information, please see our
        <a href="/privacy">privacy policy</a>. By registering you agree to Blend-Exchange's
        <a href="/terms">Terms of Service</a>.
    </div>
    <div class="btnBlue" id="register" style="width: 100%; max-width: none;">
        Register
    </div>
</form>
<script src="/jquery.js"></script>
<script src="/sha256.js"></script>
<script src="/register.js"></script>