<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
require_once __DIR__ . '/partials/backup.php';
function themeConfig($form)
{   
    echo '<style>.typecho-page-title h2 {font-weight: 600;color: #737373;}.typecho-page-title h2:before {content: "#";margin-right: 6px;color:#00b2ff; font-size: 20px;font-weight: 600;}.themeConfig h3 {color: #737373;font-size: 20px;}.themeConfig h3:before {content: "[";margin-right: 5px;color:#00b2ff;font-size: 25px;}.themeConfig h3:after {content: "]";margin-left: 5px;color: #00b2ff;font-size: 25px;}.info{border: 1px solid #4d75b3;padding: 20px;margin: -15px 10px 25px 0;background: #ffffff;border-radius: 5px;color: #0984E3;}.info a{color: #ff004c;}</style>';
    themeAutoUpgradeNotice();
    $logoUrl = new \Typecho\Widget\Helper\Form\Element\Text(
        'logoUrl',
        null,
        null,
        _t('<span class="themeConfig"><h3>博客设置</h3></span>站点 LOGO 地址'),
        _t('图片 URL 地址, 以在网站标题前显示 LOGO')
    );
    $form->addInput($logoUrl);
    $faviconUrl = new \Typecho\Widget\Helper\Form\Element\Text(
        'faviconUrl',
        null,
        null,
        _t('站点 Favicon 地址'),
        _t('图片 URL 地址, 以显示浏览器标签页 Favicon')
    );
    $form->addInput($faviconUrl); 
    $thumbUrl = new \Typecho\Widget\Helper\Form\Element\Text(
        'thumbUrl',
        null,
        null,
        _t('默认文章缩略图地址'),
        _t('默认的文章缩略图地址')
    );    
    $form->addInput($thumbUrl); 
    $darkMode = new Typecho_Widget_Helper_Form_Element_Radio(
        'darkMode',
        array(
            'auto' => '自动切换',
            'light' => '始终浅色',
            'dark' => '始终深色'
        ),
        'auto',
        '显示模式',
        '选择站点外观模式。'
    );
    $form->addInput($darkMode);
    $lxgw = new Typecho_Widget_Helper_Form_Element_Radio('lxgw', ['0' => _t('默认字体'), '1' => _t('霞鹜文楷')], '0', _t('选择字体'), _t('选择站点字体'));
    $form->addInput($lxgw);
    $cnavatar = new Typecho_Widget_Helper_Form_Element_Text('cnavatar', NULL, NULL, _t('Gravatar镜像'), _t('默认https://cravatar.cn/avatar/'));
    $form->addInput($cnavatar);
    $slidePosts = new Typecho_Widget_Helper_Form_Element_Text(
        'slidePosts',
        NULL,
        NULL,
        _t('<span class="themeConfig"><h3>Hero设置</h3></span><div class="info">图文推荐展示设置</div>幻灯片文章'),
        _t('输入文章的 CID，多个请用英文逗号或空格分隔，如：1,2,3 或 1 2 3')
    );
    $form->addInput($slidePosts);   
    $midCenter = new Typecho_Widget_Helper_Form_Element_Text('midCenter', NULL, '', _t('中间展示分类,填写两个分类mid,用英文逗号或空格分隔'), _t('请输入分类的mid'));
    $form->addInput($midCenter);
    $midRight = new Typecho_Widget_Helper_Form_Element_Text('midRight', NULL, '', _t('右边展示分类,填写一个分类mid'), _t('请输入分类的mid'));
    $form->addInput($midRight);
    $icpbeian = new Typecho_Widget_Helper_Form_Element_Text('icpbeian', NULL, NULL, _t('<span class="themeConfig"><h3>底部设置</h3></span><div class="info">个性化设置</div>备案号码'), _t('不填写则不显示'));
    $form->addInput($icpbeian);
    $showlinks = new Typecho_Widget_Helper_Form_Element_Radio('showlinks', ['0' => _t('不显示'), '1' => _t('显示')], '0', _t('选择<b>显示</b>前请先启用links插件. 友情链接'), _t('是否显示首页友情链接'));
    $form->addInput($showlinks);
    $tongji = new Typecho_Widget_Helper_Form_Element_Textarea('tongji', NULL, '<li><a href="/">首页</a></li>', _t('Footer代码'), _t('支持HTML'));
    $form->addInput($tongji);
    $sidebarBlock = new \Typecho\Widget\Helper\Form\Element\Checkbox(
        'sidebarBlock',
        [
            'ShowRecentPosts'    => _t('显示最新文章'),
            'ShowRecentComments' => _t('显示最近回复'),
            'ShowHotPosts'       => _t('显示热门文章'),
            'ShowTags'           => _t('显示标签'),
            'ShowOther'          => _t('显示其它杂项')
        ],
        ['ShowRecentPosts', 'ShowRecentComments', 'ShowHotPosts', 'ShowTags', 'ShowOther'],
        _t('<span class="themeConfig"><h3>侧边栏设置</h3></span><div class="info">侧边栏显示</div>')
    );
    $form->addInput($sidebarBlock->multiMode());
    $recentarticle = new Typecho_Widget_Helper_Form_Element_Text('recentarticle', NULL, '3', _t('最新文章数量'), _t('默认数量3，侧边栏最新文章模块显示的文章数量'));
    $recentarticle->input->setAttribute('class', 'w-10');
    $form->addInput($recentarticle->addRule('isInteger', _t('请填写整数数字')));

    $hotarticle = new Typecho_Widget_Helper_Form_Element_Text('hotarticle', NULL, '5', _t('热门文章数量'), _t('默认数量5，侧边栏热门文章模块显示的文章数量'));
    $hotarticle->input->setAttribute('class', 'w-10');
    $form->addInput($hotarticle->addRule('isInteger', _t('请填写整数数字')));

    $hottags = new Typecho_Widget_Helper_Form_Element_Text('hottags', NULL, '20', _t('热门标签数量'), _t('默认数量20，侧边栏热门标签模块显示的标签数量'));
    $hottags->input->setAttribute('class', 'w-10');
    $form->addInput($hottags->addRule('isInteger', _t('请填写整数数字')));
    $friend = new Typecho_Widget_Helper_Form_Element_Textarea('friend', NULL, NULL, _t('<span class="themeConfig"><h3>评论相关设置</h3></span><div class="info">好友认证</div>好友邮箱'), _t('一行一个邮箱地址,用于评论区好友等级认证'));
    $form->addInput($friend);
    // 主题备份功能钩子
    if (function_exists('once_render_theme_backup_section')) {
        once_render_theme_backup_section();
    }
}

