<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
/**
 * 友情链接
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
            <?php $this->content(); ?>
            <div class="links-page">
                <?php
                if (!class_exists('Links_Plugin')) {
                    echo '<p>请先安装 links 插件。</p>';
                } else {
                    try {
                        $db = Typecho_Db::get();
                        $db->fetchAll($db->select()->from('table.links')->limit(1));
                        echo '<div class="links-page-grid">';
                        Links_Plugin::output('<li><a class="links-page-item" href="{url}" target="_blank" rel="me noopener" title="{title}"><span class="links-page-name">{name}</span><span class="links-page-desc">{title}</span></a></li>');
                        echo '</div>';
                    } catch (Exception $e) {
                        echo '<p>友情链接数据不可用：请确认 links 插件已启用并初始化数据表。</p>';
                    }
                }
                ?>
            </div>
        </article>
    </div>
</div>
<?php $this->need('sidebar.php'); $this->need('footer.php'); ?>