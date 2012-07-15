<div id="header" class="mb-10">
	<div class="site-box mt-10 clearfix">
		<div class="logosite fl">
			<a href="{Common_Smarty_Url_format key=domain}" title="爱深红">
				<img src="/images/eshop/wanhang-new-logo.jpg" alt="爱深红" />
			</a>
		</div>
		
		<div class="auth mb-10 fr clearfix">
			<div class="topnav ablack fl">
				{if $user_auth_name}
				<a href="{Common_Smarty_Url_format key=register}" class="red bold">您好，{$user_auth_name}</a> | <a href="{Common_Smarty_Url_format key=manage_center}">我的帐户</a> | <a href="{Common_Smarty_Url_format key=domain}/app/admin/" class="bold">管理中心</a> | <a href="{Common_Smarty_Url_format key=logout}" class="bold">退出登录</a> | 
				{else}
				<a href="{Common_Smarty_Url_format key=login}" class="bold">登录</a> | <a href="{Common_Smarty_Url_format key=register}" class="bold">注册</a> | 
				{/if}
				<a href="{Common_Smarty_Url_format key=helper name=register}" class="bold">客服中心</a>
			</div>

			<div class="buy-cart awhite fr">
				<h4 class="mb-5 clearfix"><img src="/images/eshop/icon-car.png" />  <a href="{Common_Smarty_Url_format key=cart}" class="fr"><img src="/images/eshop/icon-view.png" /></a></h4>
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
					<a href="{Common_Smarty_Url_format key=channel slug=red}" {if $current_menu == 'tab_tablet'}class="actived"{/if}>红葡萄酒</a>
				</li>
				<li>
					<a href="{Common_Smarty_Url_format key=channel slug=white}" {if $current_menu == 'tab_worksite'}class="actived"{/if}>白葡萄酒</a>
				</li>
				<li>
					<a href="{Common_Smarty_Url_format key=channel slug=pink}" {if $current_menu == 'tab_notepad'}class="actived"{/if}>桃红葡萄酒</a>
				</li>
 	<!--
				<li>
					<a href="{Common_Smarty_Url_format key=channel slug=book}" {if $current_menu == 'tab_book'}class="actived"{/if} >图书</a>
				</li>
				<li>
					<a href="{Common_Smarty_Url_format key=domain}" >教育</a>
				</li>
				<li>
					<a href="{Common_Smarty_Url_format key=build}" >画吧</a>
				</li>
			
				<li>
					<a href="#" >社区</a>
				</li>
				<li>
					<a href="#" >活动</a>
				</li>
				-->
			</ul>
		</div>
		
		<form class="search-form clearfix" action="">
			<input type="text" name="q" value="" class="fl query" />
			<input type="image" src="/images/eshop/icon-search.png" />
		</form>
	</div>
</div>