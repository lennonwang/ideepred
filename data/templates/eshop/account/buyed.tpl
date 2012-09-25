<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>购买商品记录-个人帐户管理</title>
	<meta name="author" content="xiaoyi">
	<link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" />
	{smarty_include eshop.js-common}
</head>

<body> 
	
	{smarty_include eshop.common.header}
	
	
		
<!-- S crumbs -->
<div class="crumbs">
	<div class="c0">
  	<a href="/">首页</a>&gt;<a href="#" class="on">个人中心</a>  &gt;<a href="#" class="on">已买到的商品</a>  
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
								<td colspan="6">已买到的商品</td>
							</tr> 
							<tr class="gs">
											<td>序号</td>
											<td>商品图片</td>
											<td width="50%">商品信息</td>
											<td>数量</td>
											<td>单价(最新价格)</td> 
														</tr>
						{foreach from=$plist item=product name=order}
										<tr class="gs">
											<td>{$smarty.foreach.order.iteration}</td>
											<td >
												<a href="{Common_Smarty_Url_format key=product id=$product.id}" title="{$product.title}">
												<img src="{Common_Smarty_Product_photoThumb thumb_path=$product.thumb w=90 h=90 is_resize=true}"  width="90" height="90" />
											</a></td>
											<td width="50%"> <a href="{Common_Smarty_Url_format key=product id=$product.id}" target="_blank">{$product.title}
											 </a> </td>
											<td>{$product.sale_num}</td>
											<td>{$product.sale_price}元</td> 
										</tr>
								{/foreach}
						</tbody>
						</table>
					</div> 
 

				</div>
				<!-- E tables -->

			</div>
		</div>
<!-- E main -->

	</div>
</div>
<!-- E bdy -->


	<div id="container">
		<div class="box">
			<div class="bordor profile">
				<h2>个人帐户管理</h2>
				
				<div class="box clearfix">
					<div class="leftref noborder" id="channelside">
						{smarty_include eshop.account.leftnav}
					</div>
					<div class="righttwo2" id="contentlist">
						<div class="a_item contentbox">
							<div class="contentbaby">
							
								<div class="a_item ablue">
									<table >
										<tr class="tr_lin gs">
											<td>序号</td>
											<td>商品图片</td>
											<td width="50%">商品信息</td>
											<td>数量</td>
											<td>单价</td>
											<td>小计</td>
										</tr>
										{foreach from=$plist item=product name=order}
										<tr class="gs">
											<td>{$smarty.foreach.order.iteration}</td>
											<td class="pg">
												<a href="{Common_Smarty_Url_format key=product id=$product.id}" title="{$product.title}">
												<img src="{Common_Smarty_Product_photoThumb thumb_path=$product.thumb w=90 h=90 is_resize=true}" class="bordor" width="90" height="90" />
											</a></td>
											<td width="50%"><p class="pl"><a href="{Common_Smarty_Url_format key=product id=$product.id}" target="_blank">{$product.title} ({$product.size})</a></p></td>
											<td>{$product.sale_num}</td>
											<td>{$product.sale_price}元</td>
											<td>{$product.sale_price*$product.sale_num}元</td>
										</tr>
										{/foreach}
									</table>
								</div>
							
							</div>
						</div>

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