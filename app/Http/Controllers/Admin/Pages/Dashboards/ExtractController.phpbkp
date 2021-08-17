<?php

namespace App\Http\Controllers\Admin\Pages\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Extract;
use App\Models\Game;
use App\Models\TypeGameValue;
use Illuminate\Http\Request;

class ExtractController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('read_extract')) {
            abort(403);
        }

        return view('admin.pages.dashboards.extracts.index');
    }

    public static function store($data)
    {
        $extract = new Extract();
        $extract->type = $data['type'];
        $extract->value = $data['value'];
        $extract->type_game_id = $data['type_game_id'];
        $extract->description = $data['description'];
        $extract->user_id = $data['user_id'];
        $extract->client_id = $data['client_id'];
        $extract->save();
    }
}
