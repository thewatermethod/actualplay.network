<?php 



function apn_home_css() { ?>
    
    <style>
    body.home div.site main.site-main article:not(.category-podcast) {
	    background: #F5F5F5;
    }

    article {
        margin: 0 0 1em 0;
        padding: 1em 0;
    }

    @media(min-width:1400px) and (min-height: 900px){
        @supports(display:grid){
            header.site-header{
                background-image: url( '<?php echo get_template_directory_uri(); ?>/assets/graph.svg');
            }
        <?php            

           // if ( false === ( $compiled_home_css = get_transient( 'compiled_home_css' ) ) ) {
                require  get_template_directory() . "/vendor/autoload.php";
                $less = new lessc;                 
                $compiled_home_css = $less->compileFile( get_template_directory(). "/assets/home.less" );                
                set_transient( 'compiled_home_css', $compiled_home_css, 24 * HOUR_IN_SECONDS );
        //    }                  

            echo $compiled_home_css;

        ?>
        }    
    }
    </style>
    <?php
}
