<prepend select="{if $jq_error_tip_append_to}{$jq_error_tip_append_to}{else}#ajax-response{/if}">
	<div id="_jq_response_result" class="warning">{$jq_error_tip_message}</div>
</prepend>
{if $jq_error_tip_auto_hide }
{literal}
<eval>
	$('#_jq_response_result').animate({opacity: 1.0}, 3000,function(){$(this).remove();});
</eval>
{/literal}
{/if}
