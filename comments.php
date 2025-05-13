<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/comments.css'); ?>">
<?php 
// 获取父评论链接
function getPermalinkFromCoid($coid) {
    $db = Typecho_Db::get();
    $row = $db->fetchRow($db->select('author')->from('table.comments')->where('coid = ?', $coid));
    if (empty($row)) return '';
    return '<a href="#comment-' . $coid . '">@' . $row['author'] . '</a> ';
}
?>
<div class="post_comment" id="post_comment_anchor">
    <div id="comments" class="comments-area">
        <div class="layoutSingleColumn">
            <?php $this->comments()->to($comments); ?>
            <?php 
            $previousAuthor = isset($_COOKIE['__typecho_remember_author']) ? htmlspecialchars($_COOKIE['__typecho_remember_author']) : '';
            $previousEmail = isset($_COOKIE['__typecho_remember_mail']) ? htmlspecialchars($_COOKIE['__typecho_remember_mail']) : '';
            $previousUrl = isset($_COOKIE['__typecho_remember_url']) ? htmlspecialchars($_COOKIE['__typecho_remember_url']) : '';          
            $language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';
            if($this->allow('comment') && stripos($language, 'zh') > -1): 
            ?>
            <h3 class="comments-title">
                <i class="bi bi-filter me-2"></i>评论<small>(<?php $this->commentsNum(_t('0'), _t('1'), _t('%d')); ?>)</small>
            </h3>            
            <?php if ($this->commentsNum == 0): ?>
                <div class="no-comments">
                    <svg class="icon" style="width:3em;height:3em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="7595"><path d="M833 314.6c-43.8 28.2-61.9 48.2-87.8 47.1-25.9-1.1-70.5-28.6-88.9-36.4-29-12.3-70.3-21.6-95.6-5.3-20.1 14.5-2.9 39 4.6 48.1 7.4 9.1 43.7 36.4 54.4 49.8 6.1 7.7 6.7 18.8-5.8 20.6-24 6.7-41.4 1.6-57.3-1.8-15.8-3.3-32.2-15.3-57.7-13.7-32 2.1-21.1 29.7-21.1 29.7s26.4 78.7 97.6 96.5c62.2 15.6 347.3-127.7 378.6-180.1 30.5-50.5-59.3-94.2-121-54.5z m49.4 70.1c-32.8 24-119.1 69.2-216.8 109.3-32.5 13.3-60.8 22.1-80.5 16.7-21.7-6-44.6-19.8-52.3-37.3-3.3-7.6-1.9-12 8.7-7.6 13.2 5.5 24.6 6.9 39.8 8.8 17.8 2.2 34.7 0 34.7 0 28.7-4.3 32.8-11.2 39.5-19.2 7.8-9.4 9.3-22.3 4.3-39.5-5.4-18.9-30.3-36.4-30.3-36.4s-38.8-22.9-23.5-31.4c13-7.3 42 10.3 60.4 21.5 12 7.3 48.2 23.2 66.4 25.7 33.3 4.6 62.4-10.6 102.4-41.9 27.7-22.2 115.5-18.6 47.2 31.3zM801.7 530.5c-10.4 0-18.8 8.4-18.8 18.7-18.5 137.5-139.4 243.7-282.8 243.7-107.1 0-200.2-59.2-248.2-146.5 127.4-27.2 199.3-65.7 209.5-78.5 5.8-5.9 5.8-39.8-36.7-18.7-55.9 27.8-127.6 50.5-188.5 63.6-12.2-31.3-18.8-65.4-18.8-101 0-155.3 126.6-281.3 282.8-281.3 63.6 0 128.8 22.7 176.7 61.4 0 0 8.3 7 16.9 6.7 10.5-0.3 17.4-7.6 17.4-18 0-4.5-1.7-8.8-4.6-12.3 0.1-0.1-1.1-1.1-1.6-1.6-0.4-0.4-1-0.8-1.4-1.1-55.3-45.3-126.1-72.6-203.3-72.6-177 0-320.4 142.7-320.4 318.7 0 37.9 6.7 74.3 18.9 108.1-13.7 2.2-26.4 3.7-37.7 4.4-43.6 3-75.7-2-37.7-56.2 23.5-33.5 30.5-47.2 18.8-56.3-12.3-6.6-22.6 4.6-22.6 4.6s-44.5 52.3-53 89.1c-3.7 17.9-16.9 62.1 75.4 56.3 24.8-1.6 48.5-4.3 71.2-8 52.5 104.8 161.3 176.7 287 176.7 160.2 0 295.4-115.9 319.1-268.6 1.3-8.2 1.3-8.2 1.3-12.7 0-10.3-8.4-18.6-18.9-18.6z" p-id="7596"></path></svg>暂无评论
                </div>
            <?php else: ?>
                <?php $commentApprove = commentApprove($comments, $comments->mail); ?>                
                <?php if ($comments->have()): ?>
                <?php function threadedComments($comments, $options) {$commentClass = '';if ($comments->authorId) {if ($comments->authorId == $comments->ownerId) {$commentClass .= ' comment-by-author';} else {$commentClass .= ' comment-by-user';}}$commentApprove = commentApprove($comments, $comments->mail);?>
                    <li id="<?php $comments->theId(); ?>" class="comment even thread-even depth-1 <?php if ($comments->levels == 0) {echo 'comment parent';} else {echo 'comment child';}echo $commentClass; ?>">
                <article class="comment-body" id="div-<?php $comments->theId(); ?>">
                    <footer class="comment-meta">
                        <div class="comment-author vcard">
                            <?php echo $comments->gravatar('40', ''); ?>
                            <b class="fn">
                            <?php if ($comments->url): ?>
                                <a href="<?php echo $comments->url ?>" target="_blank" rel="external nofollow" title="<?php echo $commentApprove['userDesc']; ?>">
                                    <?php echo $comments->author; ?>
                                </a>
                            <?php else: ?>
                                <?php echo $comments->author; ?>  
                            <?php endif; ?>                            
                            <span style="margin-left: 10px;font-size:10px;color:<?php echo $commentApprove['bgColor']; ?>;">
                             <?php echo $commentApprove['userLevel']; ?>
                            </span>
                            </b><span class="says">说道：</span>
                        </div>
                        <div class="comment-metadata">
                            <a href="<?php $comments->permalink(); ?>" title="<?php $comments->date('Y-m-d H:i'); ?>">
                                <time datetime="<?php $comments->date('Y-m-d H:i'); ?>">
                                    <?php $comments->date('Y-m-d H:i'); ?>
                                </time>
                            </a>
                        </div><!-- .comment-metadata -->
                    </footer><!-- .comment-meta -->
                    <div class="comment-content">
                        <?php if ($comments->parent) {echo getPermalinkFromCoid($comments->parent);} $comments->content(); ?>
                    </div><!-- .comment-content -->
                    <div class="reply">
                        <?php $comments->reply(); ?>
                    </div>
                </article><!-- .comment-body -->
                <?php if ($comments->children) { ?>
                    <ol class="children">
                        <?php $comments->threadedComments($options); ?>
                    </ol><!-- .children -->
                <?php } ?>
            </li><!-- #comment-## -->
        <?php } ?>
        <?php if ($comments->have()): ?>
            <ol class="comment-list">
                <?php 
                $parameter = array(
                    'before'        => '',
                    'after'         => '',
                    'beforeAuthor'  => '',
                    'afterAuthor'   => '',
                    'beforeDate'    => '',
                    'afterDate'     => '',
                    'dateFormat'    => 'Y-m-d H:i'
                );
                $comments->listComments($parameter); 
                ?>
            </ol><!-- .comment-list -->
        <?php endif; ?>
                    <!-- 评论分页 -->
            <nav class="navigation comments-pagination" aria-label="评论分页">
                <?php $comments->pageNav('','',1,'...',
                        array(
                            'wrapTag' => 'div',
                            'wrapClass' => 'nav-links',
                            'itemTag' => '',
                            'textTag' => 'page-numbers current"',
                            'itemClass' => 'page-numbers',
                            'currentClass' => 'page-numbers current',
                            'prevClass' => 'hidden',
                            'nextClass' => 'hidden'
                        ));?>           
                    </nav>
                <?php endif; ?>
            <?php endif; ?>
                <!-- 评论表单 -->
                <div id="<?php $this->respondId(); ?>" class="comment-respond">
                <h3 id="reply-title" class="comment-reply-title">
                    <i class="bi bi-keyboard me-1"></i>发布评论 
                    <small>
                        <?php $comments->cancelReply(); ?>
                    </small>
                </h3>
                    <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" class="comment-form">
                        <?php if($this->user->hasLogin()): ?>
                        <p>
                            登录身份: <a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>.
                            <a href="<?php $this->options->logoutUrl(); ?>" title="Logout">退出 &raquo;</a>
                        </p>
                        <?php else: ?>
                        <p class="comment-form-author">
                            <input placeholder="称呼 *" type="text" name="author" id="author" class="text" value="<?php echo $previousAuthor; ?>" required />
                        </p>
                        <p class="comment-form-email">
                            <input placeholder="邮箱<?php if ($this->options->commentsRequireMail): ?> *<?php endif; ?>" type="email" name="mail" id="mail" class="text" value="<?php echo $previousEmail; ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> />
                        </p>
                        <p class="comment-form-url">
                            <input type="url" name="url" id="url" class="text" placeholder="http(s)://<?php if ($this->options->commentsRequireURL): ?> *<?php endif; ?>" value="<?php echo $previousUrl; ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> />
                        </p>
                        <?php endif; ?>                       
                        <p class="comment-form-comment">
                            <textarea rows="8" cols="50" name="text" id="textarea" class="textarea"  onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('misubmit').click();return false};"  placeholder="雁过留声,人过留名"  required><?php $this->remember('text'); ?></textarea>
                        </p>
                        <p class="form-submit">
                            <button type="submit" class="submit" id="misubmit">提交评论</button>
                        </p>
                    </form>
                </div><!-- #respond -->
            <?php endif; ?>
        </div>
    </div>
