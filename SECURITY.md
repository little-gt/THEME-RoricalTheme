# 🔐 Security Policy

感谢您关注 **Rorical Theme** 的安全性！为了保护用户与开发环境，我们制定了以下安全策略。我们非常欢迎来自安全研究人员与开发者的负责任披露。

---

## 📌 Supported Versions

目前我们仅为以下版本提供安全更新，建议尽快升级至最新版本以确保安全性与稳定性。目前该主题已经彻底完成了对于 Typecho 1.2.1、 PHP 7.4-8.3 和 MySQL 9 的支持。并且完成了 Cookie 管理器的支持更新。自 1.2.4 版本之后的更新速率将会放缓。

| Version | Status |
| :------ | :----- |
| **1.2.7**   | ✅ Latest        |
| **＜ 1.2.7** | ❌ Out of Scope     |

---

## 📮 Reporting a Vulnerability

我们欢迎社区对本项目进行安全审计。如果您发现了任何安全漏洞，请遵循负责任的披露原则，**不要在公开场合（如 GitHub Issues）发布**。

### 📧 Security Contact

[coolerxde@gt.ac.cn](mailto:coolerxde@gt.ac.cn)

请在邮件标题中注明：
`[Security] RoricalTheme - <brief summary>`

### 🔐 Need encryption?

如果您倾向于加密沟通，请在邮件中说明，维护者将提供 **PGP 公钥** 以便您安全发送详细内容。

---

## 🧾 Information to Include

为加快问题定位、复现与修复，建议在您的报告中尽可能包含以下信息：

* 影响版本（如：`v1.2.5` 或 commit hash）
* 环境信息：Typecho / PHP / MySQL / 浏览器 / OS 等
* 漏洞类型（XSS / SQL Injection / Privilege Escalation / CSRF / Info Leak 等）
* 清晰的复现步骤（step-by-step）
* PoC 或 Minimal Repro（可选但强烈推荐）
* HTTP 请求/响应（如适用，可脱敏处理）
* 影响级别评估（高 / 中 / 低）
* 修复建议或 patch（如果已有）

我们非常感谢任何形式的协助，但请勿提供超出您愿意分享的敏感内容。

---

## 📢 Disclosure Policy

我们遵循 **Responsible Disclosure**：

* 请勿在未修复前公开漏洞细节或 PoC
* 维护者将尽快确认收到您的报告
* 修复后将发布安全公告或补丁版本
* 如您希望在公告中署名致谢，请在邮件中告知

---

## 📦 Scope

本安全策略适用于：

* Rorical Theme 原始代码（PHP 模板 / JS / CSS / 前端资源）

不适用以下情况：

* 第三方 Typecho 插件
* 非主题相关的服务端环境问题
* 外部 CDN 资源

如第三方插件漏洞影响主题，我们将酌情协助联系插件维护者。

---

## 🛠 Temporary Mitigation

如漏洞无法立即修复，管理员可采用以下短期缓解措施：

* 临时关闭受影响功能（如评论、涉及用户输入的接口等）
* 对输出内容进行严格转义 / whitelist filtering
* 禁用高风险第三方插件
* 暂停加载不信任的外部资源

---

## 💬 Maintainer Commitment

我们承诺：

* 及时、友善地回应安全报告
* 优先处理高风险漏洞
* 保护研究人员的隐私与合法权益
* 在修复后公开透明地发布安全说明

需要更安全的沟通方式（如 PGP 全链路加密或其他渠道）？请在邮件中说明您的偏好，我们将尽可能配合。

---

## ⚖️ Legal & Ethics

我们鼓励善意的安全研究，但请遵从：

* 不进行未授权访问
* 不滥用漏洞
* 不破坏数据或侵犯隐私
* 遵守相关法律法规

我们欢迎所有善意的安全贡献者，共同让 Rorical Theme 更加安全。

---

感谢你可以看到这里，因为有你，Rorical Theme 才能有今天的成就。