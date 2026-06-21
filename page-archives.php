<?php 
/**
 * 文章归档
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php'); ?>
<div class="col-lg-9">
    <div class="post_container_title">
	    <h1><?php $this->title() ?></h1>
	</div>
    <div class="post_container">
    <div class="archives-page">
        <?php
        // 使用数据库直接查询文章，避免与侧边栏冲突
        $db = \Typecho\Db::get();
        $posts = $db->fetchAll($db->select('cid', 'title', 'slug', 'created', 'commentsNum')
            ->from('table.contents')
            ->where('type = ?', 'post')
            ->where('status = ?', 'publish')
            ->order('created', \Typecho\Db::SORT_DESC));

        if (empty($posts)) {
            echo '<div class="page-empty">暂无归档文章。</div>';
        } else {
            $total = count($posts);
            $years = [];
            foreach ($posts as $post) {
                $years[date('Y', (int)$post['created'])] = true;
            }

            echo '<div class="archives-page-meta"><span>共 ' . $total . ' 篇文章</span><span>' . count($years) . ' 个年份</span></div>';

            $currentYear = '';
            $currentMonth = '';
            foreach ($posts as $post) {
                $created = (int)$post['created'];
                $postYear = date('Y', $created);
                $postMonth = date('m', $created);

                if ($postYear !== $currentYear) {
                    if ($currentMonth !== '') {
                        echo '</ul></section>';
                    }
                    if ($currentYear !== '') {
                        echo '</div>';
                    }
                    $currentYear = $postYear;
                    $currentMonth = '';
                    echo '<div class="archive-year-block">';
                    echo '<div class="archive-year">' . once_esc_html($currentYear) . '</div>';
                }

                if ($postMonth !== $currentMonth) {
                    if ($currentMonth !== '') {
                        echo '</ul></section>';
                    }
                    $currentMonth = $postMonth;
                    echo '<section class="archive-month-block">';
                    echo '<h2><span>' . once_esc_html(date('m 月', $created)) . '</span></h2>';
                    echo '<ul class="archive-list">';
                }

                $permalink = \Typecho\Router::url('post', $post, $this->options->index);
                $rawTitle = once_decode_html_entities_deep((string)$post['title'], 3);
                $title = once_esc_html($rawTitle);
                $commentsNum = (int)($post['commentsNum'] ?? 0);

                echo '<li class="archive-item">';
                echo '<time datetime="' . date('Y-m-d', $created) . '"><span>' . date('d', $created) . '</span> </time>';
                echo '<a class="archive-title" href="' . once_esc_url($permalink) . '">' . $title . '</a>';
                echo '<span class="archive-count"><i class="bi bi-chat-dots" aria-hidden="true"></i>' . $commentsNum . '</span>';
                echo '</li>';
            }

            if ($currentMonth !== '') {
                echo '</ul></section>';
            }
            if ($currentYear !== '') {
                echo '</div>';
            }
        }
        ?>
    </div>
    </div>
</div>
<?php $this->need('sidebar.php');$this->need('footer.php'); ?>
