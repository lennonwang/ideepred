<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>选择支付方式</title>
	<link type="image/x-icon" href="/favicon.ico" rel="shortcut icon"/> 
	{smarty_include eshop.js-common}
	{smarty_include eshop.js-form}
	<script type="text/javascript" src="/js/e/confirm.js"></script>
</head>

<body> 

		{smarty_include eshop.common.header}

<!-- S bdy -->
<div class="bdy">
	<div class="c0">
		 
				<div class="bordor" id="orderfrom">
					<h2 class="step step2">购物步骤: <span id="shoppingstep_1">1.登录注册</span> >> 
					<span id="shoppingstep_2" class="current_step">2.填写核对订单信息</span> >> 
					<span id="shoppingstep_3">3.提交订单</span></h2>
					 
					
					{smarty_include eshop.shopping.checkout_address_ok}
					
					<h3 class="stepTitle"><span class="opt">带<span class="s">*</span>的项目为必填项</span>请填写支付方式及配送方式</h3>
					<form method="post" action="/app/eshop/shopping/do_payment" id="order_ofrm" >
					<div class="sho_step editable" id="chkpay_info"> 
					  	<input type="hidden" name="next_step" value="{$next_step}" />
							<div class="dataTable  ">
								<table >
									<tr>
										<th class="pal_away">支付方式</th>
										<td class="pal_note">备 注</td>
									</tr>
								
									{foreach from=$payment_methods item=pm key=key}
									<tr>
										<th class="pal_away">
											<input type="radio" name="payment_method" value="{$key}" {if $data.payment_method eq $key}checked="checked"{/if} /><label for="payment_method">{$pm.name}</label>
										</th>
										<td class="pal_note">
											<span>{$pm.summary}</span>
										</td>
									</tr>
									{/foreach}
								
								</table>
							</div>
							
							<div class="dataTable  ">
								<table class="odrable">
									<tr>
										<th class="tranf_away">配送方式</th>
										<td class="pal_note">运 费</td>
									</tr>
								
									{foreach from=$transfer_methods item=tm key=key}
									<tr>
										<th class="tranf_away"><input type="radio" name="transfer" value="{$key}" {if $data.transfer eq $key}checked="checked"{/if} /> <label for="transfer">{$tm.name}</label></th>
										<td class="pal_note"><label>{$tm.freight}元</label>
										<br /><label>{$tm.summary}</label>
										</td>
									</tr>
									{/foreach}
								
								</table>
							</div>
							
							<div class="dataTable  ">
								<table class="odrable">
									<tr>
										<th><label>送货时间：</label></th>
										<td class="pal_note">
											<div class="tsr">
												{foreach from=$transfer_times item=tt key=key}
												<p><input type="radio" name="transfer_time" value="{$key}" {if $data.transfer_time eq $key}checked="checked"{/if} /><label for="transfer_time">{$tt}</label></p>
												{/foreach}
											</div>
										</td>
									</tr>
								</table>
							</div>
							
						<div class="dataTable  ">
							<table class="odrable">
								<tr>
									<th class="td_lab">备注：</th>
									<td class="pal_note">
										<textarea name="summary" cols="60">{$data.summary}</textarea>
										<p>(*请在文本框内填写您的留言,最好别超过100个字符)</p>
									</td>
								</tr>
							</table>
						</div>
							
							
							<div id="do_buy" class="btns2">
								<button type="submit" name="payment_ofrm" class="go_submit step-addr btn"><b>保存支付方法</b></button>
							</div> 
							 
						
					</div>
					
				</div>
				</form>
			</div>
			
		</div>

		{smarty_include eshop.site-help}

		{smarty_include eshop.footer}
 
	
</body>
</html>