/**
 * 将时间戳转换为"多久之前"的格式
 *
 * @param int $timestamp 时间戳
 * @return string
 */
function time_ago($timestamp) {
    $current_time = time();
    $time_diff = $current_time - $timestamp;

    if ($time_diff < 60) {
        return $time_diff . ' 秒前';
    } elseif ($time_diff < 3600) {
        return floor($time_diff / 60) . ' 分钟前';
    } elseif ($time_diff < 86400) {
        return floor($time_diff / 3600) . ' 小时前';
    } elseif ($time_diff < 2592000) {
        return floor($time_diff / 86400) . ' 天前';
    } elseif ($time_diff < 31536000) {
        return floor($time_diff / 2592000) . ' 个月前';
    } else {
        return floor($time_diff / 31536000) . ' 年前';
    }
}

/**
 * 关闭评论反垃圾保护
 * 评论层级突破999
 * 关闭检查评论来源URL与文章链接是否一致判断
 * 最新评论显示在前
 */
function themeInit($archive)
{
    Helper::options()->commentsAntiSpam = false; 
    Helper::options()->commentsMaxNestingLevels = 999;
    Helper::options()->commentsOrder = 'DESC';
    Helper::options()->commentsCheckReferer = false;
}

/**
* Gravatar镜像
*/
$options = Typecho_Widget::widget('Widget_Options');
$gravatarPrefix = empty($options->cnavatar) ? 'https://cravatar.cn/avatar/' : $options->cnavatar;
define('__TYPECHO_GRAVATAR_PREFIX__', $gravatarPrefix);

/**
* 页面加载时间
*/
function timer_start() {
    global $timestart;
    $mtime = explode( ' ', microtime() );
    $timestart = $mtime[1] + $mtime[0];
    return true;
}
    timer_start();
function timer_stop( $display = 0, $precision = 3 ) {
    global $timestart, $timeend;
    $mtime = explode( ' ', microtime() );
    $timeend = $mtime[1] + $mtime[0];
    $timetotal = number_format( $timeend - $timestart, $precision );
    $r = $timetotal < 1 ? $timetotal * 1000 . " ms" : $timetotal . " s";
    if ( $display ) {
    echo $r;
    }
    return $r;
}

/*
* 文章浏览数统计
*/
function get_post_view($archive) {
    $cid = $archive->cid;
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        echo 0;
        return;
    }
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if ($archive->is('single')) {
        $views = Typecho_Cookie::get('extend_contents_views');
        if (empty($views)) {
            $views = array();
        } else {
            $views = explode(',', $views);
        }
        if (!in_array($cid, $views)) {
            $db->query($db->update('table.contents')->rows(array('views' => (int)$row['views'] + 1))->where('cid = ?', $cid));
            array_push($views, $cid);
            $views = implode(',', $views);
            Typecho_Cookie::set('extend_contents_views', $views); //记录查看cookie
            
        }
    }
    echo $row['views'];
}

/**
 * 处理文章点赞
*/
if (isset($_POST['action']) && $_POST['action'] == 'specs_zan') {
    handlePostLike();
}

function handlePostLike() {
    if (isset($_POST['cid'])) {
        $db = Typecho_Db::get();
        $cid = $_POST['cid'];     
        // 获取当前点赞数
        $row = $db->fetchRow($db->select('str_value')
            ->from('table.fields')
            ->where('cid = ?', $cid)
            ->where('name = ?', 'likes'));           
        $likes = isset($row['str_value']) ? intval($row['str_value']) : 0;
        $likes = $likes + 1;       
        // 更新点赞数
        if (isset($row['str_value'])) {
            $db->query($db->update('table.fields')
                ->rows(array('str_value' => $likes))
                ->where('cid = ?', $cid)
                ->where('name = ?', 'likes'));
        } else {
            $db->query($db->insert('table.fields')
                ->rows(array(
                    'cid' => $cid,
                    'name' => 'likes',
                    'type' => 'str',
                    'str_value' => '1'
                )));
        }        
        echo $likes;
        exit;
    }
}

