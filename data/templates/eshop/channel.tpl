<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title> {$channel.name}-{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi">
	{smarty_include eshop.common.header_compart}
	<link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" />
	{smarty_include eshop.js-common}
</head>

<body>
<div id="wrapper">
	
	{smarty_include eshop.common.header}
	
	<div id="container">
		<div class="box paths a999">
			<a href="{Common_Smarty_Url_format key=domain}" class="home">首页</a> > <a href="#">{$channel.name}</a>
		</div>
		
		<div class="box clearfix">
			<div class="leftref noborder" id="channelside">
				<h2>全部分类</h2>
				{smarty_include eshop.leftcategory}
				
			</div>
			<div class="righttwo" id="contentlist">
				
				<!--频道页推荐分类-->
				{foreach from=$stick_category item=stk_cat name=chk_stk_cat}
				<div class="box featurecate">
					<h2>
						<a href="{Common_Smarty_Url_format key=category_list catcode=$stk_cat.code}" title="{$stk_cat.name}">
							{if $stk_cat.image}
							<img src="{$stk_cat.image}" alt="{$stk_cat.name}" />
							{else}
							{$stk_cat.name}
							{/if}
						</a> 
						<a href="{Common_Smarty_Url_format key=category_list catcode=$stk_cat.code}" class="more">更多 >></a>
					</h2>
					
					<ul class="mt-20 stuff-list clearfix">
						{Common_Smarty_Product_findProductList catcode=$stk_cat.code size=8 item=product}
						<li {if $index%3 eq 0}class="last"{/if}>
							<a href="{Common_Smarty_Url_format key=product id=$product.id}" title="{$product.title}" class="imgborder">
								<img src="{$product.thumb}" class="bordor" width="220" height="210" />
							</a>
							<h3 class="a999"><a href="{Common_Smarty_Url_format key=product id=$product.id}" title="{$product.title}">{$product.title}</a></h3>
							<p>优惠价：<span class="ft14 orange">￥{$product.sale_price}</span></p>
							<a href="" class="abuy hidden"><img src="/images/eshop/icon-buy.png" /></a>
						</li>
						{/Common_Smarty_Product_findProductList}

					</ul>
					<div class="clear"></div>
				</div>
				{/foreach}
				
			</div>
		</div>
	</div>

	{smarty_include eshop.common.site-help}
	
	{smarty_include eshop.common.footer}
</div>
</body>
</html>