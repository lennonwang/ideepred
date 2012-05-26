<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>{$store.title}-{smarty_include eshop.common.xtitle}</title>
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
			<a href="{Common_Smarty_Url_format key=domain}" class="home">首页</a>
			<span> > </span>
			{$store.title}（共{$records}件）
		</div>
		
		<div class="box clearfix">
			<form name="filter-price" method="post" action="/app/eshop/mall/search">
				<div class="leftref noborder" id="channelside">
					<h2>全部分类</h2>
					{smarty_include eshop.leftcategory}
				</div>
				<div class="righttwo" id="contentlist">
					<div class="box nospace">
						{Common_Smarty_Advertise_findAdone number="list_rc_01"}
						{if $advertise.thumb}
						<div class="styadx2x1">
							<a href="{$advertise.link}" title="{$advertise.title}">
								<img src="{$advertise.thumb|default:'/images/eshop/stylelist-ad1x1.jpg'}" alt="{$advertise.title}" />
							</a>
						</div>
						{/if}
					</div>
					
					<div class="filter-option clearfix">
						<label for="showay" class="showay">显示方式：</label>
						<a href="{Common_Smarty_Url_format key=brand_product id=$store.id page=1}" class="way gird">格子</a>
						<a href="{Common_Smarty_Url_format key=brand_product id=$store.id page=1}" class="way list">列表</a>
					
						<label for="page" class="tabpage">
							<a href="{Common_Smarty_Url_format key=brand_product id=$store.id page=1}" class="firstpage">第一页</a>
							<a href="{Common_Smarty_Url_format key=brand_product id=$store.id page=$prev_page}" class="prevpage">前一页</a>
							<span>{$page}/{$total}</span>
							<a href="{Common_Smarty_Url_format key=brand_product id=$store.id page=$next_page}" class="nextpage">后一页</a>
							<a href="{Common_Smarty_Url_format key=brand_product id=$store.id page=$total}" class="lastpage">末 页</a>
						</label>
					</div>
				
					<div class="box featurecate">
					
						<ul class="mt-20 stuff-list clearfix">
							{foreach from=$product_list item=product name=pro}
							<li {if $smarty.foreach.pro.iteration%3 eq 0}class="last"{/if}>
								<a href="{Common_Smarty_Url_format key=product id=$product.id}" title="{$product.title}">
									<img src="{Common_Smarty_Product_photoThumb thumb_path=$product.thumb}" class="bordor" width="220" height="210" />
								</a>
								<h3 class="a999"><a href="{Common_Smarty_Url_format key=product id=$product.id}" title="{$product.title}">{$product.title}</a></h3>
								<p>优惠价：<span class="ft14 orange">￥{$product.sale_price}</span></p>
								<a href="" class="abuy hidden"><img src="/images/eshop/icon-buy.png" /></a>
							</li>
							{/foreach}
						</ul>
					
					</div>
				
					<div class="filter-option clearfix">
					
						<label for="page" class="tabpage">
							<a href="{Common_Smarty_Url_format key=brand_product id=$store.id page=1}" class="firstpage">第一页</a>
							<a href="{Common_Smarty_Url_format key=brand_product id=$store.id page=$prev_page}" class="prevpage">前一页</a>
							<span>{$page}/{$total}</span>
							<a href="{Common_Smarty_Url_format key=brand_product id=$store.id page=$next_page}" class="nextpage">后一页</a>
							<a href="{Common_Smarty_Url_format key=brand_product id=$store.id page=$total}" class="lastpage">末 页</a>
						</label>
					
					</div>
				
				</div>
			</form>
		</div>
	</div>

	{smarty_include eshop.common.site-help}
	
	{smarty_include eshop.common.footer}
</div>
</body>
</html>