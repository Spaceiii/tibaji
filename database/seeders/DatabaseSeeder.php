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
        ReservationItem::truncate();
        Reservation::truncate();
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
        
        // Créer des licenses avec différents statuts
        $clients = User::where('role', 'client')->get();
        
        // Quelques licenses approuvées
        License::factory()->count(5)->approved()->create([
            'user_id' => $clients->random()->id,
        ]);
        
        // Quelques licenses en attente
        License::factory()->count(3)->pending()->create([
            'user_id' => $clients->random()->id,
        ]);
        
        // Une license rejetée
        License::factory()->count(1)->rejected()->create([
            'user_id' => $clients->random()->id,
        ]);
        
        // Une license expirée
        License::factory()->count(1)->expired()->approved()->create([
            'user_id' => $clients->random()->id,
        ]);

        // Créer des réservations de test
        $clients = User::where('role', 'client')->get();
        
        foreach ($clients->take(5) as $client) {
            // Créer 1-3 réservations par client
            $reservationCount = rand(1, 3);
            
            for ($i = 0; $i < $reservationCount; $i++) {
                $reservation = Reservation::factory()->create([
                    'user_id' => $client->id,
                ]);

                // Ajouter 1-4 items par réservation
                $itemCount = rand(1, 4);
                
                for ($j = 0; $j < $itemCount; $j++) {
                    // 50% chance d'être une arme ou un accessoire
                    if (rand(0, 1)) {
                        ReservationItem::factory()->weapon()->create([
                            'reservation_id' => $reservation->id,
                        ]);
                    } else {
                        ReservationItem::factory()->accessory()->create([
                            'reservation_id' => $reservation->id,
                        ]);
                    }
                }

                // Recalculer le total de la réservation
                $reservation->update([
                    'total_amount' => $reservation->calculateTotal(),
                ]);
            }
        }
    }
}
