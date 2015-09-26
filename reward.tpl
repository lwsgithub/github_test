<div>
  <div class="cart-heading active" id="ch"><?php echo $heading_title; ?></div>
  <div class="cart-content" id="reward" style="height:44px;display:block;"><?php echo $entry_reward; ?>&nbsp;
  <input type="hidden" name="reward" id="reward_h" ss="0" value="<?php echo $reward; ?>" />
  &nbsp;<a id="button-reward" class="button"><span><?php echo $button_reward; ?></a></div>
</div>
<script type="text/javascript"><!--
$('#button-reward').bind('click', function() {
	$.ajax({
		type: 'POST',
		url: 'index.php?route=total/reward/calculate',
		data: $('#reward :input'),
		dataType: 'json',		
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-reward').attr('disabled', true);
			$('#button-reward').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('#button-reward').attr('disabled', false);
			$('.wait').remove();
		},		
		success: function(json) {
			if (json['error']) {
				$('#basket').before('<div class="warning">' + json['error'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
			}
			
			if (json['redirect']) {
				location = json['redirect'];
			}
		}
	});
});

jQuery(document).ready(function($){
	var zz = $('#reward').text();
	zz = zz.replace(/\D*/,'');
	zz = parseInt(zz);
	$('#reward_h').val(zz);
	
//	$.cookie('ss',0);
//	$('#button-reward').click(function(){
//									   $.cookie('zz',zz);
//									   $.cookie('ss',1);
//									   });
	//$('#xs b').text(decodeURIComponent('%E4%BD%BF%E7%94%A8%E7%A7%AF%E5%88%86')+'('+zz+')'+':');
	
});
//--></script> 
