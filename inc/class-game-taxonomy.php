<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GameTaxonomy {	
	
    public static function init() {

        //todo - edit and save functionality - helpful link: https://www.ibenic.com/custom-fields-wordpress-taxonomies/

        // Register Game Taxonomy
        add_action('init', array( __CLASS__, 'register_taxonomy'));

        // Register Game Form Fields
        add_action( 'games_add_form_fields', array(__CLASS__, 'add_form_fields'), 10, 2 );

    }    
    
    public static function add_form_fields() {

        ?>	

        <div class="form-field">
		    <label for="game_link_url"><?php _e( 'Game URL' ); ?></label>
    		<input type="url" name="game_link_url" id="game_link_url" value="">
        </div>

        <div class="form-field">
		    <label for="game_thumb_url"><?php _e( 'Game Thumbnail URL' ); ?></label>
    		<input type="url" name="game_thumb_url" id="game_thumb_url" value="">
        </div>


        <?php
    }

    public static function register_taxonomy() {
        // create a new taxonomy
        register_taxonomy(
            'games',
            'post',
            array(
                'label' => __( 'Games' ),
                'rewrite' => array( 'slug' => 'game' ),
                'capabilities' => array(
                    'assign_terms' => 'edit_posts',
                    'edit_terms' => 'edit_posts'
                )
            )
        );
    }

}

