<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
	<script type="text/javascript" src="/js/a/user_edit.js"></script>
</head>

<body>
<div class="wrap">
	<div class="icon32" id="icon-users">
		<br>
	</div>
	<h2>{if $edit_mode eq 'create'}添加新用户{else}更新用户信息{/if}</h2>
	<div class="clear"></div>
	<div id="ajax_request_progress"></div>
	<div id="ajax-response"></div>
	<p>用户可以由自己 注册 或者您可以在这里创建。</p>
	<div id="col-container">
		<div class="form-wrap">
			<form action="/app/admin/user/save" method="post" id="adduser" name="adduser">					
				<input type="hidden" value="{$user.id}" name="id" id="user_id">
				<table class="form-table">
					<tbody>
					<tr class="form-field form-required">
						<th valign="top" scope="row"><label for="account">用户名<span class="description">(必需)</span></label></th>
						<td><input type="text" size="40" value="{$user.account}" id="account" name="account" />
							<br>
							<p class="description indicator-hint">必须是一个邮箱地址！</p>	
						</td>
					</tr>
					<tr class="form-field form-required">
						<th valign="top" scope="row"><label for="username">昵称<span class="description">(必需)</span></label></th>
						<td><input type="text" size="40" value="{$user.username}" id="username" name="username" /></td>
					</tr>
					{if $edit_mode eq 'create'}
					<tr class="form-field form-required" id="validate_passwd">
						<th valign="top" scope="row"><label for="password">密码<span class="description">(重复两次，必需)</span></label></th>
						<td>
							<input type="password" autocomplete="off" id="password" name="password">
							<br>
							<input type="password" autocomplete="off" id="pass2" name="pass2">
							<br>
							<p class="description indicator-hint">提示：您的密码最好至少包含6个字符。为了保证密码强度，使用大小写字母，数字和符号，例如! " ? $ % ^ &amp; )。</p>
						</td>
					</tr>
					{/if}
					<tr class="form-field">
						<th valign="top" scope="row"><label for="sex">性别</label></th>
						<td><input class="s2em" type="radio" value="man" name="sex" {if $user.sex eq 'man'}checked="checked"{/if} />先生 <input class="s2em" type="radio" value="woman" name="sex" {if $user.sex eq 'woman'}checked="checked"{/if} />美女</td>
					</tr>
					<tr class="form-field">
						<th valign="top" scope="row"><label for="firstname">姓</label></th>
						<td><input type="text" size="40" value="{$user.meta.firstname}" id="firstname" name="firstname" /></td>
					</tr>
					<tr class="form-field">
						<th valign="top" scope="row"><label for="secondname">名</label></th>
						<td><input type="text" size="40" value="{$user.meta.secondname}" id="secondname" name="secondname" /></td>
					</tr>
					<tr class="form-field">
						<th valign="top" scope="row"><label for="role_id">角色</label></th>
						<td>
				  			<select class="postform" id="role_id" name="role_id">
								<option value="1" {if $user.role_id eq 1}selected="selected"{/if}>普通会员</option>
								<option value="2" {if $user.role_id eq 2}selected="selected"{/if}>客服人员</option>
								<option value="3" {if $user.role_id eq 3}selected="selected"{/if}>编辑人员</option>
								<option value="9" {if $user.role_id eq 9}selected="selected"{/if}>管理员</option>
							</select>
							<br>
			                <span class="description">角色的不同，具有的管理权限则不同.</span>
				  		</td>
					</tr>
					
				</tbody>
			</table>

				<p class="submit">
					<input type="submit" value=" 确认更新 " name="submit" class="button">
				</p>
			</form>
		</div>
	</div>
</div><!--endwrap-->
</body>
</html>