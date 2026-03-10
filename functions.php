<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

use Widget\Base\Contents;

/**
 * 主题配置函数
 * @param Typecho_Widget_Helper_Form $form 配置表单对象
 */
function themeConfig($form) {
    // 站点 LOGO
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('站点 LOGO 地址'), _t('填入图片 URL 地址，用于网站标题前的 LOGO'));
    $form->addInput($logoUrl);

    // 用户头像
    $defaultAvatar = 'https://cdn.sep.cc/avatar/';
    $AvatarUrl = new Typecho_Widget_Helper_Form_Element_Text('AvatarUrl', NULL, $defaultAvatar, _t('用户头像'), _t('填入图片 URL 地址，用于站点头像'));
    $form->addInput($AvatarUrl);

    // 背景图片
    $defaultPcBackground = 'https://cdn.garfieldtom.cool/img/wldairy/poster/horizontal/%E9%81%87%E8%A7%81%E4%BD%A0%E7%9A%84%E7%8C%AB_%E6%B6%88%E9%98%B2%E7%AB%99.jpg';
    $defaultMobileBackground = 'https://cdn.garfieldtom.cool/img/wldairy/poster/vertical/%E9%81%87%E8%A7%81%E4%BD%A0%E7%9A%84%E7%8C%AB_%E7%AB%96%E5%B1%8F_%E4%B8%8D%E6%98%AF%E5%90%A7.jpg';
    $pcbackgroundUrl = new Typecho_Widget_Helper_Form_Element_Text('pcbackgroundUrl', NULL, $defaultPcBackground, _t('电脑主页背景'), _t('填入电脑背景图片 URL'));
    $mobilebackgroundUrl = new Typecho_Widget_Helper_Form_Element_Text('mobilebackgroundUrl', NULL, $defaultMobileBackground, _t('手机主页背景'), _t('填入手机背景图片 URL'));
    $form->addInput($pcbackgroundUrl);
    $form->addInput($mobilebackgroundUrl);

    // 随机图片
    $defaultRandomPic = 'https://t.alcy.cc/fj';
    $randompicUrl = new Typecho_Widget_Helper_Form_Element_Text('randompicUrl', NULL, $defaultRandomPic, _t('随机图片'), _t('填入图片 URL，用于文章默认头图'));
    $form->addInput($randompicUrl);

    // PowerMode 打字特效
    $powermode = new Typecho_Widget_Helper_Form_Element_Radio('powermode', ['able' => _t('启用'), 'disable' => _t('禁止')], 'disable', _t('PowerMode 打字特效'), _t('默认禁用，可启用'));
    $form->addInput($powermode);

    // 鼠标点击特效
    $clickanime = new Typecho_Widget_Helper_Form_Element_Radio('clickanime', ['able' => _t('启用'), 'disable' => _t('禁止')], 'disable', _t('鼠标点击特效'), _t('默认禁用，可启用'));
    $form->addInput($clickanime);

    // 网站统计代码
    $Analytic = new Typecho_Widget_Helper_Form_Element_Textarea('Analytic', NULL, NULL, _t('网站统计代码'), _t('填入类似 Google Analytics 的代码，添加到 Header（直接输入代码，该功能会通过 Cookie 管理器控制）'));
    $form->addInput($Analytic);

    // 导航栏图标
    $navbarIcons = new Typecho_Widget_Helper_Form_Element_Textarea('navbarIcons', NULL, _t('fa fa-github$$Github$$https://github.com/Liupaperbox/'), _t('导航栏图标'), _t('格式：图标class$$文字$$链接，一行一个'));
    $form->addInput($navbarIcons);

    // 导航栏样式
    $navbar = new Typecho_Widget_Helper_Form_Element_Radio('navbar', ['able' => _t('下拉式'), 'disable' => _t('平铺式')], 'able', _t('导航栏样式'), _t('默认下拉式，可改为平铺式'));
    $form->addInput($navbar);

    // 文章目录开关
    $toc = new Typecho_Widget_Helper_Form_Element_Radio('toc', ['able' => _t('开启'), 'disable' => _t('关闭')], 'disable', _t('文章目录默认开关'), _t('默认关闭'));
    $form->addInput($toc);
    
    // 隐私政策 URL
    $privacyUrl = new Typecho_Widget_Helper_Form_Element_Text(
        'privacyUrl', 
        NULL, 
        './privacy.html', 
        _t('隐私政策链接'), 
        _t('填入隐私政策页面 URL，可以是相对路径（如 ./privacy.html）或完整 URL')
    );
    $form->addInput($privacyUrl);
    
    // 未登录用户评论控制
    $guestComment = new Typecho_Widget_Helper_Form_Element_Radio(
        'guestComment', 
        [
            'allow' => _t('允许未登录用户评论'),
            'deny' => _t('禁止未登录用户评论')
        ], 
        'allow', 
        _t('访客评论设置'), 
        _t('控制未登录用户是否可以发表评论')
    );
    $form->addInput($guestComment);
    
    // 禁止评论时的提示信息
    $guestCommentMsg = new Typecho_Widget_Helper_Form_Element_Textarea(
        'guestCommentMsg', 
        NULL, 
        _t('抱歉，本站仅允许登录用户发表评论。请先<a href="%loginUrl%">登录</a>您的账户。'), 
        _t('禁止访客评论提示'), 
        _t('当禁止未登录用户评论时显示的提示信息。可使用 %loginUrl% 作为登录链接占位符。')
    );
    $form->addInput($guestCommentMsg);
}

