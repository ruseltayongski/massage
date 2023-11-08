<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function userUpdateStatus(Request $request) {
        $user = User::find($request->id);
        $user->is_deleted = $request->is_deleted;
        $user->save();
        return true;
    }
}
