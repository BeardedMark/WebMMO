<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Character;
use App\Models\Location;
use App\Models\Road;
use App\Models\Transition;
use App\Models\Item;

use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'login' => 'admin',
            'email' => 'admin@admin.ru',
            'password' => 'Dev.201095'
        ]);

        // Загрузка предметов
        $items = json_decode(File::get(database_path('data/items.json')), true);
        foreach ($items as $item) {
            Item::create($item);
        }

        // Загрузка локаций
        $locationData = json_decode(File::get(database_path('data/locations.json')), true);
        $locations = [];

        foreach ($locationData as $index => $location) {
            $locations[$index + 1] = Location::create($location);
        }

        // Загрузка дорог
        $roads = json_decode(File::get(database_path('data/roads.json')), true);
        foreach ($roads as [$from, $to]) {
            Road::create([
                'from_location_id' => $locations[$from]->id,
                'to_location_id' => $locations[$to]->id,
                'size' => 1
            ]);
        }
    }
}
