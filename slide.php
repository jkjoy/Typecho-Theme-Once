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
                            <a class="banlist" href="<?php echo $post['permalink']; ?>">
                            <?php $result = get_post_thumbnail($post);$thumbnail = !empty($result['cropped_images']) ? $result['cropped_images'][0] : $result['thumbnail']; ?>
                            <img src="<?php echo htmlspecialchars($thumbnail); ?>" 
                             alt="<?php echo htmlspecialchars($post['title']); ?>" 
                             decoding="async" 
                             class="post-images lazyload"
                             loading="lazy"
                             data-src="<?php echo htmlspecialchars($thumbnail); ?>"
                             onerror="this.onerror=null;this.src='<?php echo Helper::options()->themeUrl; ?>/assets/img/nopic.svg';" />
                        <h2><?php echo $post['title']; ?></h2>
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
// 中间展示（分类面板）
if ($midCenter) {
    // 手动获取分类下的文章
    $midCenterID = intval($midCenter);
    $args = 'pageSize=5'; // 增加pageSize以便找到更多文章 
    // 使用默认的文章列表部件，然后手动过滤特定分类的文章
    $this->widget('Widget_Contents_Post_Recent', $args)->to($posts);
    echo '<div class="index_banner_center">';
    $displayed = 0;
    $scanned = 0; // 用于追踪扫描了多少文章
    while ($posts->next()) {
        $scanned++;
        // 检查这篇文章是否属于指定分类
        $inCategory = false;
        $categoryName = '';
        // 遍历文章的所有分类
        if (!empty($posts->categories)) {
            foreach ($posts->categories as $category) {
                if ($category['mid'] == $midCenterID) {
                    $inCategory = true;
                    $categoryName = htmlspecialchars($category['name']);
                    break;
                }
            }
        }
        // 如果文章属于指定分类，才显示
        if ($inCategory) {
            $displayed++;
            // 获取缩略图
            $result = get_post_thumbnail($posts);
            $thumbnail = !empty($result['cropped_images']) ? $result['cropped_images'][0] : $result['thumbnail'];
            // 输出HTML
            echo '<a class="zt_list" href="' . $posts->permalink . '" title="' . htmlspecialchars($posts->title) . '">';
            echo '<img src="' . $thumbnail. '" decoding="async" loading="lazy" class="post-images-c lazyload" data-src="' . $thumbnail. '" onerror="this.onerror=null;this.src=\'' . Helper::options()->themeUrl . '/assets/img/nopic.svg\';" /><h3>' . htmlspecialchars($posts->title) . '</h3>';
            echo '<b>' . $categoryName . '</b>';
            echo '</a>';
            // 如果已经显示了两篇文章，就退出循环
            if ($displayed >= 2) {
                break;
            }
        }
    }
    // 如果没有找到任何文章
    if ($displayed == 0) {
        echo '<div class="zt_list">没有找到分类文章 (扫描了' . $scanned . '篇文章)</div>';
    }
    echo '</div>';
    echo '</div>';
}

// 右边展示（分类面板）
if ($midRight) {
    // 手动获取分类下的文章
    $midRightID = intval($midRight);
    $args = 'pageSize=10'; // 设置足够大的数量以便找到至少一篇符合条件的文章
    // 使用独立实例获取文章列表，避免与上面的widget冲突
    $this->widget('Widget_Contents_Post_Recent', $args)->to($rightPosts);
    echo '<div class="col-lg-3 none_992">';
    $displayed = 0;
    $scanned = 0; // 用于追踪扫描了多少文章
    while ($rightPosts->next()) {
        $scanned++;
        // 检查这篇文章是否属于指定分类
        $inCategory = false;
        $categoryName = '';
        // 遍历文章的所有分类
        if (!empty($rightPosts->categories)) {
            foreach ($rightPosts->categories as $category) {
                if ($category['mid'] == $midRightID) {
                    $inCategory = true;
                    $categoryName = htmlspecialchars($category['name']);
                    break;
                }
            }
        }
        // 如果文章属于指定分类，才显示
        if ($inCategory) {
            $displayed++;
            // 获取缩略图（修复这里使用正确的文章对象）
            $result = get_post_thumbnail($rightPosts);
            $thumbnail = !empty($result['cropped_images']) ? $result['cropped_images'][0] : $result['thumbnail'];
            // 输出HTML
            echo '<a class="gglb" href="' . $rightPosts->permalink . '" title="' . htmlspecialchars($rightPosts->title) . '">';
            echo '<img src="' . $thumbnail . '" decoding="async" loading="lazy" class="post-images-r lazyload" data-src="' . $thumbnail . '" onerror="this.onerror=null;this.src=\'' . Helper::options()->themeUrl . '/assets/img/nopic.svg\';" />';
            echo '<div class="gg_txt">
                    <h3>' . htmlspecialchars($rightPosts->title) . '</h3>
                    <p><i class="bi bi-clock"></i>' . date('Y-m-d', $rightPosts->created) . '</p>
                  </div>
                  <b>' . $categoryName . '</b></a>';
            // 只显示一篇文章
            break;
        }
    }
    // 如果没有找到任何文章
    if ($displayed == 0) {
        echo '<div class="gglb">没有找到分类文章 (扫描了' . $scanned . '篇文章)</div>';
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