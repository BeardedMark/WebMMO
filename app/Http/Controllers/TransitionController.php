<?php

namespace App\Http\Controllers;

use App\Models\Transition;
use Illuminate\Http\Request;

use App\Models\Character;
use App\Models\Location;
use App\Models\Item;

class TransitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentCharacter = auth()->user()->character;
        $currentLocation = $currentCharacter->currentLocation();
        $currentTransition = $currentCharacter->latestTransition;

        return view('transitions.index', compact('currentCharacter', 'currentLocation', 'currentTransition'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'to_location_id' => 'required|exists:locations,id',
        ]);

        $currentCharacter = auth()->user()->character;
        $fromLocation = $currentCharacter->currentLocation();
        $toLocation = Location::findOrFail($request->to_location_id);

        // Проверка, если персонаж в данный момент не может выполнять действия
        if ($currentCharacter->timeToNextAction() > 0) {
            return redirect()->back()->with('error', "Переход пока невозможен");
        }

        // Находим все доступные дороги для текущей локации
        $availableRoads = $currentCharacter->availableRoads();

        // Переменная для хранения найденной дороги
        $chosenRoad = null;

        // Ищем, есть ли дорога между текущей и целевой локацией
        foreach ($availableRoads as $road) {
            if (($road->from_location_id === $fromLocation->id && $road->to_location_id === $toLocation->id) ||
                ($road->from_location_id === $toLocation->id && $road->to_location_id === $fromLocation->id)
            ) {
                $chosenRoad = $road;
                break;
            }
        }

        // Если дорога не найдена, сообщаем об этом
        if (!$chosenRoad && $fromLocation != $toLocation) {
            return redirect()->back()->with('error', "Нет доступной дороги для перехода в этом направлении");
        }

        // Проверяем, разрешает ли дорога движение в этом направлении
        if ($road->from_location_id === $fromLocation->id && !$road->is_open) {
            return redirect()->back()->with('error', "Дорога в этом направлении закрыта");
        }

        $items = [];

        $maxTotal = mt_rand(0, $toLocation->getSize()); // Суммарное количество предметов
        if ($maxTotal > 0) {
            $availableItems = $toLocation->availableItems();
            $totalAdded = 0;
            $items = [];

            foreach ($availableItems as $item) {
                $stack = 0;

                for ($i = 0; $i <= ($maxTotal - $totalAdded); $i++) {
                    if (mt_rand(1, 100) <= $item->drop_chance) {
                        $stack++;
                        $totalAdded++;

                        if ($totalAdded >= $maxTotal) {
                            break 2; // Выходим из обоих циклов — лимит достигнут
                        }
                    }
                }

                if ($stack > 0) {
                    $items[] = [
                        'id' => $item->id,
                        'stack' => $stack,
                    ];
                }
            }
        }



        // Если дорога найдена и разрешает движение, создаём переход
        $transition = $currentCharacter->allTransitions()->create([
            'from_location_id' => $fromLocation ? $fromLocation->id : null,
            'to_location_id' => $toLocation->id,
            'next_action_at' => now(),//->addSeconds((isset($chosenRoad) ? $chosenRoad->getDistance() : 0) + $toLocation->getSize()),
            'items' => $items,
        ]);


        return redirect()->route('transitions.index');
    }



    /**
     * Display the specified resource.
     */
    public function show(Transition $transition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transition $transition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transition $transition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transition $transition)
    {
        //
    }
}
