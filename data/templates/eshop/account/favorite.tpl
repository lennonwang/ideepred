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
						<div class="a_item contentbox">
							<div class="contentbaby">
							
								<div class="a_item ablue">
									<table >
										<tr class="tr_lin gs">
											<td>序号</td>
											<td>商品图片</td>
											<td>商品信息</td>
											<td>单价</td>
											<td>收藏时间</td>
										</tr>
										{foreach from=$plist item=product name=order}
										<tr class="gs">
											<td>{$smarty.foreach.order.iteration}</td>
											<td class="pg">
												<a href="{Common_Smarty_Url_format key=product id=$product.id}" title="{$product.title}">
												<img src="{Common_Smarty_Product_photoThumb thumb_path=$product.thumb w=107 h=107 is_resize=true}" class="bordor" width="107" height="107" />
											</a></td>
											<td><p class="pl"><a href="{Common_Smarty_Url_format key=product id=$product.id}" target="_blank">{$product.title}</a></p></td>
											<td>{$product.sale_price}元</td>
											<td>{$product.created_on}</td>
										</tr>
										{/foreach}
									</table>
								</div>
								{assign var=url_prefix value="/app/eshop/profile/favorite"}
								{smarty_include eshop.common.pager}
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