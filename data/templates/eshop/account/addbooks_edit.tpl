{if $edit_mode eq 'edit'}
<prepend select="#ajax-response">
	<div id="_jq_response_result" class="updated">{$msg}</div> 
</prepend>  
 <attr select="#add_id" name="value" value="{$addbooks.id}" /> 
 <attr select="#name" name="value" value="{$addbooks.name}" /> 
 <attr select="#address" name="value" value="{$addbooks.address}" /> 
 <attr select="#choose_province" name="value" value="{$addbooks.province}" /> 
 <attr select="#zip" name="value" value="{$addbooks.zip}" /> 
 <attr select="#telephone" name="value" value="{$addbooks.telephone}" /> 
 <attr select="#mobie" name="value" value="{$addbooks.mobie}" /> 
 <attr select="#email" name="value" value="{$addbooks.email}" />    
 <attr select="#choose_city_id" name="value" value="{$addbooks.city}" /> 
{literal}
<eval><![CDATA[
$('#edit_div').show();
$('#_jq_response_result').fadeOut(3000,function(){$(this).remove();});  
change_area_value();
]]></eval>   
{/literal}  
 {/if} 
{if $edit_mode eq 'save'}
 <prepend select="#ajax-response-msg">
	<div id="_jq_response_msg_result" class="updated">{$msg}</div> 
</prepend>   
{literal}
<eval><![CDATA[
$('#edit_div').hide();
$('#_jq_response_msg_result').fadeOut(3000,function(){$(this).remove();});   
]]></eval>
{/literal}
{/if}