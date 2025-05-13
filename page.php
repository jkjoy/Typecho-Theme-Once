<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div class="col-lg-8">
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
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
