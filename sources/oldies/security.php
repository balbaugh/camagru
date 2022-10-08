<!-- Security Functions -->


<!-- SANITIZE TEXT : INCLUDE IN SCRIPTS THAT OUTPUT TEXT FROM THE DATABASE -->
<!-- When outputting values from a text-related column, you should always sanitize them to prevent arbitrary code from being executed. The simple way to sanitize text output is to pass it to htmlspecialchars(). This function is related to htmlentities(), but it converts a more restricted range of characters to their equivalent HTML character entities. Specifically, it converts ampersands, quotes, and angle brackets; but it leaves periods (dots) untouched. This has the effect of neutralizing attempts to execute code when displayed in a browser because the angle brackets of <script> and PHP tags are converted. It’s important not to convert dots because they’re used in the names of files that we want to display.
The drawback with htmlspecialchars() is that by default it double encodes existing character entities. As a result, & is converted to &amp;. You can turn off this default behavior by passing the named argument double_encode to htmlspecialchars() and setting its value to false. -->

<?php
    function safe($text) 
    {
        return htmlspecialchars($text, double_encode: false);
    }
?> 