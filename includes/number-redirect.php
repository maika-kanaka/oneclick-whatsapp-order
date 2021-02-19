<?php
/**
 * Code by: Jean Livino (jeanlivino)
 * Source: https://github.com/jeanlivino/whatsapp-redirect-wordpress-plugin
 * Since version 1.0.1, we no longer need this
 */
// meta fields
$phone = get_post_meta( get_the_ID(), 'wa_order_phone_number_input', true );
$phone = intval($phone);

// Fix Api Whatsapp on Desktops
$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
// check if is a mobile
if ($iphone || $android || $palmpre || $ipod || $berry == true)
{
  header('Location: whatsapp://send?phone='. $phone .'');
  //OR
  echo "<script>window.location='whatsapp://send?phone='. $phone .'</script>";
}
// all others
else {
  header('Location: https://web.whatsapp.com/send?phone='. $phone .'');
  //OR
  echo "<script>window.location='https://web.whatsapp.com/send?phone='. $phone .'</script>";
}
	?>