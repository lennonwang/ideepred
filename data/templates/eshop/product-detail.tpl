<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>{$product.title}--{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="lennon">
	{smarty_include eshop.common.header_compart}
	{smarty_include eshop.js-common}
	{smarty_include eshop.js-form}  
	{if $product.summary} 
			<meta name="description" content="{$product.summary|stripslashes} ">				  
	{/if}
	{if $product.tags} 
	<meta name="keywords" content="{$product.tags}">
	{/if} 
	<script type="text/javascript" src="/js/e/product.js"></script>
	 
</head>

<body>
 
	
	{smarty_include eshop.common.header}
	
		
	<!-- S crumbs -->
		<div class="crumbs">
			<div class="c0">
		  		<a href="{Common_Smarty_Url_format key=domain}" class="home">首页</a> > 
				{foreach from=$product.categories item=bcate name=bcate}
				{if $smarty.foreach.bcate.first}<a href="{Common_Smarty_Url_format key=channel slug=$bcate.slug}" title="{$bcate.name}">
				{$bcate.name}</a>{else}<a href="{Common_Smarty_Url_format key=category_list catcode=$bcate.code}" title="{$bcate.name}">{$bcate.name}</a>{/if}
				{if !$smarty.foreach.bcate.last}<em> > </em>{/if}
				{/foreach} > 
				<a href="{Common_Smarty_Url_format key=product id=$product.id}">{$product.title}</a> 
		  </div>
		</div>
	<!-- E crumbs -->
	
	
	
<!-- S bdy -->
<div class="bdy">
	<div class="c0 M-A">


<!-- S main -->
		<div class="MAIN">
			<div class="c">
				 
				<!-- S topProName -->
				<div class="ap topProName">
					<!---<a href="" class="img"><img src="i/demo5.jpg" /></a>-->
					 <span class="nm">{$product.title}</span>
				</div>
				<!-- E topProName -->

				<!-- S imgView -->
				<div class="ap imgView">
					<div class="bigImg">
					{Common_Smarty_Asset_Thumb path_id=$product.asset_list[0].path domain=$product.asset_list[0].domain
					 w=535 h=535 var=first_image is_result_mode=ary}
					{Common_Smarty_Asset_Thumb path_id=$product.asset_list[0].path domain=$product.asset_list[0].domain
					 w=1000 h=1000 var=first_orign_image is_result_mode=ary} 
						<i class="img"><img src="{$first_image.url}"  id="imgM" data-imgB-url="{$first_orign_image.url}"/></i>
						<a class="zoom" ><b>zoom</b></a>
					</div>
					 

					<div class="proList proList3" id="imgS">
						{foreach from=$product.asset_list item=asset name=asset key=myId}
						<div class="pro">
							<i class="img"><a href="javascript:" class="imgSmall"
							 data-imgM-url="{Common_Smarty_Asset_Thumb path_id=$asset.path domain=$asset.domain w=535 h=535}"
							 data-imgB-url="{Common_Smarty_Asset_Thumb path_id=$asset.path domain=$asset.domain w=1000 h=1000}">
							<img src="{Common_Smarty_Asset_Thumb path_id=$asset.path domain=$asset.domain w=120 h=120}"   /></a></i>
						</div>
						{/foreach}
						
						 	
						<!-- <div class="prev"><a href=""></a></div>
						<div class="next"><a href=""></a></div> -->
					</div>
				</div>
				<!-- E imgView -->


				<!-- S proContent -->
				<div class="ap proContent">
						{if $store_brand.content}
							 	{$store_brand.content|stripslashes}
							 
						{/if}
					{* {if $product.summary} 
							 {$product.summary|stripslashes}  
					{/if}*} 
							 {$product.content|stripslashes}
					
				</div>
				<!-- E proContent -->

			</div>
		</div>
<!-- E main -->

<!-- S aside -->
		<div class="ASIDE">
			<div class="c">

<!-- S cartSeciont -->
	 <form action="{Common_Smarty_Url_format key='add_cart' id=$product.id}" method="post">
				<div class="ap cartSection">
					<span class="price">{$product.sale_price}元</span>
					<div class="buyNumber">
					 {if $product.stock &&  $product.stock > 0}
					 	数量<a class="minus" href="">-</a>
					 	<i class="txt"><input  class="num" name="quantity" type="text" value="1" /></i>
					 	<a class="add" href="">+</a>
		          	 {* <span class="buyNumber" id="buyNumber"><span class="numberOpt numUp"><a href="javascript:void(0)"></a></span>
             			 <span class="numberOpt numDown"><a href="javascript:void(0)"></a></span>
            			  <input class="num" name="quantity" type="text" value="1" />{$product.unit}</span>（库存{$product.stock}件)</dd>
           			*} 
           			{else}该商品已售罄。{/if} 
					
					</div>
				</div>
