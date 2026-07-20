# RESTORA OS
## Smart Restaurant Operating System
### Complete System Requirements & Business Workflow Document

---

## 1. System Overview

**Restora OS** is a complete restaurant management platform designed to digitize and simplify restaurant operations by connecting restaurant owners, managers, receptionists, waiters, chefs, and customers in one integrated system.

The system allows restaurants to manage their entire workflow from registration, KYC verification, staff management, menu management, QR table ordering, kitchen operations, payments, reporting, and business analytics.

Restora OS is built as a **multi-restaurant SaaS platform**, where multiple restaurants can use the system independently while maintaining their own private data.

---

## 2. Main Objectives

- Reduce manual restaurant operations
- Improve customer ordering experience
- Eliminate paper-based ordering
- Speed up kitchen communication
- Improve payment tracking
- Reduce waiter workload
- Provide real-time business analytics
- Help restaurant owners control sales and employees

---

## 3. System User Roles

### 3.1 Platform Super Admin
The owner of the Restora platform.

**Responsibilities:**
- Manage all restaurants
- Approve restaurant registrations
- Verify KYC documents
- Manage subscriptions
- Monitor platform activities
- View global analytics
- Suspend restaurants
- Manage system settings

### 3.2 Restaurant Owner
The restaurant business owner.

**Responsibilities:**
- Register restaurant
- Submit KYC documents
- Manage restaurant profile
- Add branches
- Manage staff
- Create tables
- Generate QR codes
- Manage menu
- View reports
- Monitor sales
- Manage payments
- Manage business settings

### 3.3 Restaurant Manager
Responsible for daily restaurant operations.

**Permissions:**
- View dashboard
- Manage staff
- Monitor orders
- Manage tables
- View reports
- Control daily operations

### 3.4 Reception / Cashier
Responsible for customer orders and payments.

**Responsibilities:**
- Receive customer orders
- Confirm orders
- Send orders to kitchen
- Process payments
- Receive waiter cash handover
- Print receipts
- Manage customer bills

### 3.5 Waiter
**Responsibilities:**
- Login using staff code
- Manage assigned tables
- Create customer orders
- Serve food
- Collect cash payments
- Submit collected money to reception
- Track order status

### 3.6 Chef / Kitchen Staff
**Responsibilities:**
- View incoming orders
- Prepare food
- Update order status
- Mark meals as ready
- Manage kitchen queue

### 3.7 Customer
**Customer can:**
- Scan table QR code
- View restaurant menu
- Add items to cart
- Place orders
- Track order progress
- Request bill
- Make payment
- Split payment
- View previous orders

---

## 4. Restaurant Registration Flow

### Step 1: Account Creation
Restaurant owner creates an account.

**Personal Information**
- Full Name
- Phone Number
- Email
- Password

**Restaurant Information**
- Restaurant Name
- Restaurant Type
- Location
- Address
- Description
- Logo

### Step 2: KYC Verification
Restaurant owner uploads:
- Business Registration Certificate
- License
- TIN Number
- Owner Identification
- Other supporting documents

Restaurant status: `Pending Verification`

### Step 3: Admin Approval
Super Admin reviews documents.

**Possible statuses:** `Pending` · `Approved` · `Rejected` · `Suspended`

After approval, the restaurant can access the system.

---

## 5. Restaurant Setup Module

After approval, the owner configures the **Restaurant Settings:**
- Logo
- Cover Image
- Address
- Phone
- Opening Hours
- Currency
- Tax Settings
- Service Charges
- Payment Methods

---

## 6. Staff Management System

Restaurant owner can add employees.

**Staff information:**
- Full Name
- Phone Number
- Role
- Salary (optional)
- Profile Picture

The system automatically generates a **Staff Login Code:**

```
Staff ID:    RST-45892
Login Code:  739201
```

Employees login using the staff code only — no email required.

```
Enter Staff Code
739201
LOGIN
```

---

## 7. Role Permission System

Each role has different permissions.

### Chef
| Can | Cannot |
|-----|--------|
| View orders | View financial reports |
| Update cooking status | Access payments |

