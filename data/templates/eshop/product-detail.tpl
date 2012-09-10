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
	<link rel="stylesheet" href="http://221.179.173.197/d/c/g.css" type="text/css" /> 
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
				{/foreach} > {$product.title}
		  </div>
		</div>
	<!-- E crumbs -->

<!-- S body -->
<div class="bdy">
	<div class="c0">
	<!-- S Left -->
	<div class="aside">
		<!-- S 分类 -->
        {smarty_include eshop.category}
        <!-- E 分类 -->
        
        <!-- 喜欢--> 
        {if $like_products}
	        <div class="ap">
	      	 <div class="apT" style="font-size:12px;">购买此商品的用户还喜欢...</div>
	       	  <div class="apB"> 
	        		<div class="proSection proSection3">
	        	{foreach from=$like_products item=likepro}
		          	<div class="proList">
		              <p class="img"><a href="{Common_Smarty_Url_format key=product id=$likepro.id}">
											<img src="{Common_Smarty_Asset_Thumb path_id=$likepro.thumb w=90 h=90}" class="bordor" width="90px" height="90px" />
										</a></p>
		              <p class="nm"><a href="{Common_Smarty_Url_format key=product id=$likepro.id}">{$likepro.title}</a></p>
		              <p class="price">优惠价：￥{$likepro.sale_price}</p>
		            </div> 
		           	{/foreach}
		        </div>
	           </div> 
	     	</div> 
		{/if} 
		<!--s 浏览--> 
		  <div class="ap">
      			<div class="apT" style="font-size:12px;">最近浏览过的商品...</div>
       			<div class="apB"> 
	        	 <div class="proSection proSection3">
		        	{foreach from=$visited_products item=viewpro}
		          	<div class="proList">
		              <p class="img"><a href="{Common_Smarty_Url_format key=product id=$viewpro.id}">
										<img src="{Common_Smarty_Asset_Thumb path_id=$viewpro.thumb w=90 h=90}" class="bordor" width="90px" height="90px" />
									</a></p>
		              <p class="nm"><a href="{Common_Smarty_Url_format key=product id=$viewpro.id}">{$viewpro.title}</a></p>
		              <p class="price">优惠价：￥{$viewpro.sale_price}</p>
		            </div> 
		           	{/foreach}
	        	</div> 
        	</div> 
    	  </div>  
		 <!--e 浏览--> 	 
    	</div>  
		<!-- E Left -->
		
		<!-- S Right -->
	    <div class="main">
    		
    		
