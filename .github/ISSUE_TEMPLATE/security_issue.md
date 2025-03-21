---
name: 🚨 Security Issue
about: Report a security vulnerability in the Seokar WordPress Theme
title: "[Security] "
labels: security
assignees: ''
---

# 🚨 Security Issue

Thank you for reporting a security vulnerability in the Seokar WordPress Theme! 🔒  
To help us address the issue quickly and effectively, please provide the following information:

---

## 📝 **Description of the Vulnerability**

Provide a clear and concise description of the security issue.  
- What is the vulnerability?  
- How does it affect the theme or its users?  

**Example:**  
There is an XSS vulnerability in the theme's comment section that allows attackers to inject malicious scripts.

---

## 🛠️ **Steps to Reproduce**

List the steps to reproduce the vulnerability:  
1. Go to '...'  
2. Click on '...'  
3. Enter '...'  
4. See the vulnerability  

**Example:**  
1. Navigate to a post with comments enabled.  
2. Submit a comment containing a malicious script (e.g., `<script>alert('XSS')</script>`).  
3. The script executes when the page is reloaded.

---

## ✅ **Expected Behavior**

Describe what you expected to happen.  

**Example:**  
I expected the theme to sanitize user input and prevent the execution of malicious scripts.

---

## ❌ **Actual Behavior**

Describe what actually happened.  

**Example:**  
The theme did not sanitize user input, allowing the malicious script to execute.

---

## 🖼️ **Screenshots or Proof of Concept**

If applicable, add screenshots or a proof of concept (PoC) to demonstrate the vulnerability.  

**Example:**  
![XSS Vulnerability Screenshot](https://example.com/xss-vulnerability.png)

---

## 🌐 **System Information**

Please provide the following details about your system:  
- **WordPress Version:**  
- **Seokar Theme Version:**  
- **PHP Version:**  
- **Browser:**  
- **Operating System:**  

**Example:**  
- WordPress Version: 6.0  
- Seokar Theme Version: 1.2.0  
- PHP Version: 7.4  
- Browser: Chrome 95  
- Operating System: Windows 10  

---

## 📋 **Additional Context**

Add any additional context or information about the vulnerability here.  

---

## 🔒 **Disclosure Policy**

- **Do not disclose this issue publicly until it has been resolved.**  
- The Seokar Theme team will acknowledge your report and work on a fix as soon as possible.  
- Once the issue is resolved, we will credit you (if desired) and publish a security advisory.  

---

Thank you for helping us keep the Seokar Theme secure! 🚀  
The Seokar Theme team will review your report and get back to you as soon as possible.
