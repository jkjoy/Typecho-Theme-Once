<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
/**
 * 友情链接
 *
 * @package custom
 */
$this->need('header.php'); ?>
<div class="col-lg-9">
    <div class="post_container_title">
        <h1><?php $this->title() ?></h1>
    </div>
    <div class="post_container">
        <article class="wznrys">
            <?php $this->content(); ?>
            <div class="links-page">
                <?php
                try {
                    $db = Typecho_Db::get();
                    $prefix = $db->getPrefix();
                    $links = $db->fetchAll(
                        $db->select()
                            ->from($prefix . 'links')
                            ->where('state = ?', 1)
                            ->order('sort', Typecho_Db::SORT_ASC)
                            ->order($prefix . 'links.order', Typecho_Db::SORT_ASC)
                    );

                    if (empty($links)) {
                        echo '<div class="page-empty">暂无友情链接数据。</div>';
                    } else {
                        $groups = [];
                        foreach ($links as $link) {
                            $sort = trim((string)($link['sort'] ?? ''));
                            $group = $sort !== '' ? $sort : '默认分类';
                            if (!isset($groups[$group])) {
                                $groups[$group] = [];
                            }
                            $groups[$group][] = $link;
                        }

                        echo '<div class="links-page-meta"><span>共 ' . count($links) . ' 个站点</span><span>' . count($groups) . ' 个分类</span></div>';
                        foreach ($groups as $groupName => $groupLinks) {
                            echo '<section class="links-group">';
                            echo '<div class="links-group-head"><h2>' . once_esc_html($groupName) . '</h2><span>' . count($groupLinks) . '</span></div>';
                            echo '<ul class="links-page-grid">';

                            foreach ($groupLinks as $link) {
                                $rawName = trim((string)($link['name'] ?? ''));
                                $name = once_esc_html($rawName !== '' ? $rawName : '未命名站点');
                                $url = once_esc_url($link['url'] ?? '#');
                                $descriptionRaw = trim((string)($link['description'] ?? ''));
                                $description = once_esc_html($descriptionRaw !== '' ? $descriptionRaw : ($link['url'] ?? ''));
                                $title = once_esc_attr($descriptionRaw !== '' ? $descriptionRaw : $rawName);
                                $image = once_esc_url($link['image'] ?? '');
                                $initialSource = $rawName !== '' ? $rawName : '友';
                                $initial = function_exists('mb_substr')
                                    ? mb_substr($initialSource, 0, 1, once_charset())
                                    : substr($initialSource, 0, 1);
                                $initial = once_esc_html($initial);

                                echo '<li class="links-page-card">';
                                echo '<a class="links-page-item" href="' . $url . '" target="_blank" rel="me noopener" title="' . $title . '">';
                                echo '<span class="links-page-avatar">';
                                if ($image !== '') {
                                    echo '<img src="' . $image . '" alt="' . once_esc_attr($rawName) . '" loading="lazy">';
                                } else {
                                    echo '<span>' . $initial . '</span>';
                                }
                                echo '</span>';
                                echo '<span class="links-page-main">';
                                echo '<span class="links-page-name">' . $name . '</span>';
                                echo '<span class="links-page-desc">' . $description . '</span>';
                                echo '</span>';
                                echo '<i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>';
                                echo '</a>';
                                echo '</li>';
                            }

                            echo '</ul>';
                            echo '</section>';
                        }
                    }
                } catch (Exception $e) {
                    echo '<p>友情链接数据不可用：请确认 links 表已初始化。</p>';
                }
                ?>
            </div>
        </article>
    </div>
</div>
<?php $this->need('sidebar.php'); $this->need('footer.php'); ?>
