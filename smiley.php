<script type="text/javascript" language="javascript">
/* <![CDATA[ */
    function grin(tag) {
    	var myField;
    	tag = ' ' + tag + ' ';
        if (document.getElementById('comment') && document.getElementById('comment').type == 'textarea') {
    		myField = document.getElementById('comment');
    	} else {
    		return false;
    	}
    	if (document.selection) {
    		myField.focus();
    		sel = document.selection.createRange();
    		sel.text = tag;
    		myField.focus();
    	}
    	else if (myField.selectionStart || myField.selectionStart == '0') {
    		var startPos = myField.selectionStart;
    		var endPos = myField.selectionEnd;
    		var cursorPos = endPos;
    		myField.value = myField.value.substring(0, startPos)
    					  + tag
    					  + myField.value.substring(endPos, myField.value.length);
    		cursorPos += tag.length;
    		myField.focus();
    		myField.selectionStart = cursorPos;
    		myField.selectionEnd = cursorPos;
    	}
    	else {
    		myField.value += tag;
    		myField.focus();
    	}
    }
/* ]]> */
</script>
<a href="javascript:grin(':?:')"><img src="<?php echo get_template_directory_uri(); ?>/img/smilies/1f604.png" alt="" /></a>
<a href="javascript:grin(':razz:')"><img src="<?php echo get_template_directory_uri(); ?>/img/smilies/1f61b.png" alt="" /></a>
<a href="javascript:grin(':sad:')"><img src="<?php echo get_template_directory_uri(); ?>/img/smilies/1f626.png" alt="" /></a>
<a href="javascript:grin(':smile:')"><img src="<?php echo get_template_directory_uri(); ?>/img/smilies/1f623.png" alt="" /></a>
<a href="javascript:grin(':oops:')"><img src="<?php echo get_template_directory_uri(); ?>/img/smilies/1f633.png" alt="" /></a>
<a href="javascript:grin(':grin:')"><img src="<?php echo get_template_directory_uri(); ?>/img/smilies/1f600.png" alt="" /></a>
<a href="javascript:grin(':eek:')"><img src="<?php echo get_template_directory_uri(); ?>/img/smilies/1f62e.png" alt="" /></a>
<a href="javascript:grin(':shock:')"><img src="<?php echo get_template_directory_uri(); ?>/img/smilies/1f62f.png" alt="" /></a>
<a href="javascript:grin(':cool:')"><img src="<?php echo get_template_directory_uri(); ?>/img/smilies/1f60e.png" alt="" /></a>
<a href="javascript:grin(':lol:')"><img src="<?php echo get_template_directory_uri(); ?>/img/smilies/1f606.png" alt="" /></a>
<a href="javascript:grin(':mad:')"><img src="<?php echo get_template_directory_uri(); ?>/img/smilies/1f621.png" alt="" /></a>
<a href="javascript:grin(':wink:')"><img src="<?php echo get_template_directory_uri(); ?>/img/smilies/1f609.png" alt="" /></a>
<a href="javascript:grin(':neutral:')"><img src="<?php echo get_template_directory_uri(); ?>/img/smilies/1f610.png" alt="" /></a>
<a href="javascript:grin(':cry:')"><img src="<?php echo get_template_directory_uri(); ?>/img/smilies/1f625.png" alt="" /></a>
<br />