<?php

namespace App\Http\Controllers\Admin\Manager;

use App\Http\Requests\ScopeRequest;
use App\Models\Scope;
use App\Repositories\ScopeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class ScopeController extends Controller
{
    protected $scopeRepository;

    public function __construct()
    {
        $this->scopeRepository = new ScopeRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scopes = $this->scopeRepository->getAll();

//        dd(__METHOD__, $scopes);

        return view('admin.page.manager.tour.scopeList', compact('scopes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScopeRequest $request)
    {
        $data = $request->input();

        if ($this->scopeRepository->isIdenticalTitle($request['title']) == false) {
            $data['slug'] = Str::slug($request['title']);
            $scope = new Scope($data);
            $scope->save();

            return redirect()
                ->route('manager.scope.index')
                ->with(['success' => 'Направление добавлено']);
        } else {
            return redirect()
                ->route('manager.scope.index')
                ->withErrors('Направление с таким названием существует');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ScopeRequest $request, $id)
    {
        if ($this->scopeRepository->isIdenticalTitle($request['title']) == false) {
            $scope = Scope::find($id);

            $scope->title = $request->title;
            $scope->slug = Str::slug($request->title);
            $scope->save();

            return redirect()
                ->route('manager.scope.index')
                ->with(['success' => 'Направление обновлено']);
        } else {
            return redirect()
                ->route('manager.scope.index')
                ->withErrors('Направление с таким названием существует');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $toursCount = $this->scopeRepository->getEdit($id)
            ->tours()
            ->get()
            ->count();

        if ($toursCount > 0) {
            return redirect()
                ->route('manager.scope.index')
                ->withErrors(['Направление не может быть удалена, так как содержит туры. Сначала переместите туры в другое направление.']);
        } else {
            Scope::destroy($id);
            return redirect()
                ->route('manager.scope.index')
                ->with(['success' => 'Направление удалено']);
        }
    }
}
