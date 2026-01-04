<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WeaponType;
use App\Models\AccessoryType;
use App\Models\Weapon;
use App\Models\Accessory;
use App\Models\License;
use App\Models\Reservation;
use App\Models\ReservationItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. NETTOYAGE COMPLET
        Schema::disableForeignKeyConstraints();
        ReservationItem::truncate();
        Reservation::truncate();
        License::truncate();
        Weapon::truncate();
        WeaponType::truncate();
        Accessory::truncate();
        AccessoryType::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();


        $admin = User::factory()->create([
            'name' => 'Admin Tibaji',
            'email' => 'admin@tibaji.fr',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        $clientValide = User::factory()->create([
            'name' => 'Client Validé',
            'email' => 'client@tibaji.fr',
            'role' => 'client',
            'password' => bcrypt('password'),
        ]);

        $clientPending = User::factory()->create([
            'name' => 'Client En Attente',
            'email' => 'pending@tibaji.fr',
            'role' => 'client',
            'password' => bcrypt('password'),
        ]);

        $clientRejected = User::factory()->create([
            'name' => 'Client Refusé',
            'email' => 'rejected@tibaji.fr',
            'role' => 'client',
            'password' => bcrypt('password'),
        ]);

        $clientNew = User::factory()->create([
            'name' => 'Nouveau Client',
            'email' => 'new@tibaji.fr',
            'role' => 'client',
            'password' => bcrypt('password'),
        ]);

        $this->call([
            WeaponSeeder::class,
            AccessorySeeder::class,
        ]);


        // Licence VALIDÉE pour le client principal
        License::create([
            'user_id' => $clientValide->id,
            'license_number' => '2024-VALID-01',
            'level' => 'B', // Accès total
            'expiration_date' => now()->addYear(),
            'file_path' => 'licenses/sample.jpg', // Chemin fictif pour le test
            'status' => 'approved',
            'submitted_at' => now()->subDays(2),
            'verified_at' => now()->subDay(),
        ]);

        // Licence EN ATTENTE
        License::create([
            'user_id' => $clientPending->id,
            'license_number' => '2024-PEND-02',
            'level' => 'C',
            'expiration_date' => now()->addMonths(6),
            'file_path' => 'licenses/sample.jpg',
            'status' => 'pending',
            'submitted_at' => now()->subHours(4),
        ]);

        // Licence REFUSÉE
        License::create([
            'user_id' => $clientRejected->id,
            'license_number' => '2024-REJ-03',
            'level' => 'C',
            'expiration_date' => now()->addMonths(6),
            'file_path' => 'licenses/sample.jpg',
            'status' => 'rejected',
            'submitted_at' => now()->subDays(5),
            'verified_at' => now()->subDays(4),
            'admin_comment' => 'Document illisible ou périmé. Merci de renvoyer un scan net.',
        ]);

        $weapon = Weapon::first();
        $accessory = Accessory::first();
    }
}
