<?php

namespace App\Domains\Items\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Domains\Items\Models\Item;
use Illuminate\Http\Request;

use App\Domains\Characters\Models\Character;
use App\Models\Transition;
use Illuminate\Support\Facades\Auth;
use App\Domains\Items\Services\CraftingService;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();
        return view('db.items.index', compact('items'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return view('db.items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }

    public function move(Request $request)
    {
        $request->validate([
            'uuid' => 'required|string',
            'from_container_type' => 'required|string',
            'to_container_type' => 'required|string',
            'from_container_id' => 'required|exists:' . $request->from_container_type . ',id',
            'to_container_id' => 'required|exists:' . $request->to_container_type . ',id',
            'stack' => 'required|integer|min:1',
        ]);

        $uuid = $request->uuid;
        $stack = $request->stack;

        $from = $this->getContainer($request->from_container_type, $request->from_container_id);
        $to = $this->getContainer($request->to_container_type, $request->to_container_id);

        $from->transferItemTo($to, $uuid, $stack);

        return redirect()->back();
    }


    /**
     * Получение контейнера по типу и ID.
     *
     * @param string $containerType
     * @param int $containerId
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function getContainer(string $containerType, int $containerId)
    {
        switch ($containerType) {
            case 'characters':
                return Character::findOrFail($containerId);
            case 'transitions':
                return Transition::findOrFail($containerId);
            default:
                abort(404, 'Контейнер не найден');
        }
    }

    public function assemble($code)
    {
        $character = Auth::user()->currentCharacter();
        $item = Item::where('code', $code)->firstOrFail();

        CraftingService::assemble($character, $item);

        $character->addLog('ItemController.disassemble', "Предмет скрафчен");
        return back();
    }

    public function disassemble($uuid)
    {
        $character = Auth::user()->currentCharacter();
        $item = $character->findItemByUuid($uuid); // метод из HasItems

        if ($item) {
            CraftingService::disassemble($character, $item);
        }

        $character->addLog('ItemController.disassemble', "Предмет разобран");
        return back();
    }

    public function equip(Request $request)
    {
        $character = Auth::user()->currentCharacter();
        $uuid = $request->input('uuid');

        $item = $character->findItemByUuid($uuid);
        if (!$item) {
            $character->addLog('ItemController.equip', "Предмет не найден в инвентаре");
            return redirect()->back();
        }

        $model = $item->getModel();

        if (!$model || !$model->slot) {
            $character->addLog('ItemController.equip', "Предмет нельзя экипировать");
            return redirect()->back();
        }

        $item->slot = $model->slot; // "weapon", "armor" и т.п.

        if (!$character->equip($item)) {
            $character->addLog('ItemController.equip', "Не удалось экипировать предмет");
            return redirect()->back();
        }

        $character->removeItem($uuid);
        return redirect()->back();
    }

    public function unequip(Request $request)
    {
        $character = Auth::user()->currentCharacter();
        $uuid = $request->input('uuid');

        $item = $character->unequip($uuid);
        if (!$item) {
            $character->addLog('ItemController.unequip', "Предмет не найден среди экипированных");
            return redirect()->back();
        }

        $character->addItem($item);
        return redirect()->back();
    }
}
