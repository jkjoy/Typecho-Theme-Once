<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="<?php $this->options->charset(); ?>">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="max-age=86400" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
<title><?php $this->archiveTitle([
            'category' => _t('分类 %s 下的文章'),
            'search'   => _t('包含关键字 %s 的文章'),
            'tag'      => _t('标签 %s 下的文章'),
            'author'   => _t('%s 发布的文章')
        ], '', ' - '); ?><?php $this->options->title(); ?> | <?php $this->options->description(); ?></title>
<meta name="description" content="<?php echo once_esc_attr($this->options->description ?? ''); ?>" />
<?php if ($this->options->faviconUrl): ?>
<link rel="icon" href="<?php echo once_esc_url($this->options->faviconUrl ?? ''); ?>" type="image/x-icon" />
<?php else: ?>
<link rel="icon" href="<?php $this->options->themeUrl('assets/img/nopic.svg'); ?>" type="image/svg+xml" />
<?php endif; ?>
<!-- 预加载logo图片 -->
<?php if ($this->options->logoUrl): ?>
<link rel="preload" href="<?php echo once_esc_url($this->options->logoUrl ?? ''); ?>" as="image">
<?php endif; ?>
<!-- 使用url函数转换相关路径 -->
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/bootstrap.min.css'); ?>">
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/bootstrap-icons.css'); ?>">
<script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/jquery.min.js'); ?>" id="jquery-min-js"></script>
<!-- Dark mode config (read by assets/js/main.js) -->
<script>
      window.__ONCE_THEME_MODE__ = <?php
        $themeMode = 'auto';
        if (isset($this->options->darkMode) && $this->options->darkMode !== '') {
          $themeMode = (string)$this->options->darkMode;
        }
        echo json_encode(trim($themeMode), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
      ?>;
      (function() {
        var themeMode = window.__ONCE_THEME_MODE__;
        if (themeMode !== "auto" && themeMode !== "light" && themeMode !== "dark") themeMode = "auto";

        var savedMode = null;
        try { savedMode = localStorage.getItem("isDarkMode"); } catch (e) {}

        function isDaytime() {
          var now = new Date();
          var hour = now.getHours();
          return hour >= 6 && hour < 18;
        }

        var shouldDark = false;
        if (savedMode === "1") shouldDark = true;
        else if (savedMode === "0") shouldDark = false;
        else if (themeMode === "dark") shouldDark = true;
        else if (themeMode === "light") shouldDark = false;
        else shouldDark = !isDaytime();

        if (shouldDark) document.documentElement.classList.add("dark");
        else document.documentElement.classList.remove("dark");
      })();
</script>
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/style.css'); ?>">
<script src="<?php $this->options->themeUrl('assets/js/main.js'); ?>" defer></script>
<?php if (isset($this->options->lxgw) && $this->options->lxgw == '1'): ?>
<style>body, button, input, select, textarea {font-family: 'LXGW', sans-serif !important;}</style>
<?php endif; ?>
</head>
<body class="home blog">
<header class="header sticky-top">
<div class="container">
	<div class="top">
		<button class="mobile_an" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobile_right_nav" aria-controls="mobile_right_nav"><i class="bi bi-list"></i></button>
			<div class="top_l">
	            <h1 class="logo">
	                <a href="<?php $this->options->siteUrl(); ?>" title="<?php echo once_esc_attr($this->options->description ?? ''); ?>">
	                <?php if ($this->options->logoUrl): ?>
	                <img src="<?php echo once_esc_url($this->options->logoUrl ?? ''); ?>" onload="this.classList.add('loaded')" alt="logo">
	                <?php endif; ?>
	                <b><?php $this->options->title() ?></b>
	                </a>
	            </h1>
        		<nav class="header-menu">
                    <ul id="menu" class="header-menu-ul">
                    <li id="menu" class="menu-itemcurrent-menu-item current_page_item menu-item-home">
                        <a<?php if ($this->is('index')): ?> class="current"<?php endif; ?> href="<?php $this->options->siteUrl(); ?>">
                        <i class="bi bi-house-door-fill me-1"></i><?php _e('首页'); ?>
                        </a>
                    </li>
	                    <li class="menu-item-has-children">
	                        <button type="button" class="menu-parent"><i class="bi bi-folder-fill me-1"></i><?php _e('分类'); ?></button>
	                        <ul class="sub-menu" style="display: none;">
	                        <?php $categories = Typecho_Widget::widget('Widget_Metas_Category_List'); while($categories->next()): ?>
	                        <li class="menu-item">
	                            <a href="<?php $categories->permalink(); ?>">
                            <?php 
                            switch($categories->slug) {
                                case 'images': echo '<i class="bi bi-images me-1"></i>';
                            break;
                                case 'share': echo '<i class="bi bi-share-fill me-1"></i>';
                            break;
                                case 'NULL': echo '<i class="bi bi-speaker-fill me-1"></i>';
                            break;
                                case 'memos': echo '<i class="bi bi-chat me-1"></i>';
                            break;
                                case 'codes': echo '<i class="bi bi-code me-1"></i>';
                            break;
                                case 'logs': echo '<i class="bi bi-person-fill me-1"></i>';
                            break;
                                case 'test': echo '<i class="bi bi-calendar-fill me-1"></i>';
                            break;
                                case 'tools': echo '<i class="bi bi-tools me-1"></i>';
                            break;
                                case 'music': echo '<i class="bi bi-music-note me-1"></i>';
                            break;
                                case 'links': echo '<i class="bi bi-link me-1"></i>';
                            break;
                                case 'video': echo '<i class="bi bi-camera-video me-1"></i>';
                            break;
                                case 'life': echo '<i class="bi bi-heart-fill me-1"></i>';
                            break;
                                case 'study': echo '<i class="bi bi-book-fill me-1"></i>';
                            break;
                                case 'news': echo '<i class="bi bi-newspaper me-1"></i>';
                            break;
                                case 'themes': echo '<i class="bi bi-palette me-1"></i>';
                            break;
                                case 'plugins': echo '<i class="bi bi-gear-fill me-1"></i>';
                            break;
                                case 'photo': echo '<i class="bi bi-images me-1"></i>';
                            break;
                                default: echo '<i class="bi bi-folder-fill me-1"></i>';
                            } ?>
                            <?php $categories->name(); ?>
                            </a>
                        </li>
                        <?php endwhile; ?>
                        </ul>
                        </li>
                        <?php $this->widget('Widget_Contents_Page_List')->to($pages); while($pages->next()): ?>
                        <li class="menu-item">
                             <a href="<?php $pages->permalink(); ?>">
                             <?php echo pageIcon($pages->slug, $pages->title); ?>
                            </a>
                        </li>
                    <?php endwhile; ?>
                    </ul>
                </nav>        	
            </div>
        	<div class="top_r">
        		<div class="top_r_an theme-switch me-4" onclick="window.switchDarkMode && window.switchDarkMode()">
                    <i class="bi bi-lightbulb-fill"></i>
                </div>
				<button class="top_r_an" type="button" data-bs-toggle="offcanvas" data-bs-target="#c_sousuo">
                    <i class="bi bi-search"></i>
                </button>
        	</div>
        </div>
	</div>
</header>

<div class="offcanvas offcanvas-top" tabindex="-1" id="c_sousuo" aria-labelledby="c_sousuoLabel">
    <div class="container">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        <div class="row justify-content-center">
            <div class="col-10 col-lg-6 search_box">
                <form action="<?php $this->options->siteUrl(); ?>" class="ss_a clearfix" method="get">
                    <input name="s" aria-label="Search" type="text" onblur="if(this.value=='')this.value='搜索'" onfocus="if(this.value=='搜索')this.value=''" value="搜索">
                    <button type="submit" title="Search">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-start" tabindex="-1" id="mobile_right_nav" aria-labelledby="mobile_right_navLabel">
	<div class="mobile_head">
		<div class="mobile_head_logo">
			<?php if ($this->options->logoUrl): ?>
			<a href="<?php $this->options->siteUrl(); ?>" title="<?php echo once_esc_attr($this->options->description ?? ''); ?>"><img src="<?php echo once_esc_url($this->options->logoUrl ?? ''); ?>" onload="this.classList.add('loaded')" alt="logo"><b><?php $this->options->title() ?></b></a>
			<?php else: ?>
			<a href="<?php $this->options->siteUrl(); ?>" title="<?php echo once_esc_attr($this->options->description ?? ''); ?>"><b><?php $this->options->title() ?></b></a>
			<?php endif; ?>
		</div>
		<div class="theme-switch" onclick="window.switchDarkMode && window.switchDarkMode()"><i class="bi bi-lightbulb-fill"></i></div>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
    <div id="sjcldnav" class="menu-zk">
        <ul id="menu-mobile">
            <li class="menu-item<?php if ($this->is('index')): ?> current-menu-item<?php endif; ?>">
                <a href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a>
            </li>
            <?php \Widget\Contents\Page\Rows::alloc()->to($pages); 
            while ($pages->next()): 
            $rawTitle = once_decode_html_entities_deep($pages->title ?? '', 3); ?>
		        <li class="menu-item<?php if ($this->is('page', $pages->slug)): ?> current-menu-item<?php endif; ?>">
		            <a href="<?php $pages->permalink(); ?>" title="<?php echo once_esc_attr($rawTitle); ?>"><?php echo once_esc_html($rawTitle); ?></a>
		        </li>
		    <?php endwhile; ?>
            
	            <?php $this->widget('Widget_Metas_Category_List')->to($categories);if ($categories->have()): ?>
	            <li class="menu-item menu-item-has-children">
	                <button type="button" class="menu-parent"><?php _e('分类'); ?></button>
	                <ul class="sub-menu">
		            <?php while ($categories->next()): ?>
		                <li class="menu-item">
		                    <a href="<?php $categories->permalink(); ?>" title="<?php echo once_esc_attr($categories->name ?? ''); ?>"><?php echo once_esc_html($categories->name ?? ''); ?> (<?php echo (int)($categories->count ?? 0); ?>)</a>
	                </li>
	            <?php endwhile; ?>
                </ul>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<?php if ($this->is('index')):
$this->need('slide.php');
endif; ?> 

<section class="index_area">
    <div class="container">
        <div class="row g-3">