/**
 * 重写头像逻辑，使用指定镜像
 * @param string $mail 评论者的邮箱
 * @param int $size 头像尺寸
 * @param string $author 评论者作者
 * @param string $class CSS class
 */
function get_custom_gravatar($mail, $size = 40, $author = '', $class = 'rounded-circle') {
    $mail = trim($mail);
    if (empty($mail)) {
        $mail = 'default@example.com';
    }
    $size = max(1, min(2048, intval($size)));
    $url = "https://cdn.sep.cc/avatar/" . md5(strtolower($mail));
    $url .= "?s=" . $size;
    $author = htmlspecialchars($author, ENT_QUOTES, 'UTF-8');
    $class = htmlspecialchars($class, ENT_QUOTES, 'UTF-8');
    echo '<img src="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" class="' . $class . '" alt="' . $author . '">';
}

/**
 * 为文章标题添加锚点以生成目录
 * @param string $obj 文章内容
 * @return string 处理后的内容
 */
function createCatalog($obj) {
    global $catalog, $catalog_count;
    $catalog = [];
    $catalog_count = 0;
    $obj = preg_replace_callback('/<h([1-6])(.*?)>(.*?)<\/h\1>/i', function($match) use (&$catalog, &$catalog_count) {
        $catalog_count++;
        $catalog[] = ['text' => trim(strip_tags($match[3])), 'depth' => $match[1], 'count' => $catalog_count];
        return "<h{$match[1]}{$match[2]} id=\"cl-{$catalog_count}\">{$match[3]}</h{$match[1]}>";
    }, $obj);
    return $obj;
}

/**
 * 输出文章目录 HTML
 */
function getCatalog() {
    global $catalog;
    if (empty($catalog)) {
        echo '<p>暂无目录</p>';
        return;
    }

    $html = '<ul>';
    $prev_depth = 0;
    $depth_diff = 0;

    foreach ($catalog as $item) {
        $depth = $item['depth'];
        if ($prev_depth) {
            if ($depth > $prev_depth) {
                $html .= '<ul>';
                $depth_diff++;
            } elseif ($depth < $prev_depth) {
                $diff = min($depth_diff, $prev_depth - $depth);
                $html .= str_repeat('</li></ul>', $diff);
                $depth_diff -= $diff;
                $html .= '</li>';
            } else {
                $html .= '</li>';
            }
        }
        $html .= "<li><a href=\"#cl-{$item['count']}\" onclick=\"jumpto({$item['count']})\" style=\"color: #000000;\">{$item['text']}</a>";
        $prev_depth = $depth;
    }

    $html .= str_repeat('</li></ul>', $depth_diff + 1);
    echo $html;
}

/**
 * 获取文章浏览次数
 * @param Widget_Archive $archive 文章对象
 */