/**
 * 获取用户文章总数
 */
function getPostsCount() {
    $db = Typecho_Db::get();
    return $db->fetchObject($db->select(array('COUNT(cid)' => 'num'))
        ->from('table.contents')
        ->where('type = ?', 'post')
        ->where('status = ?', 'publish'))->num;
}

/**
 * 获取文章缩略图和所有图片
 * 
 * @param object|array $post 文章对象或数组
 * @return array 包含缩略图URL、所有图片数组(最多9张)和实际图片总数
 */
function get_post_thumbnail($post) {
    if (is_array($post)) $post = (object)$post;
    $default_thumbnail = Helper::options()->themeUrl . '/assets/img/nopic.svg';
    // 从主题设置中获取自定义缩略图（后台填写的默认地址）
    $custom_thumbnail = Helper::options()->thumbUrl ?? ''; 
    
    // 使用自定义缩略图（如果已设置）
    if (!empty($custom_thumbnail)) {
        $default_thumbnail = $custom_thumbnail;
    }
    
    $result = array(
        'thumbnail' => $default_thumbnail,
        'images' => array(),
        'cropped_images' => array(), // 新增
        'count' => 0,
        'total_count' => 0 
    );  
    
    if (!$post) return $result;
    $content = '';
    if (!empty($post->text)) $content = $post->text;
    elseif (!empty($post->content)) $content = $post->content;
    elseif (method_exists($post, 'content') && is_callable([$post, 'content'])) $content = $post->content();
    $images = array();
    if (!empty($content)) {
        preg_match_all('/<img[^>]*src=[\'"]([^\'"]+)[\'"][^>]*>/i', $content, $html_matches);
        if (!empty($html_matches[1])) {
            foreach ($html_matches[1] as $img_url) {
                if (strpos($img_url, 'http') !== 0 && strpos($img_url, '//') !== 0) {
                    $img_url = Helper::options()->siteUrl . ltrim($img_url, '/');
                }
                $images[] = $img_url;
            }
        }
        // URL直链
        preg_match_all('/(https?:\/\/[^\s<>\"\']*?\.(?:jpg|jpeg|png|gif|webp))(\?[^\s<>\"\']*)?/i', $content, $url_matches);
        if (!empty($url_matches[1])) {
            $images = array_merge($images, $url_matches[1]);
        }
        // 去重
        $images = array_unique($images);
        $images = array_values($images);
        $total_count = count($images);
        if (count($images) > 9) {
            $thumbnail = $images[0];
            $images = array_slice($images, 0, 9);
            if (!in_array($thumbnail, $images)) {
                $images[8] = $thumbnail;
            }
        }
        // 只生成首图缩略图，避免一次请求生成多张缩略图导致卡顿
        $cropped_images = array();
        if (!empty($images[0])) {
            $cropped_images[] = get_thumb($images[0]);
        }
        $result['images'] = $images;
        $result['cropped_images'] = $cropped_images;
        $result['count'] = count($images);
        $result['total_count'] = $total_count;
        if (!empty($images)) {
            $result['thumbnail'] = $images[0];
        }
    }
    return $result;
}

/**
 * 生成缩略图
 * 
 * @param string $imgUrl 原始图片URL
 * @return string 缩略图URL
 */
