<div id="nav">
	<a href="/app/admin/article" {if $main_menu eq 'article'}class="now"{/if}>文章管理</a>
	<a href="/app/admin/user" {if $main_menu eq 'user'}class="now"{/if}>用户管理</a>
	<a href="/app/admin/role" {if $main_menu eq 'system'}class="now"{/if}>系统管理</a>
</div>
<div class="clearer"></div>
<div id="status">
	<div id="subnav">
		{if $main_menu eq 'article'}
		<a href="/app/admin/sort/display" title="栏目列表">栏目列表</a>
		<a href="/app/admin/article/display" title="文章列表">文章列表</a>
		<a href="/app/admin/advertise/display" title="广告管理">广告管理</a>
		{/if}
		{if $main_menu eq 'permission'}
		<a href="/app/admin/permission/edit">添加权限</a>
		{/if}
		{if $main_menu eq 'system'}
		<a href="/app/admin/role" >用户组</a>
		<a href="/app/admin/permission" >权限管理</a>
		{/if}
		{if $main_menu eq 'user'}
		<a href="/app/admin/user/group" title="会员用户">会员用户</a>
		{/if}
	</div>
	{if $admin_name}
	<span>欢迎<a href="/app/admin/authorize/welcome">{$admin_name}</a>，离开请<a href="/app/admin/authorize/logout" title="退出">退出</a></span>
	{else}
	<span>你好，请<a href="/app/admin/authorize/login" title="登录">登录</a></span>
	{/if}
	<span><a href="http://www.instyles.com.cn" title="新花样">返回首页</a></span>
</div>
<div id="ajax_request_progress">
	正在处理...
</div>