## lovelyz-ecommerce
Full-stack skincare e-commerce app built with PHP, MySQL &amp; JavaScript — featuring a shopping cart, order management, and membership system.

⚙️ Features
1) ## Product Catalog

Products are stored in MySQL and displayed dynamically by category
Categories include: Foam/Gel/Cream/Milk/Oil Cleansers, Micellar Water, Toners, Serums, Essences, Suncreams, Sleeping/Sheet/Clay/Peel-off Masks
Out-of-stock products are visually marked and buttons disabled

2) ## Shopping Cart

Cart is stored in localStorage — no login required
Add, remove, increase/decrease quantity per product
Stock limit enforced on both frontend and backend
Cart badge updates dynamically in the header

3) ## Order System

On checkout, cart is sent via POST to save_order.php
A MySQL transaction handles:

Deleting any previous pending order for the session
Inserting a new order into orders
Inserting each product into order_details
Deducting stock from products
Rolling back everything if stock is insufficient

Order is marked completed after payment confirmation

4) ## Membership / Subscription

Users can subscribe via a form to receive discounts and updates
Data is validated (required fields, email format, duplicate check)
Stored in the subscribers table

5) ## Database Schema
-- Products
products (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    name        VARCHAR(255),
    description TEXT,
    price       DECIMAL(10,2),
    category    VARCHAR(100),
    image       VARCHAR(255),
    in_stock    INT
)

-- Orders (one row per purchase session)
orders (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    session_id  VARCHAR(255),
    status      ENUM('pending', 'completed'),
    total_price DECIMAL(10,2),
    created_at  DATETIME
)

-- Order line items
order_details (
    id           INT PRIMARY KEY AUTO_INCREMENT,
    order_id     INT REFERENCES orders(id),
    product_id   INT,
    product_name VARCHAR(255),
    price        DECIMAL(10,2),
    quantity     INT
)

-- Newsletter / membership subscribers
subscribers (
    id        INT PRIMARY KEY AUTO_INCREMENT,
    name      VARCHAR(255),
    surname   VARCHAR(255),
    phone     VARCHAR(50),
    email     VARCHAR(255) UNIQUE
)

## Purchase Flow
User adds products → localStorage (cart) -> "Proceed to Checkout" → POST save_order.php → Creates order + order_details in DB → Deducts stock -> Redirects to checkout.html
-> GET checkout.php → displays items + total -> "Pay Now" → POST checkout.php → Marks order as completed -> localStorage cleared → redirects to success.html

## 🚀 Setup

1. Clone the repository
   git clone https://github.com/username/lovelyz-skincare.git

2. Configure the database
   cp includes/db.example.php includes/db.php
   Then open db.php and fill in your MySQL credentials.

3. Import the database
   Import the SQL schema into your MySQL server.

4. Start a local server
   Use XAMPP or WAMP and place the project in the htdocs folder.

5. Open in browser
   http://localhost/SkinCare/index.php
