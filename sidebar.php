<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div class="col-lg-3">
<div class="sidebar_sticky">
    <div class="author_show_box">
<!-- 作者信息 -->
<?php
// 获取数据库实例
$db = Typecho_Db::get();
// 获取当前用户
$user = Typecho_Widget::widget('Widget_User');
// 确定要显示的用户
if ($user->hasLogin()) {
    // 用户已登录，显示当前用户信息
    $targetUser = $user;
    $userId = $user->uid;
} else {
    // 用户未登录，获取管理员信息
    try {
        // 查询管理员用户（通常 group='administrator' 或 uid=1）
        $adminUser = $db->fetchRow($db->select()
            ->from('table.users')
            ->where('group = ?', 'administrator')
            ->limit(1));

        if ($adminUser) {
            // 使用管理员信息创建临时用户对象
            $targetUser = new stdClass();
            $targetUser->uid = $adminUser['uid'];
            $targetUser->mail = $adminUser['mail'];
            $targetUser->screenName = $adminUser['screenName'];
            $userId = $adminUser['uid'];
        } else {
            // 如果找不到管理员，返回空
            echo "";
            return;
        }
    } catch (Exception $e) {
        // 生产环境不记录异常日志，直接降级
        echo "";
        return;
    }
}
// 查询用户的文章数量
$postCountRow = $db->fetchRow($db->select('COUNT(*) AS count')
    ->from('table.contents')
    ->where('authorId = ?', $userId)
    ->where('type = ?', 'post')
    ->where('status = ?', 'publish'));
$postCount = isset($postCountRow['count']) ? intval($postCountRow['count']) : 0;

// 查询用户的评论数量
$commentCountRow = $db->fetchRow($db->select('COUNT(*) AS count')
    ->from('table.comments')
    ->where('authorId = ?', $userId)
    ->where('status = ?', 'approved'));
$commentCount = isset($commentCountRow['count']) ? intval($commentCountRow['count']) : 0;

// 生成 Gravatar 头像 URL
$email = $targetUser->mail;
$options = Typecho_Widget::widget('Widget_Options');
$gravatarPrefix = empty($options->cnavatar) ? 'https://cravatar.cn/avatar/' : $options->cnavatar;
$gravatarUrl = $gravatarPrefix . md5(strtolower(trim($email))) . '?s=80&d=mm&r=g';
$gravatarUrl2x = $gravatarPrefix . md5(strtolower(trim($email))) . '?s=160&d=mm&r=g';
?>
<div class="author_show_head">
    <img alt='<?php echo htmlspecialchars($targetUser->screenName); ?>'
         src='<?php echo htmlspecialchars($gravatarUrl); ?>'
         srcset='<?php echo htmlspecialchars($gravatarUrl2x); ?> 2x'
         class='avatar avatar-80 photo'
         height='80' width='80'
         loading='lazy'
         decoding='async'/>
    <h3><?php echo htmlspecialchars($targetUser->screenName); ?></h3>
    <p></p>
</div>
<div class="author_show_info">
    <span><i class="bi bi-book"></i><b>文章</b><?php echo $postCount; ?></span>
    <span><i class="bi bi-chat-square-dots"></i><b>评论</b><?php echo $commentCount; ?></span>
