<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function create()
    {
        $users = User::where('id', '!=', auth()->user()->id)->get();

        return view('messages.create', compact('users'));
    }

    public function store(Request $request)
    {
        return $request->all();
    }
}
