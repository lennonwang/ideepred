<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>搜索结果-{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi">
	{smarty_include eshop.common.header_compart}
<!--	<link rel="stylesheet" href="/csstyle/cstyle.css" type="text/css" /> -->
		<link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" />
	{smarty_include eshop.js-common}
</head>

<body>
 
<div id="wrapper">
	{smarty_include eshop.common.header}
	
	<div id="container">
		
		<div class="box clearfix">
			<div class="leftref noborder" id="channelside">
			<!--	<img src="/images/eshop/search-result.jpg" alt="搜索结果" /> -->
 
				<h2>全部分类</h2>
				<!-- {smarty_include eshop.leftcategory} -->
				
		 
				<div class="bordor linespace pricescope" >
					
					<h2>红酒类型</h2> 
					 <li><a href="{Common_Smarty_Url_format key=search_list catcode="" page=1 style=$style orderby=1 low_price=0 high_price=0 
							country=$country grape_breed=$grape_breed query=$query}" {if $country eq ""} class="current"{/if}>全部类型</a></li> 
					{foreach from=$all_category item=cate} 
						 <li><a href="{Common_Smarty_Url_format key=search_list catcode=$cate.code page=1 style=$style orderby=1 low_price=0 high_price=0 
							country=$country grape_breed=$grape_breed query=$query}" {if $country_item.id eq $country} class="current"{/if}>{$cate.name}</a></li> 
					{/foreach} 
					<br/>
					
					<h2>红酒国家</h2> 
					<ul>
						<li><a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=0 high_price=0
						 country="" grape_breed=$grape_breed query=$query}" {if $country eq ""} class="current"{/if}>不限国家</a></li> 
						{foreach from=$wine_country_array item=country_item } 
							<li><a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=0 high_price=0 
							country=$country_item.id grape_breed=$grape_breed query=$query}" {if $country_item.id eq $country} class="current"{/if}>{$country_item.name}</a></li> 
						{/foreach}
					</ul>
					<br/>
					
					<h2>红酒品种</h2> 
					<ul>
						<li><a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=0 high_price=0 
							country=$country grape_breed="" query=$query}" 
							 {if $grape_breed eq ""} class="current"{/if}>全部品种</a></li> 
						{foreach from=$grape_breed_array item=breed_item }
							<li><a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=0 high_price=0 
								country=$country grape_breed=$breed_item.id query=$query}"
							 {if $breed_item.id eq $grape_breed} class="current"{/if}>{$breed_item.name}</a></li>  
						{/foreach}
					</ul>
					<br/>
					
					<h2>红酒品种</h2> 
					<ul>
						<li><a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=0 high_price=0 
							country=$country grape_breed="" query=$query}" 
							 {if $grape_breed eq ""} class="current"{/if}>全部品种</a></li> 
						{foreach from=$grape_breed_array item=breed_item }
							<li><a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=0 high_price=0 
								country=$country grape_breed=$breed_item.id query=$query}"
							 {if $breed_item.id eq $grape_breed} class="current"{/if}>{$breed_item.name}</a></li>  
						{/foreach}
					</ul>
					<br/>
										 	 	
					<h2>价格区间</h2> 
					<ul>
						<li><a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=0 high_price=0 
						country=$country grape_breed=$grape_breed query=$query}" {if $high_price eq 0}class="current"{/if}>不限价格</a></li>
						<li><a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=0 high_price=100
						 country=$country grape_breed=$grape_breed query=$query}" {if ($high_price <= 100) && ($high_price gt 0)}class="current"{/if}>0元-100元</a></li>
						<li><a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=101 high_price=200
						 country=$country grape_breed=$grape_breed query=$query}" {if ($high_price <= 200) && ($high_price gt 101)}class="current"{/if}>101元-200元</a></li>
						<li><a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=201 high_price=300
						 country=$country grape_breed=$grape_breed query=$query}" {if ($high_price <= 300) && ($high_price gt 201)}class="current"{/if}>201元-300元</a></li>
						<li><a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=0 high_price=300
						 country=$country grape_breed=$grape_breed query=$query}" {if ($high_price gt 300)}class="current"{/if}>300元以上</a></li>
					</ul>
					
					<form name="filter-price" method="post" action="/app/eshop/mall/search">
						<input type="hidden" name="catcode" value="{$catcode}" />
						<input type="hidden" name="style" value="{$style}" /> 
						<input type="hidden" name="country" value="{$country}" />
						<input type="hidden" name="grape_breed" value="{$grape_breed}" />
						<input type="hidden" name="wine_mode" value="{$wine_mode}" />
						<input type="hidden" name="orderby" value="1" />
						<input type="hidden" name="query" value="{if $query}{$query}{else}{/if}" />
						<label for="price">输入价格查询区间</label>
						<table>
							<tr>
								<td><input type="text" name="low-price" value="{if $low_price}{$low_price}{/if}" class="small-text" /></td>
								<td>-</td>
								<td><input type="text" name="high-price" value="{if $high_price}{$high_price}{/if}" class="small-text"  /></td>
							</tr>
							<tr>
								<td colspan="3">
									<input type="submit" name="filter_price" value=" 搜 索 " class="button"/>
								</td>
							</tr>
						</table>
					</form>
				</div>
				
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
					{foreach from=$category_path item=cp name=catepath}
					{if $smarty.foreach.catepath.first}
					<a href="{Common_Smarty_Url_format key=channel name=$cp.slug}" title="{$cp.name}">{$cp.name}</a>
					{elseif $smarty.foreach.catepath.last}
					{$cp.name}
					{else}
					<a href="{Common_Smarty_Url_format key=category_list id=$cp.id}" title="{$cp.name}">{$cp.name}</a>
					{/if}
					{if !$smarty.foreach.catepath.last}
					<span> » </span>
					{/if}
					{/foreach}
					{if $query}
					搜索词:{$query}
					{/if}
					（共{$records}件）
				</div>
				<div class="clear"></div>
				
				<div class="filter-option">
					<label for="showay" class="showay">显示方式：</label>
					<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=0 orderby=$orderby low_price=$low_price 
					high_price=$high_price country=$country grape_breed=$grape_breed query=$query}" class="way gird">格子</a>
					<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=1 orderby=$orderby low_price=$low_price
					 high_price=$high_price country=$country grape_breed=$grape_breed query=$query}" class="way list">列表</a>
					
					
					<label for="order" class="orderby">排序方式:  
						<select name="orderby" id="filter_orderby">
							<option value="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=$low_price
							 high_price=$high_price country=$country grape_breed=$grape_breed query=$query}" {if $orderby eq 1}selected="selected"{/if}>按上架时间</option>
							<option value="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=2 low_price=$low_price
							high_price=$high_price   country=$country grape_breed=$grape_breed query=$query}" {if $orderby eq 2}selected="selected"{/if}>按价格排序</option>
							<option value="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=3 low_price=$low_price
							high_price=$high_price country=$country grape_breed=$grape_breed query=$query}" {if $orderby eq 3}selected="selected"{/if}>按查看次数</option>
						</select>
					</label>
					
					<label for="page" class="tabpage">
						<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=$orderby low_price=$low_price
						 high_price=$high_price  country=$country grape_breed=$grape_breed query=$query}" class="firstpage">第一页</a>
						<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=$prev_page style=$style orderby=$orderby low_price=$low_price
						 high_price=$high_price  country=$country grape_breed=$grape_breed query=$query}" class="prevpage">前一页</a>
						<span>{$page}/{$total}</span>
						<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=$next_page style=$style orderby=$orderby low_price=$low_price
						 high_price=$high_price  country=$country grape_breed=$grape_breed query=$query}" class="nextpage">后一页</a>
						<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=$total style=$style orderby=$orderby low_price=$low_price 
						high_price=$high_price  country=$country grape_breed=$grape_breed query=$query}" class="lastpage">末 页</a>
					</label>
					
					<div class="clear"></div>
				</div>
				
				<div class="box featurecate">
					
					{if $product_list}
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
					{else}
					<p style="text-align:center;"><span class="red">很抱歉</span>，没有找到符合您要求的"<span class="red">{$query}</span>"商品，</p>
					<p style="text-align:center;">您可以<span class="red">改变搜索关键词</span>或<span class="red">减少分类条件的限制</span>试试。</p>
					{/if}
					
					<div class="clear"></div>
				</div>
				
				<div class="filter-option">
					
					<label for="page" class="tabpage">
						<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=$orderby low_price=$low_price
						 high_price=$high_price  country=$country  grape_breed=$grape_breed query=$query}" class="firstpage">第一页</a>
						<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=$prev_page style=$style orderby=$orderby low_price=$low_price
						 high_price=$high_price  country=$country grape_breed=$grape_breed query=$query}" class="prevpage">前一页</a>
						<span>{$page}/{$total}</span>
						<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=$next_page style=$style orderby=$orderby
						 low_price=$low_price high_price=$high_price  grape_breed=$grape_breed country=$country  query=$query}" class="nextpage">后一页</a>
						<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=$total style=$style orderby=$orderby 
						low_price=$low_price high_price=$high_price   grape_breed=$grape_breed country=$country query=$query}" class="lastpage">末 页</a>
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