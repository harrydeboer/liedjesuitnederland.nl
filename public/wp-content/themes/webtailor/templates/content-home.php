<?php

$intro_1 = get_field('intro_afbeelding'); ?>
<section id="intro" style="background-image:url('<?php echo $intro_1;?>')"><div class="overlay"></div>
    <div class="row nf">
        <h1 data-aos="fade" data-aos-duration="1500" data-aos-delay="600"><?php the_field('intro_titel');?></h1>
    </div>
</section>
<section id="uitleg">
    <div class="row nf">
        <?php the_field('uitleg'); ?>
    </div>
</section>
<?php

require_once(__DIR__ . '/filter-form.php');
?>

<section id="videos">
    <div id="all-video-results" class="row">
        <?php
        require_once(__DIR__ . '/videos.php');
        ?>
    </div>
</section>
<div id="video-container" class="pop-up-container">
    <div class="pop-up">
        <div class="closepop"><svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 512 512"><path opacity="1" fill="#ffffff" d="M256 32a224 224 0 1 1 0 448 224 224 0 1 1 0-448zm0 480A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM180.7 180.7c-6.2 6.2-6.2 16.4 0 22.6L233.4 256l-52.7 52.7c-6.2 6.2-6.2 16.4 0 22.6s16.4 6.2 22.6 0L256 278.6l52.7 52.7c6.2 6.2 16.4 6.2 22.6 0s6.2-16.4 0-22.6L278.6 256l52.7-52.7c6.2-6.2 6.2-16.4 0-22.6s-16.4-6.2-22.6 0L256 233.4l-52.7-52.7c-6.2-6.2-16.4-6.2-22.6 0z"/></svg></div>
        <iframe id="youtube-iframe" src="" allowfullscreen=""></iframe>
    </div>
</div>
