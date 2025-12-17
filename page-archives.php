<?php 
/**
 * 文章归档
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div class="col-lg-9">
    <div class="post_container_title">
	    <h1><?php $this->title() ?></h1>
	</div>
    <div class="post_container">
    <div class="widget widget_recent_entries">
        <?php
        // 使用数据库直接查询文章，避免与侧边栏冲突
        $db = \Typecho\Db::get();
        $posts = $db->fetchAll($db->select('cid', 'title', 'slug', 'created', 'commentsNum')
            ->from('table.contents')
            ->where('type = ?', 'post')
            ->where('status = ?', 'publish')
            ->order('created', \Typecho\Db::SORT_DESC));
        $output = ''; // 初始化输出变量
        $year = ''; // 当前年份
        $month = ''; // 当前月份
        foreach ($posts as $post) {
            // 处理文章数据
            $permalink = \Typecho\Router::url('post', $post, $this->options->index);
            $charset = Helper::options()->charset ? Helper::options()->charset : 'UTF-8';
            $titleDecoded = html_entity_decode((string)$post['title'], ENT_QUOTES | ENT_HTML5, $charset);
            $title = htmlspecialchars($titleDecoded, ENT_QUOTES | ENT_SUBSTITUTE, $charset);
            $created = $post['created'];
            // 获取年月日
            $postYear = date('Y', $created);
            $postMonth = date('m', $created);
            $postDay = date('d', $created);

            $output .= '<ul>';
            $output .= '<li>';
            $output .= '<p>'. date('Y-m-d', $created) .'<div class="archive-title"><a  href="' . $permalink . '">' . $title . '</a></div></p>';
            $output .= '</li>';
            $output .= '</ul>';
        }
        echo $output;
        ?>
    </div>
    </div>
</div>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
<style>.widget_recent_entries .archive-title a{font-size: 1rem !important;}</style>