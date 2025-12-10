# User Roles and Access Control Guide

## Default User Credentials

After running `php artisan migrate:fresh --seed`, the following default users will be created:

### 1. SUPER ADMIN
- **Email:** `superadmin@pasigcitylibrary.gov.ph`
- **Password:** `superadmin123`
- **Role:** `super_admin`

### 2. MEMBER LIBRARIAN
- **Email:** `librarian@pasigcitylibrary.gov.ph`
- **Password:** `librarian123`
- **Role:** `member_librarian`

### 3. BORROWER/MEMBER
- **Email:** `borrower@example.com`
- **Password:** `borrower123`
- **Role:** `borrower`

---

## User Roles and Permissions

### SUPER ADMIN (`super_admin`)
**Full system access and control**

#### Accessible Pages/Features:
- **Dashboard**
  - System overview
  - Analytics across all member libraries
  - Recent activities
  - System health monitoring

- **Member Library Management (CRUD)**
  - Create new member libraries
  - Read/View all libraries
  - Update library information
  - Delete/Deactivate libraries
  - Manage library contacts and details

- **Analytics of Member Libraries**
  - How many books per library
  - How many books borrowed per library
  - How many members per library
  - Borrowing trends and statistics
  - Popular books across libraries

- **Activities Management**
  - View all activities/posts
  - Approve/Reject activities from member librarians
  - View-only mode for published activities
  - Manage activity categories

- **Settings (CRUD)**
  - System-wide settings
  - Create/Update/Delete super admin accounts
  - Configure system parameters
  - Email templates
  - General configurations

- **Archive Page**
  - View archived libraries
  - View archived books
  - View archived members
  - View archived activities
  - Restore or permanently delete

- **Audit Trail**
  - Track all user actions
  - Login/Logout history
  - CRUD operations log
  - Activity approval/rejection log
  - System changes history
  - Export audit reports

---

### MEMBER LIBRARIAN (`member_librarian`)
**Library-specific management access**

#### Accessible Pages/Features:
- **Members Management**
  - Upload new members (CSV/Excel)
  - Add individual members
  - View members list
  - Upload-only permission (cannot delete)

- **Book Requests**
  - View all book requests
  - Approve book requests
  - Reject book requests with reasons
  - Request history

- **Books Management**
  - Upload books (CSV/Excel)
  - Add individual books
  - View books in their library
  - Upload-only permission (cannot delete)
  - Update book availability status

- **Activities**
  - Add new activities/posts
  - Edit their own activities
  - Submit for approval
  - View published activities

**Note:** Member librarians can only access data related to their assigned library.

---

### BORROWER/MEMBER (`borrower`)
**Public user with borrowing privileges**

#### Accessible Pages/Features:
- **Book Search**
  - Search across all libraries
  - Filter by library, category, author
  - View book details
  - Check availability

- **Reservation**
  - Reserve available books
  - View reservation history
  - Cancel reservations
  - Request book renewals

- **My Account**
  - View profile
  - Update personal information
  - View borrowing history
  - View active reservations
  - View due dates

---

## Role-Based Route Protection

### Middleware Usage

```php
// Super Admin only
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/admin/libraries', [LibraryController::class, 'index']);
    Route::get('/admin/analytics', [AnalyticsController::class, 'index']);
    Route::get('/admin/audit-trail', [AuditController::class, 'index']);
});

// Super Admin and Member Librarian
Route::middleware(['auth', 'role:super_admin,member_librarian'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

// Member Librarian only
Route::middleware(['auth', 'role:member_librarian'])->group(function () {
    Route::post('/members/upload', [MemberController::class, 'upload']);
    Route::post('/books/upload', [BookController::class, 'upload']);
});

// Borrower only
Route::middleware(['auth', 'role:borrower'])->group(function () {
    Route::post('/reservations', [ReservationController::class, 'store']);
});

// All authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index']);
});
```

---

## Database Schema Updates

### Users Table
```sql
- id (bigint, primary key)
- name (varchar)
- email (varchar, unique)
- email_verified_at (timestamp, nullable)
- password (varchar)
- role (varchar) -- 'super_admin', 'member_librarian', 'borrower'
- library_id (bigint, nullable, foreign key to libraries.id)
- remember_token (varchar)
- created_at (timestamp)
- updated_at (timestamp)
```

### Notes:
- `library_id` is only used for `member_librarian` role
- Super admins and borrowers have `library_id` as NULL
- Member librarians are linked to a specific library

---

## User Model Helper Methods

```php
// Check roles
$user->isSuperAdmin();        // Returns true if super_admin
$user->isMemberLibrarian();   // Returns true if member_librarian
$user->isBorrower();           // Returns true if borrower
$user->hasRole('super_admin', 'member_librarian'); // Check multiple roles

// Get user's library (for member_librarian)
$user->library; // Returns Library model instance
```

---

## Feature Access Matrix

| Feature | Super Admin | Member Librarian | Borrower |
|---------|-------------|------------------|----------|
| Dashboard | ✅ Full | ✅ Limited | ❌ |
| Member Libraries CRUD | ✅ | ❌ | ❌ |
| Analytics (All) | ✅ | ❌ | ❌ |
| Analytics (Own Library) | ✅ | ✅ | ❌ |
| Approve Activities | ✅ | ❌ | ❌ |
| Add Activities | ✅ | ✅ | ❌ |
| System Settings | ✅ | ❌ | ❌ |
| Archive Page | ✅ | ❌ | ❌ |
| Audit Trail | ✅ | ❌ | ❌ |
| Upload Members | ❌ | ✅ | ❌ |
| Manage Book Requests | ❌ | ✅ | ❌ |
| Upload Books | ❌ | ✅ | ❌ |
| Book Reservation | ❌ | ❌ | ✅ |
| Search Books | ✅ | ✅ | ✅ |

---

## Implementation Checklist

- [x] User roles defined in database
- [x] Default users seeded
- [x] Role-based middleware created
- [x] User model helper methods added
- [ ] Super Admin controllers and views
- [ ] Member Librarian controllers and views
- [ ] Borrower controllers and views
- [ ] Audit trail implementation
- [ ] Archive functionality
- [ ] Analytics dashboard
- [ ] Activity approval system
- [ ] Member upload functionality
- [ ] Book upload functionality
- [ ] Reservation system

---

## Next Steps

1. Run migrations: `php artisan migrate:fresh --seed`
2. Register the CheckRole middleware in `bootstrap/app.php`
3. Create controllers for each role's features
4. Create views for role-specific dashboards
5. Implement audit trail logging
6. Set up activity approval workflow
7. Create upload functionality for CSV/Excel
8. Build reservation system for borrowers
