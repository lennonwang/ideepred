<replace select="#metakeyselect">
<select tabindex="8" name="metakeyselect" id="metakeyselect" gtbfieldid="122">
	<option value="#NONE#">- 选择 -</option>
	{foreach from=$features_list item=feature}
	<option value="{$feature.featurekey}" name="{$feature.id}">{$feature.featurename}</option>
	{/foreach}
</select>
</replace>