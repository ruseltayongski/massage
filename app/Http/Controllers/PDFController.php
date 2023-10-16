<?php

namespace App\Http\Controllers;

use PDF;

use App\Models\User;
use App\Models\Bookings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PDFController extends Controller
{
    public function generatePDF(Request $request) {
       /*  dd($request->all()); */
       $user = Auth::user();
        if($request->has('id')) {
            $bookingId = $request->input('id');

            $booking = Bookings::select(
                'spa.id as spa_id',
                'spa.name as spa_name',
                'services.name as services',
                User::raw("concat(users.fname,' ',users.lname) as therapist"), 
                'bookings.booking_type',
                'bookings.start_date',
                'bookings.receipt_number',
                'bookings.start_time',
                'bookings.amount_paid',
                'bookings.status',
                'bookings.payment_picture',
            )
                ->where('bookings.id',$bookingId)
                ->leftJoin('spa','spa.id','=','bookings.spa_id')
                ->leftJoin('services','services.id','=','bookings.service_id')
                ->leftJoin('users','users.id','=','bookings.therapist_id')
                ->first();
            $data = [
                'title' => '',
                'date' => date('m/d/Y'),
                'booking' => $booking,
                'user' => $user
            ]; 


           /*  dd(response()->json($data)); */
                
            $pdf = PDF::loadView('client.receipt', $data);
        
            return $pdf->download('receipt.pdf');
        }   
    }
}
