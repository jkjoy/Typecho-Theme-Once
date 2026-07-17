<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
</div>
</div>
</section>
</main>
<?php
$footerLinks = [];
if ($this->options->showlinks) {
    try {
        $db = Typecho_Db::get();
        $prefix = $db->getPrefix();
        $footerLinks = $db->fetchAll(
            $db->select()
                ->from($prefix . 'links')
                ->where('state = ?', 1)
                ->where('sort = ?', 'home')
                ->order('sort', Typecho_Db::SORT_ASC)
                ->order($prefix . 'links.order', Typecho_Db::SORT_ASC)
        );
    } catch (Exception $e) {
        $footerLinks = [];
    }
}
?>
<?php if (!empty($footerLinks)): ?>
<section class="links mobile_none">
    <div class="container">
        <span>友情链接：</span>
        <?php
        foreach ($footerLinks as $link) {
            $rawName = trim((string)($link['name'] ?? ''));
            $name = once_esc_html($rawName !== '' ? $rawName : '未命名站点');
            $url = once_esc_url($link['url'] ?? '#');
            $descriptionRaw = trim((string)($link['description'] ?? ''));
            $title = once_esc_attr($descriptionRaw !== '' ? $descriptionRaw : $rawName);

            echo '<a href="' . $url . '" target="_blank" rel="me noopener" title="' . $title . '">' . $name . '</a>';
        }
        ?>
    </div>
</section>
<?php endif; ?>
<footer class="footer">
<div class="footbox">
    <div class="container">
        <div class="foot">
    	    <div class="copyright">
                <p> &copy; <?php echo date('Y'); ?> <?php $this->options->title(); ?> . Theme <a href="https://github.com/jkjoy/Typecho-Theme-Once" rel="external nofollow" target="_blank">Once</a>
                </p>
            <p class="hidden">
                Theme <a href="https://github.com/jkjoy/Typecho-Theme-Once" rel="external nofollow" target="_blank">Once</a> 
                Design by <a href="https://huitheme.com" rel="external nofollow" target="_blank">绘主题</a>
                Made by <a href="https://www.imsun.org" target="_blank">Sun</a>
                Powered by <a href="https://typecho.org" rel="external nofollow" target="_blank" >Typecho</a>
            </p>
            </div>
            <div class="foot_nav">
				<nav class="dbdh">
                    <ul class="menu">
                        <li class="menu-item"> </li>
                        <?php echo $this->options->tongji(); ?>
                    </ul>
                </nav>	
            <?php if($this->options->icpbeian): ?>
            <a class="beian" href="https://beian.miit.gov.cn/" rel="external nofollow" target="_blank" title="备案号"><i class="bi bi-shield-check me-1"></i><?php $this->options->icpbeian() ?></a>
            <?php endif; ?>
            </div>
	    </div>
    </div>
    <button class="scrollToTopBtn" title="返回顶部"><i class="bi bi-chevron-up"></i></button>   
</footer>
<!-- end #footer -->
<?php $this->footer(); ?>
</body>
</html>
