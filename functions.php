<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * 主题配置函数
 * @param Typecho_Widget_Helper_Form $form 配置表单对象
 */
function themeConfig($form) {
    // 站点 LOGO
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('站点 LOGO 地址'), _t('填入图片 URL 地址，用于网站标题前的 LOGO'));
    $form->addInput($logoUrl);

    // 用户头像
    $AvatarUrl = new Typecho_Widget_Helper_Form_Element_Text('AvatarUrl', NULL, NULL, _t('用户头像'), _t('填入图片 URL 地址，用于站点头像'));
    $form->addInput($AvatarUrl);

    // 背景图片
    $pcbackgroundUrl = new Typecho_Widget_Helper_Form_Element_Text('pcbackgroundUrl', NULL, NULL, _t('电脑主页背景'), _t('填入电脑背景图片 URL'));
    $mobilebackgroundUrl = new Typecho_Widget_Helper_Form_Element_Text('mobilebackgroundUrl', NULL, NULL, _t('手机主页背景'), _t('填入手机背景图片 URL'));
    $form->addInput($pcbackgroundUrl);
    $form->addInput($mobilebackgroundUrl);

    // 随机图片
    $randompicUrl = new Typecho_Widget_Helper_Form_Element_Text('randompicUrl', NULL, NULL, _t('随机图片'), _t('填入图片 URL，用于文章默认头图'));
    $form->addInput($randompicUrl);

    // PowerMode 打字特效
    $powermode = new Typecho_Widget_Helper_Form_Element_Radio('powermode', ['able' => _t('启用'), 'disable' => _t('禁止')], 'disable', _t('PowerMode 打字特效'), _t('默认禁用，可启用'));
    $form->addInput($powermode);

    // 鼠标点击特效
    $clickanime = new Typecho_Widget_Helper_Form_Element_Radio('clickanime', ['able' => _t('启用'), 'disable' => _t('禁止')], 'disable', _t('鼠标点击特效'), _t('默认禁用，可启用'));
    $form->addInput($clickanime);

    // 网站统计代码
    $Analytic = new Typecho_Widget_Helper_Form_Element_Textarea('Analytic', NULL, NULL, _t('网站统计代码'), _t('填入类似 Google Analytics 的代码，添加到 Header'));
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
    return preg_replace_callback('/<h([1-6])(.*?)>(.*?)<\/h\1>/i', function($match) use (&$catalog, &$catalog_count) {
        $catalog_count++;
        $catalog[] = ['text' => trim(strip_tags($match[3])), 'depth' => $match[1], 'count' => $catalog_count];
        return "<h{$match[1]}{$match[2]}><a name=\"cl-{$catalog_count}\"></a>{$match[3]}</h{$match[1]}>";
    }, $obj);
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
        $html .= "<li><a href=\"javascript:jumpto({$item['count']})\">{$item['text']}</a>";
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
    $cid = $archive->cid;
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();

    // 检查 views 字段是否存在，不存在则添加
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query("ALTER TABLE `{$prefix}contents` ADD `views` INT(10) DEFAULT 0;");
        return 0;
    }

    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if ($archive->is('single')) {
        $views = Typecho_Cookie::get('extend_contents_views');
        $viewed = $views ? explode(',', $views) : [];
        if (!in_array($cid, $viewed)) {
            $db->query($db->update('table.contents')->rows(['views' => (int)$row['views'] + 1])->where('cid = ?', $cid));
            $viewed[] = $cid;
            Typecho_Cookie::set('extend_contents_views', implode(',', $viewed));
        }
    }
    echo $row['views'];
}

/**
 * 计算文章字数（仅中文）
 * @param int $cid 文章 ID
 */
function art_count($cid) {
    $db = Typecho_Db::get();
    $row = $db->fetchRow($db->select('text')->from('table.contents')->where('cid = ?', $cid));
    $text = preg_replace("/[^\x{4e00}-\x{9fa5}]/u", "", $row['text']);
    echo mb_strlen($text, 'UTF-8');
}

/**
 * 主题初始化
 * @param Widget_Archive $archive 当前页面对象
 */
function themeInit($archive) {
    Helper::options()->commentsMaxNestingLevels = 999; // 设置最大评论嵌套层级
    if ($archive->is('single')) {
        $archive->content = createCatalog($archive->content); // 为单篇文章添加目录锚点
    }
}

