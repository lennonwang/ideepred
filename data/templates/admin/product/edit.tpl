<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	
		<script>
				var wineAreaList = new Array();
				{foreach from=$wine_area_array item=area}
					wineAreaList[wineAreaList.length]=new Array("{$area.cid}","{$area.id}","{$area.name}");
				{/foreach}
				
					var wineLevelList = new Array();
				{foreach from=$wine_level_array item=level}
					wineLevelList[wineLevelList.length]=new Array("{$level.cid}","{$level.id}","{$level.name}");
				{/foreach}
				
				var catList = new Array();
				{foreach from=$all_category item=cat}
					catList[catList.length]=new Array("{$cat.id}","{$cat.code}","{$cat.name}");
				{/foreach} 
	</script>
				{smarty_include admin.system.jscript}
	<script type="text/javascript" src="/js/uploadify/swfobject.js"></script>
	<script type="text/javascript" src="/js/uploadify/jquery.uploadify.v2.1.0.js"></script>
	<script type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="/js/a/product_edit.js"></script>
<!-- -->
<script type="text/javascript" src="/js/xheditor/xheditor-1.1.14-zh-cn.min.js"></script>
	
</head>

<body> 
<div class="wrap">
	<div class="icon32" id="icon-edit">
		<br>
	</div>
	<h2>{if $edit_mode eq 'create'}上传新产品{else}编辑产品信息{/if} <a class="button add-new-h2" title="添加新产品" href="/app/admin/product/edit">添加新产品</a></h2>
	<div class="clear"></div>
	<div id="ajax_request_progress"></div>
	<div id="ajax-response"></div>
	<div id="col-container">
		<div class="form-wrap">
			<ul id="messageBox"></ul>
			<form action="/app/admin/product/save" method="post" id="addproduct" name="addproduct">					
				<input type="hidden" value="{$product.id}" name="id" id="product_id">
				<input type="hidden" value="{$rand_sign}" name="rand_sign_id" id="rand_sign_id">
				
				<div id="poststuff" class="metabox-holder has-right-sidebar"> 
					 
					 	<div id="post-body-content" style="margin-right: 10px;">
						  
						 <p class="submit" style="text-align:center">
								 <input type="submit" value=" 确认提交 " name="submit" class="button"  id="submit_product" />
								  {if $product.title}   <a href="/app/admin/product/edit/id/{$product.id}">编辑</a> {/if}
							 </p> 
							 
							
							<div class="productNumber">
								<table class="form-table">
									<tbody>
									  <tr class="form-field form-required">
											<th scope="row"  >
												<label for="retail_price">产品标题：</label>
											</th>
											<td colspan="3"> 
											 <input type="text"  id="title" value="{$product.title}" tabindex="1" size="30" name="title">
											   {if $product.title}<a href="/product/{$product.id}.html"  target="_blank">预览</a> {/if}
											</td> 
								       </tr>
									   <tr class="form-field form-required">
									<th scope="row"  >
												<label for="retail_price">产品状态：</label>
											</th>
											<td  > 
											<input type="radio" name="state" value="0" {if $product.state eq 0}checked="checked"{/if} />默 认 
											<input type="radio" name="state" value="2" {if $product.state eq 2}checked="checked"{/if} />展 示 
											<input type="radio" name="state" value="1" {if $product.state eq 1}checked="checked"{/if} />上 架 
											<input type="radio" name="state" value="-1" {if $product.state eq -1}checked="checked"{/if} />下 架 	 
									
								            </td>
									 <th scope="row" style="width:120px;">
												<label for="wine_code">红酒编码：</label>
											</th>
												<td >  
												<input type="text" size="30" value="{$product.wine_code}" id="wine_code" name="wine_code"  tabindex="2"  /> 
								            </td> 
								             
										 
								       </tr>
								       
								       <tr>
										
											<th scope="row">	<a class="hide-if-no-js" href="/app/admin/category" > 类别：</a></th>
											<td>
												<input type="hidden" name="cat_code" id="cat_code" value="{$product.cat_code}"/>
											<select  name="category_id" id="category_id">
												<option value="0">请选择</option>
											{foreach from=$all_category item=cate} 
												 <option value="{$cate.id}" > {$cate.name}  --  {$cate.code} </option>
											{/foreach}
											</select>
											</td>
											
												<th scope="row">	<a class="hide-if-no-js" href="/app/admin/store" > 品牌：</a></th>
											<td >
											<select  name="store_id" id="store_id">
													<option value="0">请选择</option>
												{foreach from=$all_store item=store}
										 			<option  value="{$store.id}" > {$store.title}  </option>
										 	 	{/foreach}
											</select> 
											<a class="hide-if-no-js" href="/app/admin/store/edit" >+ 添加品牌</a>
											</td> 
										</tr>
										
									   <tr class="form-field form-required">
											<th scope="row"> <label>是否为推荐</label></th>
											<td>
													<input type="radio" name="stick" value="1" {if $product.stick eq 1}checked="checked"{/if} />推荐 
												    <input type="radio" name="stick" value="0" {if $product.stick eq 0}checked="checked"{/if} />不推荐  
								            </td>
											<th scope="row"> 	<label for="market_price">是否为赠品：</label> 	</th> 
											<td>
													<input type="radio" name="is_gift" value="1" {if $product.is_gift eq 1}checked="checked"{/if} />是  
													<input type="radio" name="is_gift" value="0" {if $product.is_gift eq 0}checked="checked"{/if} />否
								            </td>
								       </tr>
										<tr >
											<th scope="row"  >
												<label for="retail_price">进货价格：</label>
											</th>
											<td>
												<input type="text" size="20" value="{$product.retail_price}" id="retail_price" name="retail_price" tabindex="3" /> 
								            </td>
											<th scope="row">
												<label for="market_price">市场价格：</label>
											</th>
									  
											<td>
												<input type="text" size="20" value="{$product.market_price}" id="market_price" name="market_price" tabindex="4" /> 
								            </td>
								       </tr>
									   <tr>
											<th scope="row">
												<label for="sale_price">优惠价格：</label>
											</th>
											<td>
												<input type="text" size="20" value="{$product.sale_price}" id="sale_price" name="sale_price" tabindex="5" />
								            </td>
											<th scope="row">
												<label for="member_price">会员价格：</label>
											</th>
											<td>
												<input type="text" size="20" value="{$product.member_price}" id="member_price" name="member_price" tabindex="6" />
								            </td>
											
										</tr>
										<!-- 产地 -->
										 <tr>
											<th scope="row">
												<label for="retail_price">产地：</label>
											</th>
											<td>  
												<select  name="wine_country" id="wine_country" onchange="changeCountry();">
													<option value="0">请选择产地</option>
												{foreach from=$wine_country_array item=country }
										 			<option  value="{$country.id}" > {$country.name}  </option>
										 	 	{/foreach}
											</select>
												&nbsp;&nbsp;
												<select name="wine_area" id="wine_area">
																<option value="0">请选择产区</option> 
												</select>
												
													&nbsp;&nbsp;
												<select name="wine_level" id="wine_level">
																<option value="0">请选择红酒级别</option> 
												</select>
								       </td> 
								             
								            <th scope="row">
												<label for="wine_sugar">葡萄糖分：</label>
											</th>
											<td>
												<select  name="wine_sugar" id="wine_sugar">
													<option value="0">请选择</option>
												{foreach from=$wine_sugar_array item=item }
										 			<option  value="{$item.id}" > {$item.name}  </option>
										 	 	{/foreach}
											</select>
								            </td> 
								      </tr>
								      <tr>      
								             <th scope="row">
												<label for="wine_year">年份：</label>
											</th>
											<td>
												<select  name="wine_year" id="wine_year">
													<option value="0">请选择</option>
												{foreach from=$wine_year_array item=item }
										 			<option  value="{$item.id}" > {$item.name}  </option>
										 	 	{/foreach}
											</select>
								            </td> 
								            
								             <th scope="row">
												<label for="retail_price">适合场合：</label>
											</th>
											<td>
												<select  name="wine_occasion" id="wine_occasion">
													<option value="0">请选择</option>
												{foreach from=$wine_occasion_array item=item }
										 			<option  value="{$item.id}" > {$item.name}  </option>
										 	 	{/foreach}
											</select>
								            </td> 
										</tr>
										
										 <tr>      
								             <th scope="row">
												<label for="wine_ml">净含量：</label>
											</th>
											<td  >   
												<input type="text" size="10" 
												{if $product.wine_ml}value="{$product.wine_ml}"{/if}
												{if !$product.wine_ml}value="750"{/if}
												 id="wine_ml" name="wine_ml" tabindex="8" /> ML(毫升)
								            </td> 
								             
								             <th scope="row">
												<label for="wine_craft">制作工艺：</label>
											</th>
											<td  >   
												 <select  name="wine_craft" id="wine_craft">
														<option value="0">请选择</option>
													{foreach from=$wine_craft_array item=item }
											 			<option  value="{$item.id}" > {$item.name}  </option>
											 	 	{/foreach}
												</select>
										 
								            </td> 
								         </tr>
										<tr>    
								             <th scope="row">
												<label for="stock">库存：</label>
											</th>
												<td >  
												<input type="text" size="30" value="{$product.stock}" id="stock" name="stock" tabindex="9" /> 
								            </td> 
                                             <th scope="row">
												<label for="stock_alarm">库存警告：</label>
											</th>
												<td >  
												<input type="text" size="30" value="{$product.stock_alarm}" id="stock_alarm" name="stock_alarm"  tabindex="10"  /> 
								            </td> 
                                        </tr> 
                                        
                                        <tr>    
								             <th scope="row">
												<label for="wine_degree">度数：</label>
											</th>
												<td >  
												<input type="text" size="30" value="{$product.wine_degree}" id="wine_degree" name="wine_degree" tabindex="11" /> %
								            </td> 
                                             <th scope="row">
												<label for="wine_decant">醒酒时间：</label>
											</th>
												<td >  
												<input type="text" size="30" value="{$product.wine_decant}" id="wine_decant" name="wine_decant"  tabindex="11"  /> 
								            </td> 
                                        </tr> 
                                        
                                         <tr>    
								             <th scope="row">
												<label for="wine_temp">饮酒温度：</label>
											</th>
												<td >  
												<input type="text" size="30" value="{$product.wine_temp}" id="wine_temp" name="wine_temp" tabindex="11" />  
								            </td> 
                                             <th scope="row">
												<label for="wine_shelf_life">红酒保质期：</label>
											</th>
												<td >  
												<input type="text" size="30" value="{$product.wine_shelf_life}"
												 id="wine_shelf_life" name="wine_shelf_life"  tabindex="11"  />年
								            </td> 
                                        </tr> 
                                        
                                      
								        
								         
										 <tr>
											<th scope="row">
												<label for="">葡萄品种：</label>
											</th>
											<td colspan="3">  
												{foreach from=$grape_breed_array item=breed }
										 			<input type="checkbox" name="grape_breed[]" id="grape_breed_{$breed.id}"   value="{$breed.id}" />
										 				 <label for="grape_breed_{$breed.id}">{$breed.name} &nbsp; </label>
										 	 	{/foreach}
											 
								            </td> 
										</tr>
										
										 <tr>
											<th scope="row">
												<label for="">葡萄品种描述：</label>
											</th>
											<td colspan="3">  
												  <input name="wine_grape_desc" tabindex="13" value="{$product.wine_grape_desc}" style="width:400px;"></input>
												   （eg.10% 颂维翁,60% 梅罗特,30% 弗朗克）
								            </td> 
										</tr>
										
										 <tr>
											<th scope="row">
												<label for="">搜索类型：</label>
											</th>
											<td colspan="3">  
												{foreach from=$wine_mode_array item=wine_mode }
										 			<input type="checkbox" name="wine_mode[]" id="wine_mode_{$wine_mode.id}"  value="{$wine_mode.id}" />
										 				 <label for="wine_mode_{$wine_mode.id}">{$wine_mode.name} &nbsp; </label>
										 	 	{/foreach}
											 
								            </td> 
										</tr>
										
										  <tr>
                                        <th scope="row">
												<label for="wine_first_taste">初品口感</label>
											</th>
											<td colspan="3">  
												{foreach from=$wine_taste_array item=taste_mode }
										 			<input type="radio" name="wine_first_taste"
										 				 id="wine_first_taste_{$taste_mode.id}"  value="{$taste_mode.id}" />
										 				 <label for="wine_first_taste_{$taste_mode.id}">{$taste_mode.name} &nbsp; </label>
										 	 	{/foreach}
								            </td> 
								         </tr>
								         
								            <tr>
                                        <th scope="row">
												<label for="wine_taste">红酒味道：</label>
											</th>
											<td colspan="3">  
												<input type="text" size="30" value="{$product.wine_taste}" id="wine_taste"
													 name="wine_taste" style="width:400px;" tabindex="14" />  
								            </td> 
								         </tr>
								         
										  <tr>
                                        <th scope="row">
												<label for="wine_first_match">首选美食搭配</label>
											</th>
											<td colspan="3">  
												{foreach from=$wine_match_array item=match_mode }
										 			<input type="checkbox" name="wine_first_match[]"
										 				 id="wine_first_match_{$match_mode.id}"  value="{$match_mode.id}" />
										 				 <label for="wine_first_match_{$match_mode.id}">{$match_mode.name} &nbsp; </label>
										 	 	{/foreach}
								            </td> 
								         </tr>
								         
										 <tr>
                                        <th scope="row">
												<label for="wine_match_food">搭配菜肴：</label>
											</th>
											<td colspan="3">  
												<input type="text" size="30" value="{$product.wine_match_food}" id="wine_match_food"
													 name="wine_match_food" style="width:400px;" tabindex="15" />  
								            </td> 
								         </tr>
								            
								            
										 <tr>
											<th scope="row">
												<label for="">产品标签：</label>
											</th>
											<td colspan="7">  
												  <textarea name="tags" tabindex="16" cols="60" rows="2">{$product.tags}</textarea>
												   多个标签请用英文逗号分开。 
								            </td> 
										</tr>
										
										
									</tbody>
								</table>
							</div>
							
							
							
							<div id="postcustom-sortables" class="meta-box-sortables ui-sortable">
								<div id="postexcerpt" class="postbox">
									<div title="显示/隐藏" class="handlediv"><br></div>
									<h3 class="hndle"><span>产品属性</span></h3>
									<div class="inside">
										<div id="postcustomstuff">
											<table id="list-table">
												<thead>
													<tr>
														<th class="left">名称</th>
														<th>值</th>
														<th>操作</th>
													</tr>
												</thead>
												<tbody class="list:meta" id="the-list">
													{foreach from=$meta_list item=meta}
													<tr id="meta-{$meta.id}">
														<td class="left">
															<label for="meta_key_{$meta.id}" class="screen-reader-text">键</label>
															<input type="text" value="{$meta.feature.featurename}" size="10" readonly="readonly" id="meta_title_{$meta.id}" name="meta_title_{$meta.id}" />
															<input type="hidden" value="{$meta.name}" id="meta_key_{$meta.id}" name="meta_key_{$meta.id}" /> 
														</td>
														<td>
																<input type="text"  id="meta_value_{$meta.id}" name="meta_value_{$meta.id}" value="{$meta.value}" />
																<!--	<textarea cols="20" rows="2" id="meta_value_{$meta.id}" name="meta_value_{$meta.id}">{$meta.value}</textarea> -->
														</td>
														<td>
																<input type="button" class="deletemeta" value="删除" name="{$meta.id}" style="width:80px;"/>
																<input type="button" class="updatemeta" value="更新" name="{$meta.id}" style="width:80px;"/>
														</td>
													</tr>
													{/foreach}
													</tbody>
												</table>
											 
											<table id="newmeta"> 

												<tbody>
													<tr>
														<td class="left" id="newmetaleft">
															<select  name="metakeyselect" id="metakeyselect" gtbfieldid="122">
																<option value="#NONE#">- 选择新增产品属性 -</option>
																{foreach from=$features_list item=feature}
																<option value="{$feature.featurekey}" name="{$feature.id}">{$feature.featurename}</option>
																{/foreach}
															</select>
														</td>
														<td>
																					<input type="text"  name="metavalue"  id="metavalue" value="" />
														<!--	<textarea cols="20" rows="2" name="metavalue" id="metavalue"></textarea> -->
														</td>
															<td>
															<input type="button" value="添加产品属性"   class="addnewmeta" name="addmeta" id="addmetasub">
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										
									</div>
									
								</div>
								
							</div>
							
							{if $edit_mode eq 'edit'}
							<div id="picturediv-stuff" class="postbox ">
								<div title="显示/隐藏" class="handlediv"><br></div>
								<h3 class="hndle">
									<span>产品照片</span>
								</h3>
								
								<div class="inside">
									<p class="howto">
									  <label id="uploadify_assets">Select Files</label>图例说明：标正(正面大图)、标细1(第一张细节图片)、 标细2(第二张细节图片) 刷新有效，后续优化。   
										<div id="product-photos" class="tagsdiv"></div>
									</p>
									
									<div id="uploadify_goods_result">
										<ul class="goods-pic">
										{foreach from=$asset_list item=a}
										<li id="asset_{$a.id}" class="{if $a.parent_type eq 4}red{elseif $a.parent_type eq 5}green{elseif $a.parent_type eq 7}blue{/if}">
										<!--
										   <a href="/app/admin/article/insert_asset/asset_id/{$a.id}#insert_asset" class="jq_a_ajax">
										-->
										 <a href="{$a.water_image}" target="_blank">
												<img src="{$a.water_image}" width="120" height="90" name="{$a.id}" class="art_ast" />
											</a>
											<div class="row-actions">
												<span>尺寸: {$a.width}x{$a.height}px</span>
												[<a href="/app/admin/asset/assign_thumb?id={$a.id}&parent_type=4" class="jq_a_ajax">标正</a>]  
												[<a href="/app/admin/asset/assign_thumb?id={$a.id}&parent_type=5&position=1" class="jq_a_ajax">标细1</a>] 
												[<a href="/app/admin/asset/assign_thumb?id={$a.id}&parent_type=5&position=2" class="jq_a_ajax">标细2</a>] 
												[<a href="/app/admin/asset/assign_thumb?id={$a.id}&parent_type=5&position=3" class="jq_a_ajax">标细3</a>] 
												<!--
												[<a href="/app/admin/asset/assign_thumb?id={$a.id}&parent_type=7" class="jq_a_ajax">标内</a>] 
												-->
												[<a href="/app/admin/asset/delete?id={$a.id}" class="jq_a_ajax">删除</a>]
											</div>
										</li>
										{/foreach}
										</ul>
										<div class="clear"></div>
									</div>
									<script type="text/javascript" src="/js/a/upload_photo.js"></script>
								</div>
							</div>
							{/if}
															
															
							<div id="postdivrich" class="meta-box-sortables ui-sortable">
								<div id="editorcontainer" class="postbox">
									<div title="显示/隐藏" class="handlediv"><br></div>
									<h3 class="hndle"><span>产品介绍</span></h3>
									<script type="text/javascript" src="/js/a/init_tiny.js"></script>
									<div class="inside">
										<label for="content" class="screen-reader-text">产品介绍</label>
										<textarea id="content" name="content" class="xheditor" rows="12" cols="80" style="width: 80%">{$product.content|stripslashes}</textarea>
									 
									</div>
								</div>
							</div>
							
							<div id="normal-sortables" class="meta-box-sortables ui-sortable">
								<div id="postexcerpt" class="postbox">
									<div title="显示/隐藏" class="handlediv"><br></div>
									<h3 class="hndle"><span>产品摘要</span></h3>
									<div class="inside">
										<label for="excerpt" class="screen-reader-text">摘要</label>
										<textarea id="excerpt" tabindex="19" name="summary" cols="40" rows="1">{$product.summary}</textarea>
										<p>摘要是您可以手动添加的内容概要。</p>
									</div>
								</div> 
							</div>
							<!-- 
							<div id="tagsdiv-post_tag" class="postbox ">
								<div title="显示/隐藏" class="handlediv"><br></div>
								<h3 class="hndle"> 	<span>产品标签</span> 	</h3> 
								<div class="inside">
									<div id="post_tag" class="tagsdiv">
										<div class="jaxtag"> 
											<div class="ajaxtag hide-if-no-js">
												<textarea name="tags" tabindex="15" cols="40" rows="2">{$product.tags}</textarea>
											</div>
										</div>
										<p class="howto">多个标签请用英文逗号分开。</p>
										<div class="tagchecklist"></div>
									</div>
									<p class="hide-if-no-js">
										<a id="link-post_tag" class="tagcloud-link" href="#titlediv">从 产品标签 中选择使用最频繁的标签</a>
									</p>
								</div> 
							</div> 
							 -->
									
						</div>
					 	 <p class="submit" style="text-align:center">
								 <input type="submit" value=" 确认提交 " name="submit" class="button"  id="submit_product" />
							 </p> 
					<div class="clear"></div>
				</div>
			</form>
		</div>
		
	</div>

