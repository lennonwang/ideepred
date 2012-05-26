<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>{$product.title}--{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi">
	{smarty_include eshop.common.header_compart}
	<link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" />
	{smarty_include eshop.js-common}
	{smarty_include eshop.js-form}
	<script type="text/javascript" src="/js/e/product.js"></script>
</head>

<body>
<div id="wrapper">
	
	{smarty_include eshop.common.header}
	
	<div id="container">
		<div class="box nospace">
			<div class="box paths a999">
				<a href="{Common_Smarty_Url_format key=domain}" class="home">首页</a> > {foreach from=$product.categories item=bcate name=bcate}
				{if $smarty.foreach.bcate.first}<a href="{Common_Smarty_Url_format key=channel slug=$bcate.slug}" title="{$bcate.name}">{$bcate.name}</a>{else}<a href="{Common_Smarty_Url_format key=category_list catcode=$bcate.code}" title="{$bcate.name}">{$bcate.name}</a>{/if}{if !$smarty.foreach.bcate.last}<em>,</em>{/if}
				{/foreach}
				>
				{$product.title}
			</div>
		</div>
		
		<div class="box clearfix">
			<div class="leftref noborder" id="channelside">
				<h2 class="orange ft14">全部分类</h2>
				{smarty_include eshop.leftcategory}
				
				{if $like_products}
					<span class="blank10"></span>
					<div class="linespace guess">
						<h2 class="orange ft14">购买此商品的用户还喜欢...</h2>
						<ul class="stuff-list clearfix">
							{foreach from=$like_products item=likepro}
							<li>
								<a href="{Common_Smarty_Url_format key=product id=$likepro.id}">
									<img src="{Common_Smarty_Asset_Thumb path_id=$likepro.thumb w=50 h=50}" class="bordor" width="90px" height="90px" />
								</a>
								<h3 class="a999"><a href="{Common_Smarty_Url_format key=product id=$likepro.id}">{$likepro.title}</a></h3>
								<p>优惠价：<span class="ft14 orange">￥{$likepro.sale_price}</span></p>
							</li>
							{/foreach}
						</ul>
					</div>
				{/if}
				
				<span class="blank10"></span>
				<div class="linespace history">
					<h2 class="orange ft14">最近浏览过的商品...</h2>
					<ul class="stuff-list clearfix">
						{foreach from=$visited_products item=viewpro}
						<li>
							<a href="{Common_Smarty_Url_format key=product id=$viewpro.id}">
								<img src="{Common_Smarty_Asset_Thumb path_id=$viewpro.thumb w=50 h=50}" class="bordor" width="90px" height="90px" />
							</a>
							<h3 class="a999"><a href="{Common_Smarty_Url_format key=product id=$viewpro.id}">{$viewpro.title}</a></h3>
							<p>优惠价：<span class="ft14 orange">￥{$viewpro.sale_price}</span></p>
						</li>
						{/foreach}
					</ul>
				</div>
				
			</div>
			<div class="righttwo" id="contentlist">
				
				<div class="box clearfix">
					<div id="showbox">
						{Common_Smarty_Asset_Thumb path_id=$product.asset_list[0].path domain=$product.asset_list[0].domain w=500 h=360 var=first_image is_result_mode=ary}
						<div class="xhd">
							<img src="{$first_image.url}"  id="product-bigpicture" alt="{$product.title}"  width="400" height="350" class="bordor" />
						</div>
						<ul class="slide-show clearfix">
							{foreach from=$product.asset_list item=asset name=asset}
							<li {if $smarty.foreach.asset.last}class="lastitem"{/if}>
								{if $smarty.foreach.asset.first}
								<a href="{$first_image.url}" class="a_ajax actived">
								{else}
								<a href="{Common_Smarty_Asset_Thumb path_id=$asset.path domain=$asset.domain w=400 h=350}" class="a_ajax">
								{/if}
									<img src="{Common_Smarty_Asset_Thumb path_id=$asset.path domain=$asset.domain w=50 h=50}" class="bordor" />
								</a>
							</li>
						    {/foreach}
						</ul>
					</div>
					<div class="productmesg clearfix">
						<h3>
							{$product.title}
						</h3>	
						<div class="bebx">
							<label>品 牌： {$store_brand.title}</label>
							<a href="{Common_Smarty_Url_format key='brand_product' id=$store_brand.id}" class="more" />更多 {$store_brand.title} 产品 »</a>
						</div>
						
						<div class="bebx">
							<label>型号：{$product.mode|default:'无'}</label>
						</div>
						<div class="bebx">
							<label>价 格： <span class="red">￥{$product.sale_price}</span></label>
						</div>
						<div class="bebx">
							<label>颜 色： {$product.color|default:'无'}</label>
						</div>
						{if $product.material}
						<div class="bebx">
							<label>材 质： {$product.material}</label>
						</div>
						{/if}
						<div class="bebx aorange">
							<label>包装费用： 无</label>  <a href="#" class="ml-20">查看运费</a>
						</div>
						

						<div class="bebx clearfix">
							<form action="{Common_Smarty_Url_format key='add_cart' id=$product.id}" method="post">
								<input type="hidden" name="id" value="{$product.id}" id="com_sku" />
								<div class="jaline">
									<label>外形尺寸：{if $product.width or $product.height or $product.length}{$product.length} x {$product.width} x {$product.height} cm{else}均码{/if}</label>
									<input type="hidden" name="size" value="F" id="com_size" />
								</div>
								<div class="mb-10">
									<label>数 量： <input type="text" value="1" name="quantity"  class="small-text quantity-count" /> {$product.unit}</label>
								</div>
								<div class="buy clearfix">
									<input type="image" src="/images/eshop/icon-nowbuy.png" class="nowbuy" />
									<input type="submit" name="addtocart" value="放入购物车" class="addtocart" />
								</div>
								<div class="a999 rated">
									<label>用户评论：</label> <a href="#view_comment" class="jq_a_ajax" />已有<strong id="comment_count1">{$product.coment_count|default:0}</strong>条评论</a>
								</div>
							</form>
						</div>
						
					</div>

				</div>
				<div class="box clearfix">
					<div id="sharelike" class="mt-10">
						<div class="sharebtn aorange">
							<!-- JiaThis Button BEGIN -->
							<div id="ckepop">
								<a href="http://www.jiathis.com/share/" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank">分享到：</a>
								<a class="jiathis_button_tsina"></a>
								<a class="jiathis_button_qzone"></a>
								<a class="jiathis_button_kaixin001"></a>
								<a class="jiathis_button_renren"></a>
							</div>
							<script type="text/javascript" src="http://v2.jiathis.com/code/jia.js" charset="utf-8"></script>
							<!-- JiaThis Button END -->
							<span class="ml-5 mr-5">|</span> 
							<a href="{Common_Smarty_Url_format key='favorite' id=$product.id}{if !$user_auth_name}#noAuthLogin{/if}" class="jq_a_ajax">收藏该商品</a>
						</div>
					</div>
				</div>
				
				<div class="box">
					<div class="box100 clearfix">
						<div class="proservice" id="product-detail">
							<ul class="tabs clearfix">
								<li><a href="#productbody" class="current">产品描述</a></li>
								<li><a href="#payaway">支付方式</a></li>
								<li><a href="#deliverynote">配送说明</a></li>
								<li><a href="#reviewsbox" id="product-comment" class="lasta">用户评论</a></li>
							</ul>

							<div class="pbox" id="productbody">
								{if $store_brand.content}
								<div class="product-features">
									{$store_brand.content|stripslashes}
								</div>
								{/if}

								<div class="product-body">
									{$product.content|stripslashes}
								</div>
								
							</div>

							<div class="pbox" id="payaway">
								{smarty_include eshop.shopping.payaway}
							</div>

							<div class="pbox" id="deliverynote">
								{smarty_include eshop.shopping.distribution}
							</div>

							<div class="pbox" id="reviewsbox">
								<h3>用户评论  <span class="lco">共有 <b id="comment_count2"> {$product.coment_count|default:0} </b> 条评论</span></h3>

								<div id="comment-box">
									{Common_Smarty_DataSet_comment target_id=$product.id}
									<div class="item">
										<h4>{$cmt.title} on {$cmt.created_on|date_format:'%Y-%m-%d'}:</h4>
										<p>{$cmt.content|stripslashes}</p>
									</div>
									{/Common_Smarty_DataSet_comment}
								</div>

								<h3>我来评价与提问:</h3>
								<div id="ajax-response"></div>
								<div id="post-comment" class="clearfix">
									<form method="post" action="/app/eshop/comment/do_comment" id="post-comment-frm">
										<input type="hidden" name="target_id" value="{$product.id}" />
										<input type="hidden" name="type" value="1" />
										<input type="hidden" name="user_id" value="{$user_id|default:0}" />
										<input type="hidden" name="username" value="{$user_name|default:'guest'}" />
										<div class="r">
											<label for="title">标 题:</label><br/>
											<input type="text" name="title" value="" /><br/>
											<label for="content">内 容:</label><br/>
											<textarea name="content" id="post-content"></textarea>
											<a href="#post_comment" class="do-submit jq_a_ajax">确 认</a>
										</div>
										<div class="gerfaq">
											<h4>常见问题</h4>
											<p class="titxt">1、是否有我需要的型号？</p> 
											<p>只要您在“现有型号”列表中看到的都是有货的。如果没有您适合的型号，您可以点击“没有我需要的型号?”进行缺货登记，新商品到货之后会尽快通知您。 </p>

											<p class="titxt">2、我的地区能够货到付款吗？</p>
											<p>在全国近1000个城市开通了送货上门货到付款服务，详细的配送范围请点击查看</p>
										</div>
									</form>
								</div>

							</div>

						</div>
						
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