function get_thumb($imgUrl) {
    $upload_dir = __TYPECHO_ROOT_DIR__ . '/usr/thumbnails/';
    // 获取默认缩略图URL（用于图片加载失败时）
    $default_thumbnail = Helper::options()->themeUrl . '/assets/img/nopic.svg';
    $custom_thumbnail = Helper::options()->thumbUrl ?? '';
    if (!empty($custom_thumbnail)) {
        $default_thumbnail = $custom_thumbnail;
    }
    
    // 确保缓存目录存在
    if (!is_dir($upload_dir)) {
        if (!@mkdir($upload_dir, 0755, true)) {
            return $default_thumbnail; // 如果无法创建目录，返回默认图片
        }
    }
    // 生成唯一文件名
    $hash = md5($imgUrl);
    $thumbnail_path = $upload_dir . $hash . '.webp';
    $thumbnail_url = Helper::options()->siteUrl . 'usr/thumbnails/' . $hash . '.webp';
    $fail_path = $thumbnail_path . '.fail';
    $lock_path = $thumbnail_path . '.lock';
    $fail_ttl = 6 * 3600; // 失败缓存 6 小时，避免每次请求都阻塞重试

    // 如果缩略图已存在，直接返回
    if (file_exists($thumbnail_path)) {
        return $thumbnail_url;
    }

    // 最近生成失败过，直接返回原图（由 <img onerror> 兜底）
    if (file_exists($fail_path) && (time() - filemtime($fail_path)) < $fail_ttl) {
        return $imgUrl;
    }

    // GD 不可用直接返回原图
    if (!function_exists('imagecreatefromstring') || !function_exists('imagewebp')) {
        return $imgUrl;
    }

    // 并发锁：避免多个请求同时生成同一张缩略图
    $lock_fp = @fopen($lock_path, 'c');
    if ($lock_fp) {
        if (!@flock($lock_fp, LOCK_EX | LOCK_NB)) {
            @fclose($lock_fp);
            return $imgUrl;
        }
    }

    // 拿到锁后再检查一次
    if (file_exists($thumbnail_path)) {
        if ($lock_fp) {
            @flock($lock_fp, LOCK_UN);
            @fclose($lock_fp);
        }
        return $thumbnail_url;
    }

    // 尽量走本地文件读取，避免 HTTP 自己请求自己导致变慢
    $img_data = false;
    $img_url_str = (string)$imgUrl;
    $site_url = (string)Helper::options()->siteUrl;
    $site_host = '';
    $parsed_site = @parse_url($site_url);
    if ($parsed_site && isset($parsed_site['host'])) {
        $site_host = strtolower($parsed_site['host']);
    }
    $parsed_img = @parse_url($img_url_str);
    if ($parsed_img && isset($parsed_img['path'])) {
        $img_host = isset($parsed_img['host']) ? strtolower($parsed_img['host']) : '';
        $img_path = $parsed_img['path'];
        if ($img_path && ($img_host === '' || $img_host === $site_host)) {
            $root_real = @realpath(__TYPECHO_ROOT_DIR__);
            $candidate = @realpath(__TYPECHO_ROOT_DIR__ . '/' . ltrim($img_path, '/'));
            if ($root_real && $candidate && stripos($candidate, $root_real) === 0 && is_file($candidate) && is_readable($candidate)) {
                $img_data = @file_get_contents($candidate);
            }
        }
    }

    // 远程拉取（设置超时，避免卡顿）
    if ($img_data === false) {
        $ctx = stream_context_create([
            'http' => [
                'header' => "User-Agent: Typecho-Theme-Once\r\n",
                'timeout' => 3,
                'follow_location' => 1,
                'max_redirects' => 3
            ]
        ]);
        $img_data = @file_get_contents($img_url_str, false, $ctx);
    }

    if ($img_data === false) {
        @file_put_contents($fail_path, (string)time());
        if ($lock_fp) {
            @flock($lock_fp, LOCK_UN);
            @fclose($lock_fp);
        }
        return $imgUrl;
    }
    // 创建图片资源
    $src = @imagecreatefromstring($img_data);
    if (!$src) {
        @file_put_contents($fail_path, (string)time());
        if ($lock_fp) {
            @flock($lock_fp, LOCK_UN);
            @fclose($lock_fp);
        }
        return $imgUrl; // 图片格式无效或无法创建资源时，返回原图
    }
    try {
        $width = imagesx($src);
        $height = imagesy($src);
        // 计算缩略图尺寸
        $target_ratio = 400 / 280;
        $src_ratio = $width / $height; 
        if ($src_ratio > $target_ratio) {
            $new_height = $height;
            $new_width = $height * $target_ratio;
            $src_x = ($width - $new_width) / 2;
            $src_y = 0;
        } else {
            $new_width = $width;
            $new_height = $width / $target_ratio;
            $src_x = 0;
            $src_y = ($height - $new_height) / 2;
        }
        // 计算最终尺寸
        $scale = min(400/$new_width, 280/$new_height);
        $dst_width = (int)($new_width * $scale);
        $dst_height = (int)($new_height * $scale);
        // 创建目标图像
        $thumb = imagecreatetruecolor($dst_width, $dst_height);
        // 处理透明背景
        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);
        // 重采样
        imagecopyresampled(
            $thumb, $src,
            0, 0, $src_x, $src_y,
            $dst_width, $dst_height,
            $new_width, $new_height
        );
        // 保存缩略图（先写临时文件再替换，避免并发/中断导致损坏）
        $tmp_path = $thumbnail_path . '.tmp';
        imagewebp($thumb, $tmp_path, 80);
        @rename($tmp_path, $thumbnail_path);
        if (file_exists($fail_path)) {
            @unlink($fail_path);
        }
        return $thumbnail_url;
    } catch (Exception $e) {
        // 发生异常时返回默认图片
        @file_put_contents($fail_path, (string)time());
        return $imgUrl;
    } finally {
        // 释放资源
        if (isset($src)) {
            imagedestroy($src);
        }
        if (isset($thumb)) {
            imagedestroy($thumb);
        }
        if ($lock_fp) {
            @flock($lock_fp, LOCK_UN);
            @fclose($lock_fp);
        }
    }
}

/**
 * 简易文件缓存（主题目录内 cache/）
 * - 不依赖 Typecho 缓存组件，方便部署
 * - 写入失败会自动降级为不缓存
 */
function once_cache_get($key, $ttl)
{
    $ttl = (int)$ttl;
    if ($ttl <= 0) return null;
    $dir = __TYPECHO_ROOT_DIR__ . '/usr/cache/';
    $path = $dir . md5((string)$key) . '.json';
    if (!is_file($path) || !is_readable($path)) return null;
    $raw = @file_get_contents($path);
    if ($raw === false) return null;
    $payload = json_decode($raw, true);
    if (!is_array($payload) || !isset($payload['time'])) return null;
    if ((time() - (int)$payload['time']) > $ttl) return null;
    return $payload['data'] ?? null;
}

