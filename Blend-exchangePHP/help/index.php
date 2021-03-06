    <?php include("../parts/header.php"); ?>
        <div id="mainContainer">
            <h1>Help:</h1>
            <div style="width: 400px; float: right;" ><img  src="/help/Demo.gif" alt="Demonstration"/>Steps to upload a .blend</div>
            <h2>Upload a file</h2>
            <ol>
                <li>Drop a file</li>
                <li>Enter the url of the question on blender.stackexchange</li>
                <li>Copy embed code into post</li>
            </ol>
            If you need a <a href="/help/AdvancedHelp.gif"><b>More Detailed .Gif</b>, click here</a>.
            <h2>How do I edit or delete my .blend</h2>
            If you entered a password when uploading, you can use it to do this. However this feature has not been implemented yet.
            <h2>I clicked on the upload box nothing happend!</h2>
            That is a known issue... I'm working to fix it
            <h2>I clicked upload and it said invalid question</h2>
            You need to copy and paste the URL from the question into the text area. Be sure to get the full url with the http and everything. We do this to make it easier to check for abuse.
            <h2>The embed is not displaying properly</h2>
            Copy the code straight into your post, don't try to wrap it in a link, image or any other markup. If it doesn't display properly in the preview, try backspacing then retyping a character to get stack exchange to update the preview.
            <h2>My blend was taken down due to copyright, now what</h2>
            You can contact me, see below
            <h2>If you need help, contact me:</h2>
            <a href="http://www.google.com/recaptcha/mailhide/d?k=01SR3F0O5RcRWWOXZyvP7Udw==&amp;c=93BWQEsO3Y4SRPmZVt6qRS8Rmai5fVwVKiVZTzKJY8QVvMGvFrYwOJ0f7keKKGVa" onclick="window.open('http://www.google.com/recaptcha/mailhide/d?k\07501SR3F0O5RcRWWOXZyvP7Udw\75\75\46c\7593BWQEsO3Y4SRPmZVt6qRS8Rmai5fVwVKiVZTzKJY8QVvMGvFrYwOJ0f7keKKGVa', '', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=500,height=300'); return false;" title="Reveal this e-mail address">b...@giantcowfilms.com</a> - It may take a few days for a response.
            If you don't want to use email, you can report a bug by opening a <a href="https://github.com/GiantCowFilms/Blend-Exchange/issues/new">GitHub issue</a>.
        </div>
        <?php include("../parts/footer.php"); ?>
        <script src="jquery.js"></script>
        <script src="dropzone.js"></script>
    </body>
</html>
