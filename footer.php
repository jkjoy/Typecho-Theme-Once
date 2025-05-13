<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
    </div>
</div>
</section>
<?php if ($this->options->showlinks): ?>
<section class="links mobile_none">
    <div class="container">
        <span>友情链接：</span>
        <?php Links_Plugin::output('<a href="{url}" target="_blank" rel="me noopener" title="{title}">{name}</a>'); ?>        
    </div>
</section>
<?php endif; ?>  
<footer class="footer">
<div class="footbox">
    <div class="container">
        <div class="foot">
    	    <div class="copyright">
                <p>Powered by <a href="https://typecho.org" rel="external nofollow" target="_blank" >Typecho</a>. <?php $this->options->title(); ?></a>. &copy; <?php echo date('Y'); ?>
                </p>
                <p>Theme by <a href="https://huitheme.com" rel="external nofollow" target="_blank">HUiTHEME</a>&<a href="https://www.imsun.org" target="_blank">老孙</a>
                <?php _e('加载耗时'); ?><?php echo timer_stop();?>
            </p>
            </div>
            <div class="foot_nav">
				<nav class="dbdh">
                    <ul class="menu">
                        <li class="menu-item menu-item-type-post_type menu-item-object-page"></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page"></li>
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
<?php if ($this->options->tongji): ?>
<?php echo $this->options->tongji(); ?>
<?php endif; ?>
<!-- end #footer -->
<?php $this->footer(); ?>
<script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/main.js'); ?>"></script>
</body>
</html>