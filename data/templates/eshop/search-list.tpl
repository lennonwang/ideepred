<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>搜索结果-{smarty_include eshop.common.xtitle}</title>
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
  	<a href="{Common_Smarty_Url_format key=domain}" class="home">首页</a>
					>  
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
					{if $query}> 搜索词:{$query} {/if}
					（共{$records}件）
  </div>
</div>
<!-- E crumbs -->



<!-- S body -->
<div class="bdy">
	<div class="c0">
  	 
    {smarty_include eshop.common.condition_list}
    
    
    
    <!-- S ArrayList --> 
     <div class="pg">
    	<!-- <a href="#" class="on">上一页</a> <a href="#" class="on">1</a><a href="#">2</a><a href="#">3</a>
    	<a href="#">4</a><a href="#">5</a>…<a href="#">9</a><a href="#">5</a> <a href="#" class="on">下一页</a>
    	-->
    		<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=$orderby low_price=$low_price
				high_price=$high_price  country=$country grape_breed=$grape_breed query=$query orderSeq=$orderSeq }" class="firstpage">第一页</a>
				{if $page gt 1}
			<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=$prev_page style=$style orderby=$orderby low_price=$low_price
						 high_price=$high_price  country=$country grape_breed=$grape_breed query=$query  orderSeq=$orderSeq }" class="prevpage">前一页</a>
				{/if}
				<span>{$page}/{$total}</span>
					{if $page lt $total}
					<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=$next_page style=$style orderby=$orderby low_price=$low_price
						high_price=$high_price  country=$country grape_breed=$grape_breed query=$query  orderSeq=$orderSeq }" class="nextpage">后一页</a>
				    {/if}
			<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=$total style=$style orderby=$orderby low_price=$low_price 
						high_price=$high_price  country=$country grape_breed=$grape_breed query=$query  orderSeq=$orderSeq }" class="lastpage">末 页</a> 
					 
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
					<p style="text-align:center;"><span class="red">很抱歉</span>，没有找到符合您要求的"<span class="red">{$query}</span>"商品，</p>
					<p style="text-align:center;">您可以<span class="red">改变搜索关键词</span>或<span class="red">减少分类条件的限制</span>试试。</p>
					{/if}
				 
      </div>
		</div>
    <!-- E ArrayList -->
    
    <div class="pg">
    	<!-- <a href="#" class="on">上一页</a> <a href="#" class="on">1</a><a href="#">2</a><a href="#">3</a>
    	<a href="#">4</a><a href="#">5</a>…<a href="#">9</a><a href="#">5</a> <a href="#" class="on">下一页</a>
    	-->
    		<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=$orderby low_price=$low_price
				high_price=$high_price  country=$country grape_breed=$grape_breed query=$query orderSeq=$orderSeq }" class="firstpage">第一页</a>
				{if $page gt 1}
			<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=$prev_page style=$style orderby=$orderby low_price=$low_price
						 high_price=$high_price  country=$country grape_breed=$grape_breed query=$query  orderSeq=$orderSeq }" class="prevpage">前一页</a>
				{/if}
				<span>{$page}/{$total}</span>
					{if $page lt $total}
					<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=$next_page style=$style orderby=$orderby low_price=$low_price
						high_price=$high_price  country=$country grape_breed=$grape_breed query=$query  orderSeq=$orderSeq }" class="nextpage">后一页</a>
				    {/if}
			<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=$total style=$style orderby=$orderby low_price=$low_price 
						high_price=$high_price  country=$country grape_breed=$grape_breed query=$query  orderSeq=$orderSeq }" class="lastpage">末 页</a> 
					 
	 	</div>	
	 	
  </div>
</div> 

	{smarty_include eshop.common.site-help}
	
	{smarty_include eshop.common.footer}
 
</body>
</html>