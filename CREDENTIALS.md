# DEFAULT USER CREDENTIALS

## After running: php artisan migrate:fresh --seed

---

### 1. SUPER ADMIN
**Email:** superadmin@pasigcitylibrary.gov.ph  
**Password:** superadmin123  
**Role:** super_admin

**Access:**
- Dashboard (Full Analytics)
- Member Library Management (CRUD)
- Analytics of all Member Libraries
- Activities Approval
- System Settings
- Archive Page
- Audit Trail

---

### 2. MEMBER LIBRARIAN
**Email:** librarian@pasigcitylibrary.gov.ph  
**Password:** librarian123  
**Role:** member_librarian

**Access:**
- Members Upload
- Book Requests (Approve/Reject)
- Books Management (Upload Only)
- Activities (Add)

---

### 3. BORROWER/MEMBER
**Email:** borrower@example.com  
**Password:** borrower123  
**Role:** borrower

**Access:**
- Book Search
- Book Reservation
- My Account
- Borrowing History

---

## Quick Login

Copy-paste these credentials for testing:

**Super Admin Login:**
```
Email: superadmin@pasigcitylibrary.gov.ph
Password: superadmin123
```

**Librarian Login:**
```
Email: librarian@pasigcitylibrary.gov.ph
Password: librarian123
```

**Borrower Login:**
```
Email: borrower@example.com
Password: borrower123
```

---

## Role-Based Access Control

All routes are protected with the `role` middleware:

```php
// Example usage in routes:
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    // Super admin only routes
});

Route::middleware(['auth', 'role:member_librarian'])->group(function () {
    // Member librarian only routes
});

Route::middleware(['auth', 'role:borrower'])->group(function () {
    // Borrower only routes
});

Route::middleware(['auth', 'role:super_admin,member_librarian'])->group(function () {
    // Super admin and member librarian routes
});
```

---

**Note:** These are default credentials for development. Change them in production!
