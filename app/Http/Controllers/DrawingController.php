<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Draw;
use App\Models\Pivots\DrawPrize;
use Illuminate\Http\Request;
use App\Http\Requests\Draw\CreateRequest;
use App\Http\Requests\Draw\UpdateRequest;
use App\Repositories\Draw\DrawRepository;
use App\Repositories\Prize\PrizeRepository;

class DrawController extends Controller
{
    public function __construct(DrawRepository $repository, PrizeRepository $prizeRepository){
        $this->middleware('permission:Draw Read');
        $this->middleware('permission:Draw Create', ['only' => ['create', 'store']]);
        $this->middleware('permission:Draw Edit', ['only' => ['update']]);
        $this->middleware('permission:Draw Delete', ['only' => ['destroy']]);

        $this->repository = $repository;
        $this->prizeRepository = $prizeRepository;
    }

    public function index()
    {
        return view('draw.index', [
            'draw' => Draw::currentDrawingRound(),
            'activeDraws' => $this->repository->select()->with('prizes')->active()->orderBy('round_number', 'desc')->get(),
            'historyDraws' => Draw::select()->completed()->orderBy('round_number', 'desc')->get(),
        ]);
    }

    public function create()
    {
        return view('draw.add-edit', [
            'roundNumber' => Draw::nextDrawingNumber()
        ]);
    }

    public function store(CreateRequest $request)
    {
        $data = $this->repository->createOrUpdate($request->all());
        if ($data['success']) {
            return redirect()->route('draws.edit', $data['model'])
                            ->withSuccess('You have just added a phone successfully');
        }

        return back()->withInput()->with(['error' => $data['message']]);
    }

    public function edit(Draw $draw)
    {
        return view('draw.add-edit', [
            'draw' => $draw,
            'drawPrizes' => $draw->prizes,
            'prizes' => $this->prizeRepository->select()->active()->get()
        ]);
    }

    public function update(UpdateRequest $request, Draw $draw)
    {
        $data = $this->repository->createOrUpdate($request->all(), $draw->id);;
        if ($data['success']) {
            return redirect()->route('draws.edit', $draw->id)
                            ->withSuccess('You have just updated a draw successfully');
        }

        return back()->withInput()->with(['error' => $data['message']]);
    }

    public function destroy($id)
    {
        if ($this->repository->delete($id)) {
            return redirect()->route('draws.index')
                            ->withSuccess('You have just deleted a draw successfully');
        }

        return back()->withInput()->with(['error' => 'Something went wrong!']);
    }

    public function updatePrizeOrder(Request $request, Draw $draw) {

        DB::beginTransaction();
        try {
            foreach ($request->get('item') as $index => $id) {
                DrawPrize::whereDrawId($draw->id)->wherePrizeId($id)->update(['order_column' => $index + 1]);
            }
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
