

<!-- S topBg -->
<div class="topBg"><div class="c0"></div></div>
<!-- E topBg -->
<!-- S topBar -->
<div class="topBar">
	<div class="c0">
		{if $user_auth_name}
		<p class="usr">Hello, 	
		<a href="{Common_Smarty_Url_format key=manage_center}">{$user_auth_name}</a>
		<a href="{Common_Smarty_Url_format key=manage_center}">我的帐户</a>  
    	<a href="{Common_Smarty_Url_format key=helper name=register}">客服中心</a>
    	<a href="{Common_Smarty_Url_format key=logout}">退出登录</a>
    	</p>
    	 {/if}  
    	 <a href="{Common_Smarty_Url_format key=domain}"><b>欢迎来到深红俱乐部</b></a> 
		{* 
			<a href="">买酒</a><a href="">学习酒</a><a href="">资料库</a><a href="">酒友会</a><a href="">促销</a>
		*}
	</div>
</div>
<!-- E topBar -->

<!-- S TopNav -->
<div class="topNav">
	<div class="c0">
		<div class="logo"><a href="{Common_Smarty_Url_format key=domain}"><b>深红</b></a></div>

		<div class="schForm">
			  <form   action="/mall/search"> 
				 {if $user_auth_name}
					<i class="userStatue">
					<a href="{Common_Smarty_Url_format key=domain}">红 酒</a>
					<a href="{Common_Smarty_Url_format key=manage_center}">我 的</a></i>
				 {else}
					<i class="userStatue">
					<a href="{Common_Smarty_Url_format key=login}">登 录</a>
					<a href="{Common_Smarty_Url_format key=register}">注 册</a></i>  
				 {/if}  
				
				<i class="txt"><input type="text" value="{$query}" name="query"/></i>
					<button type="submit" class="btn" /><b>搜索</b></button>
				</form>
			 
		</div>
		<div class="cart"><a href="{Common_Smarty_Url_format key=cart}">
		 {if $user_auth_name}<b>{$items_count}件,{$total_money}元</b>{/if}</a></div>
	</div>
</div>
<!-- E TopNav -->

