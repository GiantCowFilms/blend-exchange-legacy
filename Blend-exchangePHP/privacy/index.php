    <?php include("../parts/header.php"); ?>
        <div id="mainContainer">
            <p>Please also see our <a href="/terms">Terms of Service</a></p>

            In this document Blend-Exchange ("we","us") refers to the operators of this website ("the Blend-Exchange service","the service").

            <h2>Data Collection & Processing</h2>

            Any data that Blend-Exchange collects and processes will be shared whenever Blend-Exchange is legally compelled to share the data. Blend-Exchange collects and processes the following data:

            <h3>Technical Data</h3>

            Technical Data is data that your browser sends our servers or provides to our webpage. This includes:

            <ul>
                <li>IP Addresses</li>
                <li>HTTP-Header meta data. This is data that is sent along with a request to our server.</li>
            </ul>

            Blend-Exchange keeps this data in order to better protect, maintain, and develop the Blend-Exchange service. Technical Data may be linked to user accounts or any other kind of collected data. In addition, Technical Data may be associated with other user data including accounts and uploaded blend files. Technical Data is stored in log files, sometimes as a hash.

            In addition, Technical Data will be sent to the following 3rd party providers content providers:

            <ul><li>Google Fonts. Please see their privacy policy here (<a href="https://policies.google.com/privacy">https://policies.google.com/privacy</a>)</li></ul>

            <h3>Shared/Uploaded Data</h3>

            This includes all data provided when a blend file is uploaded. This includes:

            <ul>
                <li>The contents of the blend file binary.</li>
                <li>The URL to the blender.stackexchange.com question.</li>
                <li>A reference to the current authenticated account (if the user is logged in).</li>
            </ul>

            All of the listed data is avaible publicly for download.

            <h3>Account Data</h3>
            <p>
                User account data is all the data provided when creating an account. This includes:
            </p>
            <ul>
                <li>The <b>username</b> provided when registering. This is stored in a database without encryption. This information is publicly  accessible without restriction.</li>
                <li>The <b>email</b> provided when registering. This is stored in a database without encryption. This email is not pubically accessible, and will only be used to notify the user of the following:
                    <ul>
                        <li>Updates/Events relating to the security of the Blend-Exchange service and the user's personal information.</li>
                        <li>Updates to the privacy policy or terms of service of Blend-Exchange.</li>
                        <li>Responses to inquires made by the user via email. (Responses will be to the inquiring address)</li>
                        <li>Notifications of termination/removal/modification of services. (Services may be terminated without notification). This is to help prevent any inconvience for users.</li>
                    </ul>
                </li>
                <li>A <b>hash of the password</b> provided when registering.  This is stored in a database without additional encryption.</li>
                <li>A set of <b>references to .blend-files</b> uploaded while authenticated with the account. This information is publicly accessible without restriction.</li>
                <li>In addition, an <b>ID</b> is created which can be linked back to the account. This information is publicly accessible without restriction.</li>
            </ul>

            <h3>Referring URL</h3>
            <p>
                Blend-Exchange uses the referring URL if provided to detect abuse of its services. Referring URLs are stored indefinitely and linked to a hashed version of the IP address that visited that page. They are compared to the provided question URLs for blends to detect if the links to blends are being shared outside blender.stackexchange (a possible sign of abuse).
            </p>

            <h3>Use of Cookies</h3>
            Blend-Exchange uses cookies to check authentication for users with accounts. They are not used for any other kind of tracking.

            <h3>Logged Actions</h3>
            Certain User Actions (A specific web request or set of web requests that triggers a specfic action) are recorded in conjunction with linked techincal data. The following user actions are recorded:
            <ul>
                <li>Login Attempts</li>
                <li>Registration Attempts</li>
                <li>Downloading a File</li>
                <li>Uploading a File</li>
                <li>Visiting a Page</li>
            </ul>

            These User Actions are not shared publicly and are used for the security, development, and maintanence of Blend-Exchange.

            <h3>Public Actions</h3>

            In addition to logged User Actions, the following User Action are recorded and information about them is made public in order to enable certain features of the service:

            <ul>
                <li><b>"Favorting"</b> a blend file (Performed by clicking the favorite button on a .blend files page). This action will change the publicly visible favorite tally for that blend file. This data is associated with an IP address. It is possible for 3rd parties to determine if an IP address has been used to favorite a .blend file. IP Addresses are used to ensure that users do not repeatedly "favorite" a .blend file.</li>
                <li><b>"Viewing"</b> a blend file (Performed by visiting a .blend file's page). This action will change the publicly visible view tally for that blend file. This data is associated with an IP address. </li>
                <li><b>"Downloading"</b> a blend file (Performed by downloading a .blend file from Blend-Exchange). This action will change the publicly visible download tally for that blend file. This data is associated with an IP address. </li>
            </ul>

            These actions require users to opt-in by performing an action and/or visiting a page.

            <h2>Uses of Data</h2>

            The data Blend-Exchange collects is used to provide the Blend-Exchange service. We only collect data required to provide users with the services as described, and secure the Blend-Exchange service. If you feel any data collection performed by Blend-Exchange is uneccsary, please make contact. How the data is used to fufill these goals is described above.

            <h2>Data Storage</h2>

            All data collected by Blend-Exchange is stored within the United States using the methods described in the previous section.

            <h2>Controling Your Data</h2>

            <h3>Accessing Data Held by Blend-Exchange</h3>
            <p>
                The user profile includes links to the binary files uploaded. They can be downloaded from there in the original format in which they were uploaded.
                The provided password cannot be retrived in any form due to security concerns. Other account details can be obtained in plain text from the user profile page. Please contact blend-exchange if assitance is needed.
            </p>
            <h3>Removal of Data Held by Blend-Exchange</h3>
             
            <p>
                If you need your data removed, please make contact. Blend-exchange will attempt to remove your data when the operator can allocate the suffcient time without undue inconvience. Blend-Exchange may refuse to remove certain data if it is not legally oblidged to remove that data.
            </p>

            Blend-Exchange can be contacted via the following email address:

            <a href="mailto://blend-exchange-privacy@giantcowfilms.com">blend-exchange-privacy@giantcowfilms.com</a>

        </div>
		<?php include("../parts/footer.php"); ?>
        <script src="jquery.js"></script>
        <script src="dropzone.js"></script>
    </body>
</html>
