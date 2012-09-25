<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>{$product.title}--{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="lennon">
	{smarty_include eshop.common.header_compart}
	{smarty_include eshop.js-common}
	{smarty_include eshop.js-form} 
	<script type="text/javascript" src="/js/e/jquery.jqzoom-core.js"></script>

	<link rel="stylesheet" href="/csstyle/jquery.jqzoom.css" type="text/css" />
	<!-- <link rel="stylesheet" href="/css/g.css" type="text/css" />  -->
  <!-- <link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" /> -->  
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
				
				<!-- S notice <img src="i/demo5.jpg" />-->
				
				<div class="ap notice">
					<h4> {$product.title} </h4>
				</div>
				<!-- E notice -->

				<!-- S imgView -->
				<div class="ap imgView">
					<div class="bigImg">
					{Common_Smarty_Asset_Thumb path_id=$product.asset_list[0].path domain=$product.asset_list[0].domain w=535 h=535 var=first_image is_result_mode=ary}
					{Common_Smarty_Asset_Thumb path_id=$product.asset_list[0].path domain=$product.asset_list[0].domain w=1000 h=1000 var=first_orign_image is_result_mode=ary}
			
						<i class="img"><img src="{$first_image.url}" /></i>
						<a class="zoom" href=""><b>zoom</b></a>
					</div>

					<div class="proList proList3">
						{foreach from=$product.asset_list item=asset name=asset key=myId}
						<div class="pro">
							<i class="img"><a href=""><img src="{Common_Smarty_Asset_Thumb path_id=$asset.path domain=$asset.domain w=120 h=120}"   /></a></i>
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
					{if $product.summary} 
							 {$product.summary|stripslashes}  
					{/if} 
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
					<div class="share">分享<a href=""><i class="ii"></i><i class="ii"></i></a></div>
					<div class="store"><a href="">收藏</a></div>
				</div>
		</form>
<!-- E addToCart -->


<!-- S proDesc -->
				<div class="ap proDesc">
					<dl>
						<dt>身份牌 <span class="s">{$product.wine_code} </span></dd>
						<dd><b>类　　型：</b>{$wine_category.name|default:'无'}</dd>
						<dd><b>品　　牌：</b>{$store_brand.title}</dd>
						<dd><b>原产国家：</b>{$product_info->wine_country_name}</dd>
						<dd><b>酒庄产区：</b>{$product_info->wine_area_name} </dd>
						<dd><b>酒精度数：</b>13. 5%</dd></dd>  
           				<dd><b>容　　量：</b>{$product.wine_ml} 毫升</dd>   
						<dd><b>年　　份：</b>{$product_info->wine_year_name}年</dd>
						<!--
						<dd><b>葡萄构成：</b>100%赤霞珠</dd>
						<dd><b>味　　道：</b>烟草，巧克力，辣椒，黑醋栗</dd> 
						<dd><b>保 质 期：</b> 10年</dd>
						<dd><b>饮用温度：</b> 14-16度</dd>
						<dd><b>醒酒时间：</b> 45分钟</dd>
						<dd><b>产品编码：</b> AA202A</dd>
						 -->
						
						<dt style="margin-top:15px"><span class="s">{$wine_category.name|default:'Red wine'}</span></dt>
						<dd>
							<div class="proList proList4">
								<div class="pro">
									<i class="img"><a href=""><img src="i/demo6_1.jpg" /></a></i>
								</div>
								<div class="pro">
									<i class="img"><a href=""><img src="i/demo6_2.jpg" /></a></i>
								</div>
								<div class="pro pro1">
									<a href=""><span class="num"><span class="s">49</span>款</span></a>
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
				
<!-- S 热门直通车 -->
			<div class="ap hotReco">
				<div class="apT">热门直通车</div>
				<!-- S list2 -->
				<div class="apB proList proList2 proList2a">

					<div class="pro">
						<i class="img"><a href=""><img src="i/demo2.jpg" /></a></i>
					</div> 

				</div>
				<!-- E list2 -->
			</div>
<!-- E 热门直通车 -->

<!-- S addToCart -->
				<div class="ap addToCart">
					<div class="add"><a href="">加入购物车</a></div>
					<div class="share">分享<a href=""><i class="ii"></i><i class="ii"></i></a></div>
					<div class="store"><a href="">收藏</a></div>
				</div>
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

 
<div class="bubbleBox bubbleBox1" id="bubbleBox" style="display:none">
	<div class="c">
    <i class="ii i03"></i>
    <p class="info" id="favorite_msg">收藏成功！</p>
  </div>
</div>
	
	
	
 
</body> 
</html>