<!-- S proMain--->
    <div class="proMain">
    	
      
      <div class="imgSection">
        <div class="imgPreview">
          <div class="imgMain">
         	{Common_Smarty_Asset_Thumb path_id=$product.asset_list[0].path domain=$product.asset_list[0].domain w=350 h=350 var=first_image is_result_mode=ary}
			{Common_Smarty_Asset_Thumb path_id=$product.asset_list[0].path domain=$product.asset_list[0].domain w=1000 h=1000 var=first_orign_image is_result_mode=ary}
					
            <a href="{$first_orign_image.url}" class="jqzoom" rel='gal1'  title="triumph" >
            <img src="{$first_image.url}" class="imgMid" /></a>
          </div>
          
          <div class="imgSmall">
            <ul id="thumblist"> 
					{foreach from=$product.asset_list item=asset name=asset key=myId}
							<li {if $smarty.foreach.asset.last}class="lastitem"{/if}> 
								<a href='javascript:void(0);' class="zoomThumbActive" rel=""
									o_rel="gallery: 'gal1', smallimage:'{Common_Smarty_Asset_Thumb path_id=$asset.path domain=$asset.domain w=350 h=350}',largeimage:'{Common_Smarty_Asset_Thumb path_id=$asset.path domain=$asset.domain w=1000 h=1000}'" ;> 
									<img src="{Common_Smarty_Asset_Thumb path_id=$asset.path domain=$asset.domain w=75 h=75}"   />
								</a>
							</li>
					 {/foreach}
            </ul>
          </div>
        </div>
        
        <div class="imgOptions">
        	<h4>{$product.title}</h4>
          <dl>
            <dd><b>商品编号：</b>{$product.wine_code}</dd>
            <dd><span class="op">
            {if $store_brand.title}
            <a href="{Common_Smarty_Url_format key='brand_product' id=$store_brand.id}" />更多{$store_brand.title}产品 »</a>
            {/if} </span> <b>品 牌：</b>{$store_brand.title}</dd>
            <dd><span class="op">
            {if $wine_category.name} <a href="{Common_Smarty_Url_format key='category_list' id=$wine_category.code}">更多<span class="split">{$wine_category.name}</span>产品 »</a></span>{/if}
            <b>类别：</b>{$wine_category.name|default:'无'}</dd>
            <dd><b>价 格：</b><span class="priceB">￥{$product.sale_price}</span> 元</dd>
          <!--  <dd><b>市场价：</b>￥<span class="s3">586.00</span> (为您节省￥<span class="s3">428.00</span>)</dd> -->
             {if $product.wine_ml &&  $product.wine_ml > 0}
             <dd><b>净含量：</b> {$product.wine_ml} 毫升</dd>
             {/if}	
            <dd><b>产 地：</b> {$product_info->wine_country_name} &nbsp;&nbsp; 	{$product_info->wine_area_name} </dd>
								 {if $product_info->wine_level_name}
			 <dd><b>等 级：</b> {$product_info->wine_level_name}</dd>	 {/if}
			 <dd><b>评 论：</b><a  id="commentLink" class="jq_a_ajax" />已有<strong id="comment_count1">{$product.coment_count|default:0}</strong>条评论</a></dd>	 
			 
            <form action="{Common_Smarty_Url_format key='add_cart' id=$product.id}" method="post">
					<input type="hidden" name="id" value="{$product.id}" id="com_sku" />
					<input type="hidden" name="size" value="F" id="com_size" />
          	  <dd><b>数 量：</b> 
          	     {if $product.stock &&  $product.stock > 0}
          	   <span class="buyNumber" id="buyNumber"><span class="numberOpt numUp"><a href="javascript:void(0)"></a></span>
              <span class="numberOpt numDown"><a href="javascript:void(0)"></a></span><input class="num" name="quantity" type="text" value="1" />{$product.unit}</span>（库存{$product.stock}件)</dd>
           		{else}该商品已售罄。{/if}
           	  <dd>
           	  <span class="buyBtns">
           	   {if $product.stock &&  $product.stock > 0}<input type="submit" class="addtocart" value=""/> {/if}
           	  <a href="{Common_Smarty_Url_format key='favorite' id=$product.id}{if !$user_auth_name}#noAuthLogin{/if}"
           	  id="favorite_link" class="jq_a_ajax collect"></a> 
           	  </span></dd>
            </form>
          </dl>
         
          <div class="shareCode">
          <!-- JiaThis Button BEGIN -->
      <div class="jiathis_style">
        <span class="jiathis_txt">分享到：</span>
        <a class="jiathis_button_tsina"></a>
        <a class="jiathis_button_qzone"></a>
        <a class="jiathis_button_renren"></a>
        <a class="jiathis_button_tqq"></a>
        <a class="jiathis_button_kaixin001"></a>
        <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
      </div>
      <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1343394143513914" charset="utf-8"></script>
      <!-- JiaThis Button END -->
      			</div>
      
        </div>
			</div>
      
    
      
    </div>
<!-- E proMain--->

 
<!-- S proInfo--->
    <div class="ap proInfo"> 
    	<div class="apTList">
      	<ul id="productTabs">
        	<li class="on"><a href="javascript:void(0)" data="productDesc">产品介绍</a></li>
          <li><a href="javascript:void(0)" data="userComment" id="userCommentLink">用户评论</a></li>
          <li><a href="javascript:void(0)" data="express">快递说明</a></li>
          <li><a href="javascript:void(0)" data="customerService">售后服务</a></li>
        </ul>
      </div>
      
      <div class="apC" id="contentDivId">
<!-- S 产品介绍 -->
      	<div class="prosection productDesc" id="productDesc">
        	<!-- <div class="cnt">
      			<span class="cell">品牌: A /span><span class="cell">产地: 萨尔瓦多</span><span class="cell">市场价: 2400</span>
						<span class="cell">是否现货: 现货</span><span class="cell">颜色分类:  </span><span class="cell">适用人群: 男士</span><br />
            <img src="" />
					</div>   -->
				{if $store_brand.content}
								<div class="cnt">
									{$store_brand.content|stripslashes}
								</div>
					{/if}
					{if $product.summary}
							<dt class="dt">产品简介</dt>
								 <dd class="dd"> {$product.summary|stripslashes} </dd>
					{/if}
					<div class="cnt">
									{$product.content|stripslashes}
						</div>
			
        </div>
        
