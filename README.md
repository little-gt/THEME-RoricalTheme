# 🌸 Rorical Theme for Typecho

> **简洁 · 可爱 · 功能强大**  
> 一款为 Typecho 打造的现代化卡片式主题，专注于优雅与实用的平衡。  
> “Rorical Theme 是你理想的个人博客选择。”

[![License](https://img.shields.io/badge/license-GPL-green.svg)](LICENSE)
[![Typecho](https://img.shields.io/badge/Typecho-1.2.1+-blue.svg)](https://typecho.org)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-4.6-purple.svg)](https://getbootstrap.com)
[![Argon Design System](https://img.shields.io/badge/Design-Argon-orange.svg)](https://demos.creative-tim.com/argon-design-system/)
[![GitHub Stars](https://img.shields.io/github/stars/little-gt/THEME-RoricalTheme.svg?style=social&label=Star)](https://github.com/little-gt/THEME-RoricalTheme/stargazers)

主题预览：

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
| 🧩 **插件支持** | 评论区 IP 归属展示（依赖 [CommentShowIp](https://github.com/SocialSisterYi/Typecho-Plugin-CommentShowIp)） |
| 🧠 **兼容优化** | 完全支持 Typecho 1.2.1 / PHP 8.X / MySQL 8.X |

---

## 🚀 近期更新 (二次开发增强版)

> 当前维护者：[**little-gt**](https://github.com/little-gt/THEME-RoricalTheme)  
> 原作者：[**Rorical**](https://github.com/Rorical/RoricalTheme)

### 🛠️ 功能与性能优化
- 全面重写 `functions.php`，升级 SQL 路由兼容 Typecho 1.2.1  
- 优化头像逻辑，支持自定义 Gravatar CDN（默认 `cdn.sep.cc`）  
- 评论区 UI 改进，新增 IP 归属地显示功能  
- 修复 **MathJax** 加载问题并更新至 v3.2.2  
- 优化 TOC 快捷跳转逻辑与显示样式  
- 重构部分前端 JS 与 CSS，提升整体性能  

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

   * 安装 [CommentShowIp](https://github.com/SocialSisterYi/Typecho-Plugin-CommentShowIp) 插件以启用 IP 归属显示功能

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