/**
 * 获取评论的永久链接（用于 @ 回复）
 * @param int $coid 评论 ID
 * @return array|string 评论信息或错误提示
 */
function getPermalinkFromCoid($coid) {
    $db = Typecho_Db::get();
    $options = Typecho_Widget::widget('Widget_Options');
    $row = $db->fetchRow($db->select('cid', 'type', 'author', 'text')->from('table.comments')->where('coid = ? AND status = ?', $coid, 'approved'));

    if (empty($row)) return 'Comment not found!';

    $cid = $row['cid'];
    $comments = $db->fetchAll($db->select('coid', 'parent')->from('table.comments')->where('cid = ? AND status = ?', $cid, 'approved')->order('coid'));
    if ($options->commentsShowCommentOnly) {
        $comments = array_filter($comments, fn($c) => $c['type'] === 'comment');
    }
    if ($options->commentsOrder === 'DESC') {
        $comments = array_reverse($comments);
    }

    $parents = array_column($comments, 'parent', 'coid');
    $count = 0;
    $i = $coid;
    while ($i != 0 && isset($parents[$i])) {
        $break = $i;
        $i = $parents[$i];
        if ($i == 0) $count++;
    }

    $content = Typecho_Widget::widget('Widget_Abstract_Contents')->push($db->fetchRow($db->select()->from('table.contents')->where('cid = ?', $cid)));
    $permalink = rtrim($content['permalink'], '/');
    $page = $options->commentsPageBreak ? '/comment-page-' . ceil($count / $options->commentsPageSize) : (substr($permalink, -5) === '.html' ? '' : '/');

    return [
        'author' => $row['author'],
        'text' => $row['text'],
        'href' => "{$permalink}{$page}#{$row['type']}-{$coid}"
    ];
}

/**
 * 输出上一篇链接
 * @param Widget_Archive $widget 当前文章对象
 * @param string $randompicUrl 默认图片 URL
 */
function thePrev($widget, $randompicUrl) {
    $db = Typecho_Db::get();
    $content = $db->fetchRow($db->select()->from('table.contents')
        ->where('created < ?', $widget->created)
        ->where('status = ?', 'publish')
        ->where('type = ?', $widget->type)
        ->where('password IS NULL')
        ->order('created', Typecho_Db::SORT_DESC)
        ->limit(1));

    echo generatePostLink($content, $widget, $randompicUrl, 'prev');
}

/**
 * 输出下一篇链接
 * @param Widget_Archive $widget 当前文章对象
 * @param string $randompicUrl 默认图片 URL
 */
function theNext($widget, $randompicUrl) {
    $db = Typecho_Db::get();
    $content = $db->fetchRow($db->select()->from('table.contents')
        ->where('created > ?', $widget->created)
        ->where('status = ?', 'publish')
        ->where('type = ?', $widget->type)
        ->where('password IS NULL')
        ->order('created', Typecho_Db::SORT_ASC)
        ->limit(1));

    echo generatePostLink($content, $widget, $randompicUrl, 'next');
}

/**
 * 生成上一篇/下一篇链接 HTML
 * @param array $content 文章数据
 * @param Widget_Archive $widget 当前文章对象
 * @param string $randompicUrl 默认图片 URL
 * @param string $direction 方向（prev 或 next）
 * @return string HTML 链接
 */
function generatePostLink($content, $widget, $randompicUrl, $direction) {
    if ($content) {
        $widget->widget("Widget_Archive@cid{$content['cid']}", 'pageSize=1&type=post', "cid={$content['cid']}")->to($post);
        $pic = $post->fields->pic ?: $randompicUrl . "?_=" . mt_rand();
        $icon = $direction === 'prev' ? '<i class="ni ni-bold-left"></i>' : '<i class="ni ni-bold-right"></i>';
        $layout = $direction === 'prev' ? "$icon<h2 class=\"heading-title text-info blackback\" style=\"text-transform:none;\">{$post->title}</h2>" : "<h2 class=\"heading-title text-info blackback\" style=\"text-transform:none;\">{$post->title}</h2>$icon";
        return "<a class=\"carousel\" href=\"{$post->permalink}\" title=\"{$post->title}\"><div style=\"background-image:url($pic);\" class=\"card-img tu\"></div><div class=\"carousel-indicators\">$layout</div></a>";
    }
    return "<a class=\"carousel\" title=\"没啦\"><div style=\"background-image:url($randompicUrl);\" class=\"card-img tu\"></div><div class=\"carousel-indicators\"><h3 class=\"heading-title text-info blackback\" style=\"text-transform:none;\">没啦</h3></div></a>";
}

