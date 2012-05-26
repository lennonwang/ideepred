<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>非法操作提示-新花样</title>
	{if $url}
	<meta http-equiv="REFRESH" content="2;URL={$url}">
	{/if}
	<link href="/csstyle/changelist.css" type="text/css" rel="stylesheet" />
</head>

<body>
<div id="container">
	<div id="content">
		<div id="hint_failing">
            <p>系统提示:{$message}</p>
			<span>
				{if $user_id}
				<a href="{$url}">返回上一步..</a>
				{else}
				<a href="/app/admin/authorize/login">请先登录..</a>
				{/if}
			</span>
        </div>
	</div>
	{smarty_include admin.footer}
</div>
</body>
</html>