function once_cache_set($key, $data)
{
    $dir = __TYPECHO_ROOT_DIR__ . '/usr/cache/';
    if (!is_dir($dir)) {
        if (!@mkdir($dir, 0755, true)) return false;
    }
    $path = $dir . md5((string)$key) . '.json';
    $tmp = $path . '.tmp';
    $payload = json_encode(['time' => time(), 'data' => $data], JSON_UNESCAPED_UNICODE);
    if ($payload === false) return false;
    if (@file_put_contents($tmp, $payload, LOCK_EX) === false) return false;
    return @rename($tmp, $path);
}

function once_charset()
{
    $charset = 'UTF-8';
    try {
        $opt = Helper::options();
        if (isset($opt->charset) && $opt->charset) $charset = (string)$opt->charset;
    } catch (Exception $e) {
    }
    return $charset ?: 'UTF-8';
}

function once_esc_html($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, once_charset());
}

function once_esc_attr($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, once_charset());
}

function once_esc_url($value)
{
    $url = trim((string)$value);
    if ($url === '') return '';

    // 禁止危险 scheme
    if (preg_match('/^\s*(javascript|data|vbscript):/i', $url)) {
        return '#';
    }

    // 允许锚点、相对路径、协议相对
    $first = $url[0] ?? '';
    if ($first === '#' || $first === '/' || $first === '?' || strpos($url, '//') === 0) {
        return once_esc_attr($url);
    }

    $scheme = @parse_url($url, PHP_URL_SCHEME);
    if ($scheme) {
        $scheme = strtolower((string)$scheme);
        if (!in_array($scheme, ['http', 'https', 'mailto', 'tel'], true)) {
            return '#';
        }
    }
    return once_esc_attr($url);
}

/**    
 * 评论者认证等级 + 身份    
 *    
 * @author Chrison    
 * @access public    
 * @param str $email 评论者邮址    
 * @return result     
 */     
function commentApprove($widget, $email = NULL)      
{   
    $result = array(
        "state" => -1,//状态
        "isAuthor" => 0,//是否是博主
        "userLevel" => '',//用户身份或等级名称
        "userDesc" => '',//用户title描述
        "bgColor" => '',//用户身份或等级背景色
        "commentNum" => 0//评论数量
    );
    if (empty($email)) return $result;       
    $result['state'] = 1;
    $emailLower = strtolower(trim((string)$email));
    $friendRaw = (string)(Helper::options()->friend ?? '');
    $friendList = preg_split('/[,\s]+/u', strtolower(trim($friendRaw)), -1, PREG_SPLIT_NO_EMPTY);
    $isFriend = ($emailLower !== '' && !empty($friendList) && in_array($emailLower, $friendList, true)); 
    if ($widget->authorId == $widget->ownerId) {      
        $result['isAuthor'] = 1;//」
        $result['userLevel'] = '「博主」<i class="bi bi-award-fill"></i>';
        $result['userDesc'] = '本站站长';
        $result['bgColor'] = '#ef6762ff';
        $result['commentNum'] = 999;
    } else {
        try {
            //数据库获取
            $db = Typecho_Db::get();
            //获取评论条数
            $commentNumSql = $db->fetchAll($db->select(array('COUNT(cid)'=>'commentNum'))
                ->from('table.comments')
                ->where('mail = ?', $email));
            $commentNum = $commentNumSql[0]['commentNum'];    
            //获取友情链接
            $linkSql = $db->fetchAll($db->select()->from('table.links')
                ->where('user = ?',$email));       
            //等级判定
            if($commentNum==1){
                $result['userLevel'] = '「初见」<i class="bi bi-0-circle"></i>';
                $result['bgColor'] = '#999999';
                $userDesc = '人生一大步！';
            } else {
                if ($commentNum<10 && $commentNum>1) {
                    $result['userLevel'] = '「初识」<i class="bi bi-1-circle"></i>';
                    $result['bgColor'] = '#999999';
                }elseif ($commentNum<20 && $commentNum>=10) {
                    $result['userLevel'] = '「相识」<i class="bi bi-2-circle"></i>';
                    $result['bgColor'] = '#8dc7beff';
                }elseif ($commentNum<40 && $commentNum>=20) {
                    $result['userLevel'] = '「熟识」<i class="bi bi-3-circle"></i>';
                    $result['bgColor'] = '#3ceacdff';
                }elseif ($commentNum<80 && $commentNum>=40) {
                    $result['userLevel'] = '「好友」<i class="bi bi-4-circle"></i>';
                    $result['bgColor'] = '#27ee15ff';
                }elseif ($commentNum<160 && $commentNum>=80) {
                    $result['userLevel'] = '「知己」<i class="bi bi-5-circle"></i>';
                    $result['bgColor'] = '#e7e42dff';
                }elseif ($commentNum>=160) {
                    $result['userLevel'] = '「挚友」<i class="bi bi-6-circle"></i>';
                    $result['bgColor'] = '#fdf000ff';
                }
                 $userDesc = '您在本站有'.$commentNum.'条留言！'; 
            }
            if($linkSql){
                $result['userLevel'] = '「博友」';
                $result['bgColor'] = '#00fd15ff';
                $userDesc = '🔗'.$linkSql[0]['description'].'&#10;✌️'.$userDesc;
            }
            
            if ($isFriend) {
                $result['userLevel'] = '「好友」<i class="bi bi-heart-fill"></i>';
                $result['bgColor'] = '#880097ff';
                $userDesc = '好基友认证&#10;' . $userDesc;
            }
            $result['userDesc'] = $userDesc;
            $result['commentNum'] = $commentNum;
        } catch (Exception $e) {
            error_log('Error in commentApprove function: ' . $e->getMessage());
            // 设置默认值
            $result['userLevel'] = '「访客」';
            $result['bgColor'] = '#999999';
            $result['userDesc'] = '欢迎留言';
            $result['commentNum'] = 0;
        }
    } 
    return $result;
}

