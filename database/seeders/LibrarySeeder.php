<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Library;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $libraries = [
            [
                'name' => 'Pasig City Library and Learning Resource Center',
                'acronym' => 'PCLLRC',
                'address' => 'Pasig City, Metro Manila',
                'phone' => 'N/A',
                'website' => 'https://web.facebook.com/search/top/?q=pasig+city+library',
                'contact_person' => 'Library Administrator',
                'position' => 'Administrator',
                'is_active' => true,
            ],
            [
                'name' => 'PLP - Pamantasan ng Lungsod ng Pasig',
                'acronym' => 'PLP',
                'address' => 'Pasig City, Metro Manila',
                'phone' => 'N/A',
                'website' => 'https://plpasig.edu.ph/campus-life/library-services/',
                'contact_person' => 'Library Administrator',
                'position' => 'Administrator',
                'is_active' => true,
            ],
            [
                'name' => 'Pasig City Institute of Science and Technology',
                'acronym' => 'PCIST',
                'address' => 'Pasig City, Metro Manila',
                'phone' => 'N/A',
                'website' => 'https://web.facebook.com/search/top/?q=pcist',
                'contact_person' => 'Library Administrator',
                'position' => 'Administrator',
                'is_active' => true,
            ],
            [
                'name' => 'Pasig City Science High School Library',
                'acronym' => 'PCSHS',
                'address' => 'Pasig City, Metro Manila',
                'phone' => 'N/A',
                'website' => 'https://pasigcitysciencehs.wordpress.com/',
                'contact_person' => 'Library Administrator',
                'position' => 'Administrator',
                'is_active' => true,
            ],
            [
                'name' => 'Pasig City Hall Library',
                'acronym' => 'PCHLib',
                'address' => 'Pasig City Hall, Metro Manila',
                'phone' => 'N/A',
                'website' => 'https://pasigcityhalllibrary.wordpress.com/',
                'contact_person' => 'Library Administrator',
                'position' => 'Administrator',
                'is_active' => true,
            ],
        ];

        foreach ($libraries as $library) {
            Library::create($library);
        }
    }
}
