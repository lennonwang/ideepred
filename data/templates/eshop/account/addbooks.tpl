<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>配送地址-个人帐户管理</title>
	<meta name="author" content="xiaoyi">
	<link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" />
	{smarty_include eshop.js-common} 
	{smarty_include eshop.js-form}
	<script type="text/javascript" src="/js/e/profile.js"></script>
	<script type="text/javascript" src="/js/a/addbooks.js"></script>
	 <script type="text/javascript" src="/js/e/confirm.js"></script>
</head>

<body> 
	
	{smarty_include eshop.common.header}
	
	
				
<!-- S crumbs -->
<div class="crumbs">
	<div class="c0">
  	<a href="/">首页</a>&gt;<a href="#" class="on">个人中心</a>  &gt;<a href="#" class="on">地址管理</a>  
  </div>
</div>
<!-- E crumbs -->




	
<!-- S bdy -->
<div class="bdy">
	<div class="c0 A-M">
 	
 	{smarty_include eshop.account.leftnav}

<!-- S main -->
		<div class="MAIN">
			<div class="c">
			
			<!-- S tables -->
				<div class="ap">

					<div class="dataTable dataTable1">
							<table>
							<tbody>
							<tr class="tr_lin">
								<td colspan="6">我的收货地址</td>
							</tr> 
							<tr class="gs"> 
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
													<a href="javascript:editAddress('{$addbooks.id}');">修改</a>
												<a>设为默认地址</a>
												<a>删除</a>
											 </td>
										</tr>
										{/foreach}
								</tbody>
								</table>
					</div>  

				</div>
				<!-- E tables -->
				
				 <!-- addbooks edit begin -->
					  <div id="edit_div" style="display:none;">
					  <div id="ajax-response"></div>
					  <div id="ajax-response-msg"></div>
					  <div class="dataTable dataTable1">
					  <form method="post" action="/app/eshop/profile/save_addbooks"> 
					  		<input type="hidden" name="id" value="" id="add_id">
							<table  >
										<tr class="tr_lin">
										<td colspan="2">修改收获地址</td>
									</tr>
								<tr style="line-height:120%;">
									<td class="td_right"><label for="name">收货人姓名：</label></td>
									<td><input type="text" name="name" value="" id="name" class="middle-text" />
									<span class="star">
										<font>*</font>
										<span style="color: rgb(255, 0, 0);" class="name_table_notice"></span>
									</span>
									</td>
								</tr>
								<tr>
									<td class="td_right"><label for="province">省 份：</label></td>
									<td id="send_area">
										<label id="provice_box" name="/app/eshop/shopping/change_province"></label>
										<select name="province" id="choose_province">
											<option value="" >请选择</option>
											{foreach from=$provinces item=province}
											<option value="{$province.id}">{$province.name}</option>
											{/foreach}
										</select> 
										<label id="city_box"> 
										<input type="hidden" name="choose_city_id" value="" id="choose_city_id">
										<select name="city" id="choose_city">
											<option value="-1">-请选择-</option>
											{if $citys}
											{foreach from=$citys item=city}
											<option value="{$city.id}">{$city.name}</option>
											{/foreach}
											{/if}
										</select> 
										</label> 
										<span class="star">
											<font>*</font>
										</span>
									</td>
								</tr>
								<tr>
									<td class="td_right"><label for="address">地 址：</label></td>
									<td>
										<input type="text" name="address" value="" id="address" class="middle-text" />
										<span class="star">
											<font>*</font>
											<span style="color: rgb(255, 0, 0);" class="address_table_notice"></span>
										</span>
									</td>
								</tr>
								<tr>
									<td class="td_right"><label for="zip">邮政编码：</label></td>
									<td>
										<input type="text" name="zip" value="" id="zip" class="middle-text" />
									</td>
								</tr>
								<tr>
									<td class="td_right"><label for="telephone">固定电话：</label></td>
									<td><input type="text" name="telephone" value="" class="middle-text" id="telephone" /></td>
								</tr>
								<tr>
									<td class="td_right"><label for="mobie">手机号码：</label></td>
									<td>
										<input type="text" name="mobie" value="" class="middle-text" id="mobie" />
										<span class="star">
											<font>*</font>
											<span style="color: rgb(255, 0, 0);" class="tel_table_notice"></span>
										</span>
									</td>
								<tr>
								<tr>
									<td class="td_right"><label for="email"><span class="star">*</span>电子邮件：</label></td>
									<td><input type="text" name="email" value="" class="middle-text" id="email"/>
										<span class="star">
											<font>*</font>
											<span style="color: rgb(255, 0, 0);" class="email_table_notice"></span>
										</span>
									</td>
								</tr>
								<tr class="bh">
											<td></td>
											<td><input type="submit" name="_submit" value="确认修改" class="sm" /></td>
								</tr> 
								
							</table>
							 
									
							 
						</form>
						</div>
						</div>
					  <!-- addbooks edit end-->
					  
			</div>
		</div>
<!-- E main -->

	</div>
</div>
<!-- E bdy --> 


 

	 
	{smarty_include eshop.common.site-help}
	
	{smarty_include eshop.common.footer}
	
</div>
</body>
</html>