function get_post_view($archive) {
    $cid = intval($archive->cid);
    if ($cid <= 0) {
        echo 0;
        return;
    }
    
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();

    // 检查 views 列是否存在
    $checkRow = $db->fetchRow($db->select()->from('table.contents')->limit(1));
    if ($checkRow && !array_key_exists('views', $checkRow)) {
        try {
            $db->query("ALTER TABLE `{$prefix}contents` ADD `views` INT(10) UNSIGNED DEFAULT 0;");
        } catch (Exception $e) {
            echo 0;
            return;
        }
    }

    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if (!$row || !isset($row['views'])) {
        echo 0;
        return;
    }
    
    $currentViews = intval($row['views']);
    
    if ($archive->is('single')) {
        $views = Typecho_Cookie::get('extend_contents_views');
        $viewed_cids = $views ? array_filter(array_map('intval', explode(',', $views))) : [];
        if (!in_array($cid, $viewed_cids, true)) {
            try {
                $db->query($db->update('table.contents')->rows(['views' => $currentViews + 1])->where('cid = ?', $cid));
                $viewed_cids[] = $cid;
                Typecho_Cookie::set('extend_contents_views', implode(',', $viewed_cids));
                $currentViews++;
            } catch (Exception $e) {
                // 静默失败，显示当前计数
            }
        }
    }
    echo $currentViews;
}

/**
 * 计算文章字数（仅中文）
 * @param int $cid 文章 ID
 */
function art_count($cid) {
    $cid = intval($cid);
    if ($cid <= 0) {
        echo 0;
        return;
    }
    
    $db = Typecho_Db::get();
    $row = $db->fetchRow($db->select('text')->from('table.contents')->where('cid = ?', $cid));
    
    if (!$row || !isset($row['text'])) {
        echo 0;
        return;
    }
    
    $text = preg_replace("/[^\x{4e00}-\x{9fa5}]/u", "", $row['text']);
    echo mb_strlen($text, 'UTF-8');
}

/**
 * 主题初始化
 * @param Widget_Archive $archive 当前页面对象
 */
function themeInit($archive) {
    Helper::options()->commentsMaxNestingLevels = 999;
    
    // 后端校验：检查访客评论权限
    if ($archive->is('single') || $archive->is('page')) {
        // 检查是否是评论提交请求
        $request = $archive->request;
        if ($request->isPost() && $request->is('do=comment')) {
            $user = Typecho_Widget::widget('Widget_User');
            $options = Helper::options();
            
            // 如果设置为禁止访客评论，且用户未登录
            if (isset($options->guestComment) && $options->guestComment === 'deny' && !$user->hasLogin()) {
                // 返回 403 错误并终止
                $archive->response->setStatus(403);
                $errorMsg = $options->guestCommentMsg ? $options->guestCommentMsg : '抱歉，本站仅允许登录用户发表评论。';
                // 移除 HTML 标签用于纯文本错误消息
                $errorMsg = strip_tags(str_replace('%loginUrl%', $options->adminUrl('login.php'), $errorMsg));
                
                // 如果是 AJAX 请求，返回 JSON
                if ($request->isAjax()) {
                    header('Content-Type: application/json; charset=UTF-8');
                    echo json_encode([
                        'success' => false,
                        'message' => $errorMsg,
                        'code' => 403
                    ]);
                    exit;
                }
                
                // 普通请求返回错误页面
                throw new Typecho_Widget_Exception($errorMsg, 403);
            }
        }
        
        // 生成文章目录
        $archive->content = createCatalog($archive->content);
    }
}

/**
 * 获取评论的永久链接（用于 @ 回复）
 * @param int $coid 评论 ID
 * @return array|string
 */
