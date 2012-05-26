<replaceContent select="#cart_items_count">{$items_count}</replaceContent>
<replaceContent select="#cart_items_total">{$items_count}</replaceContent>
<replaceContent select="#items_total_money">{$total_money}</replaceContent>
<replaceContent select="#{$p.sku}_money">{$p.quantity*$p.sale_price}</replaceContent>