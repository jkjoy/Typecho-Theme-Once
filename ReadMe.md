
## 使用
> [!TIP]
> 使用前请安装`links`插件
> 需安装GD库扩展包，否则缩略图无法正常显示。


1. 下载主题
2. 解压到`usr/themes/`目录下
3. 后台启用主题
4. 后台设置主题

## 主题特性

归档页面
友情链接



| 页面slug | icon |
| ---- | ---- |
| memos | <i class="bi bi-chat-fill me-1"></i>|
| links | <i class="bi bi-folder-symlink-fill me-1"></i>|
| about | <i class="bi bi-info-circle-fill me-1"></i> |
| tags |<i class="bi bi-tags-fill me-1"></i> |
| categories | <i class="bi bi-folder-fill me-1"></i> |
| search |<i class="bi bi-search me-1"></i>|
| archives | <i class="bi bi-calendar-heart-fill me-1"></i> |
| comments | <i class="bi bi-chat-dots-fill me-1"></i> |
|help| <i class="bi bi-question-circle-fill me-1"></i>|
| gbook | <i class="bi bi-cloud-arrow-up-fill me-1"></i>|
| tools | <i class="bi bi-tools me-1"></i>|



| 分类slug | icon |
| ---- | ---- |
| images|<i class="bi bi-images me-1"></i>|
| share |<i class="bi bi-share-fill me-1"></i>|
| NULL |<i class="bi bi-speaker-fill me-1"></i>|
| memos|<i class="bi bi-chat me-1"></i>|
| codes | <i class="bi bi-code me-1"></i>|
| logs | <i class="bi bi-person-fill me-1"></i>|
| test | <i class="bi bi-calendar-fill me-1"></i>|
| tools | <i class="bi bi-tools me-1"></i>|
| music | <i class="bi bi-music-note me-1"></i>|
| links | <i class="bi bi-link me-1"></i>|
| video | <i class="bi bi-camera-video me-1"></i>|
| life | <i class="bi bi-heart-fill me-1"></i>|
| study | <i class="bi bi-book-fill me-1"></i>|
| news | <i class="bi bi-newspaper me-1"></i>|
| themes | <i class="bi bi-palette me-1"></i>|
| plugins | <i class="bi bi-gear-fill me-1"></i>|
| photo | <i class="bi bi-images me-1"></i>|
| default | <i class="bi bi-folder-fill me-1"></i>|
## 更新日志

### 1.0.1

- 修复右侧文章获取错误的问题
- 更改为从数据库获取分类文章

### 1.0.0
- 初始版本

# Typecho-Theme-Once 主题使用说明

Once for Typecho 是一款简洁、美观的双栏博客主题。

## 主要功能特性

- 响应式设计，适配各种屏幕尺寸
- 轮播图展示精选文章
- 中部和右侧专题分类展示
- 侧边栏多种模块自定义
- 图片懒加载支持，优化页面加载速度
- 图片404自动显示默认图片
- 文章浏览量和点赞统计

## 主题设置说明

### 基本设置
- **站点LOGO**：在主题设置中填入LOGO图片URL
- **Favicon**：设置浏览器标签页图标URL
- **默认缩略图**：设置文章没有图片时使用的默认缩略图

### 首页布局设置
- **幻灯片文章**：设置首页轮播图显示的文章CID，多个用英文逗号分隔
- **中间展示分类**：设置中间区域展示的分类mid
- **右边展示分类**：设置右侧区域展示的分类mid

### 侧边栏设置
在主题设置中，找到"侧边栏显示"选项，可以选择以下模块显示：

- **显示最新文章**：显示站点最新发布的文章
- **显示热门文章**：根据评论数显示热门文章
- **显示最近回复**：显示最新的评论
- **显示标签**：显示文章标签云
- **显示其它杂项**：显示登录、RSS等链接

## 最近更新内容

1. 增加图片懒加载功能
   - 所有页面的缩略图都支持懒加载
   - 使用IntersectionObserver API优化性能
   - 提供降级方案支持旧版浏览器

2. 图片404处理
   - 自动检测图片加载失败并替换为默认图片
   - 支持自定义默认缩略图

3. 侧边栏优化
   - 修复最近文章获取问题
   - 增强热门文章显示