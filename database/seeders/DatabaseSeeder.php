<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WeaponType;
use App\Models\AccessoryType;
use App\Models\Weapon;
use App\Models\Accessory;
use App\Models\License;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        */

        // reset and remove foreign key constraints
        Schema::disableForeignKeyConstraints();
        WeaponType::truncate();
        AccessoryType::truncate();
        Weapon::truncate();
        Accessory::truncate();
        License::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        WeaponType::factory()->createMany([
            ['name' => 'Pistolet'],
            ['name' => 'Carabine'],
            ['name' => 'Fusil à pompe'],
            ['name' => 'Fusil de précision'],
        ]);

        // Créer l'admin
        User::factory()->create([
            'name' => 'Admin Tibaji',
            'email' => 'admin@tibaji.fr',
            'role' => 'admin',
        ]);

        // Créer un client de test
        User::factory()->create([
            'name' => 'Client Test',
            'email' => 'client@tibaji.fr',
            'role' => 'client',
        ]);

        // Créer d'autres utilisateurs
        User::factory(8)->create();

        AccessoryType::factory()->createMany([
            ['name' => 'Lunette'],
            ['name' => 'Silencieux'],
            ['name' => 'Poignée'],
            ['name' => 'Chargeur'],
            ['name' => 'Treillis']
        ]);

        Weapon::factory(20)->create();
        Accessory::factory(30)->create();
        License::factory(8)->create();
    }
}