/**
 * 生成页面图标的函数
 */
function pageIcon($slug, $title) {
    $icon = '';
    if ($slug == 'memos') {
        $icon = '<i class="bi bi-chat-fill me-1"></i>';
    } elseif ($slug == 'links') {
        $icon = '<i class="bi bi-folder-symlink-fill me-1"></i>';
    } elseif ($slug == 'tags') {
        $icon = '<i class="bi bi-tags-fill me-1"></i>';
    } elseif ($slug == 'categories') {
        $icon = '<i class="bi bi-folder-fill me-1"></i>';
    } elseif ($slug == 'comments') {
        $icon = '<i class="bi bi-chat-dots-fill me-1"></i>';
    } elseif ($slug == 'gbook') {
        $icon = '<i class="bi bi-cloud-arrow-up-fill me-1"></i>';
    } elseif ($slug == 'search') {
        $icon = '<i class="bi bi-search me-1"></i>';
    } elseif ($slug == 'archives') {
        $icon = '<i class="bi bi-calendar-heart-fill me-1"></i>';
    } elseif ($slug == 'tools') {
        $icon = '<i class="bi bi-tools me-1"></i>';
    } elseif ($slug == 'help') {
        $icon = '<i class="bi bi-question-circle-fill me-1"></i>';
    } elseif ($slug == 'about') {
        $icon = '<i class="bi bi-info-circle-fill me-1"></i>';
    } 
    return $icon . $title;
}

/**
 * 获取幻灯片文章
 */
function getSlidesPosts() {
    $options = \Typecho\Widget::widget('Widget_Options');
    $slides = $options->slidePosts;
    if (empty($slides)) {
        return array();
    }
    $cids = preg_split('/[,\s]+/', $slides);
    $cids = array_map('intval', $cids);
    $cids = array_filter($cids);
    if (empty($cids)) {
        return array();
    }
    // 查询文章
    $db = \Typecho\Db::get();
    try {
        // 构建查询
        $posts = $db->fetchAll($db->select()
            ->from('table.contents')
            ->where('cid IN ?', $cids)
            ->where('status = ?', 'publish')
            ->where('type = ?', 'post'));
        $postsMap = array();
        foreach ($posts as $post) {
            $postsMap[$post['cid']] = $post;
        }
        $sortedPosts = array();
        foreach ($cids as $cid) {
            if (isset($postsMap[$cid])) {
                $sortedPosts[] = $postsMap[$cid];
            }
        }
        return array_map(function($post) {
            return \Typecho\Widget::widget('Widget_Abstract_Contents')->push($post);
        }, $sortedPosts);    
    } catch (Exception $e) {
        return array();
    }
}

/**
 * Typecho后台附件增强：图片预览、批量插入、保留官方删除按钮与逻辑
 * @author jkjoy
 * @date 2025-04-25
 */
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('AttachmentHelper', 'addEnhancedFeatures');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('AttachmentHelper', 'addEnhancedFeatures');

