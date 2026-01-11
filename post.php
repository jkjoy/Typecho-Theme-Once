<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php'); ?>
<div class="col-lg-9">
    <div class="post_container_title">
		<h1><?php $this->title() ?></h1>
		    <p>
		        <span><i class="bi bi-clock"></i><?php $this->date(); ?></span>
                <span><i class="bi bi-eye"></i><?php get_post_view($this) ?></span>
		    	<span><i class="bi bi-chat-square-text"></i>
				    <a href="<?php $this->permalink() ?>#post_comment_anchor">
                    <?php $this->commentsNum('0', '1', '%d'); ?>
                    </a>
			    </span>
                    <?php if($this->user->hasLogin() && $this->user->pass('editor', true)): ?>    
                    <a href="<?php $this->options->adminUrl('write-post.php?cid=' . $this->cid); ?>" target="_blank" title="编辑文章"> 
                        <i class="bi bi-pen"></i>  <span>编辑</span>
                    </a> 
                    <?php endif; ?>
		    </p>
	</div>
    <div class="post_container">
		<article class="wznrys">
			<?php $this->content(); ?>
		</article>
            <?php if ($this->modified > $this->created): ?>
        <strong>最后更新于 <?php echo date('Y-m-d H:i:s', $this->modified); ?></strong>
            <?php endif; ?>	
    </div>
	<div class="post_author">
		<div class="post_author_l">
            <?php $this->author->gravatar('60', ''); ?>
            <span><?php $this->author(); ?></span>
		</div>
		<div class="post_author_r">
	        <div class="post_author_tag">
	            <?php if ($this->tags):foreach ($this->tags as $tag): ?>
	            <em> 
	                <a href="<?php echo once_esc_url($tag['permalink'] ?? ''); ?>"><i class="bi bi-hash"></i><?php echo once_esc_html($tag['name'] ?? ''); ?></a> 
	            </em>
	            <?php endforeach;else:endif; ?>
            <em><i class="bi bi-list"></i> <?php $this->category(','); ?></em>
        </div>
			<div class="post_author_icon">
				<a href="#post_comment_anchor">
                    <i class="bi bi-chat-square-dots-fill"></i>
                    <?php $this->commentsNum('0', '1', '%d'); ?>
                </a>
	        <?php $likes = $this->fields->likes ? (int)$this->fields->likes : 0; ?>
					<a href="javascript:;" data-action="ding" data-id="<?php $this->cid(); ?>" class="specsZan ">
	                    <i class="bi bi-hand-thumbs-up-fill"></i>
	                    <small class="count"><?php echo $likes; ?></small>
					</a>
			</div>
		</div>
	</div>
        <?php
            $db = Typecho_Db::get();
            $prev = $db->fetchRow($db->select('cid', 'title', 'slug', 'created','text')
                ->from('table.contents')
                ->where('created < ?', $this->created)
                ->where('type = ?', 'post')
                ->where('status = ?', 'publish')
                ->order('created', Typecho_Db::SORT_DESC)
                ->limit(1));
            $result = get_post_thumbnail($prev);
            $prevThumbnailUrl = !empty($result['cropped_images']) ? $result['cropped_images'][0] : $result['thumbnail'];
            $next = $db->fetchRow($db->select('cid', 'title', 'slug', 'created','text')
                ->from('table.contents')
                ->where('created > ?', $this->created)
                ->where('type = ?', 'post')
                ->where('status = ?', 'publish')
                ->order('created', Typecho_Db::SORT_ASC)
                ->limit(1));
            $result = get_post_thumbnail($next);
            $nextThumbnailUrl = !empty($result['cropped_images']) ? $result['cropped_images'][0] : $result['thumbnail'];
        ?>
        <div class="next_prev_posts">
		            <div class="prev_next_box nav_previous"<?php if (!$next) echo ' style="width:100%"'; ?>>
		            <?php if ($prev):
		                $prevUrl = Typecho_Router::url('post', $prev, $this->options->index);
		                $prevRawTitle = once_decode_html_entities_deep($prev['title'] ?? '', 3);
		            ?>
		                <a href="<?php echo once_esc_url($prevUrl); ?>" title="<?php echo once_esc_attr($prevRawTitle); ?>" rel="prev" style="background-image: url('<?php echo once_esc_url($prevThumbnailUrl); ?>');">
		                    <div class="prev_next_info">
		                        <small>上一篇</small>
		                        <p><?php echo once_esc_html($prevRawTitle); ?></p>
		                    </div>
		                </a>
		        <?php else:endif; ?>
            </div>
		    <div class="prev_next_box nav_next"<?php if (!$prev) echo ' style="width:100%"'; ?>>
		    <?php if ($next):
		        $nextUrl = Typecho_Router::url('post', $next, $this->options->index);
		        $nextRawTitle = once_decode_html_entities_deep($next['title'] ?? '', 3);
		    ?>
		    <a href="<?php echo once_esc_url($nextUrl); ?>" title="<?php echo once_esc_attr($nextRawTitle); ?>" rel="next" style="background-image: url('<?php echo once_esc_url($nextThumbnailUrl); ?>');">
		        <div class="prev_next_info">
		            <small>下一篇</small>
		            <p><?php echo once_esc_html($nextRawTitle); ?></p>
		        </div>
		    </a>
		    <?php else:endif; ?>
            </div>
        </div>
    <?php $this->related(6)->to($relatedPosts); if ($relatedPosts->have()):?>
		    <div class="post_related mb-3">    
		        <h3 class="widget-title">相关文章</h3>
		        <?php while ($relatedPosts->next()): ?> 
		            <div class="post_related_list">
		                <?php
		                $relatedRawTitle = once_decode_html_entities_deep($relatedPosts->title ?? '', 3);
		                $relatedTitle = \Typecho\Common::subStr($relatedRawTitle, 0, 25, '...');
		                ?>
		                <a href="<?php $relatedPosts->permalink(); ?>" class="" title="<?php echo once_esc_attr($relatedRawTitle); ?>">
		                    <?php echo once_esc_html($relatedTitle); ?>
		                </a>
		            </div>	
		        <?php endwhile; ?>	
	    </div>	 
    <?php endif;$this->need('comments.php'); ?>
</div><!-- #main-->
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
