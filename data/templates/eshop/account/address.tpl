<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>配送地址-个人帐户管理</title>
	<meta name="author" content="xiaoyi">
	<link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" />
	{smarty_include eshop.js-common}
	<script>
		
	</script>
</head>

<body>
<div id="wrapper">
	
	{smarty_include eshop.common.header}
	
	<div id="container">
		<div class="box">
			<div class="bordor profile">
				<h2>个人帐户管理</h2>
				
				<div class="box clearfix">
					<div class="leftref noborder" id="channelside">
						{smarty_include eshop.account.leftnav}
					</div>
					<div class="righttwo2" id="contentlist">
					  <!-- addbooks edit begin -->
					  <div>
					  <form method="post" action="/app/eshop/shopping/do_address"> 
							<table>
								<tr style="line-height:120%;">
									<th><label for="name">收货人姓名：</label></th>
									<td><input type="text" name="name" value="" class="middle-text" />
									<span class="star">
										<font>*</font>
										<span style="color: rgb(255, 0, 0);" class="name_table_notice"></span>
									</span>
									</td>
								</tr>
								<tr>
									<th><label for="province">省 份：</label></th>
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
									<th><label for="address">地 址：</label></th>
									<td>
										<input type="text" name="address" value="" class="middle-text" />
										<span class="star">
											<font>*</font>
											<span style="color: rgb(255, 0, 0);" class="address_table_notice"></span>
										</span>
									</td>
								</tr>
								<tr>
									<th><label for="zip">邮政编码：</label></th>
									<td>
										<input type="text" name="zip" value="" class="middle-text" />
									</td>
								</tr>
								<tr>
									<th><label for="telephone">固定电话：</label></th>
									<td><input type="text" name="telephone" value="" class="middle-text" id="telephone" /></td>
								</tr>
								<tr>
									<th><label for="mobie">手机号码：</label></th>
									<td>
										<input type="text" name="mobie" value="" class="middle-text" id="mobie" />
										<span class="star">
											<font>*</font>
											<span style="color: rgb(255, 0, 0);" class="tel_table_notice"></span>
										</span>
									</td>
								<tr>
								<tr>
									<th><label for="email"><span class="star">*</span>电子邮件：</label></th>
									<td><input type="text" name="email" value="" class="middle-text" />
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
					  <!-- addbooks edit end-->
						<!-- table list begin -->
						<div class="a_item contentbox">
							<div class="contentbaby">
							
								<div class="a_item ablue">
									<table >
										<tr class="tr_lin gs">
											<td>序号</td> 
											<td width="30%">地址</td>
											<td>收件人</td>
											<td>手机</td>
											<td>固话</td>
											<td>编辑</td>
										</tr>
										{foreach from=$addbooks_list item=addbooks name=order}
										<tr class="gs">
											<td>{$smarty.foreach.order.iteration}</td>
											<td class="pg"> {$addbooks.address} </td>
										 	<td>{$addbooks.name}</td>
											<td>{$addbooks.mobie}</td>
											<td>{$addbooks.telephone}</td>
											<td> 
												<a href="{Common_Smarty_Url_format key='i_address'}">修改</a>
												<a>设为默认地址</a>
												<a>删除</a>
											 </td>
										</tr>
										{/foreach}
									</table>
								</div>
							
							</div>
						</div>
						<!-- table list end -->

					</div>
				</div>
			</div>
		</div>

	</div>

	{smarty_include eshop.common.site-help}
	
	{smarty_include eshop.common.footer}
	
</div>
</body>
</html>