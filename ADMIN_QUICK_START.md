# 🚀 Quick Start - Admin Dashboard

## Access Your Admin Panel

### URL
```
http://localhost:8000/admin/dashboard
(or your actual domain/admin/dashboard)
```

### Requirements
1. ✅ Must be logged in
2. ✅ User role must be "admin"
3. ✅ Database must be migrated and seeded

---

## First Time Setup

### 1. Run Migrations
```bash
cd /Users/khadijakubr/Herd/AFL1-Webdev
php artisan migrate
```

### 2. Seed Database (Optional but recommended)
```bash
php artisan db:seed
```

### 3. Create Storage Link (For images)
```bash
php artisan storage:link
```

### 4. Start Server
```bash
php artisan serve
```

Server runs at: `http://localhost:8000`

---

## Admin User Login

### Default Admin (from seeder)
```
Email:    admin@example.com
Password: password
```

### Change to Your Credentials
Update the database or create a new admin user:

```bash
# Create admin user via tinker
php artisan tinker

# In tinker shell:
User::create([
    'name' => 'Your Name',
    'email' => 'your@email.com',
    'password' => Hash::make('your-password'),
    'role' => 'admin',
    'email_verified_at' => now()
])

exit
```

---

## Main Admin Pages

### Dashboard
```
URL: /admin/dashboard
Shows: Statistics, latest orders, quick actions
```

### Products
```
URL: /admin/products                    - List all products
URL: /admin/products/create             - Add new product
URL: /admin/products/{id}/edit          - Edit product
Action: Delete product
```

### Categories
```
URL: /admin/categories                  - Manage categories
Actions: Add, Delete
```

### Orders
```
URL: /admin/orders                      - List all orders
URL: /admin/orders/{id}                 - View order details
Action: Update order status
```

### Users
```
URL: /admin/users                       - Manage users
Actions: Change role, Delete user
```

---

## Essential Tasks

### 1. Add Your First Category
1. Go to `/admin/categories`
2. Enter category name (e.g., "Electronics")
3. Click "Add Category"

### 2. Add Your First Product
1. Go to `/admin/products`
2. Click "Add New Product"
3. Fill in:
   - Name: "Product Name"
   - Price: "50000"
   - Category: Select from dropdown
   - Description: (optional)
   - Image: (optional) Upload JPG/JPEG/PNG, max 2MB
   - Discount: 0-100%
4. Click "Save Product"

### 3. View Orders
1. Go to `/admin/orders`
2. Click "View" on any order to see details
3. Update order status from dropdown
4. Click "Update Status"

### 4. Manage Users
1. Go to `/admin/users`
2. Change user role by selecting from dropdown
3. Click "Delete" to remove user (not yourself!)

---

## Features at a Glance

### Products Page
- ✅ List, Create, Read, Update, Delete
- ✅ Image upload and preview
- ✅ Category management
- ✅ Discount calculation
- ✅ Price formatting (Rupiah)

### Real-Time Calculator
As you type in price and discount fields, the final price updates automatically!

```
Example:
Price: 100,000
Discount: 20%
Final Price: 80,000 (auto-calculated)
```

### Image Upload
- Drag and drop or click to select
- Preview shows immediately
- Supports: JPG, JPEG, PNG
- Max size: 2MB

### Validation
- All required fields must be filled
- Prices must be numbers
- Images must be correct format
- Errors show below each field
- Auto-dismiss after 5 seconds

---

## Common Actions

### Adding a Product
```
1. /admin/products → [+ Add New Product]
2. Fill form:
   - Name: "Laptop"
   - Category: Electronics
   - Price: 15000000
   - Discount: 10%
   - Image: (upload)
3. Final Price shows: 13,500,000
4. Click [Save Product]
```

### Updating Order Status
```
1. /admin/orders
2. Click [View] on order
3. Change status: pending → paid
4. Click [Update Status]
```

### Changing User Role
```
1. /admin/users
2. Click role dropdown
3. Select: User or Admin
4. Auto-saves automatically
```

---

## Keyboard Shortcuts (Optional)

### Tab Navigation
- `Tab` - Move to next field
- `Shift + Tab` - Move to previous field
- `Enter` - Submit form
- `Escape` - Close confirmation dialog

---

## Troubleshooting

### Problem: Images not showing
**Solution:**
```bash
# Create symbolic link
php artisan storage:link
```

### Problem: 403 Unauthorized
**Solution:**
- Check user role is "admin"
- Check admin middleware is registered

### Problem: Validation errors
**Solution:**
- Read the error message
- Check required fields are filled
- Check data format is correct

### Problem: Can't login
**Solution:**
- Verify email is correct
- Check caps lock
- Reset password if forgotten
- Use seeded credentials: admin@example.com / password

---

## File Locations Reference

### Views
```
/resources/views/admin/
├── layouts/app.blade.php          - Main layout
├── dashboard.blade.php            - Dashboard
├── products/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── categories/
│   └── index.blade.php
├── orders/
│   ├── index.blade.php
│   └── show.blade.php
└── users/
    └── index.blade.php
```

### Controllers
```
/app/Http/Controllers/Admin/
├── DashboardController.php
├── ProductController.php
├── CategoryController.php
├── OrderController.php
└── UserController.php
```

### Routes
```
/routes/web.php       - All routes defined here
```

### Database
```
/database/migrations/  - Database tables
/database/seeders/     - Sample data
```

---

## Database Tables

### Products
```
id, name, description, price, image, discount, category_id, created_at, updated_at
```

### Categories
```
id, name, slug, created_at, updated_at
```

### Orders
```
id, user_id, total_price, shipping_address, payment_method, status, created_at, updated_at
```

### Users
```
id, name, email, password, phone, address, role, email_verified_at, created_at, updated_at
```

---

## Best Practices

### When Adding Products
1. Add category first
2. Use clear product names
3. Upload product images (helps sales)
4. Set accurate prices
5. Use discounts wisely

### When Managing Orders
1. Update status as order progresses
2. Keep statuses: pending → paid → processing → completed
3. Mark cancelled orders as cancelled

### When Managing Users
1. Don't delete your own account
2. Be careful promoting users to admin
3. Monitor user activity

---

## Get Help

### Check Error Messages
- Read validation errors carefully
- They tell you what's wrong
- Fix and try again

### Check Browser Console
- Open DevTools (F12)
- Go to Console tab
- Check for JavaScript errors

### Check Server Logs
```bash
# Watch real-time logs
tail -f storage/logs/laravel.log

# Or read recent log
cat storage/logs/laravel.log | tail -50
```

---

## Next Steps

1. ✅ Login to admin panel
2. ✅ Add categories
3. ✅ Add products
4. ✅ Check dashboard
5. ✅ Review orders
6. ✅ Manage users

---

## Support Resources

- **Laravel Docs:** https://laravel.com/docs
- **Bootstrap Docs:** https://getbootstrap.com/docs
- **PHP Manual:** https://www.php.net/manual/

---

## Summary

Your admin dashboard is **fully functional** and ready to use!

**Features:**
- ✅ Professional design
- ✅ Real-time calculations
- ✅ Image uploads
- ✅ Comprehensive validation
- ✅ Status management
- ✅ User management
- ✅ Mobile responsive
- ✅ Secure & protected

**Just login and start managing your products and orders!**

Happy managing! 🚀