</div>
<?php
$sidebarBlock = !empty($this->options->sidebarBlock) ? (array)$this->options->sidebarBlock : array();
?>
<?php if (in_array('ShowRecentPosts', $sidebarBlock)): ?>
    <ul class="author_post">
    <?php
        // 直接使用数据库查询获取最近文章，避免与其他Widget冲突
        try {
            $recentPosts = $db->fetchAll($db->select()
                ->from('table.contents')
                ->where('type = ? AND status = ?', 'post', 'publish')
                ->order('created', Typecho_Db::SORT_DESC)
                ->limit(3)
            );
            
            if (!empty($recentPosts)):
                foreach ($recentPosts as $post):
                    try {
                        // 使用Widget_Abstract_Contents处理文章数据，确保获取正确的链接等
                        $temp_post = Typecho_Widget::widget('Widget_Abstract_Contents')->filter($post);
                        $result = get_post_thumbnail($post);
                        $thumbnail = !empty($result['cropped_images']) ? $result['cropped_images'][0] : $result['thumbnail'];
                        $title = isset($temp_post['title']) ? htmlspecialchars($temp_post['title']) : '';
                        $permalink = isset($temp_post['permalink']) ? htmlspecialchars($temp_post['permalink']) : '#';
                        $commentsNum = isset($temp_post['commentsNum']) ? intval($temp_post['commentsNum']) : 0;
        ?>
            <li>
                <img width="400" height="280" src="<?php echo htmlspecialchars($thumbnail); ?>"
                         data-src="<?php echo htmlspecialchars($thumbnail); ?>"
                         class="thumbnail lazyload"
                         alt="<?php echo $title; ?>"
                         decoding="async" loading="lazy"
                         onerror="this.onerror=null;this.src='<?php echo Helper::options()->themeUrl; ?>/assets/img/nopic.svg';" 
                         />
                <div class="author_title">
                    <h4><a href="<?php echo $permalink; ?>" class="stretched-link"><?php echo $title; ?></a></h4>
                    <p><?php echo $commentsNum; ?> 条留言</p>
                </div>
            </li>
        <?php
                    } catch (Exception $e) {
                        continue; // 跳过处理有问题的文章
                    }
                endforeach;
            else:
        ?>
            <li>暂无最近文章</li>
        <?php 
            endif;
        } catch (Exception $e) {
            echo '<li>获取文章失败</li>';
        }
        ?>
    </ul>
</div>
<?php endif; ?>

<!-- 热门文章 -->
<?php if (in_array('ShowHotPosts', $sidebarBlock)): ?>
    <?php
    try {
        $hotPosts = $db->fetchAll($db->select()
            ->from('table.contents')
            ->where('type = ? AND status = ?', 'post', 'publish')
            ->order('commentsNum', Typecho_Db::SORT_DESC)
            ->limit(5)
        );
    } catch (Exception $e) {
        $hotPosts = array();
    }

    if (!empty($hotPosts)):
    ?>
        <aside id="hot_posts-2" class="widget widget_hot_posts">
            <h3 class="widget-title">热门文章</h3>
            <ul class="widget_hot_post">
                <?php
                foreach ($hotPosts as $post):
                    try {
                        // 使用 Widget_Abstract_Contents 处理文章数据
                        $temp_post = Typecho_Widget::widget('Widget_Abstract_Contents')->filter($post);
                        $post_images = get_post_thumbnail($post);
                        // 获取缩略图URL，如果没有图片则使用默认图片
                        $thumbnail = !empty($post_images['cropped_images']) ? $post_images['cropped_images'][0] : $post_images['thumbnail'];
                        $title = isset($temp_post['title']) ? htmlspecialchars($temp_post['title']) : '';
                        $permalink = isset($temp_post['permalink']) ? htmlspecialchars($temp_post['permalink']) : '#';
                        $commentsNum = isset($temp_post['commentsNum']) ? intval($temp_post['commentsNum']) : 0;
                ?>
                        <li class="widget_hot_li">
                            <img width="400"
                                 height="280"
                                 src="<?php echo htmlspecialchars($thumbnail); ?>"
                                 data-src="<?php echo htmlspecialchars($thumbnail); ?>"
                                 class="thumbnail lazyload"
                                 alt="<?php echo $title; ?>"
                                 decoding="async"
                                 loading="lazy"
                                 onerror="this.onerror=null;this.src='<?php echo Helper::options()->themeUrl; ?>/assets/img/nopic.svg';" />
                            <div class="hot_post_info">
                                <h4>
                                    <a class="stretched-link"
                                       href="<?php echo $permalink; ?>">
                                        <?php echo $title; ?>
                                    </a>
                                </h4>
                                <p><?php echo $commentsNum; ?> 条留言</p>
                            </div>
                        </li>
                <?php
                    } catch (Exception $e) {
                        // 忽略单篇异常
                        continue;
                    }
                endforeach;
                ?>
            </ul>
        </aside>
    <?php else: ?>
        <p>无热门文章</p>
    <?php endif; ?>
