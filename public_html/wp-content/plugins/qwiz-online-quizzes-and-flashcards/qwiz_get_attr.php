<?php
// -----------------------------------------------------------------------------
function qwiz_get_attr ($shortcode, $attribute) {
   $match_f = preg_match ('/' . $attribute . '\s*=\s*"([^"]+)"/', $shortcode,
                          $shortcode_matches);
   if ($match_f) {
      $attr_value = trim ($shortcode_matches[1]);
   } else {
      $attr_value = '';
   }

   return $attr_value;
}


