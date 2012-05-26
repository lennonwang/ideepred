<append select="#comment-box">
	<div class="item">
		<h4>{$cmt.title} on {$comment.created_on|date_format:'%Y-%m-%d'}:</h4>
		<p>{$comment.content|stripslashes}</p>
	</div>
</append>

<val select="#post-content" value='' />

<replaceContent select="#comment_count1">{$comment_count}</replaceContent>
<replaceContent select="#comment_count2">{$comment_count}</replaceContent>