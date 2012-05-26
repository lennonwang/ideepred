<replaceContent select="#city_box">
{if $citys}
<select name="city" id="choose_city">
	<option value="-1">-请选择-</option>
	{foreach from=$citys item=city}
	<option value="{$city.id}" {if $city.id eq $city_id}selected="selected"{/if}>{$city.name}</option>
	{/foreach}
</select>
{/if}
</replaceContent>