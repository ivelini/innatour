<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class ActionController extends Controller
{
    public function sendTourFormMessage(Request $request, $id)
    {
        $request->validate(
            [
                'clientName' => 'required|min:4',
                'clientPhone' => 'required',
            ]
        );

        $data = [
            'name' => $request->clientName,
            'phone' => $request->clientPhone,
            'email' => $request->clientEmail,
            'message' => $request->clientMessage,
            'status' => 'new',
            'tour_id' => $id,
            'created_at' => Date::now()
        ];

        DB::table('clients')->insert($data);

        return redirect()
            ->route('tour.show', $request->slug)
            ->with(['success' => 'Сообщение отправлено']);
    }
}
