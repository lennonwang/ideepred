 <div class="ap apCategory">
     <!--  <h5 class="apT">全部分类</h5> --> 
        <div class="apB">    
          {foreach from=$category_channel item=chk name=cha}
          	{if $chk.children}
		 	 <div class="treeDad"> 
			<a href="{Common_Smarty_Url_format key=channel slug=$chk.slug}" title="{$chk.name}"  >
			 {$chk.name}  </a> 
			</div> 
				<ul class="secTabs">
				{foreach from=$chk.children item=category name=cate}
					<li  >
						<a href="{Common_Smarty_Url_format key=category_list catcode=$category.code}"  	title="{$category.name}" 
						{if $current_category.code eq $category.code}class="on"{/if}
						{if $product.catcode eq $category.code}class="on"{/if} >
							 {$category.name}  
						</a>
					</li>
				{/foreach}
					<div class="clear"></div>
				</ul>
			{/if}
			
		</li>
		{/foreach}
	  </div>
 </div>

 <!-- 分类 end -->