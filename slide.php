<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
// 获取幻灯片文章
$slides = getSlidesPosts();
if (!empty($slides)):
?>
<section class="index_banner">
    <div class="container">
        <div class="row g-3">
            <div class="col-lg-7">   
                <div id="banner" class="carousel slide carousel-fade">
                <!-- 指示器 -->
                    <div class="carousel-indicators">
                    <?php foreach ($slides as $index => $post): ?>
                    <button type="button" 
                        class="<?php echo $index === 0 ? 'active' : ''; ?>">
                    </button>
                    <?php endforeach; ?>
                    </div>
                    <!-- 幻灯片内容 -->
                    <div class="carousel-inner">
	                    <?php foreach ($slides as $index => $post): ?>
	                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
	                            <a class="banlist" href="<?php echo once_esc_url($post['permalink'] ?? ''); ?>">
	                            <?php $result = get_post_thumbnail($post);$thumbnail = !empty($result['cropped_images']) ? $result['cropped_images'][0] : $result['thumbnail']; ?>
	                            <img src="<?php echo once_esc_url($thumbnail); ?>" 
	                             alt="<?php echo once_esc_attr($post['title'] ?? ''); ?>" 
	                             decoding="async" 
	                             class="post-images lazyload"
	                             loading="lazy"
	                             data-src="<?php echo once_esc_url($thumbnail); ?>"
	                             onerror="this.onerror=null;this.src='<?php echo Helper::options()->themeUrl; ?>/assets/img/nopic.svg';" />
	                        <h2><?php echo once_esc_html($post['title'] ?? ''); ?></h2>
	                        <i>置顶精彩</i>
	                    </a>
	                </div>
	                <?php endforeach; ?>
            </div>          
            <!-- 控制按钮 -->
            <?php if (count($slides) > 1): ?>
            <button class="carousel-control-prev" type="button">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button class="carousel-control-next" type="button">
                <i class="bi bi-chevron-right"></i>
            </button>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-lg-2 none_992">
    <?php
// 获取设置中的分类ID
$midCenter = $this->options->midCenter;
$midRight = $this->options->midRight;

// 获取数据库实例
$db = Typecho_Db::get();

// 中间展示（分类面板）
if ($midCenter) {
    $midCenterID = intval($midCenter);
    
    // 直接从数据库获取指定分类的文章
    $centerPosts = $db->fetchAll($db->select('table.contents.*, table.metas.name as category_name')
        ->from('table.contents')
        ->join('table.relationships', 'table.contents.cid = table.relationships.cid')
        ->join('table.metas', 'table.relationships.mid = table.metas.mid')
        ->where('table.relationships.mid = ?', $midCenterID)
        ->where('table.contents.type = ?', 'post')
        ->where('table.contents.status = ?', 'publish')
        ->order('table.contents.created', Typecho_Db::SORT_DESC)
        ->limit(2)
    );

    echo '<div class="index_banner_center">';
    
    if (!empty($centerPosts)) {
        foreach ($centerPosts as $post) {
            // 获取缩略图
            $result = get_post_thumbnail($post);
            $thumbnail = !empty($result['cropped_images']) ? $result['cropped_images'][0] : $result['thumbnail'];
            
	            // 构建文章链接
	            $permalink = Typecho_Router::url('post', array('cid' => $post['cid']), $this->options->index);
	            $safePermalink = once_esc_url($permalink);
	            $safeTitleAttr = once_esc_attr($post['title'] ?? '');
	            $safeTitleHtml = once_esc_html($post['title'] ?? '');
	            $safeCategoryHtml = once_esc_html($post['category_name'] ?? '');
	            $safeThumb = once_esc_url($thumbnail);
	            
	            // 输出HTML
	            echo '<a class="zt_list" href="' . $safePermalink . '" title="' . $safeTitleAttr . '">';
	            echo '<img src="' . $safeThumb . '" decoding="async" loading="lazy" class="post-images-c lazyload" data-src="' . $safeThumb . '" onerror="this.onerror=null;this.src=\'' . Helper::options()->themeUrl . '/assets/img/nopic.svg\';" />';
	            echo '<h3>' . $safeTitleHtml . '</h3>';
	            echo '<b>' . $safeCategoryHtml . '</b>';
	            echo '</a>';
        }
    } else {
        echo '<div class="zt_list">没有找到分类文章</div>';
    }
    echo '</div>';
    echo '</div>';
}

