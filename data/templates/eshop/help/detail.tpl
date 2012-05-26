<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>帮助中心-{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi">
	{smarty_include eshop.common.header_compart}
	<link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" />
	{smarty_include eshop.js-common}
</head>

<body>
<div id="wrapper">
	
	{smarty_include eshop.common.header}
	
	<div id="container">
		<div class="box">
			<div class="bordor profile">
				<h2>帮助中心</h2>
				
				<div class="box clearfix">
					<div class="leftref noborder" id="channelside">
						{smarty_include eshop.help.nav}
					</div>
					<div class="righttwo2" id="contentlist">
						
						<div class="contentbox">
							<h1>{$hpage.title|stripslashes}</h1>
							<div class="contentbaby">
								{$hpage_body|nl2br|stripslashes}
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