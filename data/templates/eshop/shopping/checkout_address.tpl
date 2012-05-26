<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>填写收货人配送地址--{smarty_include eshop.common.xtitle}</title>
	<link type="image/x-icon" href="/favicon.ico" rel="shortcut icon"/>
	<link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" />
	{smarty_include eshop.js-common}
	{smarty_include eshop.js-form}
	<script type="text/javascript" src="/js/e/confirm.js"></script>
</head>

<body>	
	<div id="wrapper">

		{smarty_include eshop.common.header}

		<div id="container">

			<div class="box">
				<div class="bordor" id="orderfrom">
					<h2>结算步骤: <span id="shoppingstep_1">1.登录注册</span> >> <span id="shoppingstep_2" class="current_step">2.填写核对订单信息</span> >> <span id="shoppingstep_3">3.提交订单</span></h2>
					
					<p class="hotlink">带*的项目为必填项</p>
					
					
					<div class="sho_step editable" id="chkadd_info">
						<h3>请填写收货人配送地址</h3>
						<form method="post" action="/app/eshop/shopping/do_address" id="basic_ofrm">
							<input type="hidden" name="next_step" value="{$next_step}" />
							<table class="odrable">
								<tr>
									<th class="td_lab"><label for="name">收货人姓名：</label></th>
									<td><input type="text" name="name" value="{$data.name}" class="middle-text" />
									<span class="star">
										<font>*</font>
										<span style="color: rgb(255, 0, 0);" class="name_table_notice"></span>
									</span>
									</td>
								</tr>
								<tr>
									<th class="td_lab"><label for="province">省 份：</label></th>
									<td id="send_area">
										<label id="provice_box" name="/app/eshop/shopping/change_province"></label>
										<select name="province" id="choose_province">
											<option value="" >请选择</option>
											{foreach from=$provinces item=province}
											<option value="{$province.id}" {if $province.id eq $data.province}selected="selected"{/if}>{$province.name}</option>
											{/foreach}
										</select>
										
										<label id="city_box">
										{if $citys}
										<select name="city" id="choose_city">
											<option value="-1">-请选择-</option>
											{foreach from=$citys item=city}
											<option value="{$city.id}" {if $city.id eq $data.city}selected="selected"{/if}>{$city.name}</option>
											{/foreach}
										</select>
										{/if}
										</label>
										
										<span class="star">
											<font>*</font>
										</span>
									</td>
								</tr>
								<tr>
									<th class="td_lab"><label for="address">地 址：</label></th>
									<td>
										<input type="text" name="address" value="{$data.address}" class="middle-text" />
										<span class="star">
											<font>*</font>
											<span style="color: rgb(255, 0, 0);" class="address_table_notice"></span>
										</span>
									</td>
								</tr>
								<tr>
									<th class="td_lab"><label for="zip">邮政编码：</label></th>
									<td>
										<input type="text" name="zip" value="{$data.zip}" class="middle-text" />
									</td>
								</tr>
								<tr>
									<th class="td_lab"><label for="telephone">固定电话：</label></th>
									<td><input type="text" name="telephone" value="{$data.telephone}" class="middle-text" id="telephone" /></td>
								</tr>
								<tr>
									<th class="td_lab"><label for="mobie">手机号码：</label></th>
									<td>
										<input type="text" name="mobie" value="{$data.mobie}" class="middle-text" id="mobie" />
										<span class="star">
											<font>*</font>
											<span style="color: rgb(255, 0, 0);" class="tel_table_notice"></span>
										</span>
									</td>
								<tr>
								<tr>
									<th class="td_lab"><label for="email"><span class="star">*</span>电子邮件：</label></th>
									<td><input type="text" name="email" value="{if $data.email}{$data.email}{else}{$user_data.account}{/if}" class="middle-text" />
										<span class="star">
											<font>*</font>
											<span style="color: rgb(255, 0, 0);" class="email_table_notice"></span>
										</span>
									</td>
								</tr>
							</table>
							
							<div id="do_buy">
								<p>
									<input type="submit" name="_submit" value=" 配送地址 " class="go_submit step-addr" />
								</p>
							</div>
						</form>
					</div>
					
				</div>
			</div>

		</div>

		{smarty_include eshop.site-help}

		{smarty_include eshop.footer}
	</div>
	
</body>
</html>