/**
 * 自定义评论组件
 */
class Widget_Comments_Archive extends Widget_Abstract_Comments {
    private $_currentPage, $_total, $_threadedComments = [], $_singleCommentOptions;

    public function __construct($request, $response, $params = NULL) {
        parent::__construct($request, $response, $params);
        $this->parameter->setDefault('parentId=0&commentPage=0&commentsNum=0&allowComment=1');
    }

    private function threadedCommentsCallback() {
        $options = $this->_singleCommentOptions;
        if (function_exists('threadedComments')) {
            threadedComments($this, $options);
            return;
        }
        // 默认评论 HTML（保持原逻辑）
        $commentClass = $this->authorId ? ($this->authorId == $this->ownerId ? ' comment-by-author' : ' comment-by-user') : '';
        ?>
        <li id="<?php $this->theId(); ?>" class="comment-body<?php
        echo $this->levels > 0 ? ' comment-child' . $this->levelsAlt(' comment-level-odd', ' comment-level-even') : ' comment-parent';
        $this->alt(' comment-odd', ' comment-even');
        echo $commentClass;
        ?>">
            <div class="comment-author">
                <?php $this->gravatar($options->avatarSize); ?>
                <cite><?php $this->author(); ?></cite>
            </div>
            <div class="comment-meta">
                <a href="<?php $this->permalink(); ?>"><time><?php $this->date($options->dateFormat); ?></time></a>
                <?php if ($this->status === 'waiting') echo '<em>' . $options->commentStatus . '</em>'; ?>
            </div>
            <div class="comment-content"><?php $this->content(); ?></div>
            <div class="comment-reply"><?php $this->reply($options->replyWord); ?></div>
            <?php if ($this->children) echo '<div class="comment-children">' . $this->threadedComments() . '</div>'; ?>
        </li>
        <?php
    }

    protected function ___permalink() {
        if ($this->options->commentsPageBreak) {
            $pageRow = ['permalink' => $this->parentContent['pathinfo'], 'commentPage' => $this->_currentPage];
            return Typecho_Router::url('comment_page', $pageRow, $this->options->index) . '#' . $this->theId;
        }
        return $this->parentContent['permalink'] . '#' . $this->theId;
    }

    protected function ___children() {
        return $this->options->commentsThreaded && !$this->isTopLevel && isset($this->_threadedComments[$this->coid]) ? $this->_threadedComments[$this->coid] : [];
    }

    protected function ___isTopLevel() {
        return $this->levels > $this->options->commentsMaxNestingLevels - 2;
    }

    protected function ___parentContent() {
        return $this->parameter->parentContent;
    }

    public function num() {
        $args = func_get_args() ?: ['%d'];
        echo sprintf($args[min(count($args) - 1, (int)$this->_total)], $this->_total);
    }