### Waiter
| Can | Cannot |
|-----|--------|
| Create orders | Delete orders |
| View assigned tables | View total sales |
| Serve food | |

---

## 8. Table Management System

Restaurant owner can create tables, for example:

```
Table 01
Table 02
Table 03
VIP Table
Outdoor Table
```

Each table receives:
- Table Number
- QR Code
- Unique Table Link — e.g. `restora.app/table/45892`

---

## 9. QR Ordering System

```
Customer enters restaurant
        ↓
Sits at table
        ↓
Scans QR Code
        ↓
Menu Opens
        ↓
Select Food
        ↓
Place Order
        ↓
Kitchen Receives Order
```

---

## 10. Digital Menu Management

**Categories** (example): Breakfast · Lunch · Dinner · Drinks · Desserts · Special Meals

**Food Items** — each item contains:
- Food Name
- Image
- Description
- Price
- Category
- Availability Status

```
Chicken Burger
Price:   15,000 TZS
Status:  Available
```

---

## 11. Customer Ordering Flow

1. Scan QR
2. View menu
3. Add items
4. Confirm order

**Order status:**
```
Pending → Accepted → Preparing → Ready → Served → Completed
```

---

## 12. Reception Dashboard

**New Orders show:** Table Number · Customer Order · Time · Amount

**Actions:** Accept · Reject · Send to Kitchen

---

## 13. Kitchen Dashboard

Shows pending orders, for example:

```
Table 05
2x Pizza
1x Juice
Status: Preparing
```

Chef updates: `Preparing → Ready`. The waiter then receives a notification.

---

## 14. Waiter Dashboard

The waiter sees:
- Assigned tables
- New orders
- Ready meals
- Served meals
- Pending payments

---

## 15. Customer Order History

The customer can view:
- Current order
- Previous orders
- Items purchased
- Total amount

---

## 16. Billing System

```
Food:     80,000
Tax:       8,000
Service:   5,000
TOTAL:    93,000 TZS
```

---

## 17. Payment System

### Cash Payment
```
Customer
   ↓
Waiter Receives Cash
   ↓
Cash Pending Confirmation
   ↓
Waiter Gives Money To Reception
   ↓
Reception Confirms
   ↓
Payment Completed
```

### Online Payment
**Supported:** Mobile Money · Card · Bank · Payment Gateway
```
Customer → Online Payment → Payment Gateway → Success → Order Paid
```

---

## 18. Split Payment System

Customers can divide payment.

```
Total:        100,000 TZS
Customer A:    40,000
Customer B:    30,000
Customer C:    30,000
```

**Status:** `Partially Paid → Fully Paid`

---

## 19. Receipt System

After payment, the system generates a Digital, PDF, and Printed receipt.

**Receipt includes:** Restaurant name · Items · Amount · Payment method · Date · Receipt number

---

## 20. Restaurant Dashboard

**Sales:** Today's · Weekly · Monthly · Total Revenue

**Orders:** Total · Completed · Cancelled

**Analytics:** Best Selling Foods · Peak Hours · Customer Trends · Staff Performance

---

## 21. Reports Module

**Sales Reports:** Daily · Weekly · Monthly · Yearly

**Employee Reports:** Orders handled · Cash collected · Performance

**Payment Reports:** Cash · Online Payments · Pending Payments

---

## 22. Notification System

| User | Notifications |
|------|---------------|
| Customer | Order received · Food ready · Payment successful |
| Waiter | New order · Food ready |
| Chef | New kitchen order |
| Owner | Sales updates |

---

## 23. Security Features

- Role-based permissions
- Activity logs
- Secure authentication
- Data isolation between restaurants
- Backup system
- Fraud monitoring

---

## 24. Future Expansion Features

- Inventory Management
- Supplier Management
- Restaurant Accounting
- Employee Payroll
- Delivery Management
- Table Reservation
- Customer Loyalty Program
- AI Sales Prediction
- Multi-Branch Management
- Franchise Management

---

## Final Product Definition

**RESTORA OS** — A complete digital operating system for restaurants that connects customers, waiters, receptionists, chefs, and owners through smart ordering, QR technology, payments, and real-time business management.
