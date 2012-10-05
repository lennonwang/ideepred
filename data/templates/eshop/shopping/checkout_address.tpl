<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>填写收货人配送地址--{smarty_include eshop.common.xtitle}</title>
	<link type="image/x-icon" href="/favicon.ico" rel="shortcut icon"/> 
	{smarty_include eshop.js-common}
	{smarty_include eshop.js-form}
	<script type="text/javascript" src="/js/e/confirm.js"></script>
</head>

<body>	 

		{smarty_include eshop.common.header}
<!-- S bdy -->
<div class="bdy">
	<div class="c0"> 
				<div class="bordor" id="orderfrom">
					<h2 class="step step2">购物流程: <span id="shoppingstep_1">1.登录注册</span> >> 
					<span id="shoppingstep_2"  >2.填写核对订单信息</span> >> 
					<span id="shoppingstep_3">3.提交订单</span></h2>
					 
					 
					<h3 class="stepTitle"><span class="opt">带<span class="s">*</span>的项目为必填项</span>请填写收货人配送地址</h3>
					<div class="sho_step editable" id="chkadd_info">
						 
						<form method="post" action="/app/eshop/shopping/do_address" id="basic_ofrm">
							<input type="hidden" name="next_step" value="{$next_step}" />
							<div class="dataTable dataTable4">
								<table>
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
							</div>
							<!-- table div end -->
							<div id="do_buy" class="btns2">
								<button type="submit" name="_submit" class="go_submit step-addr btn"><b>保存收货人信息</b></button>
							</div> 
							
						</form>
				 		</div>
					
				 </div>
			 </div>
 
 
	  
		
	<!-- E bdy -->
  
  	 
	{smarty_include eshop.common.site-help}
	 
	
	
	{smarty_include eshop.common.footer}
  
	
</body>
</html>