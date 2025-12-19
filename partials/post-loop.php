<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
$once_loop_image_lazy = isset($once_loop_image_lazy) ? (bool)$once_loop_image_lazy : true;
$result = get_post_thumbnail($this);
$thumbnail = !empty($result['cropped_images']) ? $result['cropped_images'][0] : $result['thumbnail'];
$postTitle = isset($this->title) ? (string)$this->title : '';
$postPermalink = isset($this->permalink) ? (string)$this->permalink : '';
if ($postPermalink === '') {
    ob_start();
    $this->permalink();
    $postPermalink = trim((string)ob_get_clean());
}
$postTitleAttr = once_esc_attr($postTitle);
$postPermalinkAttr = once_esc_url($postPermalink);
$thumbnailAttr = once_esc_url($thumbnail);
?>
<div class="post_def post_loop">
	    <div class="row g-3 g-sm-4">
	        <div class="col-3">
	            <a class="post_def_left" href="<?php echo $postPermalinkAttr; ?>" title="<?php echo $postTitleAttr; ?>">
	                <?php if ($once_loop_image_lazy): ?>
	                <img width="400" height="280"
	                     src="<?php echo $thumbnailAttr; ?>"
	                     data-src="<?php echo $thumbnailAttr; ?>"
	                     class="lazyload"
	                     alt="<?php echo $postTitleAttr; ?>"
	                     decoding="async"
	                     loading="lazy"
	                     onerror="this.onerror=null;this.src='<?php echo Helper::options()->themeUrl; ?>/assets/img/nopic.svg';" />
	                <?php else: ?>
	                <img width="400" height="280"
	                     src="<?php echo $thumbnailAttr; ?>"
	                     alt="<?php echo $postTitleAttr; ?>"
	                     decoding="async"
	                     fetchpriority="high"
	                     onerror="this.onerror=null;this.src='<?php echo Helper::options()->themeUrl; ?>/assets/img/nopic.svg';" />
	                <?php endif; ?>
	            </a>
	        </div>
        <div class="col-9">
	            <div class="post_def_right">
	                <div class="post_def_title">
	                    <h2><a class="" href="<?php echo $postPermalinkAttr; ?>" title="<?php echo $postTitleAttr; ?>"><?php echo once_esc_html($postTitle); ?></a></h2>
	                    <p><?php if ($this->fields->summary) { echo once_esc_html($this->fields->summary); } else { $this->excerpt(180); } ?></p>
	                </div>
	                <div class="post_info">
	                    <div class="post_info_l">
	                        <span><i class="bi bi-text-left"></i>
	                        <?php foreach($this->categories as $category): ?>
	                        <a href="<?php echo once_esc_url($category['permalink'] ?? ''); ?>" rel="category tag"><?php echo once_esc_html($category['name'] ?? ''); ?></a>
	                        <?php endforeach; ?>
	                        </span>
	                        <span class="mobile_none"><i class="bi bi-clock"></i><?php $this->date(); ?></span>
	                        <span class=""><i class="bi bi-eye"></i><?php get_post_view($this) ?>人浏览</span>
	                    </div>
	                    <div class="post_info_r">
	                        <?php if ($this->tags): ?>
	                        <?php foreach ($this->tags as $tag): ?>
	                        <em><i class="bi bi-hash"></i><a href="<?php echo once_esc_url($tag['permalink'] ?? ''); ?>"><?php echo once_esc_html($tag['name'] ?? ''); ?></a></em>
	                        <?php endforeach; ?>
	                        <?php endif; ?>
	                    </div>
	                </div>
	            </div>
        </div>
    </div>
</div>