function getPermalinkFromCoid($coid) {
    $coid = intval($coid);
    if ($coid <= 0) {
        return 'Invalid comment ID!';
    }
    
    $db = Typecho_Db::get();
    $options = Typecho_Widget::widget('Widget_Options');
    $row = $db->fetchRow($db->select('cid', 'type', 'author', 'text')->from('table.comments')->where('coid = ? AND status = ?', $coid, 'approved'));

    if (empty($row) || !isset($row['cid'])) {
        return 'Comment not found!';
    }

    $cid = intval($row['cid']);
    $select = $db->select('coid', 'parent', 'type')->from('table.comments')->where('cid = ? AND status = ?', $cid, 'approved')->order('coid');
    
    if ($options->commentsShowCommentOnly) {
         $select->where('type = ?', 'comment');
    }
    $comments = $db->fetchAll($select);

    if ($options->commentsOrder === 'DESC') {
        $comments = array_reverse($comments);
    }

    $parents = array_column($comments, 'parent', 'coid');
    $count = 0;
    $i = $coid;
    $maxDepth = 100; // 防止无限循环
    while ($i != 0 && isset($parents[$i]) && $maxDepth-- > 0) {
        $i = intval($parents[$i]);
        if ($i == 0) $count++;
    }

    $contentRow = $db->fetchRow($db->select()->from('table.contents')->where('cid = ?', $cid));
    if (!$contentRow) {
        return 'Content not found!';
    }
    
    $content = Typecho_Widget::widget('Widget_Abstract_Contents')->push($contentRow);
    $permalink = isset($content['permalink']) ? rtrim($content['permalink'], '/') : '';
    $page_suffix = $options->commentsPageBreak ? '/comment-page-' . ceil($count / max(1, $options->commentsPageSize)) : (substr($permalink, -5) === '.html' ? '' : '/');

    return [
        'author' => isset($row['author']) ? $row['author'] : '',
        'text' => isset($row['text']) ? $row['text'] : '',
        'href' => "{$permalink}{$page_suffix}#{$row['type']}-{$coid}"
    ];
}

/**
 * 输出上一篇链接
 */
function thePrev($widget, $randompicUrl) {
    $db = Typecho_Db::get();
    $content = $db->fetchRow($db->select()->from('table.contents')
        ->where('table.contents.created < ?', $widget->created)
        ->where('table.contents.status = ?', 'publish')
        ->where('table.contents.type = ?', $widget->type)
        ->where('table.contents.password IS NULL')
        ->order('table.contents.created', Typecho_Db::SORT_DESC)
        ->limit(1));

    if ($content) {
        echo generatePostLink($content, $widget, $randompicUrl, 'prev');
    } else {
        $safeUrl = htmlspecialchars($randompicUrl, ENT_QUOTES, 'UTF-8');
        echo "<a class=\"carousel\" title=\"没啦\"><div style=\"background-image:url({$safeUrl});\" class=\"card-img tu\"></div><div class=\"carousel-indicators\"><h3 class=\"heading-title text-info blackback\" style=\"text-transform:none;\">没啦</h3></div></a>";
    }
}

/**
 * 输出下一篇链接
 */
function theNext($widget, $randompicUrl) {
    $db = Typecho_Db::get();
    $content = $db->fetchRow($db->select()->from('table.contents')
        ->where('table.contents.created > ?', $widget->created)
        ->where('table.contents.status = ?', 'publish')
        ->where('table.contents.type = ?', $widget->type)
        ->where('table.contents.password IS NULL')
        ->order('table.contents.created', Typecho_Db::SORT_ASC)
        ->limit(1));

    if ($content) {
        echo generatePostLink($content, $widget, $randompicUrl, 'next');
    } else {
        $safeUrl = htmlspecialchars($randompicUrl, ENT_QUOTES, 'UTF-8');
        echo "<a class=\"carousel\" title=\"没啦\"><div style=\"background-image:url({$safeUrl});\" class=\"card-img tu\"></div><div class=\"carousel-indicators\"><h3 class=\"heading-title text-info blackback\" style=\"text-transform:none;\">没啦</h3></div></a>";
    }
}

/**
 * 生成上一篇/下一篇链接 HTML
 */
