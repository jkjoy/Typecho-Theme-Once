<?php
/**
 * Once for Typecho
 * 双栏主题
 * 原作者 huitheme
 * 老孙移植
 * @package  Once 
 * @author 老孙
 * @version 1.0.1
 * @link http://www.imsun.org
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
<div class="col-lg-9">
    <div class="post_box">
    <?php while ($this->next()): ?>
        <div class="post_def post_loop">
            <div class="row g-3 g-sm-4">
                <div class="col-3">
                <a class="post_def_left" href="<?php $this->permalink() ?>" title="<?php $this->title() ?>">
                <?php $result = get_post_thumbnail($this);$thumbnail = !empty($result['cropped_images']) ? $result['cropped_images'][0] : $result['thumbnail']; ?>
                <img width="400" height="280" 
                     src="<?php echo htmlspecialchars($thumbnail); ?>" 
                     data-src="<?php echo htmlspecialchars($thumbnail); ?>" 
                     class="lazyload"
                     alt="<?php $this->title() ?>" 
                     decoding="async" 
                     loading="lazy"
                     onerror="this.onerror=null;this.src='<?php echo Helper::options()->themeUrl; ?>/assets/img/nopic.svg';" />
                </a>
                </div>
                <div class="col-9">
                <div class="post_def_right">
                    <div class="post_def_title">
                        <h2><a class="" href="<?php $this->permalink() ?>" title="<?php $this->title() ?>"><?php $this->title() ?></a></h2>
                        <p> <?php if($this->fields->summary){echo $this->fields->summary;} else {$this->excerpt(180);}?></p>
                    </div>
                    <div class="post_info">
                        <div class="post_info_l">
                            <span><i class="bi bi-text-left"></i>
                            <?php foreach($this->categories as $category): ?>
                            <a href="<?php echo $category['permalink']; ?>" rel="category tag"><?php echo $category['name']; ?></a>
                            <?php endforeach; ?>
                        </span>
                            <span class="mobile_none"><i class="bi bi-clock"></i><?php $this->date(); ?></span>
                            <span class=""><i class="bi bi-eye"></i><?php get_post_view($this) ?>人浏览</span>
                        </div>
                        <div class="post_info_r">
                        <?php if ($this->tags): ?>
                        <?php foreach ($this->tags as $tag): ?>
                        <em><i class="bi bi-hash"></i><a href="<?php echo $tag['permalink']; ?>"><?php echo $tag['name']; ?></a> </em>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
                </div>
                </div></div>
        <?php endwhile; ?>
    </div>
    <?php
$nextPage = $this->_currentPage + 1;
$totalPages = ceil($this->getTotal() / $this->parameter->pageSize);
if ($this->_currentPage < $totalPages): ?>
    <div class="post-read-more">
    <?php $this->pageLink('加载更多', 'next'); ?>
    </div>
<?php endif; ?>  
</div>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>