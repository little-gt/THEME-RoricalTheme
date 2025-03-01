# Rorical Theme - 一个炒鸡可爱的 Typecho 主题

![封面](/screenshot.png)

*“简洁、可爱、功能强大，适合个人博客的理想选择”*

## 简介

Rorical Theme 是一款专为 Typecho 博客系统设计的主题，由 Rorical 开发，版本号为 1.0。它以现代化的卡片式设计和丰富的交互功能为特色，旨在为用户提供美观且实用的博客体验。无论是个人记录、生活分享还是技术笔记，这个主题都能满足你的需求。

## 主要特点

- **可爱与现代并存**：采用 Argon Design 系统和 Bootstrap 框架，结合动态背景和圆点动画，打造独特的视觉风格。
- **响应式设计**：支持电脑和手机端，自动适配不同设备，提供一致的用户体验。
- **丰富交互**：
  - 支持 PowerMode 打字特效和鼠标点击动画。
  - 内置文章目录（TOC），便于长文导航。
  - AJAX 评论提交，提升交互流畅性。
- **自定义选项**：
  - 可配置站点 LOGO、头像、背景图片（电脑/手机独立设置）。
  - 支持自定义导航栏图标和样式（下拉式/平铺式可选）。
- **文章管理**：
  - 显示阅读次数、字数统计和评论数。
  - 支持自定义文章头图，优先于随机图片显示。
- **评论系统**：支持深层嵌套评论（最大999级），并提供密码保护文章功能。

## 安装与配置

1. **下载主题**：
   - 从 GitHub 或其他来源获取主题文件，解压至 Typecho 的 `usr/themes/` 目录。
   - 从 GitHub 或其他来源获取依赖插件，请访问[https://github.com/SocialSisterYi/Typecho-Plugin-CommentShowIp](https://github.com/SocialSisterYi/Typecho-Plugin-CommentShowIp)进行下载并且启用
2. **启用主题**：
   - 登录 Typecho 后台，在“外观”中启用“Rorical Theme”。
3. **配置选项**：
   - 在“外观设置”中填写 LOGO、头像、背景图片等 URL。
   - 根据需要启用特效（如 PowerMode、点击动画）和导航样式。
4. **添加自定义字段**：
   - 在文章编辑页面，添加 `pic` 字段，填入头图 URL。

## 使用说明

- **首页**：展示最新文章列表，支持分页和懒加载图片。
- **文章页面**：显示文章详情、目录、统计信息及上下篇导航。
- **评论区**：支持嵌套回复，实时更新评论内容。
- **侧边栏**：提供归档、最新文章、最近回复和搜索功能。

## 技术细节

- **依赖**：Typecho 1.x，jQuery，Bootstrap，Lazyload.js 等。
- **文件结构**：
  - `index.php`：首页模板
  - `post.php`：文章页面模板
  - `comments.php`：评论区模板
  - `sidebar.php`：侧边栏模板
  - `header.php` / `footer.php`：头部和底部模板

## 贡献与支持

- **作者**：Rorical
- **版本**：1.0
- **问题反馈**：欢迎通过 GitHub 或评论区提交建议和 Bug 报告。

---

*感谢使用 Rorical Theme，让你的博客更可爱、更独特！*

原作者：[https://github.com/Rorical/RoricalTheme](https://github.com/Rorical/RoricalTheme)（停止维护）
二次开发：[https://github.com/little-gt/THEME-RoricalTheme/](https://github.com/little-gt/THEME-RoricalTheme/)（不定期维护）