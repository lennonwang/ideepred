<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>{$current_category.name}-{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi">
	{smarty_include eshop.common.header_compart}
	  <!-- <link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" /> --> 
	<link rel="stylesheet" href="http://221.179.173.197/d/c/g.css" type="text/css" /> 
	{smarty_include eshop.js-common}
	<script type="text/javascript" src="/js/e/jquery.iFadeSlide-core.js"></script>
	<script type="text/javascript" src="/js/e/category-list.js"></script>

</head>

<body>
 
	{smarty_include eshop.common.header}
	
	
	<!-- S crumbs -->
<div class="crumbs">
	<div class="c0">
  	<a href="{Common_Smarty_Url_format key=domain}" class="home">首页</a> > 
			{foreach from=$category_path item=cp name=catepath}
				{if $smarty.foreach.catepath.first}
				<a href="{Common_Smarty_Url_format key=channel name=$cp.slug}" title="{$cp.name}">{$cp.name}</a>
				{elseif $smarty.foreach.catepath.last}
					{$cp.name}
				{else}
					<a href="{Common_Smarty_Url_format key=category_list id=$cp.id}" title="{$cp.name}">{$cp.name}</a>
				{/if}
				{if !$smarty.foreach.catepath.last}
				>
				{/if}
			{/foreach}
			（共{$records}件）
  </div>
</div>
<!-- E crumbs -->


<!-- S body -->
<div class="bdy">
	<div class="c0">
  	 
    {smarty_include eshop.common.condition_list}
    
    <div class="sortList" id="sortList">
    	<ul>
      	<li><a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=0 high_price=0 country=$country}" data="price"><i class="ii"></i>价格</a></li>
        <li><a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=2 low_price=0 high_price=0 country=$country}" data="sell"><i class="ii"></i>上架</a></li>
        <li><a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=3 low_price=0 high_price=0 country=$country}" data="discount"><i class="ii"></i>折扣</a></li>
        <li><a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=4 low_price=0 high_price=0 country=$country}" data="hot"><i class="ii"></i>人气</a></li>
      </ul>
    </div>
    
    <!-- S ArrayList --> 
     <div class="pg">
    	<!-- <a href="#" class="on">上一页</a> <a href="#" class="on">1</a><a href="#">2</a><a href="#">3</a>
    	<a href="#">4</a><a href="#">5</a>…<a href="#">9</a><a href="#">5</a> <a href="#" class="on">下一页</a>
    	-->
     	 <a href="{Common_Smarty_Url_format key=category_list code=$catcode page=1 style=$style}" class="firstpage">第一页</a>
		 <a href="{Common_Smarty_Url_format key=category_list code=$catcode page=$prev_page style=$style}" class="prevpage">前一页</a>
		 <span>{$page}/{$total}</span>
		 <a href="{Common_Smarty_Url_format key=category_list code=$catcode page=$next_page style=$style}" class="nextpage">后一页</a>
		 <a href="{Common_Smarty_Url_format key=category_list code=$catcode page=$total style=$style}" class="lastpage">末 页</a>
	 </div>	
	 	
    <div class="CategoryResult">
      <div class="proSection proSection2">
      
      
     		 {if $product_list}
				 
					{foreach from=$product_list item=product name=pro}
						
					  <div class="proList">  
						<p class="img"> <a href="{Common_Smarty_Url_format key=product id=$product.id}" title="{$product.title}"  >
							<img src="{Common_Smarty_Product_photoThumb thumb_path=$product.thumb}" class="bordor" width="230" height="230" />
						</a></p>
						 <span class="priceB">￥<span class="B">{$product.sale_price}</span> </span> 
						 <p class="nm"><a href="{Common_Smarty_Url_format key=product id=$product.id}">{$product.title}</a></p>  
					  </div> 
					 {/foreach}
					 
					{else}
					<p class="ft14 mt-20 mb-20 c6">此分类还没有匹配的产品！</p>
					{/if}
				 
      </div>
		</div>
    <!-- E ArrayList -->
    
    <div class="pg">
    	<!-- <a href="#" class="on">上一页</a> <a href="#" class="on">1</a><a href="#">2</a><a href="#">3</a>
    	<a href="#">4</a><a href="#">5</a>…<a href="#">9</a><a href="#">5</a> <a href="#" class="on">下一页</a>
    	-->
     	 <a href="{Common_Smarty_Url_format key=category_list code=$catcode page=1 style=$style}" class="firstpage">第一页</a>
		 <a href="{Common_Smarty_Url_format key=category_list code=$catcode page=$prev_page style=$style}" class="prevpage">前一页</a>
		 <span>{$page}/{$total}</span>
		 <a href="{Common_Smarty_Url_format key=category_list code=$catcode page=$next_page style=$style}" class="nextpage">后一页</a>
		 <a href="{Common_Smarty_Url_format key=category_list code=$catcode page=$total style=$style}" class="lastpage">末 页</a>
					 
	 	</div>		
  </div>
