<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
	<script type="text/javascript">
	{literal}
	$(function(){
		$('#addoption').validate({
			rules:{
				title:"required",
				type:"required"
			},
			messages:{
				title:"活动标题不能为空",
				type:"活动类型不能为空"
			},
			submitHandler: function(form) {
				try{
					$(form).ajaxSubmit();
				}catch(e){
					alert(e);
				}
				return false;
			}
		});
	});
	{/literal}
	</script>
</head>

<body>
	<div class="wrap">
		<div class="icon32" id="icon-edit">
			<br>
		</div>
		<h2>编辑促销活动 <a class="button add-new-h2" title="添加促销活动" href="/app/admin/marketing/edit">添加促销活动</a></h2>
		<div class="clear"></div>
		<div id="ajax_request_progress"></div>
		<div id="ajax-response"></div>

		<div id="col-container">
				<div class="form-wrap">
					<form action="/app/admin/marketing/save" method="post" id="addoption" name="addoption">					
						<input type="hidden" value="{$marketing.id}" name="id" id="marketing_id">
						
						<table class="form-table">
							<tbody>
								<tr class="form-field form-required">
									<th valign="top" scope="row"><label for="title">活动标题</label></th>
									<td>
										<input type="text" size="40" value="{$marketing.title}" id="title" name="title" />
									</td>
								</tr>
								<tr class="form-field">
									<th valign="top" scope="row"><label for="type">活动类型</label></th>
									<td>
										<select name="type">
											<option value="">--------</option>
											<option value="1" {if $marketing.type eq 1}selected="selected"{/if}>买就送赠品</option>
										</select>
						            </td>
								</tr>
								<tr class="form-field">
									<th valign="top" scope="row"><label for="gift_sku">活动赠品sku</label></th>
									<td>
										<textarea rows="5" id="gift_sku" name="gift_sku">{$marketing.gift_sku}</textarea>
						            </td>
								</tr>
								<tr class="form-field">
									<th valign="top" scope="row"><label for="gift_price">赠品价格</label></th>
									<td>
										<input type="text" size="40" value="{$marketing.gift_price}" id="gift_price" name="gift_price" />
									</td>
								</tr>
								<tr class="form-field">
									<th valign="top" scope="row"><label for="start_amount">最低金额</label></th>
									<td>
										<input type="text" size="40" value="{$marketing.start_amount}" id="start_amount" name="start_amount" />
									</td>
								</tr>
								<tr class="form-field">
									<th valign="top" scope="row"><label for="end_amount">最高金额</label></th>
									<td>
										<input type="text" size="40" value="{$marketing.end_amount}" id="end_amount" name="end_amount" />
									</td>
								</tr>
								<tr class="form-field">
									<th valign="top" scope="row"><label for="summary">活动描述</label></th>
									<td>
										<textarea rows="7" id="summary" name="summary">{$marketing.summary}</textarea><br>
						            </td>
								</tr>
							</tbody>
						</table>

						<p class="submit">
							<input type="submit" value="更新促销活动" name="submit" class="button">
						</p>
					</form>
				</div>

		</div>

	</div><!--endwrap-->
</body>
</html>