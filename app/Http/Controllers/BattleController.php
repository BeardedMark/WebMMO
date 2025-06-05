<?php

namespace App\Http\Controllers;

use App\Models\Battle;
use App\Domains\Characters\Models\Character;
use Illuminate\Http\Request;
use App\Services\CombatService;

class BattleController extends Controller
{
    public function index(Request $request)
    {
        $character = $request->user()->currentCharacter();
        $location = $character->location;
        // $battles = Battle::where('location_id', $character->location->id)->get();
        $battles = $location->openBattles();
        $finishedBattles = $location->finishedBattles();

        return view('db.battles.index', compact('battles', 'finishedBattles', 'character'));
    }

    public function create(Request $request)
    {
        $character = $request->user()->currentCharacter();
        $battleTypes = Battle::getTypes();

        return view('db.battles.create', compact('character', 'battleTypes'));
    }

    public function store(Request $request)
    {
        $character = $request->user()->currentCharacter();

        $validated = $request->validate([
            'type' => 'nullable|string|in:normal,rating,brutal,siege',
            'commentary' => 'nullable|string|max:100',
        ]);

        $battle = Battle::create([
            'location_id' => $character->location->id,
            'creator_id' => $character->id,
            'type' => $validated['type'] ?? 'normal',
            'commentary' => $validated['commentary'] ?? null,
        ]);

        return redirect()->route('battles.index');
    }


    public function show(Battle $battle, Request $request)
    {
        $character = $request->user()->currentCharacter();

        return view('db.battles.show', compact('battle', 'character'));
    }

    // public function update(Battle $battle, Request $request)
    // {
    //     $character = $request->user()->currentCharacter();


    //     // Выполняем бой
    //     $creator = $battle->getCreator();
    //     $opponent = $character;

    //     $result = CombatService::fightCharacterVsCharacter($creator, $opponent);

    //     // лог пишется прямо в модель
    //     // $battle->log = json_encode($creator->getCombatLog());
    //     // $battle->save();
    //     $battle->delete();

    //     return back();
    // }

    public function destroy(Battle $battle, Request $request)
    {
        $character = $request->user()->currentCharacter();

        if ($battle->creator_id !== $character->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $battle->delete();

        return redirect()->route('battles.index');
    }

    // Оппонент подаёт заявку на участие в открытом бою
    public function apply(Battle $battle, Request $request)
    {
        $character = $request->user()->currentCharacter();
        if ($battle->opponent_id === null && $battle->location->id === $character->location->id) {
            $battle->opponent_id = $character->id;
            $battle->save();
        }

        return redirect()->route('battles.show', compact('battle', 'character'));
    }

    // Создатель подтверждает бой
    public function confirm(Battle $battle)
    {
        $character = auth()->user()->currentCharacter();

        if ($battle->creator_id !== $character->id || !$battle->opponent_id) {
            return back()->withErrors('Недопустимо');
        }

        $creator = $battle->getCreator();
        $opponent = $battle->getOpponent();

        $winner = CombatService::fightCharacterVsCharacter($battle, $creator, $opponent);
        $battle->winner_id = $winner->id;

        $battle->save();

        return back();
    }

    // Создатель отклоняет оппонента
    public function reject(Battle $battle)
    {
        $character = auth()->user()->currentCharacter();

        if ($battle->creator_id === $character->id) {
            $battle->opponent_id = null;
            $battle->save();
        }

        return back();
    }

    // Оппонент отменяет свою заявку
    public function cancelApplication(Battle $battle, Request $request)
    {
        $character = $request->user()->currentCharacter();

        if ($battle->opponent_id === $character->id) {
            $battle->opponent_id = null;
            $battle->save();
        }

        return back();
    }

    // Попытка сбежать от нападения
    public function escape(Battle $battle)
    {
        $character = auth()->user()->currentCharacter();

        if ($battle->opponent_id === $character->id) {
            $escaped = rand(1, 100) <= 50; // простая вероятность

            if ($escaped) {
                $battle->delete();
                return back()->with('message', 'Вы успешно сбежали');
            } else {
                // не сбежал — бой происходит
                $result = CombatService::fightCharacterVsCharacter($battle->creator, $character);
                $battle->delete();
                return back()->with('result', $result);
            }
        }

        return back();
    }

}
