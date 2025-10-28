<?php
/**
 * sidebar.php - The sidebar template for the Rorical theme.
 * Displays archives, recent posts, recent comments, and a search form.
 *
 * @package Rorical Theme
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>

<!-- Main sidebar container -->
<section class="section section-components">
    <div class="container container-lg align-items-center" style="text-align: center;">
        <div class="row">

            <!-- Archives Widget -->
            <div class="col-sm-3 col-6">
                <h3><span><?php _e('归档'); ?></span></h3>
                <?php $this->widget('Widget_Contents_Post_Date', 'limit=3&type=month&format=F Y')->to($archives); ?>
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

            <!-- Recent Posts Widget -->
            <div class="col-sm-3 col-6">
                <h3><span><?php _e('最新文章'); ?></span></h3>
                <?php $this->widget('Widget_Contents_Post_Recent', 'pageSize=3')->to($recentPosts); ?>
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

            <!-- Recent Comments Widget -->
            <div class="col-sm-3 col-6">
                <h3><span><?php _e('最近回复'); ?></span></h3>
                <?php $this->widget('Widget_Comments_Recent', 'ignoreAuthor=true&limit=3')->to($recentComments); ?>
                <?php if ($recentComments->have()): ?>
                    <?php while ($recentComments->next()): ?>
                        <a href="<?php $recentComments->permalink(); ?>" class="alert fade show" role="alert">
                            <div class="alert alert-warning">
                                <span class="alert-inner--text">
                                    <strong><?php $recentComments->author(false); ?></strong>: 
                                    <?php $recentComments->excerpt(19, '...'); ?>
                                </span>
                            </div>
                        </a>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="alert alert-warning">暂无评论</div>
                <?php endif; ?>
            </div>

            <!-- Search Widget -->
            <div class="col-sm-3 col-6">
                <h3><span><?php _e('搜索文章'); ?></span></h3>
                <div class="form-group">
                    <!-- The action points to the site URL for a reliable non-JS fallback. -->
                    <form method="post" id="search" action="<?php $this->options->siteUrl(); ?>" role="search">
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

<!-- JavaScript to handle search with PJAX -->
<script>
    $(document).ready(function() {
        $("#search").submit(function(e) {
            // Prevent the form's default submission behavior.
            e.preventDefault();
            const searchTerm = $("#s").val().trim();
            
            // If the search term is not empty, perform a PJAX request.
            if (searchTerm) {
                $.pjax({
                    // Use the pretty URL format for searches.
                    url: '<?php $this->options->siteUrl(); ?>search/' + encodeURIComponent(searchTerm) + '/',
                    container: '#main',
                    fragment: '#main',
                    timeout: 8000
                });
            }
        });
    });
</script>