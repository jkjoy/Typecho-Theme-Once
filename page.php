<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
$this->need('header.php'); ?>
<div class="col-lg-9">
    <div class="post_container_title">
	    <h1><?php $this->title() ?></h1>
	</div>
    <div class="post_container">
		<article class="wznrys">
			<?php $this->content(); ?>
		</article>
	</div>
<?php $this->need('comments.php'); ?>
</div>
<?php $this->need('sidebar.php');$this->need('footer.php'); ?>