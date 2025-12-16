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
                'address' => 'H36H+F88, Caruncho Ave, Pasig, 1600 Metro Manila',
                'phone' => 'N/A',
                'website' => 'https://web.facebook.com/search/top/?q=pasig+city+library',
                'contact_person' => 'Library Administrator',
                'position' => 'Administrator',
                'logo' => 'images/PCLLRC.png',
                'is_active' => true,
            ],
            [
                'name' => 'Pamantasan ng Lungsod ng Pasig',
                'acronym' => 'PLNP',
                'address' => '12-B Alcalde Jose, Pasig, 1600 Metro Manila',
                'phone' => 'N/A',
                'website' => 'https://plpasig.edu.ph/campus-life/library-services/',
                'contact_person' => 'Library Administrator',
                'position' => 'Administrator',
                'logo' => 'images/PLNP.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Pasig City Institute of Science and Technology',
                'acronym' => 'PCIST',
                'address' => 'Kaayusan St., Brgy. Manggahan, Pasig City',
                'phone' => 'N/A',
                'website' => 'https://web.facebook.com/search/top/?q=pcist',
                'contact_person' => 'Library Administrator',
                'position' => 'Administrator',
                'logo' => 'images/PCIST logo2.png',
                'is_active' => true,
            ],
            [
                'name' => 'Pasig City Science High School',
                'acronym' => 'PCSHS',
                'address' => 'F. Legaspi St. Rainforest Park, Pasig, 1600',
                'phone' => 'N/A',
                'website' => 'https://pasigcitysciencehs.wordpress.com/',
                'contact_person' => 'Library Administrator',
                'position' => 'Administrator',
                'logo' => 'images/PCSHS logo.png',
                'is_active' => true,
            ],
            [
                'name' => 'Pasig City Hall Library',
                'acronym' => 'PCHLib',
                'address' => 'Caruncho Ave, Barangay San Nicolas, Pasig, 1600 Metro Manila',
                'phone' => 'N/A',
                'website' => 'https://pasigcityhalllibrary.wordpress.com/',
                'contact_person' => 'Library Administrator',
                'position' => 'Administrator',
                'logo' => 'images/Pasig City Logo.png',
                'is_active' => true,
            ],
        ];

        foreach ($libraries as $library) {
            Library::create($library);
        }
    }
}