</div><!--endwrap-->
<script type="text/javascript" > 
		 $("#store_id option[value='{$product.store_id}']").attr("selected","selected");										 
		 $("#category_id option[value='{$product.category_id}']").attr("selected","selected"); 
		 $("#wine_country option[value='{$product.wine_country}']").attr("selected","selected");
		 changeCountry();
		 $("#wine_area option[value='{$product.wine_area}']").attr("selected","selected"); 
		 $("#wine_level option[value='{$product.wine_level}']").attr("selected","selected");
		
		 $("#wine_sugar option[value='{$product.wine_sugar}']").attr("selected","selected"); 
		 $("#wine_year option[value='{$product.wine_year}']").attr("selected","selected"); 
		 $("#wine_occasion option[value='{$product.wine_occasion}']").attr("selected","selected"); 
		 $("#wine_craft option[value='{$product.wine_craft}']").attr("selected","selected"); 
		 $("#wine_first_taste_{$product.wine_first_taste}").attr("checked",true);
		 {foreach from=$grape_breed_sel_array item=sbreed} 	$("#grape_breed_{$sbreed}").attr("checked",true); {/foreach}
		 {foreach from=$wine_match_sel_array item=sitem} 	$("#wine_first_match_{$sitem}").attr("checked",true); {/foreach}	 
		 {foreach from=$wine_mode_sel_array item=sitem} 	$("#wine_mode_{$sitem}").attr("checked",true); {/foreach}
		 updateCatChange();
</script>
</body>
</html>