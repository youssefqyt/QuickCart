# 🛒 QuickCart - Modern E-Commerce Platform

[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Stripe](https://img.shields.io/badge/Stripe-Payment_Integration-635BFF?style=for-the-badge&logo=stripe&logoColor=white)](https://stripe.com)
[![Tests](https://img.shields.io/badge/Tests-25%20Passing-emerald?style=for-the-badge)](tests/)

**QuickCart** is a modern, full-featured e-commerce platform built with Laravel 13 and Tailwind CSS. It provides an intuitive shopping experience for customers and a comprehensive administrative dashboard for store managers.

---

## 🌟 Features Overview

### 🛍️ Storefront & Customer Experience
- **Interactive Home Page**: Features trending products, category highlights, hero banners, and quick search.
- **Product Catalog & Filters**:
  - Search by keyword across product titles and descriptions.
  - Filter by category with real-time product counts.
  - Sort by Price (Low to High, High to Low) and newest arrivals.
  - Active filter badges with one-click reset.
- **Product Details**: High-resolution image view, real-time inventory counter, low-stock warnings, ratings, and related product suggestions.
- **Stock Protection**:
  - Live inventory tracking prevents adding items when out of stock.
  - Cart quantity caps to prevent ordering more than available warehouse inventory.
  - Stock is automatically decremented upon confirmed order payment.
- **Persistent Shopping Cart**:
  - Dynamic navbar cart badge with real-time item counter.
  - Item preview with thumbnails, quantity updater, single-item remover, and one-click "Empty Cart".
- **Multi-Option Checkout**:
  - **Stripe Checkout**: Secure redirect to Stripe with customer email and line items.
  - **Cash on Delivery / Direct Checkout**: Seamless local and offline checkout with instant confirmation.
  - Webhook listener for Stripe asynchronous payment confirmations (`checkout.session.completed`).
- **Real-Time Customer Order Tracking**:
  - Public order lookup via Order ID + Customer Email (`/orders/track`).
  - Visual 4-stage shipment tracker (`Pending` → `Processing` → `Shipped` → `Delivered`).
  - Detailed breakdown of ordered items, prices, shipping address, and payment status.
- **Dark Mode**: Persistent dark mode with saved preferences in `localStorage` and system preference detection.
- **Mobile Responsive**: Fully responsive UI with collapsible mobile drawer menu.

---

### 🛡️ Administrative Console (`/admin`)
- **Dashboard & Business Analytics**:
  - Real-time revenue counter calculated from completed orders.
  - Total orders, pending fulfillment alerts, catalog size, and category counts.
  - **Inventory Warning Table**: Instant view of items running low on stock (< 5 units) with quick edit actions.
  - **Recent Orders Table**: Quick management links to newest customer orders.
- **Product Management (`/admin/products`)**:
  - Full CRUD: Add, edit, browse, and delete products.
  - Image upload with automatic storage handling and cleanup on deletion.
  - Custom slugs, featured/trending toggle, category assignment, and stock level controls.
- **Category Management (`/admin/categories`)**:
  - Full CRUD: Create, view, edit, and delete categories.
  - Automatic slug generation with custom slug override.
  - Safe deletion protection preventing removal of categories containing active products.
- **Order Management (`/admin/orders`)**:
  - Filter orders by fulfillment status (`pending`, `processing`, `shipped`, `delivered`, `cancelled`).
  - Filter orders by payment status (`pending`, `paid`, `failed`).
  - Search orders by ID, customer name, or email.
  - Detailed order inspection: line items, shipping address, Stripe session ID, and payment intent ID.
  - Update fulfillment and payment status in real time.

---

## 🛠️ Technology Stack

| Layer | Technology |
|---|---|
| **Backend Framework** | Laravel 13.x (PHP 8.3+) |
| **Frontend Styling** | Tailwind CSS with Dark Mode |
| **Database** | SQLite (Default for zero-setup portability) or MySQL / PostgreSQL |
| **Payments** | Stripe PHP SDK (`stripe/stripe-php`) |
| **Testing** | PHPUnit 12.x (25 Feature & Unit Tests) |
| **Session & Cache** | File / Database / Redis compatible |

---

## 📁 Project Structure

```text
QuickCart/
├── app/
│   ├── Http/Controllers/
│   │   ├── HomeController.php             # Homepage and featured catalog
│   │   ├── ProductController.php          # Public products browsing & detail
│   │   ├── CartController.php             # Session cart add/update/remove/clear
│   │   ├── CheckoutController.php         # Checkout processing & order placement
│   │   ├── OrderTrackingController.php    # Customer order tracking & status
│   │   ├── StripeWebhookController.php    # Asynchronous Stripe webhook events
│   │   └── Admin/
│   │       ├── DashboardController.php    # Admin analytics & low stock alerts
│   │       ├── ProductController.php      # Admin product CRUD & image upload
│   │       ├── CategoryController.php     # Admin category CRUD
│   │       └── OrderController.php        # Admin order management & status updates
│   └── Models/
│       ├── Category.php                   # Category model with products relation
│       ├── Product.php                    # Product model with stock and category
│       ├── Order.php                      # Order model with stock decrement helper
│       ├── OrderItem.php                  # Order items line relation
│       └── User.php                       # User authentication model
├── database/
│   ├── factories/                         # Product, Category, Order, User factories
│   ├── migrations/                        # Categories, products, orders, payment fields
│   ├── seeders/                           # DatabaseSeeder with initial demo catalog
│   └── database.sqlite                    # Pre-configured SQLite database
├── resources/views/
│   ├── components/                        # navbar, product-card, admin-nav
│   ├── layouts/app.blade.php              # Base layout with dark mode & toasts
│   ├── home.blade.php                     # Storefront landing page
│   ├── cart.blade.php                     # Shopping cart page
│   ├── checkout.blade.php                 # Multi-option checkout form
│   ├── checkout/                          # success.blade.php, cancel.blade.php
│   ├── products/                          # index.blade.php, show.blade.php
│   ├── orders/track.blade.php             # Real-time order tracking
│   └── admin/                             # dashboard, products, categories, orders
├── routes/
│   └── web.php                            # All public and admin route declarations
├── tests/
│   ├── Feature/                           # Cart, Checkout, Tracking, Admin, Example
│   └── Unit/                              # Unit test suite
└── phpunit.xml                            # PHPUnit test configuration
```

---

## 🚀 Getting Started

### 1. Prerequisites
- **PHP** >= 8.3 with `pdo_sqlite` or `pdo_mysql`, `curl`, `mbstring`, `openssl`
- **Composer** (optional for dependency updates)

### 2. Environment Configuration
Copy `.env.example` to `.env` (or configure your existing `.env`):

```bash
cp .env.example .env
```

Ensure your database connection is configured. QuickCart supports **SQLite** out of the box with zero setup:

```env
DB_CONNECTION=sqlite
# For MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=quickcart
# DB_USERNAME=root
# DB_PASSWORD=
```

### 3. Stripe Integration (Optional for Live Card Payments)
Add your Stripe keys to `.env`:

```env
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...
```
*(If Stripe keys are not provided, QuickCart seamlessly offers Cash on Delivery / Direct Checkout for local testing).*

### 4. Database Migration & Demo Data
Run migrations and seed default products and categories:

```bash
php artisan migrate
php artisan db:seed
```

### 5. Storage Symlink
Create the public storage link to display uploaded product images:

```bash
php artisan storage:link
```

### 6. Start the Development Server
```bash
php artisan serve
```

Visit the application at:
- **Storefront**: [http://localhost:8000](http://localhost:8000)
- **Shop Catalog**: [http://localhost:8000/products](http://localhost:8000/products)
- **Track Order**: [http://localhost:8000/orders/track](http://localhost:8000/orders/track)
- **Admin Console**: [http://localhost:8000/admin](http://localhost:8000/admin)

---

## 🧪 Running Automated Tests

QuickCart includes a comprehensive automated test suite covering all critical e-commerce flows:

```bash
# Run all tests
.\vendor\bin\phpunit.bat

# Or using artisan
php artisan test
```

### Test Coverage Highlights:
- **`CartTest`**: Cart viewing, adding in-stock products, blocking out-of-stock items, quantity limits, updates, removals, and clearing.
- **`CheckoutTest`**: Cart empty guards, Cash on Delivery orders, Stripe order creation, stock decrements, and cart session resets.
- **`OrderTrackingTest`**: Public search validation, timeline display, customer privacy guards.
- **`AdminManagementTest`**: Dashboard analytics, product CRUD, category CRUD with deletion safety, and order fulfillment status updates.

---

## 🌐 Route Map

| Method | URI | Controller Action | Description |
|---|---|---|---|
| `GET` | `/` | `HomeController@index` | Storefront landing page |
| `GET` | `/products` | `ProductController@index` | Product catalog with search and filters |
| `GET` | `/products/{slug}` | `ProductController@show` | Single product details & stock |
| `GET` | `/cart` | `CartController@index` | View shopping cart |
| `POST` | `/cart/add/{product}` | `CartController@add` | Add product to cart with stock validation |
| `POST` | `/cart/update/{product}` | `CartController@update` | Update item quantity in cart |
| `DELETE` | `/cart/remove/{product}` | `CartController@remove` | Remove single item from cart |
| `POST` | `/cart/clear` | `CartController@clear` | Clear entire shopping cart |
| `GET` | `/checkout` | `CheckoutController@index` | View checkout page |
| `POST` | `/checkout` | `CheckoutController@store` | Place order (Stripe / COD) |
| `GET` | `/checkout/success` | `CheckoutController@success` | Order confirmation & receipt |
| `GET` | `/checkout/cancel` | `CheckoutController@cancel` | Cancelled payment notice |
| `GET` | `/orders/track` | `OrderTrackingController@index` | Real-time order tracking |
| `POST` | `/stripe/webhook` | `StripeWebhookController@handle`| Stripe payment webhook handler |
| `GET` | `/admin` | `Admin\DashboardController@index`| Admin dashboard & analytics |
| `RESOURCE` | `/admin/products` | `Admin\ProductController` | Products management (CRUD) |
| `RESOURCE` | `/admin/categories` | `Admin\CategoryController` | Categories management (CRUD) |
| `RESOURCE` | `/admin/orders` | `Admin\OrderController` | Orders management (index, show, update) |

---

## 📄 License
This project is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
