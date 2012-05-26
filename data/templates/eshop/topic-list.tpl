<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>专题--{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi">
	<link rel="stylesheet" href="/csstyle/cstyle.css" type="text/css" />
	{smarty_include eshop.js-common}
</head>

<body>
{smarty_include eshop.common.tophead}
<div id="wrapper">
	
	{smarty_include eshop.common.header}
	
	<div id="container">
		<div class="box">
			{Common_Smarty_Advertise_findAdone number="channel_tl_01"}
			{if $advertise.thumb}
			<div class="iadx1">
				<a href="{$advertise.link}" title="{$advertise.title}">
					<img src="{$advertise.thumb|default:'/images/eshop/newpackage.jpg'}" alt="{$advertise.title}" />
				</a>
			</div>
			{/if}
		</div>
		
		<div class="box">
			<div class="bordor profile">
				<div class="box">
					<div class="leftref noborder" id="shopside">
						<img src="/images/eshop/topic_title.jpg" />
						<div class="addressbox">
							<h1 style="color:#009966;">2011</h1>
							<ul class="addresslist clearfix">
								<li><a href="http://www.100jia.cc/valentines_day/man/index.html" target="_blank">2011情人节男士特辑</a></li>
								<li><a href="http://www.100jia.cc/valentines_day/woman/index.html" target="_blank">2011情人节女士特辑</a></li>
							</ul>
						</div>
					</div>
					<div class="fr" id="shoplist">
						<div id="topic-list">
							<div class="titem">
								<p>
									<a href="http://www.100jia.cc/valentines_day/man/index.html" target="_blank">
										<img src="/images/eshop/men.gif" alt="" />
									</a>
								</p>
								<h1>2011情人节最想要的礼物-MEN</h1>
								<div class="shopbox">
									还记得小时候为魂斗罗疯狂的日子么？那是每个男生曾经最着迷的经典游戏。现在各自成熟，疯狂不在，但是我们还需要一些贴心的设计来凭吊往日的美好。
									每个男人心里都有金戈铁马的梦，也有去到某个城堡营救公主之梦。那么送他这款极具复古风格的城堡马蹄表吧，表盘复古的花纹，大气古典；科学的双显方式，方便认……
								</div>
							</div>
							<div class="titem">
								<p>
									<a href="http://www.100jia.cc/valentines_day/woman/index.html" target="_blank">
										<img src="/images/eshop/women.gif" alt="" />
									</a>
								</p>
								<h1>2011情人节最想要的礼物-WOMEN</h1>
								<div class="shopbox">
									一只害羞的小兔子，绯红的脸蛋，羞涩的表情，还有想要遮住双眼的举起的双手。这个情人节里最萌的兔子就是它。整个兔子用环保健康的柔软拉绒制成，内部是弹性超好的弹力棉。
									情人节送围巾一直是最贴心的必选项，想在寒冷的冬日里给她带上一条温暖的围巾，那种暖意会一直流淌到心底……
								</div>
							</div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>

	</div>

	{smarty_include eshop.common.site-help}
	
	{smarty_include eshop.common.footer}
	
</div>
</body>
</html>