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
			                        <?php
			                        $rawTitle = once_decode_html_entities_deep($post['title'] ?? '', 3);
			                        $safeTitleAttr = once_esc_attr($rawTitle);
			                        $safeTitleHtml = once_esc_html($rawTitle);
			                        ?>
			                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
			                            <a class="banlist" href="<?php echo once_esc_url($post['permalink'] ?? ''); ?>">
			                            <?php $result = get_post_thumbnail($post);$thumbnail = !empty($result['cropped_images']) ? $result['cropped_images'][0] : $result['thumbnail']; ?>
			                            <img src="<?php echo once_esc_url($thumbnail); ?>" 
			                             alt="<?php echo $safeTitleAttr; ?>" 
			                             decoding="async" 
			                             class="post-images lazyload"
			                             loading="lazy"
			                             data-src="<?php echo once_esc_url($thumbnail); ?>"
			                             onerror="this.onerror=null;this.src='<?php echo Helper::options()->themeUrl; ?>/assets/img/nopic.svg';" />
			                        <h2><?php echo $safeTitleHtml; ?></h2>
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
				    <?php
				    // 获取设置中的分类ID
				    $midCenter = $this->options->midCenter;
				    $midRight = $this->options->midRight;
				    
					    // 获取数据库实例
					    $db = Typecho_Db::get();
					    $contentsWidget = null;
					    try {
					        $contentsWidget = Typecho_Widget::widget('Widget_Abstract_Contents');
					    } catch (Exception $e) {
					    }
					    ?>
					    <div class="col-lg-2 none_992">
					    <?php
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
					                $permalink = '';
					                if ($contentsWidget) {
					                    try {
					                        $tempPost = $contentsWidget->filter($post);
					                        $permalink = (string)($tempPost['permalink'] ?? '');
					                    } catch (Exception $e) {
					                    }
					                }
					                if ($permalink === '') {
					                    $permalink = \Typecho\Router::url('post', $post, $this->options->index);
					                }
					                $safePermalink = once_esc_url($permalink);
					                $rawTitle = once_decode_html_entities_deep($post['title'] ?? '', 3);
					                $safeTitleAttr = once_esc_attr($rawTitle);
					                $safeTitleHtml = once_esc_html($rawTitle);
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
				    }
				    ?>
				    </div>
				    <?php
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
					            $permalink = '';
					            if ($contentsWidget) {
					                try {
					                    $tempPost = $contentsWidget->filter($rightPost);
					                    $permalink = (string)($tempPost['permalink'] ?? '');
					                } catch (Exception $e) {
					                }
					            }
					            if ($permalink === '') {
					                $permalink = \Typecho\Router::url('post', $rightPost, $this->options->index);
					            }
					            $safePermalink = once_esc_url($permalink);
					            $rawTitle = once_decode_html_entities_deep($rightPost['title'] ?? '', 3);
					            $safeTitleAttr = once_esc_attr($rawTitle);
					            $safeTitleHtml = once_esc_html($rawTitle);
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
	<script src="<?php $this->options->themeUrl('assets/js/slide.js'); ?>"></script>
	<?php endif; ?>