<?php endif; ?>

<!-- 最近回复 -->
<?php if (in_array('ShowRecentComments', $sidebarBlock)): ?>
    <aside id="comments-3" class="widget widget_comments">
        <h3 class="widget-title"><?php _e('最近回复'); ?></h3>
        <ul class="widget_comment_ul">
        <?php $comments = \Widget\Comments\Recent::alloc(array('ignoreAuthor' => true)); ?>
            <?php while ($comments->next()): ?>
                <li>
                <?php echo $comments->gravatar('40', ''); ?>
                <div class="widget_comment_info">
                <a rel="nofollow" href="<?php $comments->permalink(); ?>"><?php $comments->excerpt(35, '...'); ?></a>
                <span>
                    <em><?php $comments->author(false); ?></em>
                    <em><?php $comments->date('Y-m-d H:i'); ?></em>
                </span>
                </div>
                </li>
            <?php endwhile; ?>
        </ul>
    </aside>
<?php endif; ?>

<!-- 热门标签 -->
<?php if (in_array('ShowTags', $sidebarBlock)): ?>
    <?php
    // 获取热门标签
    $tags = \Widget\Metas\Tag\Cloud::alloc('sort=count&desc=1&limit=20');
    if ($tags->have()):
    ?>
        <aside id="hot_tags-2" class="widget widget_hot_tags">
            <h3 class="widget-title">热门标签</h3>
            <div class="tagcloud">
                <?php while ($tags->next()): ?>
                    <a href="<?php $tags->permalink(); ?>"
                       title="<?php $tags->name(); ?> (<?php $tags->count(); ?> 篇文章)"
                       class="tag-item">
                        <?php $tags->name(); ?>
                    </a>
                <?php endwhile; ?>
            </div>
        </aside>
    <?php else: ?>
        <aside id="hot_tags-2" class="widget widget_hot_tags">
            <h3 class="widget-title">热门标签</h3>
            <div class="tagcloud"></div>
        </aside>
    <?php endif; ?>
<?php endif; ?>

 <!-- 其它 -->
<?php if (in_array('ShowOther', $sidebarBlock)): ?>
        <aside id="misc-2" class="widget widget_misc">
            <h3 class="widget-title"><?php _e('其它'); ?></h3>
            <ul class="widget_misc_ul">
                <?php if ($this->user->hasLogin()): ?>
                    <li>
                        <a href="<?php $this->options->adminUrl(); ?>"><?php _e('<i class="bi bi-box-arrow-in-right me-1"></i> 进入后台'); ?>
                            (<?php $this->user->screenName(); ?>)
                        </a>
                    </li>
                    <li>
                        <a href="<?php $this->options->logoutUrl(); ?>"><?php _e('<i class="bi bi-box-arrow-right me-1"></i> 退出'); ?></a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="<?php $this->options->adminUrl('login.php'); ?>"><?php _e('<i class="bi bi-box-arrow-in-right me-1"></i> 登录'); ?></a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="<?php $this->options->feedUrl(); ?>"><?php _e('<i class="bi bi-rss me-1"></i> 文章 '); ?></a>
                </li>
                <li>
                    <a href="<?php $this->options->commentsFeedUrl(); ?>"><?php _e('<i class="bi bi-rss-fill me-1"></i> 评论 '); ?></a>
                </li>
            </ul>
        </aside>
<?php endif; ?>
</div>