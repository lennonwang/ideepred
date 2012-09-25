<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>搜索结果-{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi">
	{smarty_include eshop.common.header_compart}
	  <!-- <link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" /> -->  
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
				{foreach from=$category_path item=cp name=catepath} 
						{if $smarty.foreach.catepath.first}
						>   <a href="{Common_Smarty_Url_format key=channel name=$cp.slug}" title="{$cp.name}">{$cp.name}</a>
						{elseif $smarty.foreach.catepath.last}
						>  {$cp.name}
						{else}
						>  <a href="{Common_Smarty_Url_format key=category_list id=$cp.id}" title="{$cp.name}">{$cp.name}</a>
						{/if}
					 	{if !$smarty.foreach.catepath.last}
						 
						{/if} 
					{/foreach}
					   
					{if $wine_mode}
						{foreach from=$wine_mode_array item=cur_item } 
								{if $cur_item.id eq $wine_mode} > {$cur_item.name}  {/if} 
						{/foreach}
					{/if}
					
					{if $country}
						{foreach from=$wine_country_array item=cur_item } 
								{if $cur_item.id eq $country} > {$cur_item.name}  {/if} 
						{/foreach}
					{/if}
					
					{if $grape_breed}
						{foreach from=$grape_breed_array item=cur_item } 
								{if $cur_item.id eq $grape_breed} > {$cur_item.name}  {/if} 
						{/foreach}
					{/if}
					
					{if $high_price &&  $high_price>0}
						{if ($high_price <= 100) && ($high_price gt 0)} > 0元-100元 {/if}
						{if ($high_price <= 200) && ($high_price gt 101)} > 101元-200元 {/if}
						{if ($high_price <= 300) && ($high_price gt 201)} > 201元-300元 {/if}
						{if ($high_price <= 500) && ($high_price gt 301)} > 301元-500元 {/if}
						{if ($high_price gt 500)} > 500元以上 {/if}
					{/if}

					
					{if $query}> 搜索词:{$query} {/if}
					（共{$records}件）
  </div>
</div>
<!-- E crumbs -->




  
<!-- S bdy -->
<div class="bdy">
	<div class="c0 A-M">

<!-- S aside -->
		<div class="ASIDE">
			<div class="c"> 
			 {smarty_include eshop.common.left_condition_list} 
			</div>
		</div>
<!-- E aside -->

<!-- S main -->
		<div class="MAIN">
			<div class="c">
			
	 
			<div class="ap schRes">
				<p class="opt"><a href=""><i class="ii"></i></a></p> 
				<p class="res">您搜索的 <span class="s">
				{foreach from=$category_path item=cp name=catepath} 
						{if $smarty.foreach.catepath.first}
					   	 <a href="{Common_Smarty_Url_format key=channel name=$cp.slug}" title="{$cp.name}">{$cp.name}</a>
						{elseif $smarty.foreach.catepath.last}
						   {$cp.name}
						{else}
						   <a href="{Common_Smarty_Url_format key=category_list id=$cp.id}" title="{$cp.name}">{$cp.name}</a>
						{/if} 
					{/foreach}
					   
					{if $wine_mode}
						{foreach from=$wine_mode_array item=cur_item } 
								{if $cur_item.id eq $wine_mode}   {$cur_item.name}  {/if} 
						{/foreach}
					{/if}
					
					{if $country}
						{foreach from=$wine_country_array item=cur_item } 
								{if $cur_item.id eq $country}   {$cur_item.name}  {/if} 
						{/foreach}
					{/if}
					
					{if $grape_breed}
						{foreach from=$grape_breed_array item=cur_item } 
								{if $cur_item.id eq $grape_breed}  {$cur_item.name}  {/if} 
						{/foreach}
					{/if}
					
					{if $high_price &&  $high_price>0}
						{if ($high_price <= 100) && ($high_price gt 0)}  0元-100元 {/if}
						{if ($high_price <= 200) && ($high_price gt 101)}   101元-200元 {/if}
						{if ($high_price <= 300) && ($high_price gt 201)}   201元-300元 {/if}
						{if ($high_price <= 500) && ($high_price gt 301)}  301元-500元 {/if}
						{if ($high_price gt 500)}   500元以上 {/if}
					{/if}

					
					{if $query}  {$query} {/if}
			
			   </span> 
				 共查到<span class="s">{$records}</span>款</p>
				{if $product_list} 
					<p class="tip">您还可以尝试搜索酒精度数、年份、产区、口感，香味或者直接搜索英文名称等等</p>
				{else}
					<p style="text-align:center;"><span class="red">很抱歉</span>，没有找到符合您要求的"<span class="red">{$query}</span>"商品，</p>
					<p style="text-align:center;">您可以<span class="red">改变搜索关键词</span>或<span class="red">减少分类条件的限制</span>试试。</p>
				{/if}
					
				
			</div>
		  
			 
			<!-- S list1-->
			<div class="ap">
				<div class="apB proList proList1">
				  
					 
     			 {if $product_list} 
					{foreach from=$product_list item=product name=pro}
						
					 	<div class="pro">
						<i class="img">
						<a href="{Common_Smarty_Url_format key=product id=$product.id}" >
						<img src="{Common_Smarty_Product_photoThumb thumb_path=$product.thumb}"  width="230" height="230" /><i class="fave"></i>
						</a> </i>
						<p class="info"><i class="price">{$product.sale_price}元</i>
						<b class="nm"><a href="{Common_Smarty_Url_format key=product id=$product.id}">{$product.title}</a></b></p>
					</div>  
					 {/foreach} 
					{/if}
					
				</div>
				  
				  
				   {if $product_list} 
				<div class="pg">
				
					<a  href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=$prev_page style=$style orderby=$orderby low_price=$low_price
						 high_price=$high_price  country=$country grape_breed=$grape_breed query=$query  orderSeq=$orderSeq }" class="prev"></a> 
			  
				 
				{section name=one loop=$total start=0 step=1}  
				 	<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=$smarty.section.one.index_next style=$style orderby=$orderby low_price=$low_price
										 high_price=$high_price  country=$country grape_breed=$grape_breed query=$query  orderSeq=$orderSeq }"
							{if $smarty.section.one.index_next eq $page}	 class="on" {/if} 	  >
							{$smarty.section.one.index_next}</a> 
				{/section}  
			
						<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=$next_page style=$style orderby=$orderby low_price=$low_price
						high_price=$high_price  country=$country grape_breed=$grape_breed query=$query  orderSeq=$orderSeq }"  class="next"></a>	
						
						
			 
				</div>
				 {/if}
			</div>
			<!-- E list1-->
  
			</div>
		</div>
<!-- E main -->

	</div>
</div>
<!-- E bdy -->

 
	
	{smarty_include eshop.common.footer}
 
</body>
</html>