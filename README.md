# 🇰🇪 Kenya Progressive Tax Calculator

A simple, user-friendly web application that helps individuals in Kenya calculate their monthly or annual income tax based on the **progressive tax system** defined by the Kenya Revenue Authority (KRA).

## 📚 About the Project

This web app takes the user’s gross income as input and calculates their applicable income tax using Kenya's PAYE (Pay As You Earn) tax bands. The results include:
- Total tax payable
- Net income after tax
- Effective tax rate

The calculator is built with **HTML**, **Tailwind CSS**, and **JavaScript/PHP** for logic.

---

## 🇰🇪 Understanding Kenya's Progressive Tax System

Kenya uses a **progressive tax system**, meaning the more you earn, the higher the percentage of tax you pay — but only on the income within each bracket. As of recent updates from KRA, the tax bands are as follows:

| Income Band (Monthly)       | Tax Rate  |
|----------------------------|-----------|
| KSh 0 – 24,000             | 10%       |
| KSh 24,001 – 32,333        | 25%       |
| KSh 32,334 and above       | 30%       |

> **Important**: Only the portion of income that falls within a given band is taxed at that rate. For example, if you earn KSh 35,000 per month:
> - The first 24,000 is taxed at 10%
> - The next 8,333 (from 24,001 to 32,333) is taxed at 25%
> - The remaining 2,667 is taxed at 30%

Additionally, personal relief (currently KSh 2,400/month) is deducted from the final tax amount to reduce the total payable.

---

## ✨ Features

- 📊 Real-time tax calculation
- 🔢 Breakdown of tax per income band
- 🧮 Automatic deduction of personal relief
- 💡 Informative display of net income and effective tax rate
- 📱 Responsive design using Tailwind CSS

---

## 🚀 How to Use

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/kenya-tax-calculator.git
   cd kenya-tax-calculator
