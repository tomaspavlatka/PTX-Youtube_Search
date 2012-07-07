<?php
// Constants.
define('YOUTUBE_VERSION',2);

/**
* Debug.
* 
* alias for debug function.
* @param mixed $data - data to be fixed
*/
function ptx_debug($data) {
    echo '<pre>';
        print_r($data);
    echo '</pre>';
}

/**
* Duration.
* 
* shows duration in human form
* @param integer $duration - duration in seconds
* @param string $empty_text - what to show in case there's no duration
* @param string hunam form of duration
*/
function ptx_duration($duration, $empty_text = '0:00') {
    if($duration > 0) {
        $seconds = $duration % 60;
        $minutes = (int)($duration / 60);
        $hours = (int)($duration/(60*60));        

        $duration_text = null;
        if(!empty($hours)) {
            $duration_text .= (int)$hours.':';
        }

        if(!empty($minutes)) {
            $duration_text .= (int)$minutes.':';
        } else {
            $duration_text .= '0:';
        }

        if(!empty($seconds)) {
            $duration_text .= sprintf('%02d',$seconds);
        }
    } else {
        $duration_text = $empty_text;
    }

    // Return results.
    return (string)$duration_text;
}

/**
* Escape.
* 
* escapes string.
* @param string $string - string to be escaped
* @return escaped string
*/
function ptx_escape($string) {
    $escaped_string = trim(htmlspecialchars($string));

    // Return it.
    return (string)$escaped_string;
}

/**
* Find Video.
* 
* finds video based on the keywrods
* @param string $keywords
* @param integer $page
*/
function ptx_find_videos($keywords, $page = 1, $maximum_results = 10, $orderBy = 'relevance', $save_search = 'none') {
    global $yt;

    // Prepare query.
    $query = $yt->newVideoQuery();
    $query->setOrderBy($orderBy);
    $query->setSafeSearch($save_search);
    $query->setMaxResults($maximum_results);
    $query->setVideoQuery($keywords);
    
    // Offset
    $offset = (int)(($page-1)*$maximum_results);
    $query->setStartIndex($offset);

    // Find video.
    $video_feed = $yt->getVideoFeed($query->getQueryUrl(YOUTUBE_VERSION));

    // Return results.
    return $video_feed;
}

/**
* Video Paginator.
* 
* shows paginator for video.
*/
function ptx_video_paginator_url(array $data, $page) {
    // Build link from data
    $link = '/';
    if(!empty($data)) {
        foreach($data as $key => $value) {
            if($key != 'page') {
                $link .= ($link == '/') ? '?' : '&amp;';
                $link .= $key.'='.urlencode($value); 
            }
        }
    }

    // Add info about page.
    $link .= ($link == '/') ? '?' : '&amp;';
    $link .= 'page='.(int)$page; 

    return (string)$link;
}

/**
 * Wrap words.
 * 
 * wraps words
 * @param string $string - original string
 * @param integer $count - how many words do we want
 * @param boolean $escape - whether string should be escaped
 * @return string with requested number of words
 */
function ptx_wrap_words($string,$count, $escape = false) {
    // Init variable.
    $return_string = null;    
    
    // Find return string.
    if($count > 0 && !empty($string)) {
        $parse_array = explode(' ',$string);
        $count_parse_array = count($parse_array);
    
        if($count_parse_array <= $count) {
            $return_string .= $string;
        } else {
            for($i = 0; $i < $count; $i++) {
                $return_string .= $parse_array[$i].' ';   
            }
        
            $return_string .= '...';
        }
    }

    // We want to escape it as well.
    if(!empty($return_string) && $escape) {
        $return_string = ptx_escape($return_string);
    }
    
    // Default return.
    return (string)$return_string;
}    
