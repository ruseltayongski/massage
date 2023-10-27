<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contracts;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard() {
        
        return view('admin.dashboard');
    }

    public function owner() {
        $ownerContracts = User::select(
                            'users.id',
                            'contracts.payment_proof as payment_proof',
                            DB::raw("concat(users.fname,' ',users.lname) as username"),
                            'users.mobile',
                            'users.picture',
                            'users.status',
                            'users.contract_type'
                        )
                        ->withCount('spas')
                        ->withCount('therapist')
                        ->where('roles', 'OWNER')
                        ->leftJoin('contracts', 'contracts.owner_id', '=', 'users.id')
                        ->paginate(15);
        return view('admin.owner',[
            'ownerContracts' => $ownerContracts,
        ]);
    }

    public function updateOwnerStatus(Request $request) {
        $user = User::find($request->user_id);
        $user->status = $request->contract_status;
        $user->save();

        $contracts = Contracts::where('owner_id', $user->id)->first();
        if($contracts) {
            $contracts->status = $request->contract_status;
            $contracts->save();
        }

        $notification = new Notifications();
        $notification->contract_owner = $user->id;
        $notification->notifier_id = Auth::user()->id; //admin account                
        $notification->message = $request->contract_status.' your contract';
        $notification->save();
        
        session()->flash('owner_status', true);
        return redirect()->back();
    }
}