<!-- S 所有评论 -->
				<div class="prosection userComment" id="userComment" style="display:none">
					<h3>用户评论  <span class="lco">共有 <b id="comment_count2"> {$product.coment_count|default:0} </b> 条评论</span></h3>			
         			  <ul class="comment" id="comment-box">
								 {Common_Smarty_DataSet_comment target_id=$product.id}
									<li> 
								    <b>{$cmt.username}</b><i class="time">{$cmt.created_on|date_format:'%Y-%m-%d'}:</i><span class="star star_5"></span>
										<p>{$cmt.content|stripslashes}</p>
									 </li>
									{/Common_Smarty_DataSet_comment}
					 </ul>
								{if !$user_auth_name}
										<h3>欢迎登陆后评价与提问。</h3>
								{/if}
								{if $user_auth_name}
								<h3>我来评价与提问:</h3>
								<div id="ajax-response"></div>
								<div id="post-comment" class="clearfix">
									<form method="post" action="/app/eshop/comment/do_comment" id="post-comment-frm">
										<input type="hidden" name="target_id" value="{$product.id}" />
										<input type="hidden" name="type" value="1" />
										<input type="hidden" name="user_id" value="{$user_id|default:0}" />
										<input type="hidden" name="username" value="{$user_auth_name|default:'guest'}" />
										<div class="r">
											<!-- <label for="title">标 题:</label><br/>
											<input type="text" name="title" value="" /><br/>
											-->
											<label for="content">内 容:</label><br/>
											<textarea name="content" id="post-content"></textarea>
											<a href="#post_comment" class="do-submit jq_a_ajax">确 认</a>
										</div>
										<!-- 
										<div class="gerfaq">
											<h4>常见问题</h4>
											<p class="titxt">1、是否有我需要的型号？</p> 
											<p>只要您在“现有型号”列表中看到的都是有货的。如果没有您适合的型号，您可以点击“没有我需要的型号?”进行缺货登记，新商品到货之后会尽快通知您。 </p>

											<p class="titxt">2、我的地区能够货到付款吗？</p>
											<p>在全国近1000个城市开通了送货上门货到付款服务，详细的配送范围请点击查看</p>
										</div>
										-->
									</form>
								</div>
								{/if}
         
				</div>
        
<!-- S 快递说明 -->
		<div class="prosection" id="express" style="display:none">
        	{smarty_include eshop.shopping.payaway}
        </div>
<!-- S 售后服务 -->
				<div class="prosection" id="customerService" style="display:none">
       	{smarty_include eshop.shopping.distribution}
        </div>
        
      </div>
		</div>

<!-- 相关推荐 -->
		<div class="ap">
      <div class="apT">推荐产品</div>
      <div class="apC">
					
      	<div class="proSection proSection0"> 
				 {Common_Smarty_Product_findProductList stick=1 size=3}
				 <div class="proList">
					<p class="img"><a href="{Common_Smarty_Url_format key=product id=$product.id}" >
						<img src="{$product.thumb}" class="bordor" width="230" height="230" />
					</a></p>
					 <span class="priceB">￥<span class="B">{$product.sale_price}</span> </span> 
					 <p class="nm"><a href="{Common_Smarty_Url_format key=product id=$product.id}">{$product.title}</a></p> 
					  
				  </div>
				{/Common_Smarty_Product_findProductList} 
        </div>
      </div>
    </div>
<!-- E proInfo--->

    </div>
    
  </div>
</div>
<!-- E body -->

<!-- S footer -->
 
  		{smarty_include eshop.common.site-help}
  		{smarty_include eshop.common.footer}
<!-- E footer -->

 
<div class="bubbleBox bubbleBox1" id="bubbleBox" style="display:block">
	<div class="c">
    <i class="ii i03"></i>
    <p class="info" id="favorite_msg">收藏成功！</p>
  </div>
</div>
	
	
	
 
</body> 
</html>