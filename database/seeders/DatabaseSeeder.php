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
        // Seed Libraries
        $this->seedLibraries();
        
        // Seed Activities
        $this->seedActivities();
        
        // Seed Statistics
        $this->seedStatistics();
    }

    /**
     * Seed libraries data.
     */
    private function seedLibraries()
    {
        $libraries = [
            [
                'name' => 'Pasig City Library',
                'type' => 'Public',
                'address' => '123 Main Street, Pasig City, Metro Manila 1600',
                'phone' => '+63 (02) 8641-1234',
                'website' => 'www.pasigcitylibrary.gov.ph',
                'contact_person' => 'Maria Santos',
                'position' => 'Head Librarian',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'PLP Library',
                'type' => 'University',
                'address' => '456 Education Avenue, Pasig City, Metro Manila 1601',
                'phone' => '+63 (02) 8642-5678',
                'website' => 'www.plp.edu.ph/library',
                'contact_person' => 'Dr. Juan Cruz',
                'position' => 'Library Director',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'PCIST Library',
                'type' => 'Technical',
                'address' => '789 Technology Drive, Pasig City, Metro Manila 1602',
                'phone' => '+63 (02) 8643-9012',
                'website' => 'www.pcist.edu.ph/library',
                'contact_person' => 'Engr. Ana Rodriguez',
                'position' => 'Technical Services Librarian',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'PSHS Library',
                'type' => 'High School',
                'address' => '321 Science Boulevard, Pasig City, Metro Manila 1603',
                'phone' => '+63 (02) 8644-3456',
                'website' => 'www.pshs.edu.ph/library',
                'contact_person' => 'Dr. Roberto Garcia',
                'position' => 'School Librarian',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'RHS Library',
                'type' => 'High School',
                'address' => '654 Rizal Street, Pasig City, Metro Manila 1604',
                'phone' => '+63 (02) 8645-7890',
                'website' => 'www.rhs.edu.ph/library',
                'contact_person' => 'Mrs. Carmen Dela Cruz',
                'position' => 'Library Coordinator',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'name' => 'City Hall Library',
                'type' => 'Government',
                'address' => 'Pasig City Hall, Capitol Avenue, Pasig City, Metro Manila 1605',
                'phone' => '+63 (02) 8646-1234',
                'website' => 'www.pasigcity.gov.ph/library',
                'contact_person' => 'Atty. Jose Mercado',
                'position' => 'Information Officer',
                'is_active' => true,
                'order' => 6,
            ],
        ];

        foreach ($libraries as $library) {
            Library::create($library);
        }
    }

    /**
     * Seed activities data.
     */
    private function seedActivities()
    {
        $activities = [
            [
                'activity_date' => '2025-01-15',
                'title' => 'New Digital Collection Launch',
                'description' => 'We are excited to announce the launch of our new digital collection featuring over 5,000 e-books, audiobooks, and digital magazines. This collection includes academic journals, fiction and non-fiction titles, and specialized research materials.',
                'has_image' => true,
                'category' => 'announcement',
                'is_published' => true,
            ],
            [
                'activity_date' => '2025-01-10',
                'title' => 'Reading Program for Children',
                'description' => 'Join our monthly reading program designed for children ages 5-12. Every Saturday from 10 AM to 12 PM, we host interactive storytelling sessions, book discussions, and creative writing workshops.',
                'has_image' => false,
                'category' => 'program',
                'is_published' => true,
            ],
            [
                'activity_date' => '2025-01-05',
                'title' => 'Library Hours Extended',
                'description' => 'Starting February 1st, all consortium libraries will extend their operating hours. Monday through Friday: 7 AM to 10 PM, Saturday: 8 AM to 8 PM, Sunday: 10 AM to 6 PM.',
                'has_image' => false,
                'category' => 'announcement',
                'is_published' => true,
            ],
            [
                'activity_date' => '2024-12-28',
                'title' => 'Research Workshop Series',
                'description' => 'Learn advanced research techniques in our monthly workshop series. Topics include database navigation, citation management, academic writing, and digital literacy skills for students and professionals.',
                'has_image' => true,
                'category' => 'workshop',
                'is_published' => true,
            ],
            [
                'activity_date' => '2024-12-20',
                'title' => 'Holiday Reading Challenge',
                'description' => 'Participate in our annual holiday reading challenge! Read at least 5 books during the holiday season and win prizes. Challenge runs from December 20 to January 15.',
                'has_image' => false,
                'category' => 'event',
                'is_published' => true,
            ],
            [
                'activity_date' => '2024-12-15',
                'title' => 'Author Meet and Greet',
                'description' => 'Meet renowned Filipino authors in our special series of author talks and book signings. Join us for intimate discussions about their writing process and latest works.',
                'has_image' => false,
                'category' => 'event',
                'is_published' => true,
            ],
            [
                'activity_date' => '2024-12-10',
                'title' => 'Library Card Registration Drive',
                'description' => 'Free library card registration for all Pasig City residents! Visit any consortium library with a valid ID and proof of residency to get your card on the spot.',
                'has_image' => false,
                'category' => 'announcement',
                'is_published' => true,
            ],
            [
                'activity_date' => '2024-12-05',
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
