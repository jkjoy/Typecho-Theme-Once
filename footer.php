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
                <p> &copy; <?php echo date('Y'); ?> <?php $this->options->title(); ?>.<?php _e('Page Loaded in'); ?><?php echo timer_stop();?> 
                </p>
            <p>
                Theme <a href="https://github.com/jkjoy/Typecho-Theme-Once" rel="external nofollow" target="_blank">Once</a> 
                Design by <a href="https://huitheme.com" rel="external nofollow" target="_blank">HUiTHEME</a>
                Made by<a href="https://www.imsun.org" target="_blank">Sun</a>
                Powered by <a href="https://typecho.org" rel="external nofollow" target="_blank" >Typecho</a>
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