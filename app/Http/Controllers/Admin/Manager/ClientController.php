<?php

namespace App\Http\Controllers\Admin\Manager;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Repositories\TourRepository;
use Illuminate\Support\Facades\Date;

class ClientController extends Controller
{
    protected $tourRepository;

    public function __construct()
    {
        $this->tourRepository = new TourRepository();
    }

    public function new()
    {
        $clients = \DB::table('clients')
            ->where('status', 'new')
            ->get();

        $toursSendMessages = $this->getToursSentMessages($clients);

        return view('admin.page.manager.clients.new', compact('clients', 'toursSendMessages'));
    }

    public function active()
    {
        $clients = \DB::table('clients')
            ->where('status', 'active')
            ->get();

        $toursSendMessages = $this->getToursSentMessages($clients);

        return view('admin.page.manager.clients.active', compact('clients', 'toursSendMessages'));
    }

    public function closed()
    {
        $clients = \DB::table('clients')
            ->where('status', 'closed')
            ->get();

        $toursSendMessages = $this->getToursSentMessages($clients);

        return view('admin.page.manager.clients.closed', compact('clients', 'toursSendMessages'));
    }

    public function update($id)
    {
        $url = url()->current();

        if (strpos($url, 'active')) {

            \DB::table('clients')
                ->where('id', $id)
                ->update(['status' => 'active',
                            'updated_at' => Date::now()
                        ]);

            return redirect()
                ->route('manager.client.new')
                ->with(['success' => 'Клинет переведен в статус "Активные"']);
        }

        if (strpos($url, 'close')) {

            \DB::table('clients')
                ->where('id', $id)
                ->update(['status' => 'closed',
                    'updated_at' => Date::now()
                ]);

            return redirect()
                ->route('manager.client.new')
                ->with(['success' => 'Клинет переведен в статус "Завершенные"']);
        }

    }

    protected function getToursSentMessages($clients)
    {
        $tours_id = $clients->pluck('tour_id');
        $toursSendMessages = $this->tourRepository->getToursWithSentMessages($tours_id);

        return $toursSendMessages;
    }

    public function destroy($id)
    {
        \DB::table('clients')->delete($id);

        return back();
    }
}
