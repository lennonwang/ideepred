


<!-- S aside -->
		<div class="ASIDE">
			<div class="c">
				
				<!-- S ap cat-->
				<div class="ap subCat">
					<div class="apT">交易管理</div>
					<div class="apB">
						<ul class="cats">
						<li><a href="{Common_Smarty_Url_format key='i_orders'}"  {if $sub_nav eq 'order'}class="on"{/if}>订单中心</a></li>
		<li><a href="{Common_Smarty_Url_format key='i_buyed'}"  {if $sub_nav eq 'buyed'}class="on"{/if}>已买到的商品</a></li>
		<li ><a href="{Common_Smarty_Url_format key='i_favorite' page=1}" {if $sub_nav eq 'favorite'}class="on"{/if} >我收藏的商品</a></li>
						</ul>
					</div>
				</div>
				<!-- E ap cat-->

				<!-- S ap cat-->
				<div class="ap subCat">
					<div class="apT">个人信息管理</div>
					<div class="apB">
						<ul class="cats">
						<li><a href="{Common_Smarty_Url_format key='i_info'}"  {if $sub_nav eq 'info'}class="on"{/if}>编辑个人资料</a></li>
		<li><a href="{Common_Smarty_Url_format key='i_passwd'}"  {if $sub_nav eq 'passwd'}class="on"{/if}>修改密码</a></li>
		<li ><a href="{Common_Smarty_Url_format key='i_addbooks'}" {if $sub_nav eq 'addbooks'}class="on"{/if}>修改送货信息</a></li>
						</ul>
					</div>
				</div>
				<!-- E ap cat-->

			</div>
		</div>
<!-- E aside -->

		
{*
<div id="user_nav">
	<h3>交易管理</h3>
	<ul>
		<li {if $sub_nav eq 'order'}class="on"{/if}><a href="{Common_Smarty_Url_format key='i_orders'}" >订单中心</a></li>
		<li {if $sub_nav eq 'buyed'}class="on"{/if}><a href="{Common_Smarty_Url_format key='i_buyed'}" >已买到的商品</a></li>
		<li {if $sub_nav eq 'favorite'}class="on"{/if}><a href="{Common_Smarty_Url_format key='i_favorite' page=1}" >我收藏的商品</a></li>
	</ul>
	<h3>个人信息管理</h3>
	<ul>
		<li {if $sub_nav eq 'info'}class="on"{/if}><a href="{Common_Smarty_Url_format key='i_info'}" >编辑个人资料</a></li>
		<li {if $sub_nav eq 'passwd'}class="on"{/if}><a href="{Common_Smarty_Url_format key='i_passwd'}" >修改密码</a></li>
		<li {if $sub_nav eq 'addbooks'}class="on"{/if}><a href="{Common_Smarty_Url_format key='i_addbooks'}">修改送货信息</a></li>
	</ul>
</div>
*}