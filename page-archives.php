<?php 
/**
 * 文章归档
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div class="col-lg-8">
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
            $title = htmlspecialchars($post['title']);
            $created = $post['created'];
            //$commentsNum = $post['commentsNum'];
            // 获取年月日
            $postYear = date('Y', $created);
            $postMonth = date('m', $created);
            $postDay = date('d', $created);
            // 如果年份变化，添加年份标题
           // if ($year != $postYear) {
                // 如果不是第一个年份，关闭上一个月份的列表
            //    if ($year != '') {
           //         $output .= '</ul>';
           //     }
           //     $year = $postYear;
           //     $month = '';
              //  $output .= '<div class="widget-title"><h3>' . $year . '年</h3></div>';
              $output .= '<ul>';
           // }
            // 如果月份变化，添加月份标题
           // if ($month != $postMonth) {
                // 如果不是第一个月份，关闭上一个月份的列表
            //    if ($month != '') {
            //        $output .= '</ul>';
            //    }
            //    $month = $postMonth;
           //     $output .= '<h4 class="archive-month">' . $month . '月</h4><ul>';
           // }
            $output .= '<li>';
            // 输出文章项
           // $output .= '<li><span>';
            //$output .= '<i><time datetime="' . date('Y-m-d', $created) .'">' . $postDay . '日</time></i>';
           // $output .= '</span>';
            $output .= '<p>'. date('Y-m-d', $created) .'<div class="archive-title"><a  href="' . $permalink . '">' . $title . '</a></div></p>';
            // 添加评论数
           // if ($commentsNum > 0) {
           //     $output .= '(' . $commentsNum . '条评论)';
           // }
            $output .= '</li>';
            $output .= '</ul>';
        }
        // 关闭最后一个列表
       // if ($year != '') {
        //    $output .= '</ul>';
        //}
        echo $output;
        ?>
    </div>
    </div>
</div>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
<style>.widget_recent_entries .archive-title a{font-size: 1rem !important;}</style>