<?php
/**
 * 评论区模板
 *
 * @package Rorical Theme
 * @version 1.0
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->comments()->to($comments);
?>

<!-- 评论区容器 -->
<div class="container card shadow py-5 comments">
    <!-- 评论区标题 -->
    <div class="d-flex px-3">
        <div>
            <div class="icon icon-lg icon-shape bg-gradient-white shadow rounded-circle text-primary">
                <i class="ni ni-building text-primary"></i>
            </div>
        </div>
        <div class="pl-4">
            <h4 class="display-3">评论区</h4>
            <p><?php $this->commentsNum('还没有人评论', '只有一个人评论了', '有 %d 条评论 '); ?></p>
        </div>
    </div>

    <!-- 嵌套评论函数 -->
    <?php function threadedComments($comments, $options) {
        $commentClass = $comments->authorId ? ($comments->authorId == $comments->ownerId ? ' comment-by-author' : ' comment-by-user') : '';
        $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
    ?>
        <div id="<?php $comments->theId(); ?>" 
             class="card shadow shadow-lg--hover mt-2<?php echo $commentLevelClass . ($comments->levels > 0 ? $comments->levelsAlt(' comment-level-odd', ' comment-level-even') : '') . $comments->alt(' comment-odd', ' comment-even') . $commentClass; ?>">
            <div class="card-body">
                <div class="d-flex px-3">
                    <div>
                        <a class="card-profile-image bg-gradient-success rounded-circle text-white">
                            <?php $comments->gravatar('40', '', null, 'rounded-circle'); ?>
                        </a>
                    </div>
                    <div class="pl-4" style="width:90%;">
                        <h5 class="title text-success breakword"><?php $comments->author(); ?></h5>
                        <a class="text-success breakword">
                            <?php if (class_exists('LocationIP_Plugin')) LocationIP_Plugin::output($comments, "{loc}"); ?> 
                            <?php $comments->date('Y F jS'); ?>
                        </a>
                        <?php if ($comments->parent): ?>
                            <?php $p_comment = getPermalinkFromCoid($comments->parent); ?>
                            <a href="<?php echo $p_comment['href']; ?>" 
                               title="<?php echo mb_strimwidth(strip_tags($p_comment['text']), 0, 100, '...'); ?>">
                                @<?php echo $p_comment['author']; ?>
                            </a>
                        <?php endif; ?>
                        <p class="breakword"><?php $comments->content(); ?></p>
                        <?php if ($comments->status == 'waiting'): ?>
                            <span class="badge badge-pill badge-default text-white">您的评论当前仅您可见</span>
                        <?php endif; ?>
                        <?php $comments->reply('<i class="fa fa-reply"></i>'); ?>
                    </div>
                </div>
                <?php if ($comments->children): ?>
                    <?php if ($comments->levels < 1): ?>
                        <?php $comments->threadedComments($options); ?>
                        </div></div>
                    <?php else: ?>
                        </div></div>
                        <?php $comments->threadedComments($options); ?>
                    <?php endif; ?>
                <?php else: ?>
                    </div></div>
                <?php endif; ?>
    <?php } ?>

    <!-- 评论列表 -->
    <div id="comment-refresh">
        <?php $comments->listComments(); ?>
    </div>

    <!-- 评论表单 -->
    <?php if ($this->allow('comment')): ?>
        <div id="<?php $this->respondId(); ?>" class="py-3 comment-text">
            <form method="post" action="<?php $this->commentUrl(); ?>" id="comment-form" role="form">
                <div class="container mt-5">
                    <div class="card bg-gradient-warning shadow-lg border-0">
                        <div class="p-5">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <h3 class="text-white"><?php _e('添加新评论'); ?></h3>
                                    <?php if ($this->user->hasLogin()): ?>
                                        <textarea class="form-control form-control-alternative" name="text" id="textarea" rows="8" required 
                                                  placeholder="<?php echo $this->user->screenName(); ?>? 写点什么吧..."></textarea>
                                    <?php else: ?>
                                        <div class="row lead text-white mt-3">
                                            <div class="col-md-4">
                                                <div class="form-group input-group input-group-alternative">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="padding: .4rem .5rem;">
                                                            <div id="author-head" class="icon-shape rounded-circle text-white gravatar" style="width: 2rem; height: 2rem;"></div>
                                                        </span>
                                                    </div>
                                                    <input class="form-control form-control-alternative" name="author" id="author" required value="" placeholder="昵称">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="email" name="mail" id="mail" placeholder="邮箱" value="<?php $this->remember('mail'); ?>" 
                                                           class="form-control form-control-alternative" required/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="url" name="url" id="url" value="<?php $this->remember('url'); ?>" placeholder="网站" 
                                                           class="form-control form-control-alternative"/>
                                                </div>
                                            </div>
                                        </div>
                                        <textarea class="form-control form-control-alternative" name="text" id="textarea" rows="8" required placeholder="写点什么吧..."></textarea>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-3 ml-lg-auto mt-3">
                                    <button class="btn btn-lg btn-block btn-white" type="submit" id="add-comment-button">提交！</button>
                                    <div class="cancel-comment-reply mt-5 align-items-center">
                                        <?php $comments->cancelReply('取消回复', 'btn btn-danger'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <!-- 评论分页 -->
    <div id="comments">
        <?php if ($comments->have()): ?>
            <?php $comments->pageNav('<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>', 1, '...', [
                'wrapTag'      => 'ul',
                'wrapClass'    => 'pagination pagination-lg justify-content-center',
                'itemTag'      => 'li',
                'textTag'      => 'a',
                'currentClass' => 'page-item active',
                'prevClass'    => 'page-item',
                'nextClass'    => 'page-item',
                'linkClass'    => 'page-link',
                'itemClass'    => 'page-item'
            ]); ?>
        <?php endif; ?>
    </div>
</div>

<!-- JavaScript逻辑 -->
<script>
    // AJAX提交评论
    function bindSubmit() {
        $("#comment-form").submit(function() {
            $("#add-comment-button").attr("disabled", true);
            $.ajax({
                url: $(this).attr("action"),
                type: $(this).attr("method"),
                data: $(this).serializeArray(),
                complete: function() {
                    $("#add-comment-button").attr("disabled", false);
                },
                success: function(data) {
                    const parser = new DOMParser();
                    const htmlDoc = parser.parseFromString(data, "text/html");
                    const refreshedComments = htmlDoc.getElementById("comment-refresh");
                    if (refreshedComments) {
                        const commentText = document.querySelector(".comment-text");
                        const originalHtml = commentText.innerHTML;
                        document.getElementById("comment-refresh").innerHTML = refreshedComments.innerHTML;
                        if (!document.querySelector(".comment-text")) {
                            commentText.innerHTML = originalHtml;
                            commentText.querySelector(".cancel-comment-reply a").style.display = "none";
                            document.querySelector(".comments").appendChild(commentText);
                            bindSubmit();
                            if (typeof window.emojify !== "undefined") {
                                setTimeout(() => window.emojify.run(), 1000);
                            }
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("评论提交失败:", error);
                }
            });
            return false;
        });
    }
    bindSubmit();

    // 监听新评论节点
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === 'childList') {
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeType === Node.ELEMENT_NODE && node.classList.contains('comment-parent')) {
                        console.log('新增评论:', node);
                    }
                });
            }
        });
    });
    observer.observe(document.getElementById('comment-refresh'), { attributes: false, childList: true, subtree: true });

    // Typecho评论回复逻辑
    window.TypechoComment = {
        dom: (id) => document.getElementById(id),
        create: (tag, attr) => {
            const el = document.createElement(tag);
            Object.keys(attr).forEach(key => el.setAttribute(key, attr[key]));
            return el;
        },
        reply: (cid, coid) => {
            const comment = TypechoComment.dom(cid),
                  response = TypechoComment.dom('<?php $this->respondId(); ?>'),
                  form = response.tagName === 'FORM' ? response : response.getElementsByTagName('form')[0],
                  textarea = form.getElementsByTagName('textarea')[0];
            let input = TypechoComment.dom('comment-parent');
            if (!input) {
                input = TypechoComment.create('input', { type: 'hidden', name: 'parent', id: 'comment-parent' });
                form.appendChild(input);
            }
            input.setAttribute('value', coid);
            if (!TypechoComment.dom('comment-form-place-holder')) {
                const holder = TypechoComment.create('div', { id: 'comment-form-place-holder' });
                response.parentNode.insertBefore(holder, response);
            }
            comment.appendChild(response);
            TypechoComment.dom('cancel-comment-reply-link').style.display = '';
            if (textarea && textarea.name === 'text') textarea.focus();
            return false;
        },
        cancelReply: () => {
            const response = TypechoComment.dom('<?php $this->respondId(); ?>'),
                  holder = TypechoComment.dom('comment-form-place-holder'),
                  input = TypechoComment.dom('comment-parent');
            if (input) input.parentNode.removeChild(input);
            if (!holder) return true;
            TypechoComment.dom('cancel-comment-reply-link').style.display = 'none';
            holder.parentNode.insertBefore(response, holder);
            return false;
        }
    };

    // Gravatar动态更新
    $("#mail").on('blur', function() {
        const email = $(this).val();
        if (email) {
            const url = `https://cdn.sep.cc/avatar/${hex_md5(email)}?s=40&d=`;
            $("#author-head").css('background-image', `url(${url})`);
        }
    });

    // 添加CSRF令牌
    const respond = document.getElementById('<?php $this->respondId(); ?>');
    if (respond) {
        const form = respond.getElementsByTagName('form')[0];
        if (form) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = '_';
            input.value = '<?php echo Typecho_Common::shuffleScriptVar($this->security->getToken(clear_urlcan($this->request->getRequestUrl()))); ?>';
            form.appendChild(input);
        }
    }
</script>