class AttachmentHelper {
    public static function addEnhancedFeatures() {
        ?>
        <style>
        #file-list{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:15px;padding:15px;list-style:none;margin:0;}
        #file-list li{position:relative;border:1px solid #e0e0e0;border-radius:4px;padding:10px;background:#fff;transition:all 0.3s ease;list-style:none;margin:0;}
        #file-list li:hover{box-shadow:0 2px 8px rgba(0,0,0,0.1);}
        #file-list li.loading{opacity:0.7;pointer-events:none;}
        .att-enhanced-thumb{position:relative;width:100%;height:150px;margin-bottom:8px;background:#f5f5f5;overflow:hidden;border-radius:3px;display:flex;align-items:center;justify-content:center;}
        .att-enhanced-thumb img{width:100%;height:100%;object-fit:contain;display:block;}
        .att-enhanced-thumb .file-icon{display:flex;align-items:center;justify-content:center;width:100%;height:100%;font-size:40px;color:#999;}
        .att-enhanced-finfo{padding:5px 0;}
        .att-enhanced-fname{font-size:13px;margin-bottom:5px;word-break:break-all;color:#333;}
        .att-enhanced-fsize{font-size:12px;color:#999;}
        .att-enhanced-factions{display:flex;justify-content:space-between;align-items:center;margin-top:8px;gap:8px;}
        .att-enhanced-factions button{flex:1;padding:4px 8px;border:none;border-radius:3px;background:#e0e0e0;color:#333;cursor:pointer;font-size:12px;transition:all 0.2s ease;}
        .att-enhanced-factions button:hover{background:#d0d0d0;}
        .att-enhanced-factions .btn-insert{background:#467B96;color:white;}
        .att-enhanced-factions .btn-insert:hover{background:#3c6a81;}
        .att-enhanced-checkbox{position:absolute;top:5px;right:5px;z-index:2;width:18px;height:18px;cursor:pointer;}
        .batch-actions{margin:15px;display:flex;gap:10px;align-items:center;}
        .btn-batch{padding:8px 15px;border-radius:4px;border:none;cursor:pointer;transition:all 0.3s ease;font-size:10px;display:inline-flex;align-items:center;justify-content:center;}
        .btn-batch.primary{background:#467B96;color:white;}
        .btn-batch.primary:hover{background:#3c6a81;}
        .btn-batch.secondary{background:#e0e0e0;color:#333;}
        .btn-batch.secondary:hover{background:#d0d0d0;}
        .upload-progress{position:absolute;bottom:0;left:0;width:100%;height:2px;background:#467B96;transition:width 0.3s ease;}
        </style>
        <script>
        $(document).ready(function() {
            // 批量操作UI按钮
            var $batchActions = $('<div class="batch-actions"></div>')
                .append('<button type="button" class="btn-batch primary" id="batch-insert">批量插入</button>')
                .append('<button type="button" class="btn-batch secondary" id="select-all">全选</button>')
                .append('<button type="button" class="btn-batch secondary" id="unselect-all">取消全选</button>');
            $('#file-list').before($batchActions);

            // 插入格式
            Typecho.insertFileToEditor = function(title, url, isImage) {
                var textarea = $('#text'), 
                    sel = textarea.getSelection(),
                    insertContent = isImage ? '![' + title + '](' + url + ')' : 
                                            '[' + title + '](' + url + ')';
                textarea.replaceSelection(insertContent + '\n');
                textarea.focus();
            };
            // 批量插入
            $('#batch-insert').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var content = '';
                $('#file-list li').each(function() {
                    if ($(this).find('.att-enhanced-checkbox').is(':checked')) {
                        var $li = $(this);
                        var title = $li.find('.att-enhanced-fname').text();
                        var url = $li.data('url');
                        var isImage = $li.data('image') == 1;
                        content += isImage ? '![' + title + '](' + url + ')\n' : '[' + title + '](' + url + ')\n';
                    }
                });
                if (content) {
                    var textarea = $('#text');
                    var pos = textarea.getSelection();
                    var newContent = textarea.val();
                    newContent = newContent.substring(0, pos.start) + content + newContent.substring(pos.end);
                    textarea.val(newContent);
                    textarea.focus();
                }
            });
            $('#select-all').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $('#file-list .att-enhanced-checkbox').prop('checked', true);
                return false;
            });
            $('#unselect-all').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $('#file-list .att-enhanced-checkbox').prop('checked', false);
                return false;
            });
            // 防止复选框冒泡
            $(document).on('click', '.att-enhanced-checkbox', function(e) {e.stopPropagation();});
            // 增强文件列表样式，但不破坏li原结构和官方按钮
            function enhanceFileList() {
                $('#file-list li').each(function() {
                    var $li = $(this);
                    if ($li.hasClass('att-enhanced')) return;
                    $li.addClass('att-enhanced');
                    // 只增强，不清空li
                    // 增加批量选择框
                    if ($li.find('.att-enhanced-checkbox').length === 0) {
                        $li.prepend('<input type="checkbox" class="att-enhanced-checkbox" />');
                    }
                    // 增加图片预览（如已有则不重复加）
                    if ($li.find('.att-enhanced-thumb').length === 0) {
                        var url = $li.data('url');
                        var isImage = $li.data('image') == 1;
                        var fileName = $li.find('.insert').text();
                        var $thumbContainer = $('<div class="att-enhanced-thumb"></div>');
                        if (isImage) {
                            var $img = $('<img src="' + url + '" alt="' + fileName + '" />');
                            $img.on('error', function() {
                                $(this).replaceWith('<div class="file-icon">🖼️</div>');
                            });
                            $thumbContainer.append($img);
                        } else {
                            $thumbContainer.append('<div class="file-icon">📄</div>');
                        }
                        // 插到插入按钮之前
                        $li.find('.insert').before($thumbContainer);
                    }
                });
            }
            // 插入按钮事件
            $(document).on('click', '.btn-insert', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var $li = $(this).closest('li');
                var title = $li.find('.att-enhanced-fname').text();
                Typecho.insertFileToEditor(title, $li.data('url'), $li.data('image') == 1);
            });
            // 上传完成后增强新项
            var originalUploadComplete = Typecho.uploadComplete;
            Typecho.uploadComplete = function(attachment) {
                setTimeout(function() {
                    enhanceFileList();
                }, 200);
                if (typeof originalUploadComplete === 'function') {
                    originalUploadComplete(attachment);
                }
            };
            // 首次增强
            enhanceFileList();
        });
        </script>
        <?php
    }
}
/**
 * Typecho后台文章标签增强：常用标签快速插入
 * @author jkjoy
 * @date 2025-04-25
 */
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('tagshelper', 'tagslist');
class tagshelper{
    public static function tagslist(){   
?><style>.tagshelper a{cursor: pointer; padding: 0px 6px; margin: 2px 0;display: inline-block;border-radius: 2px;text-decoration: none;}
.tagshelper a:hover{background: #ccc;color: #fff;}
</style>
<script> $(document).ready(function(){
    $('#tags').after('<div style="margin-top: 35px;" class="tagshelper"><ul style="list-style: none;border: 1px solid #D9D9D6;padding: 6px 12px; max-height: 240px;overflow: auto;background-color: #FFF;border-radius: 2px;"><?php
$i=0;
Typecho_Widget::widget('Widget_Metas_Tag_Cloud', 'sort=count&desc=1&limit=200')->to($tags);
while ($tags->next()) {
echo "<a id=".$i." onclick=\"$(\'#tags\').tokenInput(\'add\', {id: \'".$tags->name."\', tags: \'".$tags->name."\'});\">".$tags->name."</a>";
$i++;
}
?></ul></div>');
  });</script>
<?php
    }
}

/**
 * 自动检查主题更新
 */
function once_normalize_version($version)
{
    $version = trim((string)$version);
    $version = ltrim($version, "vV \t\n\r\0\x0B");

    if (preg_match('/^([0-9]+(?:\\.[0-9]+){1,3})/', $version, $m)) {
        return $m[1];
    }

    return $version;
}

function once_get_theme_version_from_index()
{
    // 兼容 Windows/自定义目录：直接从当前主题目录读取 index.php 注释中的 @version
    $indexFile = dirname(__DIR__) . '/index.php';
    if (!is_file($indexFile)) {
        // 兜底：按 Typecho 目录规则拼接
        $theme = (string)Helper::options()->theme;
        if ($theme !== '') {
            $fallback = rtrim(__TYPECHO_ROOT_DIR__, '/\\') . rtrim(__TYPECHO_THEME_DIR__, '/\\') . '/' . $theme . '/index.php';
            if (is_file($fallback)) {
                $indexFile = $fallback;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    $content = @file_get_contents($indexFile);
    if ($content === false) {
        return null;
    }

    if (preg_match('/@version\\s+([^\\s\\*]+)/i', $content, $m)) {
        $version = once_normalize_version($m[1]);
        return $version !== '' ? $version : null;
    }

    return null;
}

function themeAutoUpgradeNotice()
{
    // 1. 从 index.php 注释读取当前主题版本（@version）
    $current_version = once_get_theme_version_from_index();
    if (empty($current_version)) {
        return;
    }

    // 2. 定义 GitHub API 地址
    $api_url = 'https://api.github.com/repos/jkjoy/typecho-theme-once/releases/latest';

    // 3. 设置缓存，避免每次请求都调用 API，减轻服务器压力
    $cache_dir = __TYPECHO_ROOT_DIR__ . '/usr/cache';
    $cache_file = $cache_dir . '/once-version.json';
    $cache_time = 12 * 3600; // 缓存12小时

    // 确保缓存目录存在
    if (!file_exists($cache_dir)) {
        @mkdir($cache_dir, 0755, true);
    }

    $latest_version = null;
    
    // 检查缓存文件是否存在且未过期
    if (file_exists($cache_file) && (time() - filemtime($cache_file)) < $cache_time) {
        $cache_data = json_decode(file_get_contents($cache_file), true);
        if ($cache_data && isset($cache_data['tag_name'])) {
            $latest_version = once_normalize_version($cache_data['tag_name']);
        }
    } else {
        // 缓存过期或不存在，重新请求 API
        $ctx = stream_context_create([
            'http' => [
                'header' => 'User-Agent: Typecho-Theme-Updater', // GitHub API 要求有 User-Agent
                'timeout' => 10 // 设置超时时间
            ]
        ]);
        
        $response = @file_get_contents($api_url, false, $ctx);

        if ($response) {
            $release_data = json_decode($response, true);
            if (isset($release_data['tag_name'])) {
                $latest_version = once_normalize_version($release_data['tag_name']);
                // 更新缓存文件
                $result = file_put_contents($cache_file, json_encode(['tag_name' => $latest_version, 'time' => time()]));
                // 如果缓存写入失败，记录错误但不影响显示
                if (!$result) {
                    error_log('Failed to write upgrade cache to ' . $cache_file);
                }
            }
        } else {
            // API请求失败，记录错误
            error_log('Failed to fetch release data from ' . $api_url);
            // 如果有旧缓存，使用旧缓存数据
            if (file_exists($cache_file)) {
                $cache_data = json_decode(file_get_contents($cache_file), true);
                if ($cache_data && isset($cache_data['tag_name'])) {
                    $latest_version = once_normalize_version($cache_data['tag_name']);
                }
            }
        }
    }
    // 4. 如果获取到了最新版本，则进行比较
    if ($latest_version && version_compare(once_normalize_version($current_version), once_normalize_version($latest_version), '<')) {
        
        $notice_html = '
        <span class="themeConfig"><h3>主题更新</h3>
            <div class="info">发现新版本 ' . $latest_version . '，您当前使用的是 ' . $current_version . '。建议立即更新以获得最新功能和安全性修复。
                <a href="https://github.com/jkjoy/typecho-theme-once/releases/latest" target="_blank">查看更新</a>
                <a href="https://github.com/jkjoy/typecho-theme-once/releases" target="_blank">立即下载</a>
            </div>';
        echo $notice_html;
    }
}