    public function execute() {
        if (!$this->parameter->parentId) return;

        $commentsAuthor = Typecho_Cookie::get('__typecho_remember_author');
        $commentsMail = Typecho_Cookie::get('__typecho_remember_mail');
        $select = $this->select()->where('cid = ?', $this->parameter->parentId)
            ->where('status = ? OR (author = ? AND mail = ? AND status = ?)', 'approved', $commentsAuthor, $commentsMail, 'waiting')
            ->order('coid', 'ASC');
        if ($this->options->commentsShowCommentOnly) $select->where('type = ?', 'comment');

        $this->db->fetchAll($select, [$this, 'push']);
        $outputComments = [];

        if ($this->options->commentsThreaded) {
            foreach ($this->stack as $coid => &$comment) {
                $parent = $comment['parent'];
                if ($parent && isset($this->stack[$parent])) {
                    if ($comment['levels'] >= $this->options->commentsMaxNestingLevels) {
                        $comment['levels'] = $this->stack[$parent]['levels'];
                        $comment['parent'] = $this->stack[$parent]['parent'];
                    }
                    $comment['order'] = isset($this->_threadedComments[$parent]) ? count($this->_threadedComments[$parent]) + 1 : 1;
                    $this->_threadedComments[$parent][$coid] = $comment;
                } else {
                    $outputComments[$coid] = $comment;
                }
            }
            $this->stack = $outputComments;
        }

        if ($this->options->commentsOrder === 'DESC') {
            $this->stack = array_reverse($this->stack, true);
            $this->_threadedComments = array_map('array_reverse', $this->_threadedComments);
        }

        $this->_total = count($this->stack);
        if ($this->options->commentsPageBreak) {
            $this->_currentPage = $this->parameter->commentPage ?: ('last' === $this->options->commentsPageDisplay ? ceil($this->_total / $this->options->commentsPageSize) : 1);
            $this->stack = array_slice($this->stack, ($this->_currentPage - 1) * $this->options->commentsPageSize, $this->options->commentsPageSize);
            $this->row = current($this->stack);
            $this->length = count($this->stack);
        }
        reset($this->stack);
    }

    public function push(array $value) {
        $value = $this->filter($value);
        $value['levels'] = ($value['parent'] && isset($this->stack[$value['parent']])) ? $this->stack[$value['parent']]['levels'] + 1 : 0;
        $this->stack[$value['coid']] = $value;
        $this->length++;
        return $value;
    }

    public function pageNav($prev = '&laquo;', $next = '&raquo;', $splitPage = 3, $splitWord = '...', $template = '') {
        if (!$this->options->commentsPageBreak || $this->_total <= $this->options->commentsPageSize) return;

        $template = array_merge(['wrapTag' => 'ol', 'wrapClass' => 'page-navigator'], is_string($template) ? [] : $template);
        $pageRow = $this->parameter->parentContent;
        $pageRow['permalink'] = $pageRow['pathinfo'];
        $query = Typecho_Router::url('comment_page', $pageRow, $this->options->index);

        $nav = new Typecho_Widget_Helper_PageNavigator_Box($this->_total, $this->_currentPage, $this->options->commentsPageSize, $query);
        $nav->setPageHolder('commentPage');
        $nav->setAnchor('comments');

        echo "<{$template['wrapTag']} class=\"{$template['wrapClass']}\">";
        $nav->render($prev, $next, $splitPage, $splitWord, $template);
        echo "</{$template['wrapTag']}>";
    }

