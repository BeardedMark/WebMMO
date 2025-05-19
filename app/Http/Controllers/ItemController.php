<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

use App\Models\Character;
use App\Models\Hideout;
use App\Models\Transition;
use Illuminate\Support\Facades\Auth;

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
            case 'hideouts':
                return Hideout::findOrFail($containerId);
            default:
                abort(404, 'Контейнер не найден');
        }
    }


    public function assemble(Request $request)
    {
        $character = Auth::user()->character;
        $item = Item::findOrFail($request->input('id'));

        if (!$item->craft || !is_array($item->craft)) {
            return response()->json(['error' => 'Предмет нельзя собрать'], 400);
        }

        if (!$character->hasRequiredResources($item->craft)) {
            return response()->json(['error' => 'Недостаточно ресурсов'], 400);
        }

        $character->removeResources($item->craft);
        $character->addItem($item->generateInstance());

        return redirect()->back();
    }

    public function disassemble(Request $request)
    {
        $character = Auth::user()->character;
        $uuid = $request->input('uuid');

        $item = $character->findItem($uuid);
        if (!$item) {
            return response()->json(['error' => 'Предмет не найден'], 404);
        }

        $template = Item::find($item->id);
        if (!$template || !$template->craft) {
            return response()->json(['error' => 'Этот предмет нельзя разобрать'], 400);
        }

        $character->removeItem($uuid, $item->stack);

        foreach ($template->craft as $resource) {
            $resItem = Item::find($resource['item']);
            if ($resItem) {
                $character->addItem($resItem->generateInstance($resource['stack']));
            }
        }

        return redirect()->back();
    }
    public function equip(Request $request)
{
    $character = Auth::user()->character;
    $uuid = $request->input('uuid');

    $item = $character->findItem($uuid);
    if (!$item) {
        return response()->json(['error' => 'Предмет не найден в инвентаре'], 404);
    }

    // Пробрасываем class из модели Item
    $model = Item::find($item->id);
    if (!$model || !$model->class) {
        return response()->json(['error' => 'Предмет нельзя экипировать (нет класса/слота)'], 400);
    }

    $item->class = $model->class; // "weapon", "armor" и т.п.

    if (!$character->equip($item)) {
        return response()->json(['error' => 'Не удалось экипировать предмет'], 400);
    }

    $character->removeItem($uuid);
    return redirect()->back();

}

public function unequip(Request $request)
{
    $character = Auth::user()->character;
    $uuid = $request->input('uuid');

    $item = $character->unequip($uuid);
    if (!$item) {
        return response()->json(['error' => 'Предмет не найден среди экипированных'], 404);
    }

    $character->addItem($item);
    return redirect()->back();
}
}
