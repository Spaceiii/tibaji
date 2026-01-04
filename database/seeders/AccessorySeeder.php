<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accessory;
use App\Models\AccessoryType;

class AccessorySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Création des Catégories
        $optique = AccessoryType::firstOrCreate(['name' => 'Optique'])->id;
        $munition = AccessoryType::firstOrCreate(['name' => 'Munition'])->id;
        $equipement = AccessoryType::firstOrCreate(['name' => 'Équipement'])->id;
        $protection = AccessoryType::firstOrCreate(['name' => 'Protection'])->id;

        $accessories = [
            // --- OPTIQUES ---
            [
                'name' => 'Holosun HS510C',
                'description' => "Viseur reflex ouvert avec réticule commutable (Point 2 MOA / Cercle 65 MOA).\n\nConception robuste en titane, autonomie solaire et système Shake Awake. L'optique idéale pour votre AR-15 ou PCC.",
                'price' => 359.00,
                'quantity' => 8,
                'accessory_type_id' => $optique,
                'image' => 'accessories/holosun510c.jpg',
            ],
            [
                'name' => 'Vortex Strike Eagle 1-6x24',
                'description' => "Lunette de visée LPVO (Low Power Variable Optic) polyvalente.\n\nGrossissement réel de 1x pour le tir rapide et jusqu'à 6x pour les cibles éloignées. Réticule AR-BDC3 éclairé. Garantie à vie Vortex VIP.",
                'price' => 429.00,
                'quantity' => 5,
                'accessory_type_id' => $optique,
                'image' => 'accessories/vortex1-6.jpg',
            ],

            // --- MUNITIONS ---
            [
                'name' => 'Geco 9mm Luger 124gr (x50)',
                'description' => "Boîte de 50 cartouches.\n\nOgive FMJ (Full Metal Jacket) de 124 grains. La munition d'entraînement par excellence, offrant un excellent rapport qualité/prix et une propreté de tir reconnue.",
                'price' => 14.50,
                'quantity' => 200, // Gros stock
                'accessory_type_id' => $munition,
                'image' => 'accessories/geco9mm.jpg',
            ],
            [
                'name' => 'Fiocchi .223 Rem 55gr (x50)',
                'description' => "Munitions pour fusil semi-automatique type AR-15.\n\nOgive FMJ 55 grains. Douille laiton. Précision et fiabilité pour le tir sportif de vitesse (TSV) ou la cible.",
                'price' => 28.90,
                'quantity' => 150,
                'accessory_type_id' => $munition,
                'image' => 'accessories/fiocchi223.jpg',
            ],
            [
                'name' => 'CCI Standard Velocity .22LR (x50)',
                'description' => "La référence absolue pour le tir de précision en calibre .22 Long Rifle.\n\nVitesse subsonique (326 m/s) pour une précision maximale et un bruit réduit. Idéale pour pistolet et carabine.",
                'price' => 5.50,
                'quantity' => 500,
                'accessory_type_id' => $munition,
                'image' => 'accessories/cci22.jpg',
            ],

            // --- ÉQUIPEMENT ---
            [
                'name' => 'Magpul PMAG 30 AR/M4 Gen M3',
                'description' => "Chargeur polymère 30 coups pour plateforme AR-15.\n\nNouvelle génération M3 plus robuste, compatible avec une large gamme d'armes (HK416, SCAR, etc.). Fenêtre de visualisation du niveau de munitions.",
                'price' => 24.90,
                'quantity' => 40,
                'accessory_type_id' => $equipement,
                'image' => 'accessories/pmag30.jpg',
            ],
            [
                'name' => 'Olight Baldr Pro R',
                'description' => "Lampe tactique avec laser vert intégré.\n\nPuissance de 1350 Lumens. Montage rapide sur rail Picatinny ou Glock. Rechargeable par USB magnétique. Indispensable pour le home defense.",
                'price' => 169.90,
                'quantity' => 10,
                'accessory_type_id' => $equipement,
                'image' => 'accessories/olightbaldr.jpg',
            ],

            // --- PROTECTION ---
            [
                'name' => 'Casque 3M Peltor SportTac',
                'description' => "Protection auditive électronique intelligente.\n\nAmplifie les sons faibles (voix) et coupe instantanément les détonations nocives. Coques interchangeables (Vert/Orange). Le best-seller des stands de tir.",
                'price' => 149.00,
                'quantity' => 15,
                'accessory_type_id' => $protection,
                'image' => 'accessories/peltor.jpg',
            ],
            [
                'name' => 'Lunettes Oakley SI Ballistic M Frame',
                'description' => "Lunettes de protection balistique certifiées.\n\nVerres haute définition, monture légère et résistante. Protection UV 100%. Utilisées par les forces armées du monde entier.",
                'price' => 180.00,
                'quantity' => 6,
                'accessory_type_id' => $protection,
                'image' => 'accessories/oakley.jpg',
            ],
        ];

        foreach ($accessories as $accessory) {
            Accessory::create($accessory);
        }
    }
}
