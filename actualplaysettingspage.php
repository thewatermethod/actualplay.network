<?php
add_action( 'admin_menu', 'actualplay_add_admin_menu' );
add_action( 'admin_init', 'actualplay_settings_init' );


function actualplay_add_admin_menu(  ) { 

    add_options_page( 'ActualPlay.Network', 'ActualPlay.Network', 'manage_options', 'actualplay.network', 'actualplay_options_page' );

}


function actualplay_settings_init(  ) { 

    register_setting( 'pluginPage', 'actualplay_settings' );

    add_settings_section(
        'actualplay_pluginPage_section', 
        __( 'Your section description', 'actual-play' ), 
        'actualplay_settings_section_callback', 
        'pluginPage'
    );

    add_settings_field( 
        'actualplay_itunes', 
        __( 'iTunes Page Link', 'actual-play' ), 
        'actualplay_itunes_render', 
        'pluginPage', 
        'actualplay_pluginPage_section' 
    );

    add_settings_field( 
        'actualplay_stitcher', 
        __( 'Stitcher Page Link', 'actual-play' ), 
        'actualplay_stitcher_render', 
        'pluginPage', 
        'actualplay_pluginPage_section' 
    );

    add_settings_field( 
        'actualplay_soundcloud', 
        __( 'Soundcloud link', 'actual-play' ), 
        'actualplay_soundcloud_render', 
        'pluginPage', 
        'actualplay_pluginPage_section' 
    );


}


function actualplay_itunes_render(  ) { 

    $options = get_option( 'actualplay_settings' );
    ?>
    <input type='text' name='actualplay_settings[actualplay_itunes]' value='<?php echo $options['actualplay_itunes']; ?>'>
    <?php

}


function actualplay_stitcher_render(  ) { 

    $options = get_option( 'actualplay_settings' );
    ?>
    <input type='text' name='actualplay_settings[actualplay_stitcher]' value='<?php echo $options['actualplay_stitcher']; ?>'>
    <?php

}


function actualplay_soundcloud_render(  ) { 

    $options = get_option( 'actualplay_settings' );
    ?>
    <input type='text' name='actualplay_settings[actualplay_soundcloud]' value='<?php echo $options['actualplay_soundcloud']; ?>'>
    <?php

}


function actualplay_settings_section_callback(  ) { 

    echo __( 'This section description', 'actual-play' );

}


function actualplay_options_page(  ) { 

    ?>
    <form action='options.php' method='post'>

        <h2>ActualPlay.Network</h2>

        <?php
        settings_fields( 'pluginPage' );
        do_settings_sections( 'pluginPage' );
        submit_button();
        ?>

    </form>
    <?php

}

?>