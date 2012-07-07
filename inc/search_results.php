<?php
if(!defined('GRAND_ACCESS') || GRAND_ACCESS != 1) {
    exit('__Restricted Area__');
}

// Form data.
if(isset($_GET['keywords'])) {
    $keywords = $_GET['keywords'];
    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

    require_once 'Zend/Loader.php'; // the Zend dir must be in your include_path
    Zend_Loader::loadClass('Zend_Gdata_YouTube');
    $yt = new Zend_Gdata_YouTube();
    $yt->setMajorProtocolVersion(YOUTUBE_VERSION);

    $videos = ptx_find_videos($keywords,1,2);
}
?>

<?php if(isset($videos) && !empty($videos)): ?>
    <div class="container_12">
        <div class="grid_12">
            <div class="box">
                <h2>Found videos</h2>
            </div>
        </div>
        <?php $counter = 1; foreach($videos as $key => $entry): ?>
        <div class="grid_6">
            <div class="box results">
                <h3><?php echo ptx_wrap_words($entry->getVideoTitle(),8,true); ?></h3>

                <iframe id="ytplayer_<?php echo $entry->getVideoId(); ?>" width="440" height="248"
                    src="<?php echo str_replace('&','&amp;',$entry->getFlashPlayerUrl()); ?>" frameborder="0"></iframe>
                
                <div class="ts">
                    <span class="tb">Duration</span>: <?php echo ptx_duration($entry->getVideoDuration()); ?> | 
                    <span class="tb">Views</span>: <?php echo number_format($entry->getVideoViewCount(),0,'.','.'); ?>&nbsp;x
                </div>
            </div>
            <?php if($counter++ %2 == 0): ?>
                <div class="clean"></div>
            <?php endif; ?>
        </div>    
        <?php endforeach; ?>

        <!-- Complete missing one. -->
        <?php if($counter % 2 == 0): ?>
            <div class="grid_6"></div>
        <?php endif; ?>

        <!-- Paginator. -->
        <div class="grid_12">
            <div class="paginator">                
                <?php for($i = 1; $i < 6; $i++): ?>
                    <?php $extra = ($page == $i) ? 'class="active"' : null; ?>
                    <a href="<?php echo ptx_video_paginator_url($_GET,$i); ?>" <?php echo $extra; ?>><?php echo $i; ?></a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
<?php endif; ?>



