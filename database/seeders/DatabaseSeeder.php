<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Domains\Characters\Models\Character;
use App\Domains\Enemies\Models\Enemy;
use App\Domains\Containers\Models\Container;
use App\Domains\Locations\Models\Location;
use App\Models\Road;
use App\Models\Transition;
use App\Domains\Items\Models\Item;
use App\Models\Property;
use App\Domains\Modifiers\Models\Modifier;

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
            'password' => 'Dev.201095',
            'is_admin' => true
        ]);

        User::create([
            'login' => 'user',
            'email' => 'user@admin.ru',
            'password' => 'Dev.201095'
        ]);

        User::create([
            'login' => 'guest',
            'email' => 'guest@admin.ru',
            'password' => 'Dev.201095'
        ]);

        // Загрузка предметов
        $itemsFileNames = ['armor', 'weapons', 'equipment', 'components', 'food', 'resources', 'entities'];
        foreach ($itemsFileNames as $itemsFileName) {
            $items = json_decode(File::get(database_path("data/items/{$itemsFileName}.json")), true);
            foreach ($items as $item) {
                Item::create($item);
            }
        }

        // Загрузка врагов
        $enemiesFileNames = ['animals', 'humans'];
        foreach ($enemiesFileNames as $enemiesFileName) {
            $enemies = json_decode(File::get(database_path("data/enemies/{$enemiesFileName}.json")), true);
            foreach ($enemies as $enemy) {
                Enemy::create($enemy);
            }
        }

        // Загрузка объектов
        $containersFileNames = ['treasure', 'corpses', 'nature'];
        foreach ($containersFileNames as $containersFileName) {
            $containers = json_decode(File::get(database_path("data/containers/{$containersFileName}.json")), true);
            foreach ($containers as $container) {
                Container::create($container);
            }
        }

        // Загрузка локаций
        $locationsFileNames = ['junior', 'middle', 'senior'];
        foreach ($locationsFileNames as $locationsFileName) {
            $locations = json_decode(File::get(database_path("data/locations/{$locationsFileName}.json")), true);
            foreach ($locations as $location) {
                Location::create($location);
            }
        }

        // Загрузка дорог
        $roads = json_decode(File::get(database_path('data/locations/roads.json')), true);
        foreach ($roads as $road) {
            Road::create($road);
        }

        // Загрузка модификаторов
        $modifiersFileNames = ['action', 'attribute', 'defence', 'damage'];
        foreach ($modifiersFileNames as $modifiersFileName) {
            $modifiers = json_decode(File::get(database_path("data/modifiers/{$modifiersFileName}.json")), true);
            foreach ($modifiers as $modifier) {
                Modifier::create($modifier);
            }
        }
    }
}
