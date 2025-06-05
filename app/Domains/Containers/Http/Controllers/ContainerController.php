<?php

namespace App\Http\Controllers;

use App\Domains\Containers\Models\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ContainerInteractionService;

class ContainerController extends Controller
{
    public function index()
    {
        $containers = Container::all();
        return view('db.containers.index', compact('containers'));
    }

    public function create() {}

    public function store(Request $request) {}

    public function show(Container $container) {}

    public function edit(Container $container) {}

    public function update(Request $request, Container $container) {}

    public function destroy(Container $container) {}

    public function interact($uuid)
    {
        $character = Auth::user()->currentCharacter();
        $transition = $character->transition;
        $container = $transition->findContainerByUuid($uuid);

        if (ContainerInteractionService::interact($character, $container, $transition)) {
            $character->addLog('ContainerController.interact', "Вы открыли объект и получили ресурсы");
            return back();
        }

        $character->addLog('ContainerController.interact', "Не выполнены условия");
        return back();
    }
}
