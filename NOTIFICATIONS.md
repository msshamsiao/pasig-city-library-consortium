# Notification System - Integrated Triggers

## Overview
The notification system is now integrated into the following controllers to send real-time notifications for important events.

---

## ✅ Implemented Notification Triggers

### 1. **Book Reservations** (`Librarian/ReservationController`)

#### When Reservation is Approved
- **Trigger**: Librarian approves a book reservation
- **Recipient**: Member who requested the book
- **Type**: `reservation_approved`
- **Message**: "Your reservation for '{book_title}' has been approved. Please pick it up soon."

#### When Reservation is Rejected
- **Trigger**: Librarian rejects a book reservation
- **Recipient**: Member who requested the book
- **Type**: `reservation_rejected`
- **Message**: "Your reservation for '{book_title}' was rejected. Reason: {reason}"

#### When Book is Borrowed
- **Trigger**: Librarian marks book as borrowed (picked up)
- **Recipient**: Member who borrowed the book
- **Type**: `book_borrowed`
- **Message**: "You have successfully borrowed '{book_title}'. Please return by {due_date}."

#### When Book is Returned
- **Trigger**: Librarian marks book as returned
- **Recipient**: Member who returned the book
- **Type**: `book_returned`
- **Message**: "Thank you for returning '{book_title}'. We hope you enjoyed it!"

---

### 2. **Activities** (`Librarian/ActivityController` & `Admin/ActivityController`)

#### When Activity is Submitted
- **Trigger**: Librarian creates a new activity
- **Recipient**: All Super Admins
- **Type**: `activity_submission`
- **Message**: "New activity '{activity_title}' has been submitted for approval."
- **Link**: Admin activities page

#### When Activity is Approved
- **Trigger**: Admin approves an activity
- **Recipient**: Librarian of that library
- **Type**: `activity_approved`
- **Message**: "Your activity '{activity_title}' has been approved and is now live!"
- **Link**: Librarian activities page

#### When Activity is Rejected
- **Trigger**: Admin rejects an activity
- **Recipient**: Librarian of that library
- **Type**: `activity_rejected`
- **Message**: "Your activity '{activity_title}' was rejected. Reason: {reason}"
- **Link**: Librarian activities page

---

### 3. **Contact Messages** (`ContactController`)

#### When New Message is Received
- **Trigger**: Public user submits contact form
- **Recipient**: All Super Admins
- **Type**: `contact_message`
- **Message**: "New message from {email} - Subject: {subject}"
- **Link**: Admin messages page

---

### 4. **Member Management** (`Librarian/MemberController`)

#### When Members are Bulk Imported
- **Trigger**: Librarian uploads member CSV
- **Recipient**: All Super Admins
- **Type**: `member_import`
- **Message**: "{librarian_name} imported {count} new member(s) to their library."
- **Link**: Admin members page

---

### 5. **Borrower Reservations** (`Borrower/ReservationController`)

#### When Borrower Creates Reservation
- **Trigger**: Borrower submits a book reservation request
- **Recipient**: Librarian of that book's library
- **Type**: `new_reservation`
- **Message**: "{member_name} requested to borrow '{book_title}'. Scheduled pickup: {date_time}"
- **Link**: Librarian reservations page

#### When Borrower Cancels Reservation
- **Trigger**: Borrower cancels their pending reservation
- **Recipient**: Librarian of that book's library
- **Type**: `reservation_cancelled`
- **Message**: "{member_name} cancelled their reservation for '{book_title}'."
- **Link**: Librarian reservations page

---

## 🔧 How to Add More Notifications

### Example: Notify when book is overdue

```php
use App\Services\NotificationService;

// In your controller or scheduled task
NotificationService::create(
    $member,
    'overdue_book',
    'Overdue Book Reminder',
    "The book '{$book->title}' is overdue. Please return it as soon as possible.",
    route('borrower.reservations.index')
);
```

### Example: Notify all librarians

```php
NotificationService::notifyLibrarians(
    'system_maintenance',
    'System Maintenance Notice',
    'The system will undergo maintenance on Dec 20 from 2AM-4AM.',
    null
);
```

### Example: Notify specific library's librarian

```php
NotificationService::notifyLibraryLibrarian(
    $libraryId,
    'low_inventory',
    'Low Book Inventory',
    'Your library has only 5 available books remaining.',
    route('librarian.books.index')
);
```

---

## 📊 Notification Types Reference

| Type | Description |
|------|-------------|
| `reservation_approved` | Book reservation approved |
| `reservation_rejected` | Book reservation rejected |
| `book_borrowed` | Book successfully borrowed |
| `book_returned` | Book successfully returned |
| `activity_submission` | New activity submitted for approval |
| `activity_approved` | Activity approved by admin |
| `activity_rejected` | Activity rejected by admin |
| `contact_message` | New contact form submission |
| `member_import` | Bulk member import completed |
| `new_reservation` | Borrower created new reservation request |
| `reservation_cancelled` | Borrower cancelled their reservation |
| `test` | Test notification |

---

## 🧪 Testing the Notifications

### Option 1: Use Test Page
Visit: `http://localhost:8000/test-notifications`

### Option 2: Run Seeder
```bash
php artisan db:seed --class=NotificationSeeder
```

### Option 3: Perform Real Actions
1. Login as librarian
2. Approve/reject a book reservation
3. Create a new activity
4. Import members via CSV
5. Check the bell icon for notifications

### Option 4: Use Test Route
Visit: `http://localhost:8000/test-notification` (while logged in)

---

## 🎯 Features

- ✅ Real-time notifications
- ✅ Unread count badge
- ✅ Mark as read on click
- ✅ Mark all as read
- ✅ Auto-refresh every 30 seconds
- ✅ Click to navigate to related page
- ✅ Different notification types with icons
- ✅ Persistent across sessions
- ✅ Mobile responsive

---

## 🔮 Future Enhancements

1. **Email Notifications**: Send email for important notifications
2. **Push Notifications**: Browser push notifications
3. **Notification Preferences**: Let users choose what they want to be notified about
4. **Notification Sounds**: Play sound when new notification arrives
5. **Notification History**: Archive old notifications
6. **Priority Levels**: Urgent, Normal, Low priority notifications
7. **Scheduled Notifications**: Send reminders for upcoming events
8. **Overdue Reminders**: Automatic notifications for overdue books
