<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Podcast_Statistics {	
	
	/*--------------------------------------------------------------------------------------
    *
    * Add Actions
    *
    *--------------------------------------------------------------------------------------*/

	public static function init() {

		// add custom post meta box
		add_action( 'add_meta_boxes_post', array( __CLASS__, 'add_custom_post_meta_box') , 10, 2 );
	}

	public static function add_custom_post_meta_box() {
		add_meta_box( 
			'episodeStatistics',
			__( 'Episode Statistics' ),
			array( __CLASS__, 'render_post_meta_box'),
			'post',
			'normal',
			'default'
        );
    }
    

    public static function render_post_meta_box(){ ?>

        <stats podcast="136666"></stats>

    <?
    }

} 