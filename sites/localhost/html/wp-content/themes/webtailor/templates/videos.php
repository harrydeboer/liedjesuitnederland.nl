<?php
/**
 * @var array $videos
 * @var array $filter
 */
$i = 0;
if (count($videos) > 0) {
    foreach ( $videos as $video ) {
        if ($i < 3) {
            $i++;
            if ($i == 1) {
                $c = 'l';
            } elseif ($i == 2) {
                $c = 'm';
            } else {
                $c = 'r';
            }
        } else {
            $c = '';
        } ?>
        <div class="video column col-md-4 <?php echo $c; ?>">
            <a href="<?php echo $video->getYoutubeLink(); ?>" class="video-button">
                <?php $img = get_the_post_thumbnail_url($video->getID(), 'medium_large'); ?>
                <div class="thumb" style="background-image: url('<?php echo $img; ?>');">
                    <svg class="svg-inline--fa fa-play-circle fa-3x"
                         role="img"
                         xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 512 512"
                         style="max-width:63px">
                        <path
                                fill="currentColor"
                                d="M256 504c137 0 248-111 248-248S393 8 256 8 8 119 8 256s111 248 248 248zM40 256c0-118.7 96.1-216 216-216 118.7 0 216 96.1 216 216 0 118.7-96.1 216-216 216-118.7 0-216-96.1-216-216zm331.7-18l-176-107c-15.8-8.8-35.7 2.5-35.7 21v208c0 18.4 19.8 29.8 35.7 21l176-101c16.4-9.1 16.4-32.8 0-42zM192 335.8V176.9c0-4.7 5.1-7.6 9.1-5.1l134.5 81.7c3.9 2.4 3.8 8.1-.1 10.3L201 341c-4 2.3-9-.6-9-5.2z"></path>
                    </svg>
                </div>
                <h4 class="vid-title"><?php echo $video->getName(); ?></h4>
            </a>
        </div>
        <?php
        if ($i == 3 ) {
            $i = 0;
        }
    }
} elseif (!isset($filter['offset'])) {
    echo '<p>Sorry, er zijn geen video\'s gevonden</p>';
}
