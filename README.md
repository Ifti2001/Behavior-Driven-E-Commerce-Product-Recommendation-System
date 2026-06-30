# Behavior-Driven E-Commerce Product Recommendation System

An intelligent, real-time e-commerce recommendation engine that captures user intent through implicit feedback loops. Moving away from traditional explicit rating systems (likes/stars), this system analyzes real-time user behavior to dynamically personalize the shopping experience.

Built using a **hybrid priority scoring model** with a PHP backend and asynchronous JavaScript engagement tracking to efficiently solve the industry-wide "Cold Start" and "Information Overload" dilemmas.

---

## 🚀 Key Features & Architecture

* **Implicit Feedback Loop (Dwell Time Monitoring):** Engineered an asynchronous AJAX-based pipeline to track user engagement and session behavior seamlessly without causing page-level interruptions or UI latency.
* **Silent Interest Mapping:** Formulated a 16-second high-intent dwell time benchmark to filter out passive scrolling noise and capture genuine user intent in real-time.
* **Hybrid Ranking Algorithm:** Designed a custom algorithm that combines active session-based behavioral scoring with global item popularity metrics to dynamically restyle and personalize the user's homepage.
* **Cold Start & Sparsity Mitigation:** Effectively recommends new or unrated products by capitalizing on immediate, real-time session intuition rather than relying on historical user data.

---

## 🛠️ Tech Stack & Tools

* **Backend & Logic:** PHP 8 (Object-Oriented Programming)
* **Frontend Pipeline:** JavaScript (Asynchronous AJAX), Bootstrap, HTML5, CSS3
* **Database & Management:** MySQL, phpMyAdmin
* **Development Environment:** XAMPP, VS Code

---

## 📂 Database Design & Optimization

The database architecture is optimized to handle high-frequency behavioral logs. It tracks:
1. **Product Metrics:** Category, views, and global popularity scores.
2. **User Session Logs:** Real-time dwell time per product page and asynchronous click streams.

![image alt](https://github.com/Ifti2001/Behavior-Driven-E-Commerce-Product-Recommendation-System/blob/5c74f32626d9dd63e89649d766df02f6194439bb/Screenshot%202026-06-30%20211206.png)

![image alt](https://github.com/Ifti2001/Behavior-Driven-E-Commerce-Product-Recommendation-System/blob/452fc256e366aec0a6a2e468111f2d33eff0443c/photo_6318908297544667526_w.jpg)

---


![image alt](https://github.com/Ifti2001/Behavior-Driven-E-Commerce-Product-Recommendation-System/blob/9d0c2b1e82e022e2055ffefafbaad8f27f291f6b/Screenshot%202026-06-27%20215345.png)
![image alt](https://github.com/Ifti2001/Behavior-Driven-E-Commerce-Product-Recommendation-System/blob/882dabd94535be8e32ae9054257bf51d7a3f262a/Screenshot%202026-06-27%20215415.png)
![image alt](https://github.com/Ifti2001/Behavior-Driven-E-Commerce-Product-Recommendation-System/blob/96436fc37ec389741119c36185308c31ef36273a/Screenshot%202026-06-27%20215451.png)
![image alt](https://github.com/Ifti2001/Behavior-Driven-E-Commerce-Product-Recommendation-System/blob/fd18fb6cc0314b8e9a528bc33e171fc07d4e09ff/Screenshot%202026-06-27%20215508.png)
