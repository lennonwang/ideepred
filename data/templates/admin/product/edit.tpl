<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
	<script type="text/javascript" src="/js/uploadify/swfobject.js"></script>
	<script type="text/javascript" src="/js/uploadify/jquery.uploadify.v2.1.0.js"></script>
	<script type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="/js/a/product_edit.js"></script>
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
					<div id="side-info-column" class="inner-sidebar">
						<div id="side-sortables" class="meta-box-sortables ui-sortable">
							<div id="submitdiv" class="postbox">
								<div title="显示/隐藏" class="handlediv"><br></div>
								<h3 class="hndle">
									<span>发布</span>
								</h3>
								<div class="inside">
									
									<div id="major-publishing-actions">
										<p>
											<label>产品状态</label>
											<input type="radio" name="state" value="0" {if $product.state eq 0}checked="checked"{/if} />默 认 
											<input type="radio" name="state" value="2" {if $product.state eq 2}checked="checked"{/if} />展 示 
											<input type="radio" name="state" value="1" {if $product.state eq 1}checked="checked"{/if} />上 架 
											<input type="radio" name="state" value="-1" {if $product.state eq -1}checked="checked"{/if} />下 架 		</p>
										<p>
											<label>是否推荐</label>
											<input type="radio" name="stick" value="1" {if $product.stick eq 1}checked="checked"{/if} />推荐 
											<input type="radio" name="stick" value="0" {if $product.stick eq 0}checked="checked"{/if} />不推荐 
										</p>
										<p>
											<label>是否为赠品</label>
											<input type="radio" name="is_gift" value="1" {if $product.is_gift eq 1}checked="checked"{/if} />是  
											<input type="radio" name="is_gift" value="0" {if $product.is_gift eq 0}checked="checked"{/if} />否
										</p>
										<p class="submit">
											<input type="submit" value=" 确认提交 " name="submit" class="button"  id="submit_product" />
										</p>
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
									<p class="howto">图例说明：标正(正面大图)、标细(细节图片)、标内(内容图片)。</p>
									<div id="product-photos" class="tagsdiv">
										<label id="uploadify_assets">Select Files</label>
									</div>
									
									<div id="uploadify_goods_result">
										<ul class="goods-pic">
										{foreach from=$asset_list item=a}
										<li id="asset_{$a.id}" class="{if $a.parent_type eq 4}red{elseif $a.parent_type eq 5}green{elseif $a.parent_type eq 7}blue{/if}">
											<a href="/app/admin/article/insert_asset/asset_id/{$a.id}#insert_asset" class="jq_a_ajax">
												<img src="{$a.water_image}" width="120" height="90" name="{$a.id}" class="art_ast" />
											</a>
											<div class="row-actions">
												<span>尺寸: {$a.width}x{$a.height}px</span>
												[<a href="/app/admin/asset/assign_thumb?id={$a.id}&parent_type=4" class="jq_a_ajax">标正</a>] [<a href="/app/admin/asset/assign_thumb?id={$a.id}&parent_type=5" class="jq_a_ajax">标细</a>] [<a href="/app/admin/asset/assign_thumb?id={$a.id}&parent_type=7" class="jq_a_ajax">标内</a>] [<a href="/app/admin/asset/delete?id={$a.id}" class="jq_a_ajax">删除</a>]
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
							
							<div id="tagsdiv-post_tag" class="postbox ">
								<div title="显示/隐藏" class="handlediv"><br></div>
								<h3 class="hndle">
									<span>产品标签</span>
								</h3>
								
								<div class="inside">
									<div id="post_tag" class="tagsdiv">
										<div class="jaxtag">

											<div class="ajaxtag hide-if-no-js">
												<textarea name="tags" tabindex="15" cols="25" rows="5">{$product.tags}</textarea>
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
							
							<div class="postbox " id="categorydiv">
								<div title="显示/隐藏" class="handlediv"><br></div>
								<h3 class="hndle"><span>分类目录</span></h3>
								<div class="inside">
									<ul id="category-tabs">
										<li class="tabs">
											<a tabindex="16" href="#categories-all">全部分类目录</a>
										</li>
									</ul>

									<div class="tabs-panel" id="categories-all">
										
										<div class="site_node_list">
											{foreach from=$all_category item=cate}
											<span class="{$cate.classname}"> <input type="checkbox" name="catcode" value="{$cate.id}" {if $product.catcode eq $cate.code}checked="checked"{/if} /> <strong> {$cate.name}  --  {$cate.code} </strong> </span>
											{/foreach}
										</div>
										
									</div>

									<div class="wp-hidden-children" id="category-adder">
										<h4><a class="hide-if-no-js" href="/app/admin/category/edit" id="category-add-toggle">+ 添加分类目录</a></h4>
									</div>
									
								</div>
							</div>
							
							<div class="postbox " id="storediv">
								<div title="显示/隐藏" class="handlediv"><br></div>
								<h3 class="hndle"><span>所属品牌</span></h3>
								<div class="inside">
									<ul id="store-tabs">
										<li class="tabs">
											<a tabindex="17" href="#store-all">全部品牌</a>
										</li>
									</ul>

									<div class="tabs-panel" id="store-all">
										
										<div class="site_node_list">
											{foreach from=$all_store item=store}
											<span> <input type="radio" name="category_id" value="{$store.id}" {if $product.category_id eq $store.id}checked="checked"{/if} /> <strong> {$store.title}</strong> </span>
											{/foreach}
										</div>
										
									</div>

									<div class="wp-hidden-children" id="store-adder">
										<h4><a class="hide-if-no-js" href="/app/admin/store/edit" >+ 添加品牌</a></h4>
									</div>
									
								</div>
							</div>
							
						</div>
					</div>
					<div id="post-body">
						<div id="post-body-content">
							
							<div id="titlediv">
								<div id="titlewrap">
									<label for="title">产品标题：</label>
									<input type="text"  id="title" value="{$product.title}" tabindex="1" size="30" name="title">
								</div>
							</div>
							
							<div class="productNumber">
								<table class="form-table">
									<tbody>
										<tr class="form-field form-required">
											<th scope="row">
												<label for="retail_price">进货价格：</label>
											</th>
											<td>
												<input type="text" size="40" value="{$product.retail_price}" id="retail_price" name="retail_price" tabindex="2" /> 
								            </td>
											<th scope="row">
												<label for="market_price">市场价格：</label>
											</th>
											<td>
												<input type="text" size="40" value="{$product.market_price}" id="market_price" name="market_price" tabindex="3" /> 
								            </td>
											<th scope="row">
												<label for="sale_price">优惠价格：</label>
											</th>
											<td>
												<input type="text" size="40" value="{$product.sale_price}" id="sale_price" name="sale_price" tabindex="4" />
								            </td>
											<th scope="row">
												<label for="member_price">会员价格：</label>
											</th>
											<td>
												<input type="text" size="40" value="{$product.member_price}" id="member_price" name="member_price" tabindex="5" />
								            </td>
											
										</tr>
										<tr class="form-field form-required">
											<th scope="row">
												<label for="material">产品材质：</label>
											</th>
											<td>
												<input type="text" size="40" value="{$product.material}" id="material" name="material" tabindex="6" />
								            </td>
											<th scope="row">
												<label for="mode">产品型号：</label>
											</th>
											<td>
												<input type="text" size="40" value="{$product.mode}" id="mode" name="mode" tabindex="6" />
								            </td>
											<th scope="row">
												<label for="color">产品颜色：</label>
											</th>
											<td>
												<input type="text" size="40" value="{$product.color}" id="color" name="color" tabindex="7" />
								            </td>
											<th scope="row">
												<label for="hot_price">特 价：</label>
											</th>
											<td>
												<input type="text" size="40" value="{$product.hot_price}" id="hot_price" name="hot_price" tabindex="8" />
								            </td>
										</tr>
										<tr class="form-field form-required">
											<th scope="row">
												<label for="unit">产品单位：</label>
											</th>
											<td>
												<input type="text" size="40" value="{$product.unit}" id="unit" name="unit" tabindex="9" /> 
								            </td>
											<th scope="row">
												<label for="length">产品长度：</label>
											</th>
											<td>
												<input type="text" size="40" value="{$product.length}" id="length" name="length" tabindex="10" />
								            </td>
											<th scope="row">
												<label for="width">产品宽度：</label>
											</th>
											<td>
												<input type="text" size="40" value="{$product.width}" id="width" name="width" tabindex="11" />
								            </td>
											<th scope="row">
												<label for="height">产品高度：</label>
											</th>
											<td>
												<input type="text" size="40" value="{$product.height}" id="height" name="height" tabindex="12" />
								            </td>
										</tr>
									</tbody>
								</table>
							</div>
							
							<div id="postdivrich" class="meta-box-sortables ui-sortable">
								<div id="editorcontainer" class="postbox">
									<div title="显示/隐藏" class="handlediv"><br></div>
									<h3 class="hndle"><span>产品介绍</span></h3>
									<script type="text/javascript" src="/js/a/init_tiny.js"></script>
									<div class="inside">
										<label for="content" class="screen-reader-text">产品介绍</label>
										<textarea id="cbody" tabindex="13" name="content" cols="10" rows="15" >{$product.content|stripslashes}</textarea>
									</div>
								</div>
							</div>
							
							<div id="normal-sortables" class="meta-box-sortables ui-sortable">
								<div id="postexcerpt" class="postbox">
									<div title="显示/隐藏" class="handlediv"><br></div>
									<h3 class="hndle"><span>产品摘要</span></h3>
									<div class="inside">
										<label for="excerpt" class="screen-reader-text">摘要</label>
										<textarea id="excerpt" tabindex="14" name="summary" cols="40" rows="1">{$product.summary}</textarea>
										<p>摘要是您可以手动添加的内容概要。</p>
									</div>
								</div>
								
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
													</tr>
												</thead>
												<tbody class="list:meta" id="the-list">
													{foreach from=$meta_list item=meta}
													<tr id="meta-{$meta.id}">
														<td class="left">
															<label for="meta_key_{$meta.id}" class="screen-reader-text">键</label>
															<input type="text" value="{$meta.feature.featurename}" size="20" id="meta_title_{$meta.id}" name="meta_title_{$meta.id}" />
															<input type="hidden" value="{$meta.name}" id="meta_key_{$meta.id}" name="meta_key_{$meta.id}" />
															<div class="submit">
																<input type="button" value="删除" class="deletemeta" name="{$meta.id}" />
																<input type="button" class="updatemeta" value="更新" name="{$meta.id}" />
															</div>
														</td>
														<td>
															<textarea cols="30" rows="2" id="meta_value_{$meta.id}" name="meta_value_{$meta.id}">{$meta.value}</textarea>
														</td>
													</tr>
													{/foreach}
													</tbody>
												</table>
											<p><strong>添加新产品属性：</strong></p>
											<table id="newmeta">
												<thead>
													<tr>
														<th class="left"><label for="metakeyselect">名称</label></th>
														<th><label for="metavalue">值</label></th>
													</tr>
												</thead>

												<tbody>
													<tr>
														<td class="left" id="newmetaleft">
															<select tabindex="8" name="metakeyselect" id="metakeyselect" gtbfieldid="122">
																<option value="#NONE#">- 选择 -</option>
																{foreach from=$features_list item=feature}
																<option value="{$feature.featurekey}" name="{$feature.id}">{$feature.featurename}</option>
																{/foreach}
															</select>
														</td>
														<td>
															<textarea cols="25" rows="2" name="metavalue" id="metavalue"></textarea>
														</td>
													</tr>

													<tr>
														<td class="submit" colspan="2">
															<input type="button" value="添加产品属性" tabindex="9" class="addnewmeta" name="addmeta" id="addmetasub">
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										
									</div>
									
								</div>
								
							</div>
									
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</form>
		</div>
		
	</div>

</div><!--endwrap-->
</body>
</html>