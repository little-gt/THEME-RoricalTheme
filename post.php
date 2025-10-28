<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

    <script>let page = 0;</script>
    <main class="profile-page">
        <section class="section-profile-cover section-shaped my-0">
            <!-- Circles background -->
            <div class="shape shape-style-1 alpha-4 shape-background">
                <span></span><span></span><span></span><span></span><span></span><span></span><span></span>
            </div>
            <!-- SVG separator -->
        </section>
        <div class="card shadow border-0 bg-secondary toc-container">
            <a class="carousel-control-prev" id="toc-nomiao">
                <span class="ni ni-bold-left" id="toc-miao"></span>
            </a>
            <div class="card-img tu container container-lg py-5 toc">
                <strong>文章目录</strong>
                <div class="toc-list"><?php getCatalog(); ?></div>
            </div>
        </div>
        <script>
            // Define jumpto as a global function to ensure it's accessible from inline onclick or javascript: URLs
            function jumpto(num) {
                const target = $('[name="cl-' + num + '"]');
                if (target.length) {
                    $('html, body').animate({ scrollTop: target.offset().top - 100 }, 500);
                } else {
                    console.error('Anchor not found: cl-' + num);
                }
            }

            $(document).ready(function() {
                let onshow = false;
                function tocshow() {
                    onshow = !onshow;
                    const container = $(".toc-container");
                    const icon = $("#toc-miao");
                    container.css("right", onshow ? '-5px' : '-175px');
                    icon.toggleClass("ni-bold-left ni-bold-right");
                }

                // 使用事件委托绑定点击事件
                $(document).on("click", ".toc-list a", function(event) {
                    event.preventDefault();
                    const href = $(this).attr("href");
                    const numMatch = href.match(/jumpto\((\d+)\)/);
                    if (numMatch && numMatch[1]) {
                        jumpto(numMatch[1]);
                    }
                });

                // 绑定 TOC 显示/隐藏事件
                $(document).on("click", "#toc-nomiao", tocshow);

                // 检查页面加载时是否需要显示 TOC
                <?php if ($this->options->toc == "able") { echo("tocshow();"); } ?>
            });
        </script>
        <section class="section">
            <div class="container container-lg py-5" style="max-width: 1500px;">
                <div class="card card-profile shadow mt--250">
                    <div class="px-4">
                        <div class="text-center mt-5" style="margin: 50px auto;">
                            <h2 class="display-2"><?php $this->title(); ?></h2>
                            <br>
                            <div class="h6 font-weight-300">
                                <i class="ni location_pin mr-2"></i>
                                <a href="<?php $this->author->permalink(); ?>" rel="author"><?php $this->author(); ?></a>
                                <time style="margin:auto 10px;" datetime="<?php $this->date('c'); ?>"><?php $this->date(); ?></time>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="card-profile-stats d-flex justify-content-center">
                                    <div>
                                        <span class="heading"><?php get_post_view($this); ?></span>
                                        <span class="description">观看次数</span>
                                    </div>
                                    <div>
                                        <span class="heading"><?php art_count($this->cid); ?></span>
                                        <span class="description">字数</span>
                                    </div>
                                    <div>
                                        <span class="heading"><?php $this->commentsNum('%d'); ?></span>
                                        <span class="description">评论</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 text-lg-right align-self-lg-center">
                                <div class="card-profile-actions card-profile-stats d-flex justify-content-center">
                                    <?php if (count($this->tags) > 0): ?>
                                        <?php foreach ($this->tags as $tag): ?>
                                            <a href="<?php echo $tag['permalink']; ?>" class="btn btn-sm btn-info mr-4"><?php echo $tag['name']; ?></a>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <a class="btn btn-sm btn-info mr-4">无标签..</a>
                                    <?php endif; ?>
                                    <?php foreach ($this->categories as $category): ?>
                                        <a href="<?php echo $category['permalink']; ?>" class="btn btn-sm btn-default float-right"><?php echo $category['name']; ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 py-5 border-top">
                            <div class="row justify-content-center">
                                <div class="col-lg-9 breakword content">
                                    <?php if ($this->hidden): ?>
                                        <div class="container text-center">
                                            <form class="protected" id="protected" action="<?php $this->permalink(); ?>" method="post">
                                                <textarea name="text" style="display:none;"></textarea>
                                                <p class="lead">需要你输入密码哦！</p>
                                                <div class="row justify-content-md-center">
                                                    <div class="col col-10">
                                                        <input class="form-control" type="password" name="protectPassword" id="protectPassword" placeholder="请输入密码">
                                                    </div>
                                                    <div class="col-md-auto">
                                                        <button type="submit" class="btn btn-info" id="protectButton">确认</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <script>
                                                $("#protectPassword").on('focus', function () {
                                                    $(this).removeClass("is-invalid");
                                                });
                                                $("#protected").submit(function () {
                                                    const secr = <?php echo Typecho_Common::shuffleScriptVar($this->security->getToken(clear_urlcan($this->request->getRequestUrl()))); ?>;
                                                    $("#protectButton").attr("disabled", true);
                                                    $.ajax({
                                                        url: $(this).attr("action") + "?_=" + secr,
                                                        type: $(this).attr("method"),
                                                        data: $(this).serializeArray(),
                                                        complete: function () {
                                                            $("#protectButton").attr("disabled", false);
                                                        },
                                                        success: function (data) {
                                                            if (data) {
                                                                const parser = new DOMParser();
                                                                const htmlDoc = parser.parseFromString(data, "text/html");
                                                                if (htmlDoc.title == "Error") {
                                                                    $("#protectPassword").addClass("is-invalid");
                                                                } else {
                                                                    $("#protectPassword").addClass("is-valid");
                                                                    $("#protected").fadeOut();
                                                                    setTimeout(function () {
                                                                        $("title").html(htmlDoc.title);
                                                                        $("#main").html(htmlDoc.getElementById("main").innerHTML);
                                                                    }, 1000);
                                                                }
                                                            }
                                                        }
                                                    });
                                                    return false;
                                                });
                                            </script>
                                        </div>
                                    <?php else: ?>
                                        <?php
                                        $raw_content = $this->content;
                                        $lazy_content = preg_replace('/<img(.*?)src=[\'"]([^\'"]+)[\'"](.*?)>/i', "<noscript>\$0</noscript><img\$1data-original=\"\$2\" \$3>", $raw_content);
                                        $counter = 0;
                                        $anchored_content = preg_replace_callback('/<h([1-6])(.*?)>(.*?)<\/h\1>/i', function($match) use (&$counter) {
                                            $counter++;
                                            return '<h'.$match[1].$match[2].'><a name="cl-'.$counter.'"></a>'.$match[3].'</h'.$match[1].'>';
                                        }, $lazy_content);
                                        echo $anchored_content;
                                        ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="border-top text-center">
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container container-lg">
                <div class="row">
                    <div class="col-md-6 mb-5 mb-md-0">
                        <div class="card card-lift--hover shadow border-0">
                            <?php thePrev($this, $this->options->randompicUrl); ?>
                        </div>
                    </div>
                    <div class="col-md-6 mb-5 mb-lg-0">
                        <div class="card card-lift--hover shadow border-0">
                            <?php theNext($this, $this->options->randompicUrl); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php if (!$this->hidden && $this->allow('comment')) $this->need('comments.php'); ?>
    </main>

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>