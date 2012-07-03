{if $edit_mode eq 'create'}
<append select="#the-list">
<tr id="meta-{$meta.id}">
	<td class="left">
		<label for="meta_key_{$meta.id}" class="screen-reader-text">键</label>
		<input type="text" value="{$meta.feature.featurename}" size="20" id="meta_title_{$meta.id}" name="meta_title_{$meta.id}" />
		<input type="hidden" value="{$meta.name}" id="meta_key_{$meta.id}" name="meta_key_{$meta.id}" />
	</td>
	<td>
			<input type="text"  id="meta_value_{$meta.id}" name="meta_value_{$meta.id}" value="{$meta.value}" />
		  <!--
			<textarea cols="30" rows="2" tabindex="6" id="meta_value_{$meta.id}" name="meta_value_{$meta.id}">{$meta.value}</textarea>
			-->
	</td>
	<td>
				<input type="button" value="删除" class="deletemeta" name="{$meta.id}" style="width:80px;"/>
			  <input type="button" class="updatemeta" value="更新" name="{$meta.id}" style="width:80px;"/>
	</td>
</tr>
</append>
{/if}

{if $edit_mode eq 'edit'}
<replace select="#meta-{$meta.id}">
<tr id="meta-{$meta.id}">
	<td class="left">
		<label for="meta_key_{$meta.id}" class="screen-reader-text">键</label>
		<input type="text" value="{$meta.feature.featurename}" size="20" id="meta_title_{$meta.id}" name="meta_title_{$meta.id}" />
		<input type="hidden" value="{$meta.name}" id="meta_key_{$meta.id}" name="meta_key_{$meta.id}" />
	</td>
	<td>
		<input type="text"  id="meta_value_{$meta.id}" name="meta_value_{$meta.id}" value="{$meta.value}" />
		 <!-- <textarea cols="30" rows="2" tabindex="6" id="meta_value_{$meta.id}" name="meta_value_{$meta.id}">{$meta.value}</textarea>
			-->
	</td>
	<td>
			<input type="button" value="删除" class="deletemeta" name="{$meta.id}" style="width:80px;"/>
			<input type="button" class="updatemeta" value="更新" name="{$meta.id}" style="width:80px;"/>
	</td>
</tr>
</replace>
{/if}

{if $edit_mode eq 'delete'}
{foreach from=$ids item=id}
<remove select="#meta-{$id}" />
{/foreach}
{/if}