    public function threadedComments() {
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

    public function listComments($options = NULL) {
        $this->_singleCommentOptions = Typecho_Config::factory($options);
        $this->_singleCommentOptions->setDefault([
            'before' => '', 'after' => '', 'beforeAuthor' => '', 'afterAuthor' => '',
            'beforeDate' => '', 'afterDate' => '', 'dateFormat' => $this->options->commentDateFormat,
            'replyWord' => _t('回复'), 'commentStatus' => _t('审核中...'), 'avatarSize' => 32, 'defaultAvatar' => NULL
        ]);

        if ($this->have()) {
            echo $this->_singleCommentOptions->before;
            while ($this->next()) $this->threadedCommentsCallback();
            echo $this->_singleCommentOptions->after;
        }
    }

    public function alt(...$args) {
        $num = count($args);
        $sequence = $this->levels <= 0 ? $this->sequence : $this->order;
        echo $args[($sequence % $num + $num - 1) % $num];
    }

    public function levelsAlt(...$args) {
        $num = count($args);
        echo $args[($this->levels % $num + $num - 1) % $num];
    }

    public function reply($word = '') {
        if ($this->options->commentsThreaded && !$this->isTopLevel && $this->parameter->allowComment) {
            $word = $word ?: _t('回复');
            echo "<a href=\"javascript:;\" rel=\"nofollow\" onclick=\"return TypechoComment.reply('{$this->theId}', {$this->coid});\">$word</a>";
        }
    }

    public function cancelReply($word = '', $class = "") {
        if ($this->options->commentsThreaded) {
            $word = $word ?: _t('取消回复');
            $replyId = $this->request->filter('int')->replyTo;
            echo "<a class=\"$class\" id=\"cancel-comment-reply-link\" href=\"{$this->parameter->parentContent['permalink']}#{$this->parameter->respondId}\" rel=\"nofollow\"" . ($replyId ? '' : ' style="display:none"') . " onclick=\"return TypechoComment.cancelReply();\">$word</a>";
        }
    }
}

/**
 * 自定义分页导航组件
 */
class Typecho_Widget_Helper_PageNavigator_Box extends Typecho_Widget_Helper_PageNavigator {
    public function render($prev = 'PREV', $next = 'NEXT', $splitPage = 3, $splitWord = '...', array $template = []) {
        if ($this->_total < 1) return;

        $template = array_merge([
            'itemTag' => 'li', 'textTag' => 'span', 'currentClass' => 'current',
            'prevClass' => 'prev', 'nextClass' => 'next'
        ], $template);

        extract($template);
        $itemBegin = $itemTag ? "<$itemTag" . ($itemClass ? " class=\"$itemClass\"" : '') . ">" : '';
        $itemEnd = $itemTag ? "</$itemTag>" : '';
        $linkBegin = "<a href=\"%s\"" . ($linkClass ? " class=\"$linkClass\"" : '') . ">";

        // 计算分页范围
        $from = max(1, $this->_currentPage - $splitPage);
        $to = min($this->_totalPage, $this->_currentPage + $splitPage);

        // 显示上一页链接
        if ($this->_currentPage > 1) {
            echo "$itemBegin" . sprintf($linkBegin, str_replace($this->_pageHolder, $this->_currentPage - 1, $this->_pageTemplate) . $this->_anchor) . $prev . "</a>$itemEnd";
        }

        // 显示首页链接和跳转符号
        if ($from > 1) {
            echo "$itemBegin" . sprintf($linkBegin, str_replace($this->_pageHolder, 1, $this->_pageTemplate) . $this->_anchor) . '1</a>' . "$itemEnd";
        }

        // 显示中间页码
        for ($i = $from; $i <= $to; $i++) {
            $isCurrent = $i == $this->_currentPage;
            $class = $isCurrent ? $currentClass : $itemClass;
            echo "<$itemTag" . ($class ? " class=\"$class\"" : '') . ">" . sprintf($linkBegin, str_replace($this->_pageHolder, $i, $this->_pageTemplate) . $this->_anchor) . $i . "</a>$itemEnd";
        }

        // 显示尾页链接和跳转符号
        if ($to < $this->_totalPage) {
            echo "$itemBegin" . sprintf($linkBegin, str_replace($this->_pageHolder, $this->_totalPage, $this->_pageTemplate) . $this->_anchor) . $this->_totalPage . "</a>$itemEnd";
        }

        // 显示下一页链接
        if ($this->_currentPage < $this->_totalPage) {
            echo "$itemBegin" . sprintf($linkBegin, str_replace($this->_pageHolder, $this->_currentPage + 1, $this->_pageTemplate) . $this->_anchor) . $next . "</a>$itemEnd";
        }
    }
}

/**
 * 添加文章自定义字段
 * @param Typecho_Widget_Helper_Layout $layout 布局对象
 */
function themeFields($layout) {
    $pic = new Typecho_Widget_Helper_Form_Element_Text('pic', NULL, NULL, _t('文章头图'), _t('填入图片 URL 地址'));
    $layout->addItem($pic);
}

/**
 * 清理 URL 中的查询参数
 * @param string $url 输入 URL
 * @return string 清理后的 URL
 */
function clear_urlcan($url) {
    $parsed = parse_url($url);
    return ($parsed['scheme'] ?? 'http') . '://' . $parsed['host'] . $parsed['path'];
}

/**
 * 文章标题显示插件
 */
class Titleshow_Plugin implements Typecho_Plugin_Interface {
    public static function activate() {}
    public static function deactivate() {}
    public static function config(Typecho_Widget_Helper_Form $form) {}
    public static function personalConfig(Typecho_Widget_Helper_Form $form) {}

    public static function tshow($v, $obj) {
        if ($v['hidden']) {
            $v['text'] = "输入密码才能看哦";
            $v['hidden'] = false;
            $v['titleshow'] = true;
        }
        return $v;
    }
}
Typecho_Plugin::factory('Widget_Abstract_Contents')->filter = ['Titleshow_Plugin', 'tshow'];