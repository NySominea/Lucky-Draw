<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Prize;
use Illuminate\Http\Request;
use App\Http\Requests\Prize\CreateRequest;
use App\Http\Requests\Prize\UpdateRequest;
use App\Repositories\Prize\PrizeRepository;

class PrizeController extends Controller
{
    public function __construct(PrizeRepository $repository){
        $this->middleware('permission:Prize Read');
        $this->middleware('permission:Prize Create', ['only' => ['create', 'store']]);
        $this->middleware('permission:Prize Edit', ['only' => ['update']]);
        $this->middleware('permission:Prize Delete', ['only' => ['destroy']]);

        $this->repository = $repository;
    }

    public function index()
    {
        return view('prize.index', [
            'prizes' => $this->repository->select()->ordered()->orderBy('status', 'desc')->get(),
        ]);
    }

    public function store(CreateRequest $request)
    {
        if ($this->repository->createOrUpdate($request->all())) {
            return redirect()->route('prizes.index')
                            ->withSuccess('You have just added a prize successfully');
        }

        $this->redirectBackWithErrors();
    }

    public function edit(Prize $prize)
    {
        return view('prize.index', [
            'prize' => $prize,
            'prizes' => $this->repository->select()->ordered()->orderBy('status', 'desc')->get(),
        ]);
    }

    public function update(UpdateRequest $request, Prize $prize)
    {
        if ($this->repository->createOrUpdate($request->all(), $prize->id)) {
            return redirect()->route('prizes.index')
                            ->withSuccess('You have just updated a prize successfully');
        }

        $this->redirectBackWithErrors();
    }

    public function destroy($id)
    {
        if ($this->repository->delete($id)) {
            return redirect()->route('prizes.index')
                            ->withSuccess('You have just deleted a prize successfully');
        }

        return $this->redirectBackWithErrors();
    }

    public function updateOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            Prize::setNewOrder($request->get('item'));
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'You have reordered the prizes successfully'
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
