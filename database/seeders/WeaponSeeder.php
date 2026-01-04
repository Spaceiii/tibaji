<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Weapon;
use App\Models\WeaponType;

class WeaponSeeder extends Seeder
{
    public function run(): void
    {
        $pistolet = WeaponType::firstOrCreate(['name' => 'Pistolet'])->id;
        $carabine = WeaponType::firstOrCreate(['name' => 'Carabine'])->id;
        $fusilPompe = WeaponType::firstOrCreate(['name' => 'Fusil à Pompe'])->id;
        $fusilPrec = WeaponType::firstOrCreate(['name' => 'Fusil de précision'])->id;
        $defense = WeaponType::firstOrCreate(['name' => 'Arme de défense'])->id;
        $poudreNoire = WeaponType::firstOrCreate(['name' => 'Arme à poudre noire'])->id;
        $loisir = WeaponType::firstOrCreate(['name' => 'Arme de loisir'])->id;

        $weapons = [
            // --- CATÉGORIE B ---
            [
                'brand' => 'Glock',
                'model' => '17 Gen 5',
                'description' => 'La référence mondiale des pistolets de service. Fiabilité absolue, canon Marksman pour une précision accrue, préhension améliorée sans empreintes de doigts. Livré en mallette avec 2 chargeurs.',
                'caliber' => '9mm PARA',
                'category' => 'B',
                'serial_number' => 'GLK-17-5589',
                'price' => 750.00,
                'quantity' => 12,
                'weapon_type_id' => $pistolet,
                'image' => 'weapons/glock17.jpg', // Place l'image dans storage/app/public/weapons/
            ],
            [
                'brand' => 'CZ',
                'model' => 'Shadow 2 Urban Grey',
                'description' => 'L\'arme reine du tir sportif (IPSC). Poids élevé sur l\'avant pour absorber le recul, détente match ultra-nette, visée fibre optique réglable. Une machine à points redoutable.',
                'caliber' => '9mm PARA',
                'category' => 'B',
                'serial_number' => 'CZ-S2-9988',
                'price' => 1450.00,
                'quantity' => 5,
                'weapon_type_id' => $pistolet,
                'image' => 'weapons/czshadow2.jpg',
            ],
            [
                'brand' => 'Smith & Wesson',
                'model' => '686 Plus 4"',
                'description' => 'Le revolver légendaire en acier inoxydable. Canon de 4 pouces polyvalent, barillet haute capacité de 7 coups. Capable de tirer du .38 Special pour l\'entraînement doux.',
                'caliber' => '.357 Magnum',
                'category' => 'B',
                'serial_number' => 'SW-686-7741',
                'price' => 1290.00,
                'quantity' => 3,
                'weapon_type_id' => $pistolet,
                'image' => 'weapons/sw686.jpg',
            ],
            [
                'brand' => 'Daniel Defense',
                'model' => 'DDM4 V7',
                'description' => 'Le sommet de la plateforme AR-15. Garde-main M-LOK flottant de 15 pouces, canon forgé à froid. Précision et fiabilité militaire pour le tir dynamique (TSV).',
                'caliber' => '.223 Rem',
                'category' => 'B',
                'serial_number' => 'DD-M4-1123',
                'price' => 2600.00,
                'quantity' => 2,
                'weapon_type_id' => $carabine,
                'image' => 'weapons/ddm4v7.jpg',
            ],
            [
                'brand' => 'Benelli',
                'model' => 'M4 Super 90',
                'description' => 'Le fusil de combat des US Marines. Système d\'emprunt de gaz A.R.G.O auto-nettoyant. Crosse télescopique et ghost ring sights. Une fiabilité à toute épreuve.',
                'caliber' => '12/76',
                'category' => 'B',
                'serial_number' => 'BEN-M4-0012',
                'price' => 2800.00,
                'quantity' => 0, // Pour tester l'affichage "Rupture"
                'weapon_type_id' => $fusilPompe,
                'image' => 'weapons/benellim4.jpg',
            ],

            // --- CATÉGORIE C ---
            [
                'brand' => 'Tikka',
                'model' => 'T3x TAC A1',
                'description' => 'Châssis poutre en aluminium aérospatial, crosse pliante, canon lourd fileté. La meilleure carabine "out of the box" pour le TLD (Tir Longue Distance) jusqu\'à 800m.',
                'caliber' => '.308 Win',
                'category' => 'C',
                'serial_number' => 'TIK-T3-3088',
                'price' => 2450.00,
                'quantity' => 4,
                'weapon_type_id' => $carabine,
                'image' => 'weapons/tikkat3x.jpg',
            ],
            [
                'brand' => 'Ruger',
                'model' => 'Precision Rimfire',
                'description' => 'L\'entraînement tactique à petit prix. Châssis réglable type AR, rail Picatinny incliné, canon lourd. Idéal pour le 50-100 mètres et le plinking.',
                'caliber' => '.22 LR',
                'category' => 'C',
                'serial_number' => 'RUG-22-5566',
                'price' => 650.00,
                'quantity' => 15,
                'weapon_type_id' => $carabine,
                'image' => 'weapons/ruger22.jpg',
            ],
            [
                'brand' => 'Browning',
                'model' => 'Maral SF Composite',
                'description' => 'Carabine à réarmement linéaire ultra-rapide. Système Quick Reloading. Crosse composite noire robuste pour la battue dans les traques difficiles.',
                'caliber' => '.30-06 Sprg',
                'category' => 'C',
                'serial_number' => 'BRO-MA-3321',
                'price' => 1850.00,
                'quantity' => 6,
                'weapon_type_id' => $carabine,
                'image' => 'weapons/browningmaral.jpg',
            ],
        ];

        foreach ($weapons as $weapon) {
            Weapon::create($weapon);
        }
    }
}
