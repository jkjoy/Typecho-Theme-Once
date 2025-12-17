<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
$isOnceJson = (isset($_GET['once_json']) && $_GET['once_json'] === '1');
if ($isOnceJson) {
    $charset = $this->options->charset ? $this->options->charset : 'UTF-8';

    ob_start();
    while ($this->next()) {
        $once_loop_image_lazy = true;
        $this->need('partials/post-loop.php');
    }
    $postsHtml = ob_get_clean();

    $nextUrl = null;
    $nextPage = $this->_currentPage + 1;
    $totalPages = ceil($this->getTotal() / $this->parameter->pageSize);
    if ($this->_currentPage < $totalPages) {
        ob_start();
        $this->pageLink('next', 'next');
        $linkHtml = ob_get_clean();
        if (preg_match('/href=\"([^\"]+)\"/i', $linkHtml, $m)) {
            $nextUrl = $m[1];
        }
    }

    header('Content-Type: application/json; charset=' . $charset);
    echo json_encode([
        'html' => $postsHtml,
        'next' => $nextUrl,
        'page' => (int)$this->_currentPage,
        'totalPages' => (int)$totalPages
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
?>
<?php $this->need('header.php'); ?>
<div class="col-lg-9">
    <?php if ($this->is('category')) ?>
        <div class="cat_info_top">
            <h2><?php $this->archiveTitle([
            'category' => _t('%s'),
            'search'   => _t('包含关键字 %s 的文章'),
            'tag'      => _t('包含标签 "%s"  的文章'),
            'author'   => _t('%s 发布的文章')
        ], '', ''); ?></h2>
        <?php if ($this->is('category')): ?>
        <p><?php echo $this->getDescription(); ?></p>
        <?php endif; ?>
    </div>
    <div class="post_box">
    <?php while ($this->next()): ?>
        <?php $once_loop_image_lazy = true; $this->need('partials/post-loop.php'); ?>
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
