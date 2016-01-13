<?php

add_action( 'init', 'groupper_custom_post_types' );
function groupper_custom_post_types() {
  $labels = array(
    'name'                  => _x( 'Groupper', 'post_type_general_name' ),
    'singular_name'         => _x( 'Groupper', 'post_type_singular_name' ),
    'add_new'               => _x( 'Adicionar novo', 'integration' ),
    'add_new_item'          => __( 'Adicionar nova lista' ),
    'edit_item'             => __( 'Editar lista' ),
    'new_item'              => __( 'Nova lista' ),
    'all_items'             => __( 'Todas as listas' ),
    'view_item'             => __( 'Ver lista' ),
    'search_items'          => __( 'Procurar listas' ),
    'not_found'             => __( 'Nenhuma lista encontrada' ),
    'not_found_in_trash'    => __( 'Nenhuma lista encontrada na lixeira' ),
    'parent_item_colon'     => '',
    'menu_name'             => 'Groupper - Posts'
  );
  $args = array(
      'labels'                => $labels,
      'description'           => 'Create custom archives to WordPress posts',
      'public'                => true,
      'menu_position'         => 30,
      'supports'              => array( 'title' ),
      'has_archive'           => false,
      'exclude_from_search'   => true,
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'publicly_queryable'    => false,
      'query_var'             => false
  );
  register_post_type( 'groupper_cpt', $args );
}


add_action( 'add_meta_boxes', 'groupper_get_posts' );
function groupper_get_posts() {
  add_meta_box(
      'groupper_get_posts',
      'Posts do Blog',
      'groupper_get_posts_content',
      'groupper_cpt',
      'normal'
  );
}

function groupper_get_posts_content(){
	$posts = get_post_meta(get_the_ID(), 'groupper_get_posts', true);
	if(isset($posts[0])) unset($posts[0]);
	global $wpdb; ?>
    <p>Copie e cole este código dentro de um post: <code>[groupper id="<?php the_ID(); ?>"]</code></p>
	<input type="text" id="get-posts">
	<button type="button" id="add-post-to-list" class="button button-primary button-large groupper-save">Adicionar à lista</button>
	<h2>Lista de posts</h2>
	<div id="posts-list">
		<?php
		if ($posts) : ksort($posts);
			foreach ( $posts as $position => $post_id ) :
				$post_title = $wpdb->get_var("SELECT post_title FROM $wpdb->posts WHERE ID=$post_id");?>
				<div id="<?php echo $post_id ?>">
					<input type="text" class="post-position" name="post_position<?= $post_id ?>" value="<?= $position; ?>" size="2">
					<input type="hidden" name="post_id<?= $post_id ?>" value="<?= $post_id ?>" class="post-id">
					<span class="post-title"><?= $post_title; ?></span>
					<i class="dashicons dashicons-no delete-post" id="delete-post-from-list"></i>
				</div>
				<?php
			endforeach;
		endif; ?>
	</div>
	<?php
}

add_action('wp_ajax_show_posts_content', 'ajax_show_posts_content');
function ajax_show_posts_content() {
	$args = array( 'numberposts' => -1, 's' => $_GET['q'], 'post_type' => 'post');
	$query = new WP_Query($args);
  while ($query->have_posts()) : $query->the_post();
  	echo "<p id='ajax-post-title' class='ajax-post-title'><span id='get-post-id'>".get_the_ID()."</span> - ".get_the_title()."</p> \n";
  endwhile;
  die();
}

add_action('save_post', 'groupper_save_meta_boxes');
function groupper_save_meta_boxes(){
	$post = array();
	if(!empty($_POST)) {
		foreach($_POST as $name => $value) {
			if(strpos($name, 'post_position') === 0) {
				$post_position = $value;
		    }
		    if(strpos($name, 'post_id') === 0) {
		    	$post[$post_position] = $value;
		    }
		}
	}
	update_post_meta(get_the_ID(), 'groupper_get_posts', $post);
}

add_shortcode('groupper', 'groupper_create_shortcode');
function groupper_create_shortcode($atts){
    $a = shortcode_atts(array(
        'id' => $atts['id']
    ), $atts );

    $posts = get_post_meta( $atts['id'], 'groupper_get_posts', true );
    ksort($posts);

    foreach ($posts as $post_position => $post) :
        $post_id = (int)$post;
        $the_post = get_post($post); ?>
        <h2><a href="<?php echo post_permalink($post); ?>"><?php echo $post_position . ' - ' .$the_post->post_title; ?></h2>
    <?php endforeach;
}
?>