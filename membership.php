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

</head>

  <body>
  
  <div id="root" data-user="<?php echo $user->ID; ?>"></div>

  <?php wp_footer(); ?>

  </body>

</html>