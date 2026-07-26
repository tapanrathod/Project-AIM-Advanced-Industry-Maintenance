# Project AIM — Advanced Industry Maintenance

**AIM (Advanced Industry Maintenance)** is a secure, web-based digital document and data management solution engineered to streamline information flow across organizational tiers while maintaining strict, hierarchical data privacy.

---

## 🌟 Key Features

* **🗂️ Unified Document Management:** Store, manage, and track all formats of digital files and records seamlessly.
* **🔐 Hierarchical Privacy & Role-Based Access:** 
  * **Top-Down Visibility:** Higher-tier authorities can access lower-tier logs, data, and documentation.
  * **Strict Data Isolation:** Lower-tier users are restricted from viewing high-level administrative or executive assets.
* **⚡ Interactive User Interface:** Responsive, dynamic UI designed for smooth workflows and easy navigation.
* **🛡️ Secure Backend:** Robust access authentication mechanisms ensuring data integrity across user levels.

---

## 🛠️ Tech Stack & Language Distribution

Built using a classic full-stack web architecture leveraging dynamic client-side scripting and server-side logic:

| Layer / Language | Breakdown | Description |
| :--- | :--- | :--- |
| **HTML5** | **48.4%** | Core structure and semantic markup for web interfaces |
| **JavaScript** | **34.7%** | Dynamic UI interactions, DOM manipulation, and logic |
| **PHP** | **12.6%** | Backend logic, database integration, and authentication |
| **CSS3** | **3.0%** | Custom styling and layout design |
| **SCSS** | **0.8%** | Modular, pre-processed UI component styling |
| **CoffeeScript** | **0.5%** | Concise client-side script utilities |

---

## 🔒 Access Control Model Architecture

```text
[ Executive / Top Tier ]
       │
       ▼ (Full Read/Write Access)
[ Department Managers ]
       │
       ▼ (Restricted Access)
[ General Staff / Low Tier ]
