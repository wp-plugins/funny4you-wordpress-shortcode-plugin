<?php
/*
Plugin Name: funny4you
Plugin URI: http://www.hoerandl.com/blog/item/wordpress-funny4you
Version: 1.0
Author: Günther Hörandl
Author URI: http://www.funny4you.at/
Description: Shortcode um den "Witz des Tages" oder einen Zufallswitz zu laden
*/

/*
Anwendung / Einbaucode:

Witz des Tages: [funny4you]
Zufallswitz: [funny4you do="zufall"]

Info: mit dem Parameter "mid" können Partner (registrierte Member) ihre personalisierten Einstellungen in die Ausgabe miteinbeziehen
z.B.: [funny4you mid="12345"] oder [funny4you do="zufall" mid="12345"]
*/


/* Shortcode function */
  function funny4you_shortcode($atts) {
    extract(shortcode_atts(array(
	  'do' => '',
	  'mid' => '22',
    ), $atts));
		
	$output = '';
	
	if ($do!="zufall") { // Witz des Tages
	
      if (( @include 'http://www.funny4you.at/webmasterprogramm/include.php?servername='.$servername.'&memberid='.$mid ) &&
          ( $output .= @file_get_contents("http://www.funny4you.at/webmasterprogramm/witzdestages.php") )) {
      } else {
        $output .= "<script type=\"text/javascript\" src=\"http://www.funny4you.at/webmasterprogramm/witzdestages.js.php?servername=".$servername."&amp;memberid=".$mid."\"></script>";
        $output .= "<noscript><div class=\"funny4you\"><strong><a href=\"http://www.funny4you.at/4_webmaster/errors.html#error-07\">ERROR-07:</a></strong> JavaScript ist deaktiviert!</div></noscript>";
      }
	  
	} else { // Zufallswitz
	
      if (( @include 'http://www.funny4you.at/webmasterprogramm/include.php?servername='.$servername.'&memberid='.$mid ) &&
          ( $output = @file_get_contents("http://www.funny4you.at/webmasterprogramm/zufallswitz.php") )) {
      } else {
        $output .= "<script type=\"text/javascript\" src=\"http://www.funny4you.at/webmasterprogramm/zufallswitz.js.php?servername=".$servername."&amp;memberid=".$mid."\"></script>";
        $output .= "<noscript><div class=\"funny4you\"><strong><a href=\"http://www.funny4you.at/4_webmaster/errors.html#error-07\">ERROR-07:</a></strong> JavaScript ist deaktiviert!</div></noscript>";
		
      }
	}

    if ($output == "" ) {
      $f4y_ausgabe = "<div class=\"funny4you\"><strong><a href=\"http://www.funny4you.at/4_webmaster/errors.html#error-08\">ERROR-08:</a></strong> Es konnte leider kein Witz geladen werden!</div>";
    }

    return utf8_encode($output);

  }

/* Add Shortcode */
  add_shortcode('funny4you', 'funny4you_shortcode');

?>