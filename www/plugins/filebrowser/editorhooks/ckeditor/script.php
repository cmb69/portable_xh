<?php

/**
 * @version $Id: script.php 229 2012-07-30 13:31:07Z cmb69 $
 */

/* utf-8 marker: äöü */
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