{* 
<!-- S userState -->
<div class="userState">
	<div class="c0">
	
	{if $user_auth_name}
			 <!-- S 已登录状态 --> 
    <div class="myUser">
    	<a href="{Common_Smarty_Url_format key=manage_center}">您好，{$user_auth_name}</a> | 
    	<a href="{Common_Smarty_Url_format key=manage_center}">我的帐户</a> | 
    	<a href="{Common_Smarty_Url_format key=cart}" class="showCart"><i class="ii i01"></i>购物车<b>{$items_count}</b>件，合计<b>{$total_money}</a>元</a> |
    	<a href="#">管理中心</a> | 
    	<a href="{Common_Smarty_Url_format key=logout}">退出登录</a> | 
    	<a href="{Common_Smarty_Url_format key=helper name=register}">客服中心</a>
    </div>
    
    <!-- E 已登录状态 -->
			 
		{else}
		<!-- S 未登录状态 --> 
    <div class="myUser">
    	<a href="{Common_Smarty_Url_format key=login}">登陆</a> | 
    	<a href="{Common_Smarty_Url_format key=register}">注册</a> | 
    	<a href="{Common_Smarty_Url_format key=helper name=register}">客服中心</a>
    </div>
    
    <!-- E 未登录状态 -->
    
	  {/if}  
    
  	<div class="welWord">欢迎你来到深红俱乐部！</div>
  </div>
</div>
<!-- E userState -->

<!-- S TopNav -->
<div class="topNav">
	<div class="c0">
  	<div class="search">
  	<form   action="/mall/search"> 
			<i class="txt"><input type="text" name="query" value="{$query}"   /></i><button class="btn">搜索</button>
		<!--
			<input type="text" name="query" value="{$query}" class="fl query" />
			<input type="image" src="/images/eshop/icon-search.png" />
			-->
		</form>
    	
    </div>
  	<div class="logo"><a href="{Common_Smarty_Url_format key=domain}"><b>爱深红</b></a></div>
    <div class="navs"><a href="{Common_Smarty_Url_format key=domain}" {if $current_menu == 'tab_index'}class="on"{/if}>买酒</a>
   		 <a href="{Common_Smarty_Url_format key=category_list catcode=AVNN}" {if $current_menu == 'tab_AVNN'}class="on"{/if}>红葡萄酒</a>
    	<a href="{Common_Smarty_Url_format key=category_list catcode=ATHW}" {if $current_menu == 'tab_ATHW'}class="on"{/if}>白葡萄酒</a>
    	<a href="{Common_Smarty_Url_format key=category_list catcode=AGOC}" {if $current_menu == 'tab_AGOC'}class="on"{/if}>桃红葡萄酒</a>
    	
  <!--  <a href="#">学习酒</a>
    <a href="#">资料库</a>
    <a href="#">酒友会</a>
    <a href="#">促销</a>
    -->
    
    </div>
  </div>
</div>
<!-- E TopNav -->


<!--
<div id="header" class="mb-10">
	<div class="site-box mt-10 clearfix">
		<div class="logosite fl">
			<a href="{Common_Smarty_Url_format key=domain}" title="爱深红">
				<img src="/images/eshop/ideepred_log.png" alt="爱深红" />
			</a>
		</div>
		
		<div class="auth mb-10 fr clearfix">
			<div class="topnav ablack fl">
				{if $user_auth_name}
				<a href="{Common_Smarty_Url_format key=register}" class="red bold">您好，{$user_auth_name}</a>
				 | <a href="{Common_Smarty_Url_format key=manage_center}">我的帐户</a> 
				 | <a href="{Common_Smarty_Url_format key=domain}/app/admin/" class="bold">管理中心</a>
				 | <a href="{Common_Smarty_Url_format key=logout}" class="bold">退出登录</a> | 
				{else}
				<a href="{Common_Smarty_Url_format key=login}" class="bold">登录</a> | <a href="{Common_Smarty_Url_format key=register}" class="bold">注册</a> | 
				{/if}
				<a href="{Common_Smarty_Url_format key=helper name=register}" class="bold">客服中心</a>
			</div>

			<div class="buy-cart awhite fr">
				<h4 class="mb-5 clearfix"><img src="/images/eshop/icon-car.png" /> 
				 <a href="{Common_Smarty_Url_format key=cart}" class="fr"><img src="/images/eshop/icon-view.png" /></a></h4>
				<div id="buy-item" class="pl-5 bold">{$items_count}件商品，合计{$total_money}元</div>
			</div>
		</div>
	</div>
	
	<div id="navigation" class="clearfix">
		<div class="menu-box">
			<ul class="clearfix">
				<li>
					<a href="{Common_Smarty_Url_format key=domain}" {if $current_menu == 'tab_index'}class="actived"{/if}>首 页</a>
				</li>
				<li> 
					<a href="{Common_Smarty_Url_format key=category_list catcode=AVNN}" {if $current_menu == 'tab_AVNN'}class="actived"{/if}>红葡萄酒</a>
					 
				</li>
				<li>
					<a href="{Common_Smarty_Url_format key=category_list catcode=ATHW}" {if $current_menu == 'tab_ATHW'}class="actived"{/if}>白葡萄酒</a>	</li>
				<li>
				<a href="{Common_Smarty_Url_format key=category_list catcode=AGOC}" {if $current_menu == 'tab_AGOC'}class="actived"{/if}>桃红葡萄酒</a>	</li>
  
			</ul>
		</div>
		
		<form class="search-form clearfix" action="/mall/search">
			<input type="text" name="query" value="{$query}" class="fl query" />
			<input type="image" src="/images/eshop/icon-search.png" />
		</form>
	</div>
</div>
-->
*}