// 右边展示（分类面板）
if ($midRight) {
    $midRightID = intval($midRight);
    
    // 直接从数据库获取指定分类的文章
    $rightPost = $db->fetchRow($db->select('table.contents.*, table.metas.name as category_name')
        ->from('table.contents')
        ->join('table.relationships', 'table.contents.cid = table.relationships.cid')
        ->join('table.metas', 'table.relationships.mid = table.metas.mid')
        ->where('table.relationships.mid = ?', $midRightID)
        ->where('table.contents.type = ?', 'post')
        ->where('table.contents.status = ?', 'publish')
        ->order('table.contents.created', Typecho_Db::SORT_DESC)
        ->limit(1)
    );

    echo '<div class="col-lg-3 none_992">';
    
    if ($rightPost) {
        // 获取缩略图
        $result = get_post_thumbnail($rightPost);
        $thumbnail = !empty($result['cropped_images']) ? $result['cropped_images'][0] : $result['thumbnail'];
        
	        // 构建文章链接
	        $permalink = Typecho_Router::url('post', array('cid' => $rightPost['cid']), $this->options->index);
	        $safePermalink = once_esc_url($permalink);
	        $safeTitleAttr = once_esc_attr($rightPost['title'] ?? '');
	        $safeTitleHtml = once_esc_html($rightPost['title'] ?? '');
	        $safeCategoryHtml = once_esc_html($rightPost['category_name'] ?? '');
	        $safeThumb = once_esc_url($thumbnail);
	        
	        // 输出HTML
	        echo '<a class="gglb" href="' . $safePermalink . '" title="' . $safeTitleAttr . '">';
	        echo '<img src="' . $safeThumb . '" decoding="async" loading="lazy" class="post-images-r lazyload" data-src="' . $safeThumb . '" onerror="this.onerror=null;this.src=\'' . Helper::options()->themeUrl . '/assets/img/nopic.svg\';" />';
	        echo '<div class="gg_txt">
	                <h3>' . $safeTitleHtml . '</h3>
	                <p><i class="bi bi-clock"></i>' . date('Y-m-d', $rightPost['created']) . '</p>
	              </div>
	              <b>' . $safeCategoryHtml . '</b></a>';
	    } else {
	        echo '<div class="gglb">没有找到分类文章</div>';
	    }
    echo '</div>';
}
?>
    </div>
</div>
</section>
<style>
.post-images {
    width: 700px;
    height: 400px;
    object-fit: cover;
    object-position: center;
}
.post-images-c {
    width: 300px;
    height: 300px;
    object-fit: cover;
    object-position: center;
}
.post-images-r {
    width: 300px;
    height: 400px;
    object-fit: cover;
    object-position: center;
}
/* 添加以下样式使指示器变为圆形 */
.carousel-indicators button {
    width: 10px;
    height: 10px;
    border-radius: 50%;  /* 这行是关键，使元素变为圆形 */
    padding: 0;
    margin: 0 5px;
    border: none;
    background-color: hsl(0, 0.00%, 100.00%);
    transition: background-color 0.3s ease;
}
.carousel-indicators button.active {
    background-color: rgba(0, 0, 0, 0.8);
}
</style>
<script>
// 轮播图实现
class Carousel {
    constructor(element, options = {}) {
        this.container = element;
        this.items = element.querySelectorAll('.carousel-item');
        this.total = this.items.length;
        this.current = 0;
        this.options = {
            interval: options.interval || 5000,
            duration: options.duration || 600
        };
        this.init();
    }
    init() {
        // 初始化显示第一个
        this.items[0].classList.add('active');
        // 自动播放
        if (this.total > 1) {
            this.autoplay();
            // 绑定事件
            this.bindEvents();
        }
    }
    next() {
        let next = (this.current + 1) % this.total;
        this.slideTo(next);
    }
    prev() {
        let prev = (this.current - 1 + this.total) % this.total;
        this.slideTo(prev);
    }
    slideTo(index) {
        if (index === this.current) return;        
        // 移除当前活动项的active类
        this.items[this.current].classList.remove('active');       
        // 添加新活动项的active类
        this.items[index].classList.add('active');     
        // 更新指示器
        if (this.indicators) {
            this.indicators[this.current].classList.remove('active');
            this.indicators[index].classList.add('active');
        }      
        this.current = index;
    }  
    autoplay() {
        this.timer = setInterval(() => {
            this.next();
        }, this.options.interval);
    }   
    stop() {
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }
    }   
    bindEvents() {
        // 鼠标悬停暂停
        this.container.addEventListener('mouseenter', () => this.stop());
        this.container.addEventListener('mouseleave', () => this.autoplay());    
        // 绑定按钮事件
        const prevBtn = this.container.querySelector('.carousel-control-prev');
        const nextBtn = this.container.querySelector('.carousel-control-next');   
        if (prevBtn) {
            prevBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.prev();
            });
        }    
        if (nextBtn) {
            nextBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.next();
            });
        }
        // 绑定指示器事件
        this.indicators = this.container.querySelectorAll('.carousel-indicators button');
        this.indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                this.slideTo(index);
            });
        });    
        // 触摸事件支持
        let startX = 0;
        let endX = 0;
        this.container.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            this.stop();
        }, { passive: true });  
        this.container.addEventListener('touchmove', (e) => {
            endX = e.touches[0].clientX;
        }, { passive: true }); 
        this.container.addEventListener('touchend', () => {
            let diff = startX - endX;
            if (Math.abs(diff) > 50) { // 最小滑动距离
                if (diff > 0) {
                    this.next();
                } else {
                    this.prev();
                }
            }
            this.autoplay();
        });
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.querySelector('#banner');
    if (carousel) {
        new Carousel(carousel, {
            interval: 5000, // 自动播放间隔，单位毫秒
            duration: 600  // 动画持续时间，单位毫秒
        });
    }
});
</script>
<?php endif; ?>
