<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="<?php bloginfo('description'); ?>">
<link href="https://fonts.googleapis.com/earlyaccess/roundedmplus1c.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
<link href="<?php bloginfo('template_url'); ?>/css/style-cyan.min.css" rel="stylesheet">
<meta property="og:type" content="website">
<meta property="og:title" content="<?php echo get_option('blogname'); ?>">
<meta property="og:description" content="<?php echo get_option('blogdescription'); ?>">
<meta property="og:url" content="<?php bloginfo('url'); ?>">
<meta property="og:image" content="<?php echo wp_get_attachment_image_src( get_option('it_eyecatch') , 'full' )[0]; ?>">
<meta name="twitter:card" content="summary_large_image">
<?php if(get_option('it_twitter')) : ?>
<meta name="twitter:site" content="@<?php echo get_option('it_twitter'); ?>">
<meta name="twitter:creator" content="@<?php echo get_option('it_twitter'); ?>">
<?php endif; ?>
<link rel="icon" type="image/png" href="<?php echo wp_get_attachment_image_src( get_option('it_favicon') , 'favicon' )[0]; ?>">
<link rel="apple-touch-icon" href="<?php echo wp_get_attachment_image_src( get_option('it_favicon') , 'favicon' )[0]; ?>">
<link rel="canonical" href="<?php bloginfo('url'); ?>">
<style media="screen">
  .banner::before {
    background-image: url(<?php echo wp_get_attachment_image_src( get_option('it_banner') , 'full' )[0]; ?>);
  }
</style>
<title><?php bloginfo('name'); ?></title>

<meta property="og:type" content="website">
<meta property="og:title" content="<?php bloginfo('name'); ?>">
<meta property="og:description" content="<?php bloginfo('description'); ?>">
<meta property="og:url" content="<?php bloginfo('url'); ?>">
<meta property="og:image" content="<?php bloginfo('template_url'); ?>/img/ogp.jpg">
<meta name="twitter:card" content="summary_large_image">

<?php wp_head(); ?>
</head>
<body>



<header class="header">
  <h1 class="header__heading"><?php bloginfo('name'); ?></h1>
</header>
