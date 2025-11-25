# 🌸 Rorical Theme for Typecho

> 简洁 · 可爱 · 功能强大
>
> 一款为 Typecho 打造的现代化卡片式主题.

[![项目版本](https://img.shields.io/badge/版本-1.2.3-007EC6?style=flat-square)](https://github.com/little-gt/THEME-RoricalTheme/)
[![许可证: GPL v3](https://img.shields.io/badge/许可证-GPLv3-blue?style=flat-square)](https://www.gnu.org/licenses/gpl-3.0.html)
[![Argon 版本](https://img.shields.io/badge/设计支持-Argon-orange?style=flat-square&logo=Argon)](https://demos.creative-tim.com/argon-design-system/)
[![Typecho 版本](https://img.shields.io/badge/Typecho-1.2%2B-orange?style=flat-square&logo=typecho)](https://typecho.org/)
[![作者信息](https://img.shields.io/badge/作者-GARFIELDTOM-6f42c1?style=flat-square&logo=github)](https://garfieldtom.cool/)

主题预览：

![预览1](MARKDOWN_2025-11-26_002123_964.png)

![预览2](MARKDOWN_2025-11-26_002203_506.png)

![预览3](MARKDOWN_2025-11-26_002210_813.png)

* [Typecho 官方论坛主题帖](https://forum.typecho.org/viewtopic.php?t=25532)
* [Typecho.work 主题收录页](https://typecho.work/archives/Rorical.html)

---

## ✨ 特点概览

| 功能模块 | 说明 |
| :-- | :-- |
| 💎 **现代化设计** | 基于 Argon Design System 与 Bootstrap 4，响应式支持多端展示 |
| ⚡ **轻快交互** | PowerMode 打字特效、鼠标点击涟漪、AJAX 评论与搜索 |
| 📝 **文章增强** | 自动 TOC 目录、阅读统计、字数统计、评论计数 |
| 🎨 **高度自定义** | 独立页面图标与配色、自定义导航栏样式、双端背景、LOGO 设置 |
| 🧩 **插件支持** | 评论区 IP 归属展示（依赖 [XQLocation](https://www.toubiec.cn/1194.html)） |
| 🧠 **兼容优化** | 完全支持 Typecho 1.2.1 / PHP 8.X / MySQL 8.X |
| 🍪**Cookie合规** | 支持 GDPR/最新2026年执行的中国网络安全规范的 Cookie 同意模式 |

---

## 🚀 近期更新

### 🛠️ 功能与性能优化
- 更新了 Cookie 管理器

### 🔮 未来规划
- 私密评论支持  
- 管理员标识显示  
- 灯箱组件重构  
- 更强的移动端适配与动画控制  

---

## ⚙️ 安装指南

1. **下载主题**
   ```bash
   git clone https://github.com/little-gt/THEME-RoricalTheme.git
   ```
   或直接下载 ZIP 压缩包上传至：
   ```
   /usr/themes/RoricalTheme/
   ```

2. **启用主题**

   * 登录 Typecho 后台 → 外观 → 启用 “Rorical Theme”

3. **依赖插件**

   * 安装 [XQLocation](https://www.toubiec.cn/1194.html) 插件以启用 IP 归属显示功能

---

## 🎨 独立页面图标与颜色配置

> 为导航栏下拉菜单中的独立页面设置专属图标与背景色。

在 Typecho 后台编辑页面时添加自定义字段：

| 字段名     | 示例值                   | 说明                  |
| :------ | :-------------------- | :------------------ |
| `color` | `bg-gradient-success` | 设置图标圆形背景色           |
| `icon`  | `ni-spaceship`        | 设置图标样式（Nucleo Icon） |

**可用颜色值表**

| 字段值                   | 颜色效果 |
| :-------------------- | :--- |
| `bg-gradient-success` | 绿色   |
| `bg-gradient-danger`  | 红色   |
| `bg-gradient-info`    | 蓝色   |
| `bg-gradient-primary` | 紫色   |
| `bg-gradient-warning` | 橙色   |
| `bg-gradient-default` | 灰紫色  |

> 图标来源：[Argon Icons Reference](https://demos.creative-tim.com/argon-design-system/docs/foundation/icons.html)

---

## 🍪 Cookie 合规功能配置

本次更新新增了新的 Cookie 管理器功能，并且需要你配置一个名为“隐私政策”的独立页面，其 URL 应该形为 example.com/privacy.html，或者你可以替换`footer.php`下面的代码：

```php
<a href="/privacy.html">隐私政策</a>
```

如果需要添加非必要的功能性或者是分析性的 Cookie 代码，请你参考下面的形式进行添加，以便于其受到 Cookie 管理器的控制：

```html
<!-- Google Analytics (Part 1 - External Script) -->
<script type="text/plain" data-consent-category="analytics" async src="https://www.googletagmanager.com/gtag/js?id=YOUR_GA_ID"></script>

<!-- Google Analytics (Part 2 - Inline Script) -->
<script type="text/plain" data-consent-category="analytics">
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'YOUR_GA_ID');
</script>

<!-- 一个功能性脚本，例如评论系统 -->
<script type="text/plain" data-consent-category="functional" src="/path/to/comments.js"></script>
```

---

## 💬 特效与交互控制

* ✅ PowerMode 打字特效（评论区）
* ✅ 鼠标点击涟漪动画
* ✅ Lazyload 图片懒加载
* ✅ AJAX 评论与搜索（PJAX 技术）

---

## 🧱 技术栈

| 组件       | 描述                             |
| :------- | :----------------------------- |
| **框架**   | Bootstrap 4, jQuery 3.3.1      |
| **设计系统** | Argon Design System            |
| **图标库**  | Nucleo Icons, Font Awesome 4.7 |
| **异步交互** | PJAX                           |
| **渲染优化** | Lazyload.js                    |

---

## ❤️ 开源与支持

> 如果你喜欢这个项目，请点个 ⭐ Star 支持！

* **原作者**：[@Rorical](https://github.com/Rorical/RoricalTheme)
* **二次开发维护**：[@little-gt](https://github.com/little-gt/THEME-RoricalTheme)

---

🪄 **Rorical Theme** — 让博客更优雅、更有趣。
