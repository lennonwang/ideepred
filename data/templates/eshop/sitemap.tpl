<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>网站地图-{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi">
	<link rel="stylesheet" href="/csstyle/cstyle.css" type="text/css" />
	{smarty_include eshop.js-common}
	{smarty_include eshop.js-form}
</head>

<body>
{smarty_include eshop.common.tophead}
<div id="wrapper">
	
	{smarty_include eshop.common.header}
	
	<div id="container">
		
		<div class="box">
			{Common_Smarty_Advertise_findAdone number="channel_tl_01"}
			{if $advertise.thumb}
			<div class="iadx1">
				<a href="{$advertise.link}" title="{$advertise.title}">
					<img src="{$advertise.thumb|default:'/images/eshop/newpackage.jpg'}" alt="{$advertise.title}" />
				</a>
			</div>
			{/if}
		</div>
		
		<div class="box" id="sitemap">
			<h2>特色频道</h2>
			<div class="bordor">
				{foreach from=$category_channel item=hcate name=hc}
				<div class="kind-area {if $smarty.foreach.hc.last}lastkind{/if}">
					<div class="kind f14b ac fl">
						<a name="h-h-m" class="track" href="{Common_Smarty_Url_format key=channel slug=$hcate.slug}" target="_blank">{$hcate.name}</a>
					</div>
				    <div class="more-kind fl">
				    	<ul>
							{foreach from=$hcate.children item=cat}
				            <li>
								<a name="h-h-m-1" {if $cat.stick}class="track"{/if} href="{Common_Smarty_Url_format key=category_list catcode=$cat.code}" target="_blank">{$cat.name}</a>
							</li>
				            <li class="margin-lr">|</li>
				            {/foreach}
				         </ul>
					</div>
				</div>
				{/foreach}
				
			</div>
			
			<h2>特色服务</h2>
			<div class="bordor">
				
				<div class="kind-area">
				    <div class="more-kind fl">
				    	<ul>
				            <li>
								<a name="h-h-m-1" href="{Common_Smarty_Url_format key=brand_list page=1}" target="_blank">品牌专区</a>
							</li>
				            <li class="margin-lr">|</li>
							<li>
								<a name="h-h-m-1" href="{Common_Smarty_Url_format key=newest_list}" target="_blank">最新产品</a>
							</li>
							<li class="margin-lr">|</li>
				         </ul>
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