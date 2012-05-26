<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>变更商品数量</title>
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
	<script type="text/javascript" src="/js/a/purchase.js"></script>
</head>

<body>
	<div class="wrap">
		<div class="icon32" id="icon-edit">
			<br>
		</div>
		<h2>变更商品数量</h2>
		<div class="clear"></div>
		
		<div id="ajax-response"></div>
		
		<div id="col-container">
			<div class="form-wrap">
				
				<form action="/app/admin/purchase/save" method="post" id="purchasefrm" name="purchasefrm">					
					<input type="hidden" value="{$purchase.id}" name="id" id="purchase_id" >
				
					<table class="form-table">
						<tbody>
							<tr class="form-field">
								<th valign="top" scope="row"><label for="product_id">产品标题/SKU</label></th>
								<td>
									<input type="hidden" size="40" value="{$product.id}" id="product_id" name="product_id" /><label>{$product.title}/{$product.id}</label>
					            </td>
							</tr>
							<tr class="form-field">
								<th valign="top" scope="row"><label for="product_size">产品型号</label></th>
								<td><input type="text" size="40" value="{$purchase.product_size}" id="product_size" name="product_size" /><br>
					            </td>
							</tr>
							<tr class="form-field form-upload">
								<th valign="top" scope="row"><label for="quantity">修改数量</label></th>
								<td><input type="text" size="40" value="{$purchase.quantity}" id="quantity" name="quantity" /><br></td>
							</tr>
							<tr class="form-field">
								<th valign="top" scope="row"><label for="type">变更类型</label></th>
								<td>
									<select name="type">
										<option value="">请选择变更类型</option>
										<option value="1" {if $purchase.type eq 1}selected="selected"{/if}>上货</option>
										<option value="2" {if $purchase.type eq 2}selected="selected"{/if}>退货</option>
										<option value="3" {if $purchase.type eq 3}selected="selected"{/if}>补货</option>
										<option value="-1" {if $purchase.type eq -1}selected="selected"{/if}>报损</option>
									</select>
					            </td>
							</tr>
							<tr class="form-field">
								<th valign="top" scope="row"><label for="summary">备注原因</label></th>
								<td>
									<textarea name="summary">{$purchase.summary}</textarea>
					            </td>
							</tr>
						</tbody>
					</table>

					<p class="submit">
						<input type="submit" value=" 确认提交 " name="submit" class="button">
					</p>
				</form>
			</div>

		</div>

	</div><!--endwrap-->
</body>
</html>