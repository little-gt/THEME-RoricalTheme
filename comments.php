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
                            <span class="badge badge-info">
                                <i class="fa fa-globe" aria-hidden="true"></i>
                                <?php if (class_exists('LocationIP_Plugin')) LocationIP_Plugin::output($comments, "{loc}"); ?>
                                </span>
                            <span class="badge badge-success">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                <?php $comments->date('Y F jS'); ?>
                                </span>
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
    // 获取响应容器并创建一个隐藏的输入元素
    var r = document.getElementById('<?= $this->respondId(); ?>'),
        input = document.createElement('input');
    input.type = 'hidden';
    input.name = '_';
    input.value = <?php echo Typecho_Common::shuffleScriptVar($this->security->getToken(clear_urlcan($this->request->getRequestUrl()))); ?>;

    // 如果响应容器存在，将隐藏的输入元素附加到表单中
    if (null != r) {
        var forms = r.getElementsByTagName('form');
        if (forms.length > 0) {
            forms[0].appendChild(input);
        }
    }

    // 当邮箱输入框失去焦点时，更新头像显示
    $("#mail").on('blur', function () {
        var url = "https://cdn.sep.cc/avatar/" + hex_md5($(this).val()) + "?s=40&d=";
        $("#author-head").css('background-image', 'url(' + url + ')');
    });

    // 绑定表单提交事件
    function bindsubmit() {
        $("#comment-form").submit(function () {
            // 禁用提交按钮，防止重复提交
            $("#add-comment-button").attr("disabled", true);
            $.ajax({
                url: $(this).attr("action"),
                type: $(this).attr("method"),
                data: $(this).serializeArray(),
                complete: function () {
                    // 提交完成后重新启用提交按钮
                    $("#add-comment-button").attr("disabled", false);
                },
                error: function () { },
                success: function (data) {
                    var parser = new DOMParser();
                    var htmlDoc = parser.parseFromString(data, "text/html");
                    // 如果返回的数据中包含评论刷新区域，则更新页面上的评论
                    if (htmlDoc.getElementById("comment-refresh")) {
                        var ele = document.getElementsByClassName("comment-text")[0];
                        var elehtml = ele.innerHTML;
                        document.getElementById("comment-refresh").innerHTML = htmlDoc.getElementById("comment-refresh").innerHTML;
                        if (!document.getElementsByClassName("comment-text")[0]) {
                            ele.innerHTML = elehtml;
                            ele.children[0].children[0].children[0].children[0].children[0].getElementsByClassName("col-lg-3")[0].getElementsByClassName("cancel-comment-reply")[0].children[0].style.cssText = "display:none;";
                            document.getElementsByClassName("comments")[0].appendChild(ele);
                            bindsubmit();
                            // 如果存在emojify对象，则运行emojify
                            if (typeof emojify != "undefined") {
                                setTimeout(function () {
                                    emojify.run();
                                }, 1000);
                            }
                        }
                    }

                    // 清除评论框并显示提交成功提示
                    $("#textarea").val('');
                    showSuccessMessage();
                }
            });
            return false;
        });
    }
    bindsubmit();

    // 显示提交成功提示
    function showSuccessMessage() {
        var successMessage = $("<div class='alert alert-success alert-dismissible fade show' role='alert'>评论提交成功！<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        $("#comment-form").before(successMessage);
        // 滑动页面到提示条位置
        $('html, body').animate({
            scrollTop: successMessage.offset().top - 100
        }, 500);
        setTimeout(function () {
            successMessage.fadeOut(500, function () {
                $(this).remove();
            });
        }, 3000); // 3秒后自动隐藏提示
    }

    // TypechoComment对象，用于处理评论相关的DOM操作
    (function () {
        window.TypechoComment = {
            dom: function (id) {
                return document.getElementById(id);
            },
            create: function (tag, attr) {
                var el = document.createElement(tag);
                for (var key in attr) {
                    el.setAttribute(key, attr[key]);
                }
                return el;
            },
            reply: function (cid, coid) {
                var comment = this.dom(cid), parent = comment.parentNode,
                    response = this.dom('<?= $this->respondId(); ?>'), input = this.dom('comment-parent'),
                    form = 'form' == response.tagName ? response : response.getElementsByTagName('form')[0],
                    textarea = response.getElementsByTagName('textarea')[0];

                if (null == input) {
                    input = this.create('input', {
                        'type': 'hidden',
                        'name': 'parent',
                        'id': 'comment-parent'
                    });
                    form.appendChild(input);
                }
                input.setAttribute('value', coid);

                if (null == this.dom('comment-form-place-holder')) {
                    var holder = this.create('div', {
                        'id': 'comment-form-place-holder'
                    });
                    response.parentNode.insertBefore(holder, response);
                }

                comment.appendChild(response);
                this.dom('cancel-comment-reply-link').style.display = '';

                if (null != textarea && 'text' == textarea.name) {
                    textarea.focus();
                }
                return false;
            },
            cancelReply: function () {
                var response = this.dom('<?= $this->respondId(); ?>'),
                    holder = this.dom('comment-form-place-holder'), input = this.dom('comment-parent');

                if (null != input) {
                    input.parentNode.removeChild(input);
                }

                if (null == holder) {
                    return true;
                }

                this.dom('cancel-comment-reply-link').style.display = 'none';
                holder.parentNode.insertBefore(response, holder);
                return false;
            }
        };
    })();
</script>