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
        $allItems = Item::all();
        return view('items.index', compact('allItems'));
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
        return view('items.show', compact('item'));
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
            'item_id' => 'required|exists:items,id',
            'from_container_type' => 'required|string',
            'to_container_type' => 'required|string',
            'from_container_id' => 'required|exists:' . $request->from_container_type . ',id',
            'to_container_id' => 'required|exists:' . $request->to_container_type . ',id',
            'stack' => 'required|integer|min:1',
        ]);

        $itemId = $request->item_id;

        $fromContainer = $this->getContainer($request->from_container_type, $request->from_container_id);
        $toContainer = $this->getContainer($request->to_container_type, $request->to_container_id);
        $stack = $request->stack;

        // dd($fromContainer, $toContainer);

        $fromContainer->moveItemTo($itemId, $toContainer, $stack);

        return redirect()->back();
    }

    public function disassemble(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'from_container_type' => 'required|string',
            'from_container_id' => 'required|exists:' . $request->from_container_type . ',id',
            'stack' => 'required|integer|min:1',
        ]);

        $itemId = $request->item_id;

        $fromContainer = $this->getContainer($request->from_container_type, $request->from_container_id);
        $stack = $request->stack;

        $character = Auth::user()->character;
        $targetitem = Item::findOrFail($itemId);
        $availableItems = $targetitem->getCraftItems();
        $resultItemsArray = [];

        for ($i = 0; $i < $stack; $i++) {
            foreach ($availableItems as $availableItem) {
                $items = Item::generateItems($availableItem->stack, [$availableItem->item], $character->dropChance() + 30);

                foreach ($items as $item) {
                    $resultItemsArray[] = $item['stack'] . " " . Item::findOrFail($item['id'])->getTitle();

                    $fromContainer->addItem($item['id'], $item['stack']);
                }
            }
        }

        $resultString = "Разобран: {$stack} {$targetitem->getTitle()}";
        $resultItemsString = implode(', ', $resultItemsArray);
        if ($resultItemsString) {
            $resultString .= ", получено: {$resultItemsString}";
        }
        $character->addLog('items', $resultString);
        $fromContainer->removeItem($itemId, $stack);

        return redirect()->back();
    }

    public function assemble(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'from_container_type' => 'required|string',
            'from_container_id' => 'required|exists:' . $request->from_container_type . ',id',
            'stack' => 'required|integer|min:1',
        ]);

        $character = Auth::user()->character;
        $itemId = $request->item_id;
        $stack = $request->stack;
        $fromContainer = $this->getContainer($request->from_container_type, $request->from_container_id);

        $targetItem = Item::findOrFail($itemId);
        $craftItems = $targetItem->getCraftItems();
        $resultItemsArray = [];

        // Проверка наличия всех необходимых ресурсов
        foreach ($craftItems as $craft) {
            $requiredCount = $craft->stack * $stack;
            $actualCount = $fromContainer->getItems()->where('item.id', $craft->item->id)->sum('stack');

            if ($actualCount < $requiredCount) {
                $character->addLog('items', 'Недостаточно ресурсов для создания');
                return redirect()->back();
            }
        }

        // Удаление ресурсов
        foreach ($craftItems as $craft) {
            $requiredCount = $craft->stack * $stack;
            $resultItemsArray[] = $requiredCount . " " . $craft->item->getTitle();
            $fromContainer->removeItem($craft->item->id, $requiredCount);
        }

        // Добавление целевого предмета
        $fromContainer->addItem($targetItem->id, $stack);

        $resultItemsString = implode(', ', $resultItemsArray);
        $resultString = "Собран: {$stack} {$targetItem->getTitle()}, потрачено: {$resultItemsString}";
        $character->addLog('items', $resultString);

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
}
