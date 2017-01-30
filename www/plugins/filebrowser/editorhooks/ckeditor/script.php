<?php

/**
 * @version $Id: script.php 1166 2014-01-07 14:10:29Z cmb69 $
 */

/* script.php build: 2011012801 */
$script = '
<script language="javascript" type="text/javascript">
 function setLink(link){

        //window.opener.CKEDITOR.tools.callFunction( 2, link );
		window.opener.CKEDITOR.tools.callFunction('.$_GET['CKEditorFuncNum'].', link );

         window.close();
    }
</script>
';
?>