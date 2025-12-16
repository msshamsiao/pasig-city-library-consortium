<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'user' => [
                    'name' => 'Juan Dela Cruz',
                    'email' => 'juan.delacruz@gmail.com',
                    'password' => Hash::make('password123'),
                    'role' => 'borrower',
                ],
                'member' => [
                    'member_id' => 'PCLLRC-2025-001',
                    'first_name' => 'Juan',
                    'middle_name' => 'Santos',
                    'last_name' => 'Dela Cruz',
                    'email' => 'juan.delacruz@gmail.com',
                    'phone' => '+63 912 345 6789',
                    'address' => '123 Rizal Street, Barangay Kapitolyo',
                    'city' => 'Pasig City',
                    'province' => 'Metro Manila',
                    'postal_code' => '1600',
                    'birth_date' => '1990-05-15',
                    'gender' => 'Male',
                    'member_type' => 'regular',
                    'status' => 'active',
                    'library_branch' => 'PCLLRC',
                    'membership_date' => '2024-01-10',
                    'expiry_date' => '2025-01-10',
                ],
            ],
            [
                'user' => [
                    'name' => 'Maria Santos',
                    'email' => 'maria.santos@yahoo.com',
                    'password' => Hash::make('password123'),
                    'role' => 'borrower',
                ],
                'member' => [
                    'member_id' => 'PLNP-2025-001',
                    'first_name' => 'Maria',
                    'middle_name' => 'Garcia',
                    'last_name' => 'Santos',
                    'email' => 'maria.santos@yahoo.com',
                    'phone' => '+63 923 456 7890',
                    'address' => '456 Ortigas Avenue, Barangay San Antonio',
                    'city' => 'Pasig City',
                    'province' => 'Metro Manila',
                    'postal_code' => '1605',
                    'birth_date' => '1985-08-22',
                    'gender' => 'Female',
                    'member_type' => 'regular',
                    'status' => 'active',
                    'library_branch' => 'PLNP',
                    'membership_date' => '2024-02-15',
                    'expiry_date' => '2025-02-15',
                ],
            ],
            [
                'user' => [
                    'name' => 'Pedro Reyes',
                    'email' => 'pedro.reyes@outlook.com',
                    'password' => Hash::make('password123'),
                    'role' => 'borrower',
                ],
                'member' => [
                    'member_id' => 'PCIST-2025-001',
                    'first_name' => 'Pedro',
                    'middle_name' => 'Lopez',
                    'last_name' => 'Reyes',
                    'email' => 'pedro.reyes@outlook.com',
                    'phone' => '+63 945 678 9012',
                    'address' => '789 Shaw Boulevard, Barangay Wack-Wack',
                    'city' => 'Pasig City',
                    'province' => 'Metro Manila',
                    'postal_code' => '1602',
                    'birth_date' => '2000-03-10',
                    'gender' => 'Male',
                    'member_type' => 'student',
                    'status' => 'active',
                    'library_branch' => 'PCIST',
                    'membership_date' => '2024-06-20',
                    'expiry_date' => '2025-06-20',
                ],
            ],
            [
                'user' => [
                    'name' => 'Ana Gonzales',
                    'email' => 'ana.gonzales@gmail.com',
                    'password' => Hash::make('password123'),
                    'role' => 'borrower',
                ],
                'member' => [
                    'member_id' => 'PCSHS-2025-001',
                    'first_name' => 'Ana',
                    'middle_name' => 'Cruz',
                    'last_name' => 'Gonzales',
                    'email' => 'ana.gonzales@gmail.com',
                    'phone' => '+63 956 789 0123',
                    'address' => '321 Caruncho Avenue, Barangay Pineda',
                    'city' => 'Pasig City',
                    'province' => 'Metro Manila',
                    'postal_code' => '1607',
                    'birth_date' => '1978-11-30',
                    'gender' => 'Female',
                    'member_type' => 'senior',
                    'status' => 'active',
                    'library_branch' => 'PCSHS',
                    'membership_date' => '2023-09-05',
                    'expiry_date' => '2025-09-05',
                ],
            ],
            [
                'user' => [
                    'name' => 'Carlos Mendoza',
                    'email' => 'carlos.mendoza@gmail.com',
                    'password' => Hash::make('password123'),
                    'role' => 'borrower',
                ],
                'member' => [
                    'member_id' => 'PLNP-2025-002',
                    'first_name' => 'Carlos',
                    'middle_name' => 'Torres',
                    'last_name' => 'Mendoza',
                    'email' => 'carlos.mendoza@gmail.com',
                    'phone' => '+63 967 890 1234',
                    'address' => '654 E. Rodriguez Jr. Avenue, Barangay Ugong',
                    'city' => 'Pasig City',
                    'province' => 'Metro Manila',
                    'postal_code' => '1604',
                    'birth_date' => '1982-07-18',
                    'gender' => 'Male',
                    'member_type' => 'faculty',
                    'status' => 'active',
                    'library_branch' => 'PLNP',
                    'membership_date' => '2024-03-12',
                    'expiry_date' => '2025-03-12',
                ],
            ],
            [
                'user' => [
                    'name' => 'Lucia Flores',
                    'email' => 'lucia.flores@yahoo.com',
                    'password' => Hash::make('password123'),
                    'role' => 'borrower',
                ],
                'member' => [
                    'member_id' => 'PCHL-2025-001',
                    'first_name' => 'Lucia',
                    'middle_name' => 'Ramos',
                    'last_name' => 'Flores',
                    'email' => 'lucia.flores@yahoo.com',
                    'phone' => '+63 978 901 2345',
                    'address' => '987 Meralco Avenue, Barangay Rosario',
                    'city' => 'Pasig City',
                    'province' => 'Metro Manila',
                    'postal_code' => '1609',
                    'birth_date' => '1995-12-05',
                    'gender' => 'Female',
                    'member_type' => 'regular',
                    'status' => 'active',
                    'library_branch' => 'PCHL',
                    'membership_date' => '2024-07-22',
                    'expiry_date' => '2025-07-22',
                ],
            ],
            [
                'user' => [
                    'name' => 'Roberto Silva',
                    'email' => 'roberto.silva@outlook.com',
                    'password' => Hash::make('password123'),
                    'role' => 'borrower',
                ],
                'member' => [
                    'member_id' => 'PCIST-2025-002',
                    'first_name' => 'Roberto',
                    'middle_name' => 'Martinez',
                    'last_name' => 'Silva',
                    'email' => 'roberto.silva@outlook.com',
                    'phone' => '+63 989 012 3456',
                    'address' => '246 Julia Vargas Avenue, Barangay Caniogan',
                    'city' => 'Pasig City',
                    'province' => 'Metro Manila',
                    'postal_code' => '1603',
                    'birth_date' => '1998-04-25',
                    'gender' => 'Male',
                    'member_type' => 'student',
                    'status' => 'active',
                    'library_branch' => 'PCIST',
                    'membership_date' => '2024-08-10',
                    'expiry_date' => '2025-08-10',
                ],
            ],
            [
                'user' => [
                    'name' => 'Teresa Morales',
                    'email' => 'teresa.morales@gmail.com',
                    'password' => Hash::make('password123'),
                    'role' => 'borrower',
                ],
                'member' => [
                    'member_id' => 'PCLLRC-2025-002',
                    'first_name' => 'Teresa',
                    'middle_name' => 'Diaz',
                    'last_name' => 'Morales',
                    'email' => 'teresa.morales@gmail.com',
                    'phone' => '+63 920 123 4567',
                    'address' => '135 C. Raymundo Avenue, Barangay Maybunga',
                    'city' => 'Pasig City',
                    'province' => 'Metro Manila',
                    'postal_code' => '1606',
                    'birth_date' => '1975-09-14',
                    'gender' => 'Female',
                    'member_type' => 'senior',
                    'status' => 'active',
                    'library_branch' => 'PCLLRC',
                    'membership_date' => '2023-11-18',
                    'expiry_date' => '2025-11-18',
                ],
            ],
            [
                'user' => [
                    'name' => 'Miguel Rivera',
                    'email' => 'miguel.rivera@yahoo.com',
                    'password' => Hash::make('password123'),
                    'role' => 'borrower',
                ],
                'member' => [
                    'member_id' => 'PCSHS-2025-002',
                    'first_name' => 'Miguel',
                    'middle_name' => 'Castillo',
                    'last_name' => 'Rivera',
                    'email' => 'miguel.rivera@yahoo.com',
                    'phone' => '+63 931 234 5678',
                    'address' => '852 F. Manalo Street, Barangay Bambang',
                    'city' => 'Pasig City',
                    'province' => 'Metro Manila',
                    'postal_code' => '1608',
                    'birth_date' => '1992-06-08',
                    'gender' => 'Male',
                    'member_type' => 'regular',
                    'status' => 'active',
                    'library_branch' => 'PCSHS',
                    'membership_date' => '2024-04-30',
                    'expiry_date' => '2025-04-30',
                ],
            ],
            [
                'user' => [
                    'name' => 'Rosa Fernandez',
                    'email' => 'rosa.fernandez@gmail.com',
                    'password' => Hash::make('password123'),
                    'role' => 'borrower',
                ],
                'member' => [
                    'member_id' => 'PLNP-2025-003',
                    'first_name' => 'Rosa',
                    'middle_name' => 'Navarro',
                    'last_name' => 'Fernandez',
                    'email' => 'rosa.fernandez@gmail.com',
                    'phone' => '+63 942 345 6789',
                    'address' => '741 Marcos Highway, Barangay Dela Paz',
                    'city' => 'Pasig City',
                    'province' => 'Metro Manila',
                    'postal_code' => '1610',
                    'birth_date' => '1988-02-20',
                    'gender' => 'Female',
                    'member_type' => 'faculty',
                    'status' => 'active',
                    'library_branch' => 'PLNP',
                    'membership_date' => '2024-05-15',
                    'expiry_date' => '2025-05-15',
                ],
            ],
        ];

        foreach ($members as $data) {
            // Add member_id to user data
            $data['user']['member_id'] = $data['member']['member_id'];
            
            // Create user
            $user = User::create($data['user']);
            
            // Create member linked to user
            $data['member']['user_id'] = $user->id;
            Member::create($data['member']);
        }

        $this->command->info('Created 10 members with associated user accounts.');
    }
}
