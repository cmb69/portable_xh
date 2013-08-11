<?php

/**
 * @version $Id: script.php 237 2012-08-05 12:08:30Z cmb69 $
 */

/* utf-8 marker: äöü */
$script = '
<script type="text/javascript" src="./../tinymce/tiny_mce/tiny_mce_popup.js">
</script>

<script language="javascript" type="text/javascript">

var FileBrowserDialogue = {
    
    init : function () {
        // Nothing to do
    },

   
    submit : function (url) {
        var URL = url;
        var win = tinyMCEPopup.getWindowArg("window");
        var input = win.document.getElementById(tinyMCEPopup.getWindowArg("input"));
        win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;

        input.value = URL;
        if (input.onchange) input.onchange();

        tinyMCEPopup.close();
    }
}

tinyMCEPopup.onInit.add(FileBrowserDialogue.init, FileBrowserDialogue);

function setLink(link){

    FileBrowserDialogue.submit(link);
    return true;
}

</script>';
?>
