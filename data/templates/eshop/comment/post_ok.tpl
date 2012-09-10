<append select="#comment-box"> 
	<li> 
	    <b>{$comment.username}</b><i class="time">{$comment.created_on|date_format:'%Y-%m-%d'}:</i><span class="star star_5"></span>
		<p>{$comment.content|stripslashes}</p>
	</li>
</append>

<val select="#post-content" value='' />

<replaceContent select="#comment_count1">{$comment_count}</replaceContent>
<replaceContent select="#comment_count2">{$comment_count}</replaceContent>