<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Services\NotificationService;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users
        $admin = User::where('role', 'super_admin')->first();
        $librarian = User::where('role', 'member_librarian')->first();

        if ($admin) {
            // Create notifications for admin
            NotificationService::create(
                $admin,
                'book_request',
                'New Book Request',
                'A member requested to borrow "The Great Gatsby"',
                route('admin.books.index')
            );

            NotificationService::create(
                $admin,
                'activity_submission',
                'Activity Needs Approval',
                'New activity "Summer Reading Program" submitted by PLNP Library',
                route('admin.activities.index')
            );

            NotificationService::create(
                $admin,
                'contact_message',
                'New Contact Message',
                'You have a new message from Maria Santos',
                route('admin.messages.index')
            );

            NotificationService::create(
                $admin,
                'overdue_alert',
                'Overdue Books Alert',
                '5 books are overdue and need attention',
                route('admin.books.index')
            );
        }

        if ($librarian) {
            // Create notifications for librarian
            NotificationService::create(
                $librarian,
                'book_request',
                'Book Reservation',
                'John Doe reserved "Laravel: Up & Running"',
                route('librarian.reservations.index')
            );

            NotificationService::create(
                $librarian,
                'book_return',
                'Book Returned',
                'Member returned "Clean Code" - Please verify condition',
                route('librarian.reservations.index')
            );

            NotificationService::create(
                $librarian,
                'member_registration',
                'New Member Registered',
                'Jane Smith has registered as a new member',
                route('librarian.members.index')
            );
        }

        $this->command->info('Sample notifications created successfully!');
    }
}
