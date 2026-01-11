<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
</div>
</div>
</section>
</main>
<?php if ($this->options->showlinks): ?>
<section class="links mobile_none">
    <div class="container">
        <span>友情链接：</span>
        <?php
        try {
            // 检查links表是否存在
            $db = Typecho_Db::get();
            $db->fetchAll($db->select()->from('table.links')->limit(1));
            // 如果没有异常，表存在，输出友情链接
            Links_Plugin::output('<a href="{url}" target="_blank" rel="me noopener" title="{title}">{name}</a>');
        } catch (Exception $e) {
            // 表不存在或查询失败，显示提示信息
            echo '<span style="color: #999;">请先安装links插件</span>';
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
