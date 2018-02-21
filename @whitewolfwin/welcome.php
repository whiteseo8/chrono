<?php
/*--------------------------
viviС͵��վϵͳ
qq:996948519
---------------------------*/
require_once('data.php');
require_once('checkAdmin.php');
require_once('../inc/common.inc.php');
?>
<script type="text/javascript">
var vipcode='<?php echo urlencode($vipcode)?>';
var version='<?php echo VV_VERSION?>';
var systype='wanneng';
</script>
<div class="right_top"><marquee behavior=slide width=600 scrollamount=10 onmouseover=this.stop() onmouseout=this.start()><?php echo $welcome;?></marquee></div>