function generatePostLink($content, $widget, $randompicUrl, $direction) {
    if (!$content) {
        return "";
    }
    
    $post = Typecho_Widget::widget('Widget_Archive@temp');
    $db = Typecho_Db::get();
    $sql = $db->select()->from('table.contents')->where('cid = ?', $content['cid']);
    $db->fetchRow($sql, array($post, 'push'));
    
    // 安全获取文章头图
    $pic = '';
    if (isset($post->fields) && isset($post->fields->pic) && !empty($post->fields->pic)) {
        $pic = $post->fields->pic;
    } else {
        $pic = $randompicUrl . "?_=" . mt_rand(100000, 999999);
    }
    
    $safePic = htmlspecialchars($pic, ENT_QUOTES, 'UTF-8');
    $safePermalink = htmlspecialchars($post->permalink, ENT_QUOTES, 'UTF-8');
    $safeTitle = htmlspecialchars($post->title, ENT_QUOTES, 'UTF-8');
    
    $icon = $direction === 'prev' ? '<i class="ni ni-bold-left"></i>' : '<i class="ni ni-bold-right"></i>';
    $layout = $direction === 'prev' 
        ? "{$icon}<h2 class=\"heading-title text-info blackback\" style=\"text-transform:none;\">{$safeTitle}</h2>" 
        : "<h2 class=\"heading-title text-info blackback\" style=\"text-transform:none;\">{$safeTitle}</h2>{$icon}";
    
    return "<a class=\"carousel\" href=\"{$safePermalink}\" title=\"{$safeTitle}\"><div style=\"background-image:url({$safePic});\" class=\"card-img tu\"></div><div class=\"carousel-indicators\">{$layout}</div></a>";
}

/**
 * 自定义评论组件（兼容 Typecho 1.2.1 / PHP 8.x）
 */
class Widget_Comments_Archive extends Widget_Abstract_Comments
{
    private $_currentPage = 1;
    private $_total = 0;
    private $_threadedComments = [];
    private $_singleCommentOptions = null;

    public function __construct($request, $response, $params = NULL)
    {
        parent::__construct($request, $response, $params);
        $this->parameter->setDefault(
            'parentId=0&commentPage=0&commentsNum=0&allowComment=1'
        );
    }

    /* ===============================
     * 必须与父类完全一致的返回类型
     * =============================== */
    protected function ___parentContent(): Contents
    {
        if ($this->parameter->parentContent instanceof Contents) {
            return $this->parameter->parentContent;
        }

        // 兜底（极少数情况）
        return new Contents(
            $this->request,
            $this->response,
            $this->parameter->parentContent
        );
    }

    protected function ___children(): array
    {
        return (
            $this->options->commentsThreaded
            && !$this->isTopLevel
            && isset($this->_threadedComments[$this->coid])
        )
            ? $this->_threadedComments[$this->coid]
            : [];
    }

    protected function ___isTopLevel(): bool
    {
        return $this->levels > $this->options->commentsMaxNestingLevels - 2;
    }

    protected function ___permalink(): string
    {
        $parent = $this->parentContent;

        if ($this->options->commentsPageBreak) {
            $pageRow = [
                'permalink'  => $parent->pathinfo,
                'commentPage'=> $this->_currentPage
            ];

            return Typecho_Router::url(
                'comment_page',
                $pageRow,
                $this->options->index
            ) . '#' . $this->theId;
        }

        return $parent->permalink . '#' . $this->theId;
    }

    /* ===============================
     * 核心执行逻辑
     * =============================== */
    public function execute()
    {
        if (!$this->parameter->parentId) return;

        $commentsAuthor = Typecho_Cookie::get('__typecho_remember_author');
        $commentsMail   = Typecho_Cookie::get('__typecho_remember_mail');

        $select = $this->select()
            ->where('cid = ?', $this->parameter->parentId)
            ->where(
                'status = ? OR (author = ? AND mail = ? AND status = ?)',
                'approved',
                $commentsAuthor,
                $commentsMail,
                'waiting'
            )
            ->order('coid', 'ASC');

        if ($this->options->commentsShowCommentOnly) {
            $select->where('type = ?', 'comment');
        }

        $this->db->fetchAll($select, [$this, 'push']);

        $output = [];

        if ($this->options->commentsThreaded) {
            foreach ($this->stack as $coid => &$comment) {
                $parent = $comment['parent'];

                if ($parent && isset($this->stack[$parent])) {
                    if ($comment['levels'] >= $this->options->commentsMaxNestingLevels) {
                        $comment['levels'] = $this->stack[$parent]['levels'];
                        $comment['parent'] = $this->stack[$parent]['parent'];
                    }
                    $this->_threadedComments[$parent][$coid] = $comment;
                } else {
                    $output[$coid] = $comment;
                }
            }
            $this->stack = $output;
        }

        if ($this->options->commentsOrder === 'DESC') {
            $this->stack = array_reverse($this->stack, true);
            $this->_threadedComments = array_map(
                'array_reverse',
                $this->_threadedComments
            );
        }

        $this->_total = count($this->stack);

        if ($this->options->commentsPageBreak) {
            $this->_currentPage =
                $this->parameter->commentPage
                ?: ($this->options->commentsPageDisplay === 'last'
                    ? ceil($this->_total / $this->options->commentsPageSize)
                    : 1);

            $this->stack = array_slice(
                $this->stack,
                ($this->_currentPage - 1) * $this->options->commentsPageSize,
                $this->options->commentsPageSize,
                true
            );

            $this->row = current($this->stack);
            $this->length = count($this->stack);
        }

        reset($this->stack);
    }

