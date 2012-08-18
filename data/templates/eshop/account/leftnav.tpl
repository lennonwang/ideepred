<div id="user_nav">
	<h3>交易管理</h3>
	<ul>
		<li {if $sub_nav eq 'order'}class="now"{/if}><a href="{Common_Smarty_Url_format key='i_orders'}" >订单中心</a></li>
		<li {if $sub_nav eq 'buyed'}class="now"{/if}><a href="{Common_Smarty_Url_format key='i_buyed'}" >已买到的商品</a></li>
		<li {if $sub_nav eq 'favorite'}class="now"{/if}><a href="{Common_Smarty_Url_format key='i_favorite' page=1}" >我收藏的商品</a></li>
	</ul>
	<h3>个人信息管理</h3>
	<ul>
		<li {if $sub_nav eq 'info'}class="now"{/if}><a href="{Common_Smarty_Url_format key='i_info'}" >编辑个人资料</a></li>
		<li {if $sub_nav eq 'passwd'}class="now"{/if}><a href="{Common_Smarty_Url_format key='i_passwd'}" >修改密码</a></li>
		<li {if $sub_nav eq 'addbooks'}class="now"{/if}><a href="{Common_Smarty_Url_format key='i_addbooks'}">修改送货信息</a></li>
	</ul>
</div>