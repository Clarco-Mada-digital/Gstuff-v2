<?php

/** calculate human readable time */
if (!function_exists('timeAgo')) {
  function timeAgo($timestamp)
  {
    $timeDifference = time() - strtotime($timestamp);
    $seconds = $timeDifference;
    $minutes = round($timeDifference / 60);
    $hours = round($timeDifference / 3600);
    $days = round($timeDifference / 86400);

    if ($seconds <= 60) {
      if ($seconds <= 1) {
        return "il y a une seconde";
      }
      return "il y a " . $seconds . " secondes";
    } elseif ($minutes <= 60) {
      return "il y a " . $minutes . " minutes";
    } elseif ($hours <= 24) {
      return "il y a " . $hours . " heures";
    } else {
      return date('j M y', strtotime($timestamp));
    }
  }
}

/** truncate string */
if (!function_exists('truncate')) {
  function truncate($str, $limit = 18)
  {
    return \Str::limit($str, $limit, '...');
  }
}
