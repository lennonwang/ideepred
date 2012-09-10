 
    <!-- S category -->
    <div class="proCategory">
    	<ul>
      	<li><b>产　地：</b>
      	 <a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=0 high_price=0
						 country="" grape_breed=$grape_breed query=$query}" {if $country eq ""} class="on"{/if}>不限国家</a> 
						{foreach from=$wine_country_array item=country_item } 
						 | <a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=0 high_price=0 
							country=$country_item.id grape_breed=$grape_breed query=$query}" {if $country_item.id eq $country} class="on"{/if}>{$country_item.name}</a>
						{/foreach}
      	  </li>
        <li><b>类　型：</b> 
        			<a href="{Common_Smarty_Url_format key=search_list catcode="" page=1 style=$style orderby=1 low_price=0 high_price=0 
							country=$country grape_breed=$grape_breed query=$query}" {if $catcode eq ""} class="on"{/if}>全部类型</a> 
					{foreach from=$all_category item=cate} 
					 | <a href="{Common_Smarty_Url_format key=search_list catcode=$cate.code page=1 style=$style orderby=1 low_price=0 high_price=0 
							country=$country grape_breed=$grape_breed query=$query}" {if $cate.code eq $catcode} class="on"{/if}>{$cate.name}</a>
					{/foreach}  </li>
					
		<li><b>价　格：</b><a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=0 high_price=0 
						country=$country grape_breed=$grape_breed query=$query}" {if $high_price eq 0}class="on"{/if}>不限价格</a>
						 | <a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=0 high_price=100
						 country=$country grape_breed=$grape_breed query=$query}" {if ($high_price <= 100) && ($high_price gt 0)}class="on"{/if}>0元-100元</a>
						 | <a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=101 high_price=200
						 country=$country grape_breed=$grape_breed query=$query}" {if ($high_price <= 200) && ($high_price gt 101)}class="on"{/if}>101元-200元</a>
						 | <a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=201 high_price=300
						 country=$country grape_breed=$grape_breed query=$query}" {if ($high_price <= 300) && ($high_price gt 201)}class="on"{/if}>201元-300元</a>
						 | <a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=201 high_price=300
						 country=$country grape_breed=$grape_breed query=$query}" {if ($high_price <= 500) && ($high_price gt 301)}class="on"{/if}>301元-500元</a>  
						 | <a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style orderby=1 low_price=0 high_price=500
						 country=$country grape_breed=$grape_breed query=$query}" {if ($high_price gt 500)}class="on"{/if}>500元以上</a>
  			</li>
  			<!--
			 <li><b>品　种：</b><a href="#">不限</a> | <a href="#">赤霞珠</a> | <a href="#">美乐</a> | <a href="#">黑皮诺</a> | <a href="#">西拉/设拉子</a> | <a href="#">马尔贝克</a> | <a href="#">内比奥罗</a> | <a href="#">歌海娜</a> | <a href="#">霞多丽</a> | <a href="#">雷司令</a> | <a href="#">长相思</a></li>
			 --> 
			  <li class="cateSearch">
			  	 <form name="filter-price" method="post" action="/app/eshop/mall/search">
						<input type="hidden" name="catcode" value="{$catcode}" />
						<input type="hidden" name="style" value="{$style}" /> 
						<input type="hidden" name="country" value="{$country}" />
						<input type="hidden" name="grape_breed" value="{$grape_breed}" />
						<input type="hidden" name="orderby" value="{$orderby}" /> 
						<input type="hidden" name="orderSeq" value="{$orderSeq}" />  
						<input type="hidden" name="style" value="{$style}" /> 
				<b>关键词：</b><i class="txt"><input type="text" name="query" value="{if $query}{$query}{else}{/if}"/></i><button type="submit" class="btn"><b>搜 索</b></button></form></li>
 
					
			</ul>
		</div>
    <!-- E category -->
    
    
    <div class="sortList" id="sortList">
    	<ul>  
    	{foreach from=$order_by_array item=order_by_item } 
			<li  {if $orderby==$order_by_item.id} class="on" {/if}>
	      	 {if  $orderby == $order_by_item.id && $orderSeq!=2}
	      		<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style
	      		 orderby=$order_by_item.id low_price=0 high_price=0 country=$country grape_breed=$grape_breed  query=$query orderSeq=2}" data="sell"> 
	      	 {else}
	      	 <a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style
	      		 orderby=$order_by_item.id low_price=0 high_price=0 country=$country grape_breed=$grape_breed  query=$query orderSeq=1}" data="sell">  
	      	 {/if}  
      	 <i class="ii  {if  $orderby == $order_by_item.id && $orderSeq==2 }i02{/if}"></i>{$order_by_item.name}</a></li>  
		{/foreach}
		<!--
    	 <li  {if $orderby==1} class="on" {/if}>
      	 {if  $orderby == 1 && $orderSeq!=2}
      		<a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style
      		 orderby=1 low_price=0 high_price=0 country=$country grape_breed=$grape_breed  query=$query orderSeq=2}" data="sell"> 
      	 {else}
      	 <a href="{Common_Smarty_Url_format key=search_list catcode=$catcode page=1 style=$style
      		 orderby=1 low_price=0 high_price=0 country=$country grape_breed=$grape_breed  query=$query orderSeq=1}" data="sell">  
      	 {/if}  
      	 <i class="ii  {if  $orderby == 1 && $orderSeq==2 }i02{/if}"></i>上架</a></li> 
      		-->
      	  
      </ul>
    </div>
    