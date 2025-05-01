<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

use App\Models\Character;
use App\Models\Transition;

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
        //
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


        $fromContainer->moveItemTo($itemId, $toContainer, $stack);

        return redirect()->back();
    }

    public function moves(Request $request)
    {
        $request->validate([
            'from_container_type' => 'required|string',
            'to_container_type' => 'required|string',
            'from_container_id' => 'required|exists:' . $request->from_container_type . ',id',
            'to_container_id' => 'required|exists:' . $request->to_container_type . ',id',
        ]);

        $fromContainer = $this->getContainer($request->from_container_type, $request->from_container_id);
        $toContainer = $this->getContainer($request->to_container_type, $request->to_container_id);

        $fromContainer->moveAllItemsTo($toContainer);

        return redirect()->back();
    }

    public function swap(Request $request)
    {
        $request->validate([
            'from_container_type' => 'required|string',
            'to_container_type' => 'required|string',
            'from_container_id' => 'required|exists:' . $request->from_container_type . ',id',
            'to_container_id' => 'required|exists:' . $request->to_container_type . ',id',
        ]);

        $fromContainer = $this->getContainer($request->from_container_type, $request->from_container_id);
        $toContainer = $this->getContainer($request->to_container_type, $request->to_container_id);


        $fromContainer->swapInventoryWith($toContainer);

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
}
