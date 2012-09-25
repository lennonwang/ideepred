<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi">
	{smarty_include eshop.common.header_compart}
	<link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" />
	{smarty_include eshop.js-common}
	<script type="text/javascript" src="/js/c/jcarousellite_1.0.1.js"></script>
	<script type="text/javascript" src="/js/e/idx.js"></script>
</head>

<body>
 
	
	{smarty_include eshop.common.header}
  
  
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
			
			<!-- 
			<div class="ap schRes">
				<p class="opt"><a href=""><i class="ii"></i></a></p>
				<p class="res">您搜索的“<span class="s">阿根廷 赤霞珠</span>“共查到<span class="s">12</span>款</p>
				<p class="tip">您还可以尝试搜索酒精度数、年份、产区、口感，香味或者直接搜索英文名称等等</p>
			</div>
			 -->
			 
			<!-- S list1-->
			<div class="ap">
				<div class="apB proList proList1">
				{Common_Smarty_Product_findProductList stick=1 size=9}
				 
				<div class="pro">
						<i class="img">
						<a href="{Common_Smarty_Url_format key=product id=$product.id}" >
						<img src="{$product.thumb}"  width="230" height="230" /><i class="fave"></i>
						</a> </i>
						<p class="info"><i class="price">{$product.sale_price}元</i>
							<b class="nm"><a href="{Common_Smarty_Url_format key=product id=$product.id}">{$product.title}</a></b>
						</p>
					</div> 
				 
				{/Common_Smarty_Product_findProductList}
				 
				</div>
				<!-- 
				<div class="pg">
					<a href="" class="prev"></a><a href="" class="on">1</a><a href="">2</a><a href="">3</a><a href="">4</a><a href="">5</a><a class="next"></a>
				</div>
				 -->
			</div>
			<!-- E list1-->

			<!-- S 酒友会 
			<div class="ap cardSection">
				<div class="apT">酒友会成员推荐 <span style="color:#D46095;margin-left:50px">more</span></div>
				<div class="apB">
					<div class="card">
						<i class="img"><img src="i/demo3.jpg" /></i>
						<h4>小白白的白</h4>
						<p class="desc">
							1.几乎是世界上人类培植最早的葡萄品种，最早在1546年就在德国落户。<br />
							2.是一个遍布世界的家庭系列，有几百个变种，不是单指某个葡萄品种<br />
							3.麝香系列最适合用来酿造干白、气泡酒、和加强型葡
						</p>
					</div>
					<div class="proList proList2">
						<div class="pro">
							<i class="img"><a href=""><img src="i/demo2.jpg" /></a></i>
						</div>
						<div class="pro">
							<i class="img"><a href=""><img src="i/demo2.jpg" /></a></i>
						</div>
					</div>
				</div>
			</div>
			<!-- E 酒友会 -->

			<!-- B 热门直通车 -->
			<div class="ap">
				<div class="apT">热门直通车</div>
			 
				<div class="apB proList proList2">

					<div class="pro">
						<i class="img"><a href=""><img src="i/demo2.jpg" /></a></i>
					</div>
					<div class="pro">
						<i class="img"><a href=""><img src="i/demo2.jpg" /></a></i>
					</div>
					<div class="pro">
						<i class="img"><a href=""><img src="i/demo2.jpg" /></a></i>
					</div> 


				</div>
				
			</div>
			<!-- 热门直通车 -->

			</div>
		</div>
<!-- E main -->

	</div>
</div>
<!-- E bdy -->
  
  	 
	{smarty_include eshop.common.site-help}
	 
	
	
	{smarty_include eshop.common.footer}
</div>
</body>
</html>