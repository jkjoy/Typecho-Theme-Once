<?php 
/**
 * 友情链接
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
        <article class="wznrys">
			<?php $this->content(); ?>
		</article>
    <div class="friends-container">
        <?php
        Links_Plugin::output('
            <div class="friend-link">
                <div class="friend-header">
                    <img src="{image}" alt="{name}" class="friend-avatar">
                    <a href="{url}" target="_blank"><h3 class="friend-name">{name}</h3></a>
                </div>
                <p class="friend-description">{title}</p>
            </div>
        ');
        ?>
       </div> 
    </div>	
    <?php $this->need('comments.php'); ?>    
</div>
<style>
    .friends-container {
        width: 100%;
        margin: 0;
        padding: 10px;
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        box-sizing: border-box;
    }

    .friend-link {
        /* 使用更灵活的宽度计算 */
        width: calc((100% - 155px) / 2);  /* 一排两个，考虑间隙 */
        min-width: 200px; /* 设置最小宽度 */
        margin: 0;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-decoration: none;
        color: inherit;
        flex-grow: 1;
        box-sizing: border-box;
    }
    .dark .friend-link {
        box-shadow: 0 2px 10px rgba(227, 186, 186, 0.95);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-decoration: none;
        flex-grow: 1;
        box-sizing: border-box;
    }

    /* 响应式布局调整 */
    @media screen and (max-width: 768px), 
           screen and (min-width: 768px) and (max-width: 1300px) and (min-width: 635px) {
        .friend-link {
            width: calc(50% - 18px);
        }
    }

    /* 当容器宽度小于特定值时切换为单列 */
    @media screen and (max-width: 635px) {
        .friend-link {
            width: 100%;
        }
    }

    /* 当侧边栏收起时的样式（通常容器宽度会增加） */
    @media screen and (min-width: 900px) {
        .friend-link {
            width: calc((100% - 35px) / 2);
        }
    }

    .friend-header {
        display: flex;
        align-items: center;
        padding: 15px;
    }

    .friend-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 10px;
        object-fit: cover;
    }

    .friend-name {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin: 0;
    }
    .dark .friend-name {
        font-size: 16px;
        font-weight: 600;
        color: #FFF;
        margin: 0;
    }
    .friend-description {
        font-size: 13px;
        color: #666;
        line-height: 1.4;
        margin: 0;
        padding: 0 15px 15px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .friend-link:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
</style>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
