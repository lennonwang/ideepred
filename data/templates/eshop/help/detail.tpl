<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>帮助中心-{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi">
	{smarty_include eshop.common.header_compart}
	<!-- <link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" /> -->
	{smarty_include eshop.js-common}
	 
</head>

<body>
 
	
	{smarty_include eshop.common.header}
	
	<!-- S body -->
<div class="bdy">
	<div class="c0">
  	
    <div class="aside">
			{smarty_include eshop.help.nav} 
    </div>
		
    <div class="main">
    	<div class="artSection">
        <div class="artTitle">{$hpage.title|stripslashes}</div>
        <div class="artContent">
         {$hpage_body|nl2br|stripslashes}</div>
      </div>
    </div>
    
  </div>
</div>
<!-- E body -->

 

	{smarty_include eshop.common.site-help}
	
	{smarty_include eshop.common.footer}
	
</div>
</body>
</html>