</div> 
<script>
// 评论表单提交处理
var commentForm = document.getElementById('comment-form');
if (commentForm) {
    commentForm.addEventListener('submit', function(event) {
        var author = document.getElementById('author');
        var mail = document.getElementById('mail');
        var url = document.getElementById('url');
        var textarea = document.getElementById('textarea');       
        // 检查评论内容是否为空
        if (textarea && textarea.value.trim() === '') {
            alert('必须填写评论内容');
            event.preventDefault();
            return false;
        }
        // 默认保存评论者信息
        if (author && mail && url) {
            setCookie('__typecho_remember_author', author.value, 30);
            setCookie('__typecho_remember_mail', mail.value, 30);
            setCookie('__typecho_remember_url', url.value, 30);
        }     
        // 禁用提交按钮防止重复提交
        var submitBtn = document.getElementById('misubmit');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '提交中...';
        }
    });
}
// Cookie设置函数
function setCookie(name, value, days) {
    var expires = '';
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = '; expires=' + date.toUTCString();
    }
    document.cookie = name + '=' + encodeURIComponent(value) + expires + '; path=/';
}
// Cookie删除函数
function deleteCookie(name) {
    setCookie(name, '', -1);
}
// Cookie获取函数
function getCookie(name) {
    var nameEQ = name + '=';
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1, c.length);
        }
        if (c.indexOf(nameEQ) == 0) {
            return decodeURIComponent(c.substring(nameEQ.length, c.length));
        }
    }
    return null;
}
// 页面加载时自动填充已保存的信息
document.addEventListener('DOMContentLoaded', function() {
    var author = document.getElementById('author');
    var mail = document.getElementById('mail');
    var url = document.getElementById('url');
    // 自动填充表单
    if (author) author.value = getCookie('__typecho_remember_author') || '';
    if (mail) mail.value = getCookie('__typecho_remember_mail') || '';
    if (url) url.value = getCookie('__typecho_remember_url') || '';  
    // 为评论添加过渡效果
    var comments = document.querySelectorAll('.comment-body');
    comments.forEach(function(comment) {
        comment.style.opacity = '0';
        comment.style.transform = 'translateY(10px)';
        setTimeout(function() {
            comment.style.opacity = '1';
            comment.style.transform = 'translateY(0)';
        }, 100);
    });
});
</script>