<!-- E cartSeciont -->

<!-- S addToCart --> 
					<input type="hidden" name="id" value="{$product.id}" id="com_sku" />
					<input type="hidden" name="size" value="F" id="com_size" />
				<div class="ap addToCart">
					  {if $product.stock &&  $product.stock > 0}
					  <div class="add"><button type="submit" class="submit"><b>加入购物车</b></button></div>
					   {/if} 
					<div class="share">
					<!-- JiaThis Button BEGIN -->
					<div class="jiathis_style">
						<span class="jiathis_txt">分享</span>
						<a class="jiathis_button_icons_1"></a>
						<a class="jiathis_button_icons_2"></a>
						<a class="jiathis_button_icons_3"></a>
					</div>
					
					<!-- JiaThis Button END -->
					
					</div> 
					<div class="store">  
					  <a href="{Common_Smarty_Url_format key='favorite' id=$product.id}{if !$user_auth_name}#noAuthLogin{/if}"
           	  id="favorite_link" class="jq_a_ajax collect">收藏</a> </div> 
           	  
				</div>
		</form>
<!-- E addToCart -->


<!-- S proDesc -->
				<div class="ap proDesc">
					<dl>
						<dt>身份牌 <span class="s">{$product.wine_code} </span></dd>
						<dd><b>类　　型：</b>{$wine_category.name|default:'无'}</dd>
						{if $store_brand.title}
							<dd><b>品　　牌：</b>{$store_brand.title}</dd>
						{/if}
						{if $product_info->wine_country_name}
						<dd><b>原产国家：</b>{$product_info->wine_country_name}</dd>
						{/if}
						{if $product_info->wine_area_name}
						<dd><b>酒庄产区：</b>{$product_info->wine_area_name} </dd>
						{/if}
						{if $product_info->wine_level_name}
						<dd><b>红酒等级：</b>{$product_info->wine_level_name} </dd>
						{/if}
						{if $product.wine_degree}
							<dd><b>酒精度数：</b>{$product.wine_degree}%</dd></dd>  
						{/if}
           				{if $product.wine_ml}
           					<dd><b>容　　量：</b>{$product.wine_ml} 毫升</dd>  
           				{/if} 
           				{if $product_info->wine_year_name}
						<dd><b>年　　份：</b>{$product_info->wine_year_name}年</dd>
						{/if} 
						{if $product.wine_grape_desc}
						<dd><b>葡　　萄：</b>{$product.wine_grape_desc}</dd>
						{/if} 
						{if $product.wine_shelf_life}
						<dd><b>保 质 期：</b>{$product.wine_shelf_life} 年</dd>
						{/if}
						{if $product.wine_temp}
						<dd><b>饮用温度：</b>{$product.wine_temp} </dd>
						{/if}
						{if $product.wine_decant}
						<dd><b>醒酒时间：</b>{$product.wine_decant} </dd>  
						{/if}
						{if $product_info->wine_taste_name}
						<dd><b>初尝口味：</b>{$product_info->wine_taste_name} </dd> 
						{/if} 
						{if $product.wine_taste}
						<dd><b>味　　道：</b>{$product.wine_taste} </dd> 
						{/if} 
						{if $product.wine_match_food}
						<dd><b>搭配菜肴：</b>{$product.wine_match_food}  </dd>
						{/if} 
						<!--<dd><b>产品编码：</b> AA202A</dd>
						 -->
						
						<dt style="margin-top:15px"><span class="s">{$wine_category.name|default:'Red wine'}</span></dt>
						<dd>
							<div class="proList proList4">
							{assign var=stick_count value=0}
							 {if $stick_cat_product_list} 
								{foreach from=$stick_cat_product_list item=stick_product name=pro}
								{if $product.id ne $stick_product.id && $stick_count<2}
								{assign var=stick_count value=$stick_count+1}
								<div class="pro">  
									<i class="img">
									<a href="{Common_Smarty_Url_format key=product id=$stick_product.id}" >
									<img src="{$stick_product.thumb}" title="{$stick_product.title}"  
									 width="180" height="180" /><i class="fave" title="{$stick_product.title}"></i>
									</a> </i> 
								</div>
								{/if}
								{/foreach}
							 {/if} 
								<div class="pro pro1">
								<a href="{Common_Smarty_Url_format key=category_list catcode=$bcate.code}" title="{$bcate.name}">
									<span class="num"><span class="s">{$cat_count}</span>款</span></a> 
								</div>
							</div>
						</dd>
						 <!-- -->
						 <br />
					</dl>
					<!-- 
					<div class="proRelate">
						<p class="p"><i class="ii"></i>在资料库中查找相关“<span class="s">红葡萄酒</span>”的信息</p>
						<p class="p"><i class="ii"></i>在资料库中查找相关“<span class="s">红葡萄酒</span>”的信息</p>
					</div>
					 -->
				</div>
