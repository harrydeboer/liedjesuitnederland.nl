<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >
	<header id="header" class="sticky-top">
		<div class="row">
			<div class="logo-wrap column col-md-3 col-8">
                <a href="/">
                    <svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="list-music" class="svg-inline--fa fa-list-music fa-2x" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="max-width:42px"><g class="fa-group"><path class="fa-secondary" fill="currentColor" d="M272 192H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h256a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-128H16A16 16 0 0 0 0 80v32a16 16 0 0 0 16 16h256a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16zM144 320H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h128a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z" opacity="0.4"></path><path class="fa-primary" fill="currentColor" d="M192 432c0 44.18 50.14 80 112 80s112-35.82 112-80V148.15l73-21.39a32 32 0 0 0 23-30.71V32a32 32 0 0 0-41.06-30.67l-96.53 28.51A32 32 0 0 0 352 60.34V360a148.76 148.76 0 0 0-48-8c-61.86 0-112 35.82-112 80z"></path></g></svg>
                    <h4>Liedjes uit<br>Nederland</h4>
                </a>
			</div>
			<div class="items-right column col-md-9 col-4">
                <?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'container_class' => 'header-menu desktop' ) ); ?>
                <div class="menu-wrapper mobile">
                    <div class="menu-toggle">
                        <i></i>
                    </div>
                </div>
  			</div>
		</div>
	</header>
	<div class="nav-wrapper mobile">
		<div class="nav-menu-wrapper">
			<?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'container_class' => 'header-menu mobile' ) ); ?>
  		</div>
		<div class="nav-overlay"></div>
	</div>
