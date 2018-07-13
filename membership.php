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

    $membership_status = get_user_meta( $user->ID, '_membership', true);
    $membership = "0";

    if( $membership_status ) {
      $membership = "1";
    }

  ?>

  <style>
body,
button,
input,
select,
textarea {
  color: #404040;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial,
    sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
  font-size: 1em;
  line-height: 1.5;
}

body {
  background: #f1f1f1;
  margin: 0;
}

h1,
h2,
h3,
h4,
h5,
h6,
.site-title {
  font-family: Tahoma, -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica,
    Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
}

.page-title {
  text-align: center;
}

.flex-box {
  display: flex;
}

.flex-box.space-around {
  justify-content: space-around;
}

.bg-black,
.bg-black a {
  background: black;
  color: #fff9f4;
}

.bg-white {
  background: white;
  color: #333;
}

.inner {
  margin: auto;
  max-width: 650px;
}

.space {
  margin-top: 3em;
}

.card {
  box-shadow: 1px 1px 1px #333;
  border: 1px solid black;
  background: white;
  padding: 1em;
  margin-top: 1em;
}

.no-border {
  border: 0;
}


  </style>

  <script>

      var homeUrl = "<?php echo home_url(); ?>";
      var adminUrl = "<?php echo admin_url(); ?>";

  </script>

 </head>

  <body>  

    <div id="root" data-user="<?php echo $membership ?>"></div>

    <?php wp_nonce_field( 'membership-nonce', 'membership-nonce' ); ?>

    <?php wp_footer(); ?>

  </body>

</html>