    public function push(array $value): array
    {
        $value = $this->filter($value);
        $value['levels'] =
            ($value['parent'] && isset($this->stack[$value['parent']]))
            ? $this->stack[$value['parent']]['levels'] + 1
            : 0;

        $this->stack[$value['coid']] = $value;
        $this->length++;
        return $value;
    }

    /* ===============================
     * 输出部分
     * =============================== */
    public function threadedComments()
    {
        if (!$this->children) return;

        $tmp = $this->row;
        $this->sequence++;

        echo $this->_singleCommentOptions->before;

        foreach ($this->children as $child) {
            $this->row = $child;
            $this->threadedCommentsCallback();
        }

        echo $this->_singleCommentOptions->after;

        $this->row = $tmp;
        $this->sequence--;
    }

    public function listComments($options = NULL)
    {
        $this->_singleCommentOptions = Typecho_Config::factory($options);
        $this->_singleCommentOptions->setDefault([
            'before'        => '',
            'after'         => '',
            'dateFormat'    => $this->options->commentDateFormat,
            'replyWord'     => _t('回复'),
            'commentStatus' => _t('审核中...'),
            'avatarSize'    => 32
        ]);

        if ($this->have()) {
            echo $this->_singleCommentOptions->before;
            while ($this->next()) {
                $this->threadedCommentsCallback();
            }
            echo $this->_singleCommentOptions->after;
        }
    }
}

/**
 * 自定义分页导航组件
 */
class Typecho_Widget_Helper_PageNavigator_Box extends Typecho_Widget_Helper_PageNavigator{
    protected $_total;
    protected $_pageSize;
    protected $_currentPage;
    protected $_totalPage;
    protected $_pageTemplate;
    protected $_pageHolder = 'commentPage';
    protected $_anchor;

    public function __construct($total, $currentPage, $pageSize, $pageTemplate, $anchor = NULL)
    {
        $this->_total = max(0, intval($total));
        $this->_pageSize = max(1, intval($pageSize));
        $this->_currentPage = max(1, intval($currentPage));
        $this->_pageTemplate = strval($pageTemplate);
        $this->_anchor = $anchor ? '#' . preg_replace('/[^a-zA-Z0-9_-]/', '', $anchor) : '';
        $this->_totalPage = max(1, ceil($this->_total / $this->_pageSize));

        if ($this->_currentPage < 1) {
            $this->_currentPage = 1;
        } else if ($this->_currentPage > $this->_totalPage) {
            $this->_currentPage = $this->_totalPage;
        }

        // Normalize pageTemplate: replace {page} or {X} with {commentPage}
        $this->_pageTemplate = str_replace('{page}', '{' . $this->_pageHolder . '}', $this->_pageTemplate);
        $this->_pageTemplate = preg_replace('/\{\d+\}/', '{' . $this->_pageHolder . '}', $this->_pageTemplate);

        // Call parent constructor with 4 arguments for older Typecho compatibility
        parent::__construct($this->_total, $this->_currentPage, $this->_pageSize, $this->_pageTemplate);
    }

