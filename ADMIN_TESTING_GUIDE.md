# Admin Panel - Quick Testing Guide

## How to Test Your Admin Dashboard

### Prerequisites
1. Make sure you're logged in as an admin user (role = 'admin')
2. Navigate to `/admin/dashboard`

---

## Testing Checklist

### 1. Dashboard (`/admin/dashboard`)
- [ ] See 3 stat cards at top (Total Products, Total Users, Total Orders)
- [ ] See "Quick Links" card with "Add Product" button
- [ ] See "Latest Orders" table below with recent orders
- [ ] Order statuses should be color-coded (yellow, blue, green, red)
- [ ] Click on "View" button in orders table

### 2. Products Management (`/admin/products`)

#### List Products
- [ ] Navigate to `/admin/products`
- [ ] See table of all products with pagination
- [ ] Product images display correctly (or placeholder if no image)
- [ ] See "Add New Product" button in top right
- [ ] All columns visible: ID, Image, Name, Price, Category, Discount, Final Price, Actions

#### Add Product
- [ ] Click "Add New Product" button
- [ ] **Test Product Name:**
  - [ ] Leave empty and try to save (should show error)
  - [ ] Enter a name and it displays
  
- [ ] **Test Description:**
  - [ ] Enter description text
  - [ ] Leave empty (optional field)
  
- [ ] **Test Category:**
  - [ ] Select a category from dropdown
  - [ ] Leave empty and try to save (should show error)
  
- [ ] **Test Price:**
  - [ ] Enter a price (e.g., 50000)
  - [ ] Watch final price update in real-time
  - [ ] Leave empty and try to save (should show error)
  
- [ ] **Test Discount:**
  - [ ] Leave at 0 (no discount)
  - [ ] Change to 10, watch final price recalculate
  - [ ] Final price should be: Price - (Price × Discount/100)
  - [ ] Example: 50000 - (50000 × 10/100) = 45000
  
- [ ] **Test Image Upload:**
  - [ ] Click on image area
  - [ ] Select an image (JPG, JPEG, or PNG)
  - [ ] See preview of image below
  - [ ] Try uploading a non-image file (should fail)
  - [ ] Try uploading a file over 2MB (should fail)
  
- [ ] **Test Form Submission:**
  - [ ] Fill all required fields correctly
  - [ ] Click "Save Product" button
  - [ ] See success message
  - [ ] Redirected to products list
  - [ ] New product appears in table

#### Edit Product
- [ ] Click "Edit" button on any product
- [ ] See product image displayed if it exists
- [ ] All fields pre-populated with current data
- [ ] Change a field (e.g., price or discount)
- [ ] Watch final price recalculate in real-time
- [ ] Upload a new image to replace current one
- [ ] Click "Update Product"
- [ ] See success message
- [ ] Check that changes were saved

#### Delete Product
- [ ] Click "Delete" button on any product
- [ ] Confirm deletion in dialog
- [ ] Product removed from list
- [ ] See success message with product name

### 3. Categories Management (`/admin/categories`)

#### Add Category
- [ ] Navigate to `/admin/categories`
- [ ] See "Add New Category" form on left
- [ ] Enter category name
- [ ] Click "Add Category"
- [ ] See category appear in right panel
- [ ] Try entering duplicate name (should show error)

#### Delete Category
- [ ] Click delete button (trash icon) next to category
- [ ] Confirm deletion
- [ ] Category removed from list
- [ ] See success message

### 4. Orders Management (`/admin/orders`)

#### List Orders
- [ ] Navigate to `/admin/orders`
- [ ] See table of all orders
- [ ] Statuses are color-coded
- [ ] Click "View" button on any order

#### View Order Details
- [ ] See order information (ID, customer, date)
- [ ] See "Update Order Status" section
- [ ] Dropdown shows current status
- [ ] See order items table with products
- [ ] See total order amount in card

