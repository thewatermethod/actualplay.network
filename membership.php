<?php /* Template Name: Membership */?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

  <?php 
    wp_head(); 
    $user = wp_get_current_user();
    ?>

  <style>

    body,
    button,
    input,
    select,
    textarea {
      color: #404040;
      font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
      font-size: 1em;
      line-height: 1.5;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    .site-title {
      font-family: 	Tahoma, -apple-system,BlinkMacSystemFont,"Segoe UI",Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
    }

    .flex-box {
      display: flex;     
    }

  </style>

</head>

  <body>
  
  <div id="root" data-user="<?php echo $user->ID; ?>"></div>

  <?php wp_footer(); ?>

  </body>

</html>