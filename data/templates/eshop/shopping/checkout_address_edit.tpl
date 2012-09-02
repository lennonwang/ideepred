
<!-- checkout_address_edit -->
<div class="sho_step editable" id="chkpay_address">
<table class="odrable">
								<tr>
									<th class="td_lab"><label for="name">收货人姓名：</label></th>
									<td><input type="text" name="name" value="{$data.name}" class="middle-text" />
									<span class="star">
										<font>*</font>
										<span style="color: rgb(255, 0, 0);" class="name_table_notice"></span>
									</span>
									</td>
								</tr>
								<tr>
									<th class="td_lab"><label for="province">省 份：</label></th>
									<td id="send_area">
										<label id="provice_box" name="/app/eshop/shopping/change_province"></label>
										<select name="province" id="choose_province">
											<option value="" >请选择</option>
											{foreach from=$provinces item=province}
											<option value="{$province.id}" {if $province.id eq $data.province}selected="selected"{/if}>{$province.name}</option>
											{/foreach}
										</select> 
										<label id="city_box">
										
										<select name="city" id="choose_city">
											<option value="-1">-请选择-</option>
											{foreach from=$citys item=city}
											<option value="{$city.id}" {if $city.id eq $data.city}selected="selected"{/if}>{$city.name}</option>
											{/foreach}
										</select>  
										{$data.city}
										{if $citys}{/if}
										</label> 
										<span class="star">
											<font>*</font>
										</span>
									</td>
								</tr>
								<tr>
									<th class="td_lab"><label for="address">地 址：</label></th>
									<td>
										<input type="text" name="address" value="{$data.address}" class="middle-text" />
										<span class="star">
											<font>*</font>
											<span style="color: rgb(255, 0, 0);" class="address_table_notice"></span>
										</span>
									</td>
								</tr>
								<tr>
									<th class="td_lab"><label for="zip">邮政编码：</label></th>
									<td>
										<input type="text" name="zip" value="{$data.zip}" class="middle-text" />
									</td>
								</tr>
								<tr>
									<th class="td_lab"><label for="telephone">固定电话：</label></th>
									<td><input type="text" name="telephone" value="{$data.telephone}" class="middle-text" id="telephone" /></td>
								</tr>
								<tr>
									<th class="td_lab"><label for="mobie">手机号码：</label></th>
									<td>
										<input type="text" name="mobie" value="{$data.mobie}" class="middle-text" id="mobie" />
										<span class="star">
											<font>*</font>
											<span style="color: rgb(255, 0, 0);" class="tel_table_notice"></span>
										</span>
									</td>
								<tr>
								<tr>
									<th class="td_lab"><label for="email"><span class="star">*</span>电子邮件：</label></th>
									<td><input type="text" name="email" value="{if $data.email}{$data.email}{else}{$user_data.account}{/if}" class="middle-text" />
										<span class="star">
											<font>*</font>
											<span style="color: rgb(255, 0, 0);" class="email_table_notice"></span>
										</span>
									</td>
								</tr>
							</table>
			</div>