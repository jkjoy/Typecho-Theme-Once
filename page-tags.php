<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
/**
 * 全部标签
 *
 * @package custom
 */
$this->need('header.php'); ?>
<div class="col-lg-9">
    <div class="post_container_title">
        <h1><?php $this->title() ?></h1>
    </div>
    <div class="post_container">
        <article class="wznrys">
            <div class="widget widget_hot_tags tags-page">
                <div class="tagcloud">
                    <?php
                    $tags = \Widget\Metas\Tag\Cloud::alloc('sort=count&desc=1&limit=200');
                    if ($tags->have()):
                        while ($tags->next()):
                    ?>
                        <a href="<?php $tags->permalink(); ?>" class="tag-item">
                            <?php $tags->name(); ?><span class="tag-count">(<?php $tags->count(); ?>)</span>
                        </a>
                    <?php
                        endwhile;
                    endif;
                    ?>
                </div>
            </div>
        </article>
    </div>
</div>
<?php $this->need('sidebar.php');$this->need('footer.php'); ?>