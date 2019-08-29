<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GameTaxonomy {	
	
    public static function init() {

        //todo - edit and save functionality - helpful link: https://www.ibenic.com/custom-fields-wordpress-taxonomies/

        // Register Game Taxonomy
        add_action('init', array( __CLASS__, 'register_taxonomy'));

        /** Register Game Form Fields */ 
        // for adding a new game
        add_action( 'games_add_form_fields', array(__CLASS__, 'add_form_fields'), 10, 2 );

        // for editing an existing game
        add_action( 'games_edit_form_fields', array(__CLASS__, 'edit_form_fields'), 10, 2 );

        // handle the saving of the game meta        
        add_action( 'edited_games', array(__CLASS__, 'save_game_meta' ), 10, 2);   
        add_action( 'create_games', array(__CLASS__, 'save_game_meta' ), 10, 2);

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

        
    public static function edit_form_fields( $term) {


        $id = $term->term_id;
        $game_link_url = get_term_meta( $id, 'game_link_url', true );
        $game_thumb_url = get_term_meta( $id, 'game_thumb_url', true );

    
    
    ?>	

    

        <tr class="form-field">
		    <th><label for="game_link_url"><?php _e( 'Game URL' ); ?></label></th>
		 
	    	<td>	 
		    	<input type="url" name="game_link_url" id="game_link_url" value="<?php echo esc_url( $game_link_url ); ?>">
		    </td>

	    </tr>

        <tr class="form-field">
		    <th><label for="game_thumb_url"><?php _e( 'Game Thumbnail URL' ); ?></label></th>
		 
		    <td>	 
            <input type="url" name="game_thumb_url" id="game_thumb_url" value="<?php echo esc_url( $game_thumb_url ); ?>">
		    </td>
	    </tr>       


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

    public static function save_game_meta( $term_id ) {   
        if ( isset( $_POST['game_thumb_url'] ) ) {
            $game_thumb_url = $_POST['game_thumb_url'];
            if( $game_thumb_url ) {
                 update_term_meta( $term_id, 'game_thumb_url', $game_thumb_url );
            }
        } 

        if ( isset( $_POST['game_link_url'] ) ) {
            $game_link_url = $_POST['game_link_url'];
            if( $game_link_url ) {
                 update_term_meta( $term_id, 'game_link_url', $game_link_url );
            }
        } 
    }

}

