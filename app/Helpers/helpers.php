<?php

  if (!function_exists('clean_html')) {
      function clean_html($html)
      {
          return strip_tags($html, '<p><a><ul><ol><li><h1><h2><h3><h4><strong><em><br><img>');
      }
}