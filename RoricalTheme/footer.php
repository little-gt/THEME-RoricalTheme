<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

</div>

<footer class="footer shadow bg-white">
    <div class="container align-items-center justify-content-md-between">
        <div class="row">
            <div class="col-md-6">
                <div class="footer-copyright">
                    Copyright © <?php echo date('Y'); ?> <?php $this->options->title(); ?>.
                    <?php if ($this->options->icpNumber): ?>
                        <br>
                        <a href="https://beian.miit.gov.cn/" target="_blank" rel="noopener noreferrer" class="footer-beian-link">
                            <?php echo htmlspecialchars($this->options->icpNumber); ?>
                        </a>
                    <?php endif; ?>
                    <?php if ($this->options->policeNumber): ?>
                        <a href="https://www.beian.gov.cn/" target="_blank" rel="noopener noreferrer" class="footer-beian-link">
                            <?php echo htmlspecialchars($this->options->policeNumber); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-6">
                <ul class="nav nav-footer justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php $this->options->siteUrl(); ?>">主页</a>
                    </li>
                    <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                    <?php while ($pages->next()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>
    </div>
</footer>
<style>
    .footer-copyright {
        font-size: 0.875rem;
        color: #8898aa;
        line-height: 1.5;
    }
    .footer-beian-link {
        margin-left: 10px;
        color: #8898aa;
        text-decoration: none;
        transition: color 0.2s ease-in-out;
    }
    .footer-beian-link:hover {
        color: #5e72e4;
        text-decoration: none;
    }
    @media (max-width: 767px) {
        .footer-copyright {
            text-align: center;
            margin-bottom: 10px;
        }
        .footer-beian-link {
            display: inline-block;
            margin: 5px 10px 0 0;
        }
    }
</style>

<?php $this->footer(); ?>

<script src="<?php $this->options->themeUrl('./assets/vendor/popper/popper.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('./assets/vendor/bootstrap/bootstrap.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('./assets/vendor/headroom/headroom.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('./assets/vendor/onscreen/onscreen.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('./assets/vendor/nouislider/js/nouislider.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('./assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('./assets/js/argon.js?v=1.0.0'); ?>"></script>
<script type="text/javascript">
    window.MathJax = {
        tex: {
            inlineMath: [['$', '$'], ['\\(', '\\)']],
            displayMath: [['$$', '$$'], ['\\[', '\\]']],
            processEscapes: true,
            processEnvironments: true,
            tags: 'ams'
        },
        chtml: {
            scale: 1.0,
            displayAlign: 'center'
        },
        options: {
            skipHtmlTags: ['script', 'noscript', 'style', 'textarea', 'pre', 'code', 'a'],
            ignoreHtmlClass: 'tex2jax_ignore',
            processHtmlClass: 'tex2jax_process',
            renderActions: {
                addMenu: [0, '', '']
            }
        }
    };
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/3.2.2/es5/tex-chtml.js" integrity="sha512-dYOCdOl06012DI+59NDm+JDwE5nfEOHU3OSwP1ydeLK5/dUcUohVx2Ojd7kNqw711V8++78udRAZMOGoKYJgvw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?php $this->options->themeUrl('./assets/js/prism.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('./assets/js/clipboard.min.js'); ?>"></script>

<script type="text/javascript">
    function init() {
        document.querySelectorAll('pre').forEach(item => {
            item.className = item.className ? item.className + ' line-numbers' : 'line-numbers';
        });
        Prism.highlightAll(true, null);

        if (typeof emojify !== "undefined") {
            emojify.run();
        }

        try {
            if (window.MathJax && window.MathJax.typesetPromise) {
                window.MathJax.typesetPromise([document.getElementById('main')]).catch(err => console.error(err));
            }
        } catch (e) {
            console.error(e);
        }
    }

    $(document).ready(function () {
        $('img[data-original]:not(img[no-viewer])').viewer({ url: 'data-original' });
        $("img").lazyload({ effect: "fadeIn", threshold: 700 });

        var header = document.querySelector("#navbar-main");
        var headroom = new Headroom(header, { tolerance: 5, offset: 210 });
        headroom.init();

        if (page === 1) {
            $("#navbar-main").addClass("bg-info alpha-4");
        } else {
            $("#navbar-main").removeClass("bg-info alpha-4");
        }

        $(document).pjax('a[href^="<?php Helper::options()->siteUrl(); ?>"]:not(a[target="_blank"], a[no-pjax])', {
            container: '#main',
            fragment: '#main',
            timeout: 8000
        }).on('pjax:send', function () {
            var viewer = $('img[data-original]:not(img[no-viewer])').data('viewer');
            if (viewer) {
                viewer.destroy();
            }
            show();
        }).on('pjax:complete', function () {
            $("img").lazyload({ effect: "fadeIn", threshold: 700 });
            setTimeout(() => {
                $('img[data-original]:not(img[no-viewer])').viewer({ url: 'data-original' });
            }, 300);

            if (page === 1) {
                $("#navbar-main").addClass("bg-info alpha-4");
            } else {
                $("#navbar-main").removeClass("bg-info alpha-4");
            }
            init();
            hide();
        });

        $("#search").submit(function () {
            var att = $(this).serializeArray();
            for (var i in att) {
                if (att[i].name === "s") {
                    $.pjax({
                        url: "<?php $this->options->siteUrl(); ?>search/" + att[i].value + "/",
                        container: '#main',
                        fragment: '#main',
                        timeout: 8000
                    }).on('pjax:send', function () {
                        show();
                    }).on('pjax:complete', function () {
                        $("img").lazyload({ effect: "fadeIn", threshold: 700 });
                        hide();
                    });
                }
            }
            return false;
        });

        init();
    });

    $(window).scroll(function () {
        if ($(window).scrollTop() >= 500) {
            $("#upbtn").addClass("upbtn-show");
        } else {
            $("#upbtn").removeClass("upbtn-show");
        }
    });

    function changeFrameHeight() {
        var ifm = document.getElementById("Adaptiveiframepage");
        if (ifm) {
            ifm.height = document.documentElement.clientHeight;
            ifm.width = document.body.clientWidth;
        }
    }

    window.onresize = function () {
        changeFrameHeight();
    };
</script>

<div class="loading blur-item" id="loading" style="display: none;">
    <div class="spinner-box center">
        <div class="pulse-container">
            <div class="pulse-bubble pulse-bubble-1"></div>
            <div class="pulse-bubble pulse-bubble-2"></div>
            <div class="pulse-bubble pulse-bubble-3"></div>
        </div>
    </div>
</div>

<?php if ($this->options->powermode == "able"): ?>
    <script src="<?php $this->options->themeUrl('./assets/js/activate-power-mode.js'); ?>"></script>
    <script>
        $(document).ready(function () {
            POWERMODE.colorful = true;
            POWERMODE.shake = false;
            document.body.addEventListener('input', POWERMODE);
        });
    </script>
<?php endif; ?>

<?php if ($this->options->clickanime == "able"): ?>
    <canvas id="clickcanvas"></canvas>
    <script src="<?php $this->options->themeUrl('./assets/js/click.js'); ?>"></script>
<?php endif; ?>

<?php $safePrivacyUrl = getPrivacyUrl(); ?>

<a href="javascript:$('html,body').animate({ scrollTop: 0 }, 500)">
    <button id="upbtn" class="btn btn-icon-only rounded-circle btn-info up-btn">
        <span class="btn-inner--icon"><i class="ni ni-bold-up" aria-hidden="true"></i></span>
    </button>
</a>

<!-- START - Cookie Consent Management -->
<!-- 1. Main Consent Banner (Initially Visible) -->
<div id="cookie-consent-banner" class="cookie-banner">
    <div class="cookie-banner-content">
        <p>欢迎来到「<?php $this->options->title(); ?>」。我们使用 Cookie 来优化您的体验、提供安全保障并分析网站流量。您可以选择接受所有 Cookie，或自定义您的设置。您可以阅读<a href="<?php echo $safePrivacyUrl; ?>">隐私政策</a>了解更多。</p>
        <div class="cookie-banner-buttons">
            <button id="cookie-customize-btn">自定义设置</button>
            <button id="cookie-accept-all-btn">接受所有</button>
        </div>
    </div>
</div>
<!-- 2. Detailed Settings Modal (Initially Hidden) -->
<div id="cookie-settings-modal" class="cookie-modal-backdrop">
    <div class="cookie-modal-content">
        <div class="cookie-modal-header">
            <h2>管理我的 Cookie 设置</h2>
            <button id="cookie-modal-close-btn" class="cookie-modal-close">&times;</button>
        </div>
        <div class="cookie-modal-body">
            <p>为了网站的正常运行和安全，某些 Cookie 是必需的。对于其他类型的 Cookie，您可根据需要，选择是否启用。您的选择将被保存，并且可以随时通过页脚的 Cookie 图标进行修改。您可以阅读<a href="<?php echo $safePrivacyUrl; ?>">隐私政策</a>了解更多。</p>
            <!-- Strictly Necessary Cookies -->
            <div class="cookie-category">
                <div class="cookie-category-header">
                    <label for="cookie-necessary">
                        <strong>必要的 Cookie</strong>
                    </label>
                    <div class="cookie-toggle-switch-disabled">
                        <input type="checkbox" id="cookie-necessary" checked disabled>
                        <span></span>
                    </div>
                </div>
                <p class="cookie-category-description">
                    这些 Cookie 对于网站的核心功能至关重要，例如安全性和可访问性。它们始终启用，无法被禁用。
                    <br><strong>用途</strong>: 安全人机验证、会话管理。
                </p>
            </div>
            <!-- Functional Cookies -->
            <div class="cookie-category">
                <div class="cookie-category-header">
                    <label for="cookie-functional">
                        <strong>功能性 Cookie</strong>
                    </label>
                    <label class="cookie-toggle-switch">
                        <input type="checkbox" id="cookie-functional">
                        <span></span>
                    </label>
                </div>
                <p class="cookie-category-description">
                    这些 Cookie 用于提供增强功能和个性化设置，例如记住您的偏好（如启用评论区等功能）。
                    <br><strong>用途</strong>: 记住服务偏好信息。
                </p>
            </div>
            <!-- Analytics Cookies -->
            <div class="cookie-category">
                <div class="cookie-category-header">
                    <label for="cookie-analytics">
                        <strong>分析性 Cookie</strong>
                    </label>
                    <label class="cookie-toggle-switch">
                        <input type="checkbox" id="cookie-analytics">
                        <span></span>
                    </label>
                </div>
                <p class="cookie-category-description">
                    这些 Cookie 帮助我们了解访问者如何与网站互动，通过收集和报告匿名信息来帮助我们改进网站。
                    <br><strong>用途</strong>: 统计网站访问量和流量来源。
                </p>
            </div>

        </div>
        <div class="cookie-modal-footer">
            <button id="cookie-save-prefs-btn">保存我的选择</button>
            <button id="cookie-accept-all-modal-btn">接受所有</button>
        </div>
    </div>
</div>
<!-- 3. Manage Consent Trigger (Visible after initial choice) -->
<div id="manage-consent-trigger" title="管理 Cookie 设置">
    <svg t="1761489949848" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="16013" xmlns:xlink="http://www.w3.org/1999/xlink" width="200" height="200"><path d="M512 128a384 384 0 0 0-384 384 384 384 0 0 0 384 384 384 384 0 0 0 384-384c0-21.333333-1.706667-42.666667-5.546667-64C878.933333 426.666667 853.333333 426.666667 853.333333 426.666667h-85.333333V384c0-42.666667-42.666667-42.666667-42.666667-42.666667h-85.333333V298.666667c0-42.666667-42.666667-42.666667-42.666667-42.666667h-42.666666V170.666667c0-42.666667-42.666667-42.666667-42.666667-42.666667M405.333333 256A64 64 0 0 1 469.333333 320 64 64 0 0 1 405.333333 384 64 64 0 0 1 341.333333 320 64 64 0 0 1 405.333333 256m-128 170.666667A64 64 0 0 1 341.333333 490.666667 64 64 0 0 1 277.333333 554.666667 64 64 0 0 1 213.333333 490.666667 64 64 0 0 1 277.333333 426.666667m213.333334 42.666666a64 64 0 0 1 64 64 64 64 0 0 1-64 64 64 64 0 0 1-64-64 64 64 0 0 1 64-64m213.333333 85.333334a64 64 0 0 1 64 64 64 64 0 0 1-64 64 64 64 0 0 1-64-64 64 64 0 0 1 64-64M469.333333 682.666667a64 64 0 0 1 64 64A64 64 0 0 1 469.333333 810.666667a64 64 0 0 1-64-64A64 64 0 0 1 469.333333 682.666667z" fill="#ffffff" p-id="16014" data-spm-anchor-id="a313x.search_index.0.i5.43dc3a81CmRlcO" class="selected"></path></svg>
</div>
<!-- END - Cookie Consent Management -->

</body>
</html>