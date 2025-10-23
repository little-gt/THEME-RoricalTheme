<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link href="<?php $this->options->siteUrl('/favicon.ico') ?>" rel="icon" type="image/png" />
    <title><?php $this->archiveTitle(array(
            'category'  =>  _t('%s下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>
    <!-- Analytics -->
    <?php $this->options->Analytic() ?>
	<!-- Jquery -->
    <script src="<?php $this->options->themeUrl('./assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('./assets/js/jquery.pjax.js'); ?>"></script>
    <!-- Fonts -->
    <!--<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">-->
    <!-- Icons -->
    <link href="<?php $this->options->themeUrl('./assets/vendor/nucleo/css/nucleo.css'); ?>" rel="stylesheet" />
    <link href="<?php $this->options->themeUrl('./assets/vendor/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" />
    <!-- Argon CSS -->
    <link type="text/css" href="<?php $this->options->themeUrl('./assets/css/argon.css?v=1.0.0'); ?>" rel="stylesheet" />
    <!-- Docs CSS -->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('./assets/css/index.css'); ?>" />
    <link rel="stylesheet" href="<?php $this->options->themeUrl('./assets/css/style.css'); ?>" />
    <link rel="stylesheet" href="<?php $this->options->themeUrl('./assets/css/csshake.min.css'); ?>" />
    <link rel="stylesheet" href="<?php $this->options->themeUrl('./assets/css/viewer.min.css'); ?>" />
    <link rel="stylesheet" href="<?php $this->options->themeUrl('./assets/css/prism.css'); ?>" />
    <!-- JS -->
    <script src="<?php $this->options->themeUrl('./assets/js/lazyload.js'); ?>" charset="utf-8"></script>
    <script src="<?php $this->options->themeUrl('./assets/js/functions.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('./assets/js/md5.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('./assets/js/viewer.min.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('./assets/js/jquery-viewer.min.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('./assets/js/prism.js'); ?>"></script>
    <!--[if lt IE 9]>
    <script src="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/html5shiv/3.7.3/html5shiv.min.js" type="application/javascript"></script>
    <script src="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/respond.js/1.4.2/respond.min.js" type="application/javascript"></script>
    <![endif]-->
	<!-- okaikia -->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('./assets/css/okaikia.css'); ?>" />
    <!-- 通过自有函数输出HTML头部信息 -->
    <?php $this->header(); ?>
</head>
<body>
    <!-- 老旧浏览器提示 -->
    <!--[if lt IE 8]>
    <div class="browsehappy" role="dialog"><?php _e('当前网页 <strong>不支持</strong> 你正在使用的浏览器. 为了正常的访问, 请 <a href="https://www.microsoft.com/zh-cn/edge">升级你的浏览器</a>'); ?>.</div>
    <![endif]-->

    <!-- 顶部导航 -->
    <header class="header-global">
        <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light">
            <div class="container">
                <a id="logo" href="<?php $this->options->siteUrl(); ?>" class="navbar-brand mr-lg-5">
                    <?php if ($this->options->logoUrl): ?>
                        <img src="<?php $this->options->logoUrl(); ?>" alt="<?php $this->options->title(); ?>">
                    <?php else: ?>
                        <span class="text-white"><?php $this->options->title(); ?></span>
                    <?php endif; ?>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse" id="navbar_global">
                    <div class="navbar-collapse-header">
                        <div class="row">
                            <div class="col-6 collapse-brand">
                                <a id="logo" href="<?php $this->options->siteUrl(); ?>">
                                    <?php if ($this->options->logoUrl): ?>
                                        <img src="<?php $this->options->logoUrl(); ?>" alt="<?php $this->options->title(); ?>">
                                    <?php else: ?>
                                        <span class="display-3"><?php $this->options->title(); ?></span>
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="col-6 collapse-close">
                                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                                    <span></span><span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <ul class="navbar-nav navbar-nav-hover align-items-lg-center">
                        <?php if ($this->options->navbar == "able"): ?>
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link" data-toggle="dropdown" role="button">
                                    <i class="ni ni-ui-04 d-lg-none"></i>
                                    <span class="nav-link-inner--text">页面</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-xl">
                                    <div class="dropdown-menu-inner">
                                        <a href="<?php $this->options->siteUrl(); ?>" class="media d-flex align-items-center">
                                            <div class="icon icon-shape bg-gradient-primary rounded-circle text-white">
                                                <i class="ni ni-spaceship"></i>
                                            </div>
                                            <div class="media-body ml-3">
                                                <h6 class="heading text-primary mb-md-1">主页</h6>
                                            </div>
                                        </a>
                                        <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                                        <?php while ($pages->next()): ?>
                                            <a href="<?php $pages->permalink(); ?>" class="media d-flex align-items-center">
                                                <div class="icon icon-shape <? echo(isset($pages->fields->color) ? "":$pages->fields->color)?> rounded-circle text-white">
                                                    <i class="ni <? echo(isset($pages->fields->icon) ? "":$pages->fields->icon)?>"></i>
                                                </div>
                                                <div class="media-body ml-3">
                                                    <h6 class="heading text-primary mb-md-1"><?php $pages->title(); ?></h6>
                                                </div>
                                            </a>
                                        <?php endwhile; ?>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link" data-toggle="dropdown" role="button">
                                    <i class="ni ni-collection d-lg-none"></i>
                                    <span class="nav-link-inner--text">分类</span>
                                </a>
                                <div class="dropdown-menu">
                                    <?php $this->widget('Widget_Metas_Category_List')->to($category); ?>
                                    <?php while ($category->next()): ?>
                                        <a href="<?php $category->permalink(); ?>" class="dropdown-item <?php if ($this->is('category', $category->slug)): ?>current<?php endif; ?>">
                                            <?php $category->name(); ?>
                                        </a>
                                    <?php endwhile; ?>
                                </div>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a href="<?php $this->options->siteUrl(); ?>" class="nav-link">
                                    <span class="nav-link-inner--text">主页</span>
                                </a>
                            </li>
                            <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                            <?php while ($pages->next()): ?>
                                <li class="nav-item">
                                    <a href="<?php $pages->permalink(); ?>" class="nav-link">
                                        <span class="nav-link-inner--text"><?php $pages->title(); ?></span>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </ul>
                    <ul class="navbar-nav align-items-lg-center ml-lg-auto">
                        <?php $icons = explode("\n", $this->options->navbarIcons); ?>
                        <?php foreach ($icons as $icon): ?>
                            <?php $icon = explode("$$", $icon); ?>
                            <?php if (count($icon) === 3): ?>
                                <li class="nav-item d-none d-lg-block ml-lg-4">
                                    <a class="nav-link nav-link-icon" href="<?php echo $icon[2]; ?>" target="_blank" data-toggle="tooltip" title="<?php echo $icon[1]; ?>">
                                        <i class="<?php echo $icon[0]; ?>"></i>
                                        <span class="nav-link-inner--text d-lg-none"><?php echo $icon[1]; ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div id="main">
        <style>
            :root {
                --main-bg-image: url(<?php echo $this->is('page') || $this->is('post') ? ($this->fields->pic ?: $this->options->randompicUrl() . "?_=" . mt_rand()) : $this->options->pcbackgroundUrl(); ?>) center center / cover no-repeat fixed;
                --phone-bg-image: url(<?php echo $this->is('page') || $this->is('post') ? ($this->fields->pic ?: $this->options->randompicUrl() . "?_=" . mt_rand()) : $this->options->mobilebackgroundUrl(); ?>) center center / cover no-repeat fixed;
            }
            .banner::before { background-image: url(<?php $this->options->themeUrl('./assets/css/ground.png'); ?>); }
            .shape-background {
                background: var(--main-bg-image);
                height: 100%;
                width: 100%;
                overflow: hidden;
            }
            @media (max-width: 678px) {
                .shape-background { background: var(--phone-bg-image); }
            }
        </style>
