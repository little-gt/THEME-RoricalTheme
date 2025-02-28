<?php
/**
 * 侧边栏模板 - 显示归档、最新文章、最近回复和搜索框
 *
 * @package Rorical Theme
 * @version 1.0
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>

<!-- 侧边栏容器 -->
<section class="section section-components">
    <div class="container container-lg align-items-center" style="text-align: center;">
        <div class="row">
            <!-- 归档 -->
            <div class="col-sm-3 col-6">
                <h3><span><?php _e('归档'); ?></span></h3>
                <?php $archives = $this->widget('Widget_Contents_Post_Date', 'limit=3&type=month&format=F Y'); ?>
                <?php if ($archives->have()): ?>
                    <?php while ($archives->next()): ?>
                        <a href="<?php $archives->permalink(); ?>" class="alert fade show" role="alert">
                            <div class="alert alert-success">
                                <span class="alert-inner--text">
                                    <strong><?php $archives->date(); ?></strong>
                                </span>
                            </div>
                        </a>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="alert alert-success">暂无归档</div>
                <?php endif; ?>
            </div>

            <!-- 最新文章 -->
            <div class="col-sm-3 col-6">
                <h3><span><?php _e('最新文章'); ?></span></h3>
                <?php $recentPosts = $this->widget('Widget_Contents_Post_Recent', 'pageSize=3'); ?>
                <?php if ($recentPosts->have()): ?>
                    <?php while ($recentPosts->next()): ?>
                        <a href="<?php $recentPosts->permalink(); ?>" class="alert fade show" role="alert">
                            <div class="alert alert-info">
                                <span class="alert-inner--text">
                                    <strong><?php $recentPosts->title(); ?></strong>
                                </span>
                            </div>
                        </a>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="alert alert-info">暂无文章</div>
                <?php endif; ?>
            </div>

            <!-- 最近回复 -->
            <div class="col-sm-3 col-6">
                <h3><span><?php _e('最近回复'); ?></span></h3>
                <?php $recentComments = $this->widget('Widget_Comments_Recent', 'ignoreAuthor=true&limit=3'); ?>
                <?php $recentComments->to($comments); ?>
                <?php if ($comments->have()): ?>
                    <?php while ($comments->next()): ?>
                        <a href="<?php $comments->permalink(); ?>" class="alert fade show" role="alert">
                            <div class="alert alert-warning">
                                <span class="alert-inner--text">
                                    <strong><?php $comments->author(false); ?></strong>: 
                                    <?php $comments->excerpt(19, '...'); ?>
                                </span>
                            </div>
                        </a>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="alert alert-warning">暂无评论</div>
                <?php endif; ?>
            </div>

            <!-- 搜索文章 -->
            <div class="col-sm-3 col-6">
                <h3><span><?php _e('搜索文章'); ?></span></h3>
                <div class="form-group">
                    <form method="post" id="search" action="<?php $this->options->siteUrl('search/'); ?>" role="search">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-zoom-split-in"></i></span>
                            </div>
                            <input class="form-control" type="text" id="s" name="s" placeholder="搜索" required>
                        </div>
                        <input class="btn btn-1 btn-outline-primary submit mt-2" type="submit" value="搜索吧！">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript增强搜索功能 -->
<script>
    $(document).ready(function() {
        $("#search").submit(function(e) {
            e.preventDefault();
            const searchTerm = $("#s").val().trim();
            if (searchTerm) {
                $.pjax({
                    url: '<?php $this->options->siteUrl(); ?>search/' + encodeURIComponent(searchTerm) + '/',
                    container: '#main',
                    fragment: '#main',
                    timeout: 8000
                });
            }
        });
    });
</script>