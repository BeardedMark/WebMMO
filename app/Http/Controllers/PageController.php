<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PageController extends Controller
{
    public function main()
    {
        return view('pages.main');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function gameplay()
    {
        return view('pages.gameplay');
    }

    public function lore()
    {
        return view('pages.lore');
    }

    public function gallery(Request $request)
    {
        $folder = $request->get('folder', ''); // Пример: 'characters' или '2025/nature'

        $basePath = storage_path('app/public/images/gallery');
        $targetPath = $basePath . '/' . $folder;

        $images = [];

        if (File::exists($targetPath)) {
            $files = File::allFiles($targetPath);

            foreach ($files as $file) {
                $relative = str_replace('\\', '/', $file->getRelativePathname());
                $images[] = asset("storage/images/gallery/" . ltrim($relative, '/'));
            }
        }

        return view('pages.gallery', compact('images', 'folder'));
    }
}