</div>
<!-- E body -->

	<div id="container">
		<div class="box paths a999">
			<a href="{Common_Smarty_Url_format key=domain}" class="home">首页</a> > 
			{foreach from=$category_path item=cp name=catepath}
				{if $smarty.foreach.catepath.first}
				<a href="{Common_Smarty_Url_format key=channel name=$cp.slug}" title="{$cp.name}">{$cp.name}</a>
				{elseif $smarty.foreach.catepath.last}
					{$cp.name}
				{else}
					<a href="{Common_Smarty_Url_format key=category_list id=$cp.id}" title="{$cp.name}">{$cp.name}</a>
				{/if}
				{if !$smarty.foreach.catepath.last}
				>
				{/if}
			{/foreach}
			（共{$records}件）
		</div>
		
		<div class="box clearfix">
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
					<a href="{Common_Smarty_Url_format key=category_list code=$catcode page=$page style=0}" class="way gird">格子</a>
					<a href="{Common_Smarty_Url_format key=category_list code=$catcode page=$page style=1}" class="way list">列表</a>
					
					<label for="order" class="orderby">排序方式:  
						<select name="orderby" id="filter_orderby">
							<option value="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=0 high_price=0 country=$country}" {if $orderby eq 1}selected="selected"{/if}>按上架时间</option>
							<option value="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=2 low_price=0 high_price=0 country=$country}" {if $orderby eq 2}selected="selected"{/if}>按价格排序</option>
							<option value="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=3 low_price=0 high_price=0 country=$country}" {if $orderby eq 3}selected="selected"{/if}>按查看次数</option>
						</select>
					</label>
					<label for="page" class="tabpage">
						<a href="{Common_Smarty_Url_format key=category_list code=$catcode page=1 style=$style}" class="firstpage">第一页</a>
						<a href="{Common_Smarty_Url_format key=category_list code=$catcode page=$prev_page style=$style}" class="prevpage">前一页</a>
						<span>{$page}/{$total}</span>
						<a href="{Common_Smarty_Url_format key=category_list code=$catcode page=$next_page style=$style}" class="nextpage">后一页</a>
						<a href="{Common_Smarty_Url_format key=category_list code=$catcode page=$total style=$style}" class="lastpage">末 页</a>
					</label>
				</div>
				
				<div class="box featurecate">
					{if $product_list}
					<ul class="mt-20 stuff-list clearfix">
						{foreach from=$product_list item=product name=pro}
						<li class="{if $smarty.foreach.pro.iteration%3 eq 0}last{/if}">
							<a href="{Common_Smarty_Url_format key=product id=$product.id}" title="{$product.title}" class="imgborder">
								<img src="{Common_Smarty_Product_photoThumb thumb_path=$product.thumb}" class="bordor" width="220" height="210" />
							</a>
							<h3 class="a999"><a href="{Common_Smarty_Url_format key=product id=$product.id}" title="{$product.title}">{$product.title}</a></h3>
							<p>优惠价：<span class="ft14 orange">￥{$product.sale_price}</span></p>
							<a href="" class="abuy hidden"><img src="/images/eshop/icon-buy.png" /></a>
						</li>
						{/foreach}
					</ul>
					{else}
					<p class="ft14 mt-20 mb-20 c6">此分类还没有匹配的产品！</p>
					{/if}
				</div>
				
				<div class="filter-option clearfix">
					
					<label for="page" class="tabpage">
						<a href="{Common_Smarty_Url_format key=category_list code=$catcode page=1 style=$style}" class="firstpage">第一页</a>
						<a href="{Common_Smarty_Url_format key=category_list code=$catcode page=$prev_page style=$style}" class="prevpage">前一页</a>
						<span>{$page}/{$total}</span>
						<a href="{Common_Smarty_Url_format key=category_list code=$catcode page=$next_page style=$style}" class="nextpage">后一页</a>
						<a href="{Common_Smarty_Url_format key=category_list code=$catcode page=$total style=$style}" class="lastpage">末 页</a>
					</label>
				</div>
				
			</div>
			
		</div>
	</div>

	{smarty_include eshop.common.site-help}
	
	{smarty_include eshop.common.footer}
</div>
</body>
</html>