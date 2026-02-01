![Logo Image](/readme/logo.png)

**A simple, powerful CRM for fast-moving startups.**

AZUL CRM is a mobile app for startup teams. It helps CEOs and sales members manage customer data and deals anywhere, anytime.

## 🌟 Why AZUL CRM?

- **Mobile First:** Fast and easy to use on the go.
- **Safe & Secure:** Uses a "One Database per Company" design.
- **Global Ready:** Designed for easy payments and taxes worldwide (via Paddle).

---

## 🛠 Tech Stack

- **Frontend:** Flutter
- **Backend:** Laravel 12
- **Database:** MySQL
- **Payments:** Paddle (Planned)

---

## 🏗 Key Technical Features (The "Why")

### 1. Multi-tenant (Isolated Database)

Each company gets its own database.

- **High Security:** Data is never mixed with other companies.
- **Scalability:** We can easily move big clients to their own servers.

### 2. Smart Permissions (RBAC)

- **Admin:** Can manage the whole team.
- **Member:** Can manage customers and deals.
- **JWT Auth:** Secure and fast login for mobile users.

### 3. Smooth Onboarding (Planned)

A simple 3-step flow to start:

1. **User Info:** Create an account.
2. **Payment:** Pay via Paddle (Safe & Global).
3. **Auto-Setup:** The system automatically creates a new database.

---

## ✅ Current Progress

- [x]  **Login System:** Secure JWT Authentication.
- [x]  **Permission Logic:** Admin and Member roles.
- [x]  **Multi-tenant Engine:** Smart database switching.
- [ ]  **On Boarding Process:** Account & payment registration → Multi-tenant setup (In progress)
- [ ]  **CRM Modules:** Customer & Deal management (In progress).

---