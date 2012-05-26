<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>最新产品列表-{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi">
	{smarty_include eshop.common.header_compart}
	<link rel="stylesheet" href="/csstyle/cstyle.css" type="text/css" />
	{smarty_include eshop.js-common}
</head>

<body>
{smarty_include eshop.common.tophead}
<div id="wrapper">
	{smarty_include eshop.common.header}
	
	<div id="container">
		{Common_Smarty_Advertise_findAdone number="index-t-1"}
		{if $advertise.thumb}
		<div class="box">
			<div class="iadx1">
				<a href="{$advertise.link}" title="{$advertise.title}" target="_blank">
					<img src="{$advertise.thumb|default:'/images/eshop/imgad/ad_t_1.jpg'}" alt="{$advertise.title}" />
				</a>
			</div>
		</div>
		{/if}
		
		<div class="box">
			<div class="leftref noborder" id="channelside">
				{smarty_include eshop.leftcategory}
				
				<div class="bordor linespace hotcomment" >
					<h2>用户热评</h2>
					
					<ul class="ibox-topic">
						{Common_Smarty_DataSet_comment var=comments type=1 item=cmt size=7}
						<li>
							<a href="{Common_Smarty_Url_format key=product id=$cmt.target_id}" title="{$cmt.title}">{$cmt.title}  {$cmt.created_on|date_format:'%Y-%m-%d'}</a>
						</li>
						{/Common_Smarty_DataSet_comment}
					</ul>
					
				</div>
				
			</div>
			<div class="righttwo" id="contentlist">
				
				<div class="bread-crumbs">
					<a href="{Common_Smarty_Url_format key=domain}" class="home">首页</a>
					<span> » </span>
					最新产品（共{$records}件）
				</div>
				<div class="clear"></div>
				
				<div class="filter-option">
					
					<label for="order" class="orderby">排序方式:  
						<select name="orderby" id="filter_orderby">
							<option value="{Common_Smarty_Url_format key=newest_list page=1 orderby=1}" {if $orderby eq 1}selected="selected"{/if}>按上架时间</option>
							<option value="{Common_Smarty_Url_format key=newest_list page=1 orderby=2}" {if $orderby eq 2}selected="selected"{/if}>按价格排序</option>
							<option value="{Common_Smarty_Url_format key=newest_list page=1 orderby=3}" {if $orderby eq 3}selected="selected"{/if}>按查看次数</option>
						</select>
					</label>
					
					<label for="page" class="tabpage">
						<a href="{Common_Smarty_Url_format key=newest_list  page=1 orderby=$orderby}" class="firstpage">第一页</a>
						<a href="{Common_Smarty_Url_format key=newest_list  page=$prev_page orderby=$orderby}" class="prevpage">前一页</a>
						<span>{$page}/{$total}</span>
						<a href="{Common_Smarty_Url_format key=newest_list  page=$next_page orderby=$orderby}" class="nextpage">后一页</a>
						<a href="{Common_Smarty_Url_format key=newest_list  page=$total orderby=$orderby}" class="lastpage">末 页</a>
					</label>
					
					<div class="clear"></div>
				</div>
				
				<div class="box featurecate">
					
					<ul>
						{foreach from=$product_list item=product name=pro}
						<li {if $smarty.foreach.pro.iteration%4 eq 0}class="last"{/if}>
							<a href="{Common_Smarty_Url_format key=product id=$product.id}" title="{$product.title}" target="_blank">
								<img src="{Common_Smarty_Product_photoThumb thumb_path=$product.thumb}" class="bordor" width="150" height="150" />
							</a>
							<div class="bp-now">
								<h3><a href="{Common_Smarty_Url_format key=product id=$product.id}" title="{$product.title}" target="_blank">{Common_Smarty_Product_brand brand_id=$product.category_id}{$product.title}</a></h3>
								<label>售价 ￥{$product.sale_price}</label>
							</div>
						</li>
						{/foreach}
						
					</ul>
					<div class="clear"></div>
				</div>
				
				<div class="filter-option">
					
					<label for="page" class="tabpage">
						<a href="{Common_Smarty_Url_format key=newest_list  page=1 orderby=$orderby}" class="firstpage">第一页</a>
						<a href="{Common_Smarty_Url_format key=newest_list  page=$prev_page orderby=$orderby}" class="prevpage">前一页</a>
						<span>{$page}/{$total}</span>
						<a href="{Common_Smarty_Url_format key=newest_list  page=$next_page orderby=$orderby}" class="nextpage">后一页</a>
						<a href="{Common_Smarty_Url_format key=newest_list  page=$total orderby=$orderby}" class="lastpage">末 页</a>
					</label>
					
					<div class="clear"></div>
				</div>
				
			</div>
			<div class="clear"></div>
		</div>
	</div>

	{smarty_include eshop.common.site-help}
	
	{smarty_include eshop.common.footer}
</div>
</body>
</html>