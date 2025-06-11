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
            'email' => 'admin@remfut.ru',
            'password' => 'Dev.201095',
            'is_admin' => true
        ]);

        User::create([
            'login' => 'user',
            'email' => 'user@remfut.ru',
            'password' => 'Dev.201095'
        ]);

        User::create([
            'login' => 'guest',
            'email' => 'guest@remfut.ru',
            'password' => 'Dev.201095'
        ]);

        User::create([
            'login' => 'user1',
            'email' => 'user1@remfut.ru',
            'password' => 'Dev.200095'
        ]);

        User::create([
            'login' => 'user2',
            'email' => 'user2@remfut.ru',
            'password' => 'Dev.001095'
        ]);

        User::create([
            'login' => 'user3',
            'email' => 'user3@remfut.ru',
            'password' => 'Dev.203095'
        ]);

        User::create([
            'login' => 'user4',
            'email' => 'user4@remfut.ru',
            'password' => 'Dev.201495'
        ]);

        User::create([
            'login' => 'user5',
            'email' => 'user5@remfut.ru',
            'password' => 'Dev.201005'
        ]);

        User::create([
            'login' => 'user6',
            'email' => 'user6@remfut.ru',
            'password' => 'Dev.201090'
        ]);

        // Загрузка предметов
        $itemsFileNames = ['armor','clothes', 'weapons', 'equipment', 'components', 'food', 'resources', 'entities'];
        foreach ($itemsFileNames as $itemsFileName) {
            $items = json_decode(File::get(database_path("data/items/{$itemsFileName}.json")), true);
            foreach ($items as $item) {
                Item::create($item);
            }
        }

        // Загрузка врагов
        $enemiesFileNames = ['animals'];
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