#### Update Order Status
- [ ] Click on status dropdown
- [ ] Change status (e.g., pending → paid)
- [ ] Click "Update Status"
- [ ] See success message
- [ ] Status in card updates
- [ ] Go back to orders list, status is updated

### 5. Users Management (`/admin/users`)

#### List Users
- [ ] Navigate to `/admin/users`
- [ ] See table of all users
- [ ] See name, email, phone, role, joined date
- [ ] Pagination works if more than 10 users

#### Change User Role
- [ ] Click on role dropdown for any user (except yourself)
- [ ] Select different role (User ↔ Admin)
- [ ] Dropdown auto-submits
- [ ] See success message
- [ ] Role updated in table

#### Delete User
- [ ] Click "Delete" button for any user (except yourself)
- [ ] Confirm deletion dialog
- [ ] User removed from list
- [ ] See success message

#### Self-protection
- [ ] Your own user has "You" badge instead of delete button
- [ ] Your role dropdown is disabled
- [ ] Cannot delete yourself

### 6. Error Handling

#### Validation Errors
- [ ] Try to create product without name (error shows)
- [ ] Try to create product without category (error shows)
- [ ] Try to create product without price (error shows)
- [ ] Try to upload non-image file (error shows)
- [ ] Errors dismiss after 5 seconds or manually

#### Success Messages
- [ ] Success messages appear at top
- [ ] Auto-dismiss after 5 seconds
- [ ] Can manually dismiss with X button

### 7. UI/UX

#### Navigation
- [ ] Sidebar active state changes when navigating
- [ ] All menu items clickable and functional
- [ ] Logout button works

#### Responsiveness
- [ ] Open on mobile (< 768px)
- [ ] All elements visible and functional
- [ ] Tables scroll horizontally if needed
- [ ] Forms are accessible

#### Design
- [ ] Professional color scheme
- [ ] Cards have proper shadows
- [ ] Badges are color-coded
- [ ] Tables have hover effects
- [ ] Buttons have proper sizing

---

## Common Issues & Solutions

### Issue: Image not uploading
- **Check:** File format is JPG, JPEG, or PNG
- **Check:** File size is less than 2MB
- **Check:** File path is correct in storage directory

### Issue: Final price not calculating
- **Solution:** Reload the page and try again
- **Check:** Price field has a value
- **Check:** Discount is between 0-100

### Issue: Cannot add product without error
- **Check:** All required fields are filled (name, price, category)
- **Check:** Category actually exists in dropdown
- **Check:** Price is a valid number

### Issue: Order status doesn't update
- **Check:** You have admin permissions
- **Check:** Status is one of: pending, paid, processing, completed, cancelled
- **Check:** Refresh the page to see update

### Issue: Cannot see product image
- **Check:** Image was uploaded successfully
- **Check:** File path is correct in storage/public/products/
- **Check:** Storage link is created (`php artisan storage:link`)

---

## Database Reset (if needed)

```bash
# Clear all data and start fresh
php artisan migrate:fresh --seed

# Or just migrations
php artisan migrate:reset
php artisan migrate
```

---

## File Locations

All admin views are in: `/resources/views/admin/`
- `layouts/app.blade.php` - Main admin layout
- `dashboard.blade.php` - Dashboard view
- `products/` - Product management views
- `categories/` - Category management view
- `orders/` - Order management views
- `users/` - User management view

All admin controllers are in: `/app/Http/Controllers/Admin/`
- `DashboardController.php`
- `ProductController.php`
- `CategoryController.php`
- `OrderController.php`
- `UserController.php`

---

## Success Criteria

✅ All CRUD operations work (Create, Read, Update, Delete)
✅ Real-time price calculation works
✅ Image upload and preview work
✅ Validation messages display correctly
✅ Status badges are color-coded
✅ Pagination works correctly
✅ Responsive design works on mobile
✅ Auto-dismiss alerts work
✅ Admin middleware protection works
✅ Navigation is intuitive

---

Good luck testing! If you find any issues, check the validation rules and error messages.
