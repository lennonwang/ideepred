<prepend select="#category-lister">
	<tr id="category_tr_{$category.id}" class="iedit{if $smarty.foreach.cat.iteration%2 } alternate{/if}">
		<th class="check-column" scope="row">
			<input type="checkbox" value="{$category.id}" name="delete[]" />
		</th>
		<td>
			<a href="#" class="row-title">{$category.name}</a>
			<div class="row-actions"><span class="edit"><a href="categories.php?action=edit&amp;cat_ID=28">编辑</a> | </span><span class="inline hide-if-no-js"><a class="editinline" href="#">快速编辑</a> | </span><span class="delete"><a href="categories.php?action=delete&amp;cat_ID=28&amp;_wpnonce=224a042935" class="delete:the-list:cat-28 submitdelete">删除</a></span></div>
		</td>
		<td>{$category.description}</td>
		<td>{$category.slug}</td>
		<td>{$category.total}</td>
	</tr>
</prepend>