    public function render($prev = '&laquo;', $next = '&raquo;', $splitPage = 3, $splitWord = '···', array $template = [])
    {
        if ($this->_total < 1) return;

        $template = array_merge([
            'itemTag' => 'li',
            'textTag' => 'span',
            'currentClass' => 'active',
            'prevClass' => 'prev',
            'nextClass' => 'next',
            'itemClass' => 'page-item',
            'linkClass' => 'page-link'
        ], $template);

        extract($template);
        $itemBegin = $itemTag ? "<{$itemTag}" . ($itemClass ? " class=\"{$itemClass}\"" : '') . ">" : '';
        $itemEnd = $itemTag ? "</{$itemTag}>" : '';
        $linkBegin = "<a href=\"%s\"" . ($linkClass ? " class=\"{$linkClass}\"" : '') . ">";

        $from = max(1, $this->_currentPage - $splitPage);
        $to = min($this->_totalPage, $this->_currentPage + $splitPage);

        // Previous page link
        if ($this->_currentPage > 1) {
            $prevUrl = str_replace('{' . $this->_pageHolder . '}', $this->_currentPage - 1, $this->_pageTemplate) . $this->_anchor;
            echo "{$itemBegin}" . sprintf($linkBegin, $prevUrl, $prevClass) . $prev . "</a>{$itemEnd}";
        }

        // First page link
        if ($from > 1) {
            $firstUrl = str_replace('{' . $this->_pageHolder . '}', 1, $this->_pageTemplate) . $this->_anchor;
            echo "{$itemBegin}" . sprintf($linkBegin, $firstUrl) . '1</a>' . "{$itemEnd}";
            if ($from > 2) echo "{$itemBegin}<{$textTag} class=\"page-link\">{$splitWord}</{$textTag}>{$itemEnd}";
        }

        // Page number links
        for ($i = $from; $i <= $to; $i++) {
            $pageUrl = str_replace('{' . $this->_pageHolder . '}', $i, $this->_pageTemplate) . $this->_anchor;
            $class = $i == $this->_currentPage ? $currentClass : $itemClass;
            echo "<{$itemTag}" . ($class ? " class=\"{$class}\"" : '') . ">" . sprintf($linkBegin, $pageUrl) . $i . "</a></{$itemTag}>";
        }

        // Last page link
        if ($to < $this->_totalPage) {
            if ($to < $this->_totalPage - 1) echo "{$itemBegin}<{$textTag} class=\"page-link\">{$splitWord}</{$textTag}>{$itemEnd}";
            $lastUrl = str_replace('{' . $this->_pageHolder . '}', $this->_totalPage, $this->_pageTemplate) . $this->_anchor;
            echo "{$itemBegin}" . sprintf($linkBegin, $lastUrl) . $this->_totalPage . "</a>{$itemEnd}";
        }

        // Next page link
        if ($this->_currentPage < $this->_totalPage) {
            $nextUrl = str_replace('{' . $this->_pageHolder . '}', $this->_currentPage + 1, $this->_pageTemplate) . $this->_anchor;
            echo "{$itemBegin}" . sprintf($linkBegin, $nextUrl, $nextClass) . '<i class="fa fa-angle-right"></i>' . "</a>{$itemEnd}";
        }
    }
}

/**
 * 添加文章自定义字段
 */
function themeFields(Typecho_Widget_Helper_Layout $layout) {
    $pic = new Typecho_Widget_Helper_Form_Element_Text('pic', NULL, NULL, _t('文章头图'), _t('填入图片 URL 地址'));
    $layout->addItem($pic);
}

/**
 * 清理 URL 中的查询参数
 */
function clear_urlcan($url) {
    if (empty($url)) {
        return '';
    }
    $parsed = parse_url($url);
    if (!$parsed) {
        return '';
    }
    $scheme = isset($parsed['scheme']) ? $parsed['scheme'] : 'http';
    $host = isset($parsed['host']) ? $parsed['host'] : '';
    $path = isset($parsed['path']) ? $parsed['path'] : '';
    
    if (empty($host)) {
        return '';
    }
    
    return $scheme . '://' . $host . $path;
}

/**
 * 文章标题显示插件（内置于主题）
 */
class Titleshow_Plugin implements Typecho_Plugin_Interface {
    public static function activate() {}
    public static function deactivate() {}
    public static function config(Typecho_Widget_Helper_Form $form) {}
    public static function personalConfig(Typecho_Widget_Helper_Form $form) {}

    public static function tshow($v, $obj)
    {
        if (array_key_exists('hidden', $v) && $v['hidden'] === true) {
            $v['text'] = "输入密码才能看哦";
            $v['hidden'] = false;
            $v['titleshow'] = true;
        }
        return $v;
    }
}
Typecho_Plugin::factory('Widget_Abstract_Contents')->filter = ['Titleshow_Plugin', 'tshow'];
