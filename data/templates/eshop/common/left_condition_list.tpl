<!-- S ap cat-->
				<div class="ap subCat subCatHot">
					<div class="apT">推荐  </div>
					<div class="apB">
						<ul class="cats"> 
						{foreach from=$wine_mode_array item=each_item } 
							 <li> 
							 <a href="{Common_Smarty_Url_format key=search_list catcode='' page=1 style=$style orderby=1 low_price=0 high_price=0 
								country='' grape_breed='' query=$query  orderSeq=0 wine_mode=$each_item.id}"
								 {if $each_item.id eq $wine_mode} class="on"{/if}
								  {if $each_item.id eq 1 && $current_menu eq 'tab_index'} class="on"{/if}
								 
								   >{$each_item.name}</a>
							</li>
						{/foreach}
						<!--	<li><a href="#">本周TOP 9</a></li>
							<li><a href="">低度畅饮 (21）</a></li>
							<li><a href="">甜蜜口感 (21）</a></li>
							<li><a href="">女性最迷 (21）</a></li>
							<li><a href="">领导最爱 (21）</a></li>-->
						</ul>
					</div>
				</div>
				<!-- E ap cat-->

				<!-- S ap cat-->
				<div class="ap subCat">
					<div class="apT">类别</div>
					<div class="apB">
						<ul class="cats">
							{foreach from=$all_category item=cate} 
					 		<li><a href="{Common_Smarty_Url_format key=search_list catcode=$cate.code page=1 style=$style orderby=1 low_price=0 high_price=0 
							country='' grape_breed='' query=$query}"  {if $cate.code eq $catcode} class="on"{/if}>{$cate.name} </a>
							</li>
						{/foreach}  
						</ul>
					</div>
				</div>
				<!-- E ap cat-->

				<!-- S ap cat-->
				<div class="ap subCat">
					<div class="apT">原产地</div>
					<div class="apB">
						<ul class="cats">
						
						{foreach from=$wine_country_array item=country_item } 
						 <li> <a href="{Common_Smarty_Url_format key=search_list catcode='' page=1 style=$style orderby=1 low_price=0 high_price=0 
							country=$country_item.id grape_breed='' query=$query}" {if $country_item.id eq $country} class="on"{/if}>{$country_item.name}</a>
						</li>
						{/foreach}
						
						</ul>
					</div>
					
					<div class="apT">葡萄</div>
					<div class="apB">
						<ul class="cats">
							{foreach from=$grape_breed_array item=breed_item} 
					  <li>
					  	 <a href="{Common_Smarty_Url_format key=search_list catcode='' page=1 style=$style orderby=1 low_price=0 high_price=0 
							country='' grape_breed=$breed_item.id query=$query  wine_mode=$wine_mode}" {if $grape_breed eq $breed_item.id} class="on"{/if}>{$breed_item.name}</a>
					</li>					
					{/foreach}  
						</ul>
					</div>
					
					<div class="apT">价位</div>
					<div class="apB">
						<ul class="cats"> 
						<li> <a href="{Common_Smarty_Url_format key=search_list catcode='' page=1 style=$style orderby=1 low_price=0 high_price=0 
						country='' grape_breed='' query=$query}" 
						  {if  $current_menu ne 'tab_index'}  
						  {if $high_price eq 0} class="on"{/if} {/if} >
						   不限价格</a> </li>
						<li><a href="{Common_Smarty_Url_format key=search_list catcode='' page=1 style=$style orderby=1 low_price=0 high_price=100
						 country='' grape_breed='' query=$query}" {if ($high_price <= 100) && ($high_price gt 0)}class="on"{/if} >0元-100元</a>
						  </li>
						<li><a href="{Common_Smarty_Url_format key=search_list catcode='' page=1 style=$style orderby=1 low_price=101 high_price=200
						 country='' grape_breed='' query=$query}" {if ($high_price <= 200) && ($high_price gt 101)}class="on"{/if}>101元-200元</a>
						  </li>
						<li> <a href="{Common_Smarty_Url_format key=search_list catcode='' page=1 style=$style orderby=1 low_price=201 high_price=300
						 country='' grape_breed='' query=$query}" {if ($high_price <= 300) && ($high_price gt 201)}class="on"{/if}>201元-300元</a>
						  </li>
						  <li> <a href="{Common_Smarty_Url_format key=search_list catcode='' page=1 style=$style orderby=1 low_price=301 high_price=500
						 country='' grape_breed='' query=$query}"  {if ($high_price <= 500) && ($high_price gt 301)}class="on"{/if}>301元-500元</a>  
						  </li>
						  <li> <a href="{Common_Smarty_Url_format key=search_list catcode='' page=1 style=$style orderby=1 low_price=500 high_price=1000000
						 country='' grape_breed='' query=$query}"  {if ($high_price gt 500)}class="on"{/if}>500元以上</a>
						  </li> 
						</ul>
					</div>
					
				</div>
				<!-- E ap cat-->