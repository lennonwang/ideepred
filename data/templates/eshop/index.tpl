<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi">
	{smarty_include eshop.common.header_compart}
	<link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" />
	{smarty_include eshop.js-common}
	<script type="text/javascript" src="/js/c/jcarousellite_1.0.1.js"></script>
	<script type="text/javascript" src="/js/e/idx.js"></script>
</head>

<body>
<div id="wrapper">
	
	{smarty_include eshop.common.header}

	<div id="carousel"> <!--slidepicture-->
		<ul class="carousel_nav">
			{Common_Smarty_Advertise_findAdmany number="index-sps" size=6 item=ad}
			<li {if $first}class="active"{/if} id="n_{$loop}">
				<a href="{$ad.link}#{$loop}" target="_blank">{$ad.title|Common_Smarty_Advertise_cnTruncate:16}</a>
			</li>
			{/Common_Smarty_Advertise_findAdmany}
		</ul>
		{Common_Smarty_Advertise_findAdmany number="index-sps" size=6 item=ad}
		<div class="panel carousel_item" id="slot{$loop}">
			<a href="{$ad.link}" title="{$ad.title}" target="_blank">
				<img src="{$ad.thumb}" alt="{$ad.title}" />
			</a>
		</div>
		{/Common_Smarty_Advertise_findAdmany}
	</div>
	
	<div id="container">
		{Common_Smarty_Advertise_findAdone number="index-sale" var='adn'}
		{if $adn}
		<div class="box pt-10">
			<a href="{$adn.link}" title="{$adn.title}" target="_blank">
				<img src="{$adn.thumb}" alt="{$adn.title}" />
			</a>
		</div>
		{/if}
		
		<div class="box pt-10">
			<h3><img src="/images/eshop/stuff-catetitle.png" alt="产品分类"/></h3>
			
			<ul class="mt-20 big-brands clearfix">
				<li>
					<a href="{Common_Smarty_Url_format key='brand_product' id=1}">
						<img src="/images/eshop/brand-wacom.jpg" alt="wacom"/>
					</a>
				</li>
				<li>
					<a href="{Common_Smarty_Url_format key='brand_product' id=3}">
						<img src="/images/eshop/brand-apple.jpg" alt="apple"/>
					</a>
				</li>
				<li class="last">
					<a href="{Common_Smarty_Url_format key='brand_product' id=2}">
						<img src="/images/eshop/brand-hp.jpg" alt="hp"/>
					</a>
				</li>
				<li>
					<a href="#">
						<img src="/images/eshop/brand-lenovo.jpg" alt="lenovo"/>
					</a>
				</li>
				<li>
					<a href="#">
						<img src="/images/eshop/brand-sandisk.jpg" alt="sandisk"/>
					</a>
				</li>
				<li class="last">
					<a href="{Common_Smarty_Url_format key=channel slug=peijian}">
						<img src="/images/eshop/brand-peijian.jpg" alt="配件"/>
					</a>
				</li>
			</ul>
		</div>
		
		<div class="box pt-10">
			<h3><img src="/images/eshop/recstuff-title.png" alt="推荐产品"/></h3>
			
			<ul class="mt-20 stuff-list stuff-list-hot clearfix">
				{Common_Smarty_Product_findProductList stick=1 size=8}
				<li class="{if $index%4 eq 0}last{/if}">
					<a href="{Common_Smarty_Url_format key=product id=$product.id}" class="imgborder">
						<img src="{$product.thumb}" class="bordor" width="220" height="210" />
					</a>
					<h3 class="a999"><a href="{Common_Smarty_Url_format key=product id=$product.id}">{$product.title}</a></h3>
					<p>优惠价：<span class="ft14 orange">￥{$product.sale_price}</span></p>
					<a href="#" class="abuy hidden"><img src="/images/eshop/icon-buy.png" /></a>
				</li>
				{/Common_Smarty_Product_findProductList}
			</ul>
			
		</div>
		
		
	</div>
	
	{smarty_include eshop.common.site-help}
	
	{smarty_include eshop.common.friend_links}
	
	{smarty_include eshop.common.footer}
</div>
</body>
</html>