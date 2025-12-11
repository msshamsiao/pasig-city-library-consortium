<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Library;
use App\Models\Activity;
use App\Models\Statistic;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default users for each role
        
        // Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@pasigcitylibrary.gov.ph',
            'password' => bcrypt('superadmin123'),
            'role' => 'super_admin',
            'email_verified_at' => now(),
        ]);
        
        // Member Librarian (for each library - create one sample)
        User::create([
            'name' => 'Librarian',
            'email' => 'librarian@pasigcitylibrary.gov.ph',
            'password' => bcrypt('librarian123'),
            'role' => 'member_librarian',
            'email_verified_at' => now(),
        ]);
        
        // Borrower/Member
        User::create([
            'name' => 'John Doe',
            'email' => 'borrower@example.com',
            'password' => bcrypt('borrower123'),
            'role' => 'borrower',
            'email_verified_at' => now(),
        ]);
        
        // Seed Libraries
        $this->call([
            LibrarySeeder::class,
            MemberSeeder::class,
        ]);
        
        // Seed Activities
        $this->seedActivities();
        
        // Seed Statistics
        $this->seedStatistics();
    }

    /**
     * Seed activities data.
     */
    private function seedActivities()
    {
        $activities = [
            [
                'activity_date' => '2025-01-15',
                'start_date' => '2025-01-15',
                'end_date' => '2025-01-15',
                'library_id' => 1,
                'title' => 'New Digital Collection Launch',
                'description' => 'We are excited to announce the launch of our new digital collection featuring over 5,000 e-books, audiobooks, and digital magazines. This collection includes academic journals, fiction and non-fiction titles, and specialized research materials.',
                'has_image' => true,
                'category' => 'announcement',
                'is_published' => true,
            ],
            [
                'activity_date' => '2025-01-10',
                'start_date' => '2025-01-11',
                'end_date' => '2025-01-11',
                'library_id' => 2,
                'title' => 'Reading Program for Children',
                'description' => 'Join our monthly reading program designed for children ages 5-12. Every Saturday from 10 AM to 12 PM, we host interactive storytelling sessions, book discussions, and creative writing workshops.',
                'has_image' => false,
                'category' => 'program',
                'is_published' => true,
            ],
            [
                'activity_date' => '2025-01-05',
                'start_date' => '2025-02-01',
                'end_date' => '2025-02-01',
                'library_id' => 1,
                'title' => 'Library Hours Extended',
                'description' => 'Starting February 1st, all consortium libraries will extend their operating hours. Monday through Friday: 7 AM to 10 PM, Saturday: 8 AM to 8 PM, Sunday: 10 AM to 6 PM.',
                'has_image' => false,
                'category' => 'announcement',
                'is_published' => true,
            ],
            [
                'activity_date' => '2024-12-28',
                'start_date' => '2025-01-05',
                'end_date' => '2025-03-05',
                'library_id' => 3,
                'title' => 'Research Workshop Series',
                'description' => 'Learn advanced research techniques in our monthly workshop series. Topics include database navigation, citation management, academic writing, and digital literacy skills for students and professionals.',
                'has_image' => true,
                'category' => 'workshop',
                'is_published' => true,
            ],
            [
                'activity_date' => '2024-12-20',
                'start_date' => '2024-12-20',
                'end_date' => '2025-01-15',
                'library_id' => 4,
                'title' => 'Holiday Reading Challenge',
                'description' => 'Participate in our annual holiday reading challenge! Read at least 5 books during the holiday season and win prizes. Challenge runs from December 20 to January 15.',
                'has_image' => false,
                'category' => 'event',
                'is_published' => true,
            ],
            [
                'activity_date' => '2024-12-15',
                'start_date' => '2024-12-15',
                'end_date' => '2024-12-15',
                'library_id' => 2,
                'title' => 'Author Meet and Greet',
                'description' => 'Meet renowned Filipino authors in our special series of author talks and book signings. Join us for intimate discussions about their writing process and latest works.',
                'has_image' => false,
                'category' => 'event',
                'is_published' => true,
            ],
            [
                'activity_date' => '2024-12-10',
                'start_date' => '2024-12-10',
                'end_date' => '2024-12-10',
                'library_id' => 1,
                'title' => 'Library Card Registration Drive',
                'description' => 'Free library card registration for all Pasig City residents! Visit any consortium library with a valid ID and proof of residency to get your card on the spot.',
                'has_image' => false,
                'category' => 'announcement',
                'is_published' => true,
            ],
            [
                'activity_date' => '2024-12-05',
                'start_date' => '2024-12-05',
                'end_date' => '2024-12-05',
                'library_id' => 5,
                'title' => 'Student Volunteer Program',
                'description' => 'High school and college students can now apply for our volunteer program. Gain valuable experience in library operations while earning community service hours.',
                'has_image' => false,
                'category' => 'program',
                'is_published' => true,
            ],
        ];

        foreach ($activities as $activity) {
            Activity::create($activity);
        }
    }

    /**
     * Seed statistics data.
     */
    private function seedStatistics()
    {
        $statistics = [
            [
                'key' => 'total_libraries',
                'label' => 'Total Libraries',
                'value' => 6,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'key' => 'total_books',
                'label' => 'Total Books',
                'value' => 15243,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'key' => 'available_books',
                'label' => 'Available Books',
                'value' => 12890,
                'order' => 3,
                'is_active' => true,
            ],
            [
                'key' => 'on_loan',
                'label' => 'On Loan',
                'value' => 2353,
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($statistics as $stat) {
            Statistic::create($stat);
        }
    }
}
