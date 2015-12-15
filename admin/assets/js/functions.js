jQuery(function($) {
  $("#get-posts").suggest(ajaxurl + "?action=show_posts_content", { delay: 300, minchars: 1 });

  $(".groupper-save").click(function(){
	  var post = $("#get-posts").val();
		var postTitle = post.substr(post.indexOf(' ')+3);
		var postId = parseInt(post.substr(0,post.indexOf(' ')));
		var list = $("#posts-list");
		var postPosition = $(".post-position").length + 1;

		list.children().removeClass('background-red');

		if(document.getElementById(postId) == null){
			element = $('<div id="'+postId+'"><input type="text" class="post-position" name="post_position'+postId+'" value="'+postPosition+'" size="2"><input type="hidden" name="post_id'+postId+'" value="'+postId+'" class="post-id"><span class="post-title">'+postTitle+'</span><i class="dashicons dashicons-no delete-post" id="delete-post-from-list"></i></div>');
			if (!isNaN(postId)) {
				list.append(element);
			}
			element.on("click", "i", function(){
				$(this).parent().remove();
			});
		} else {
			div = document.getElementById(postId);
			$(div).addClass('background-red');
		}
	});
	$(".delete-post").click(function () {
		$(this).parent().remove();
   });

});