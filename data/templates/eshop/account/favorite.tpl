<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>收藏夹-个人帐户管理</title>
	<meta name="author" content="xiaoyi">
	<link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" />
	{smarty_include eshop.js-common}
</head>

<body>
 
	
	{smarty_include eshop.common.header}
	
	
	
		
<!-- S crumbs -->
<div class="crumbs">
	<div class="c0">
  	<a href="/">首页</a>&gt;<a href="#" class="on">个人中心</a>  &gt;<a href="#" class="on">我收藏的商品</a>  
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
								<td colspan="6">我收藏的商品</td>
							</tr> 
							<tr class="gs">
											<td>序号</td>
											<td>商品图片</td>
											<td>商品信息</td>
											<td>单价</td>
											<td>收藏时间</td>
														</tr>
						{foreach from=$plist item=product name=order}
										<tr class="gs">
											<td>{$smarty.foreach.order.iteration}</td>
											<td  >
												<a href="{Common_Smarty_Url_format key=product id=$product.id}" title="{$product.title}">
												<img src="{Common_Smarty_Product_photoThumb thumb_path=$product.thumb w=107 h=107 is_resize=true}" class="bordor" width="107" height="107" />
											</a></td>
											<td><p class="pl"><a href="{Common_Smarty_Url_format key=product id=$product.id}" target="_blank">{$product.title}</a></p></td>
											<td>{$product.sale_price}元</td>
											<td>{$product.created_on}</td>
										</tr>
										{/foreach}
						</tbody>
						</table>
					</div> 
 							{assign var=url_prefix value="/app/eshop/profile/favorite"}
								{smarty_include eshop.common.pager}

				</div>
				<!-- E tables -->

			</div>
		</div>
<!-- E main -->

	</div>
</div>
<!-- E bdy -->

 
	
	{smarty_include eshop.common.footer}
	
</div>
</body>
</html>