<!-- E proDesc -->
				
<!-- S 热门直通车  -->
			<div class="ap hotReco">
				<div class="apT">热门直通车</div>
				 
				<div class="apB proList proList2 proList2a">
					{Common_Smarty_Advertise_findAdmany type="2" size=8 item=ad}
		 
				<div class="pro">
						<i class="img"> 
							<a href="{$ad.link}#{$loop}">  
							<img  src="{Common_Smarty_Asset_Thumb path_id=$ad.asset_path domain=$ad.asset_domain  w=200 h=150}"
							 alt="{$ad.title}"  title="{$ad.title}" /></a>
							  <a href="{$ad.link}#{$loop}"> {$ad.title}</a>
						</i>
					</div> 
				{/Common_Smarty_Advertise_findAdmany}

				</div>  
			</div>
<!-- E 热门直通车 -->

	
<!-- S cartSeciont -->
	 <form action="{Common_Smarty_Url_format key='add_cart' id=$product.id}" method="post">
				<div class="ap cartSection">
					<span class="price">{$product.sale_price}元</span>
					<div class="buyNumber">
					 {if $product.stock &&  $product.stock > 0}
					 	数量<a class="minus" href="">-</a>
					 	<i class="txt"><input  class="num" name="quantity" type="text" value="1" /></i>
					 	<a class="add" href="">+</a>
		          	 {* <span class="buyNumber" id="buyNumber"><span class="numberOpt numUp"><a href="javascript:void(0)"></a></span>
             			 <span class="numberOpt numDown"><a href="javascript:void(0)"></a></span>
            			  <input class="num" name="quantity" type="text" value="1" />{$product.unit}</span>（库存{$product.stock}件)</dd>
           			*} 
           			{else}该商品已售罄。{/if} 
					
					</div>
				</div>
<!-- E cartSeciont -->

<!-- S addToCart --> 
					<input type="hidden" name="id" value="{$product.id}" id="com_sku" />
					<input type="hidden" name="size" value="F" id="com_size" />
				<div class="ap addToCart">
					  {if $product.stock &&  $product.stock > 0}
					  <div class="add"><button type="submit" class="submit"><b>加入购物车</b></button></div>
					   {/if} 
					<div class="share">
					<!-- JiaThis Button BEGIN -->
					<div class="jiathis_style">
						<span class="jiathis_txt">分享</span>
						<a class="jiathis_button_icons_1"></a>
						<a class="jiathis_button_icons_2"></a>
						<a class="jiathis_button_icons_3"></a>
					</div>
					
					<!-- JiaThis Button END -->
					
					</div> 
					<div class="store">  
					  <a href="{Common_Smarty_Url_format key='favorite' id=$product.id}{if !$user_auth_name}#noAuthLogin{/if}"
           	  id="favorite_link" class="jq_a_ajax collect">收藏</a> </div> 
           	  
				</div>
		</form>
<!-- E addToCart -->
	
	

			</div>
		</div>
<!-- E aside -->


	</div>
</div>
<!-- E bdy -->
	

<!-- S footer --> 
  		{smarty_include eshop.common.footer}
<!-- E footer -->

 
 <!-- S 大图弹窗 -->
<div id="mwMask" class="mwMask" style="display:none"></div>
<div class="mw" id="mwPopUp" style="display:none">
	<div class="mwCt">
		<a href="javascript:" class="close"></a>
		<div class="mwHd">
			<img id="imgB" src="" />
		</div>
	</div>
</div>
<!-- E 大图弹窗 -->

<div class="bubbleBox bubbleBox1" id="bubbleBox" style="display:none">
	<div class="c">
    <i class="ii i03"></i>
    <p class="info" id="favorite_msg">收藏成功！</p>
  </div>
</div>
	
	
	<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1342777298822786" charset="utf-8"></script>
 
</body> 
</html>