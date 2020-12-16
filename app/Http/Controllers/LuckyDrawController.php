<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\Draw;
use App\Models\Phone;
use App\Models\DrawResult;
use App\Models\Pivots\DrawPrize;
use Illuminate\Http\Request;

class LuckyDrawController extends Controller
{
    public function __construct(){
        $this->middleware('permission:Draw Read');
        $this->middleware('permission:Draw Create', ['only' => ['create', 'store']]);
        $this->middleware('permission:Draw Edit', ['only' => ['update']]);
        $this->middleware('permission:Draw Delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $draw = Draw::currentDrawingRound();
        $selectedPhones = [];
        if ($draw) {
            $selectedPhones = DrawResult::with('phone')->whereDrawId($draw->id)->orderBy('created_at')->get();
        }

        return view('draw.lucky-draw.index', [
            'draw' => $draw,
            'selectedPhones' => $selectedPhones,
            'phones' => Phone::active()->pluck('value')
        ]);
    }

    public function startDrawing() {
        $draw = Draw::currentDrawingRound();
        $draw->update(['start_at' => Carbon::now()]);

        return response()->json([
            'success' => true
        ]);
    }

    public function getRandomPhone(Request $request) {
        $draw = Draw::currentDrawingRound();

        if ($draw->round_number === $request->round_number) {
            $prize = $draw->prizes()->where('available_qty', '>', 0)->orderBy('order_column')->first();
            $excludedPhones = DrawResult::whereDrawId($draw->id)->pluck('phone_id');
            $phone = Phone::active()->whereNotIn('id', $excludedPhones)->get()->random();

            if ($prize) {
                if ($draw->prizes->sum('pivot.qty') === count($excludedPhones) + 1) {
                    $draw->update(['end_at' => Carbon::now(), 'completed' => true]);
                }

                DrawResult::create([
                    'draw_id' => $draw->id,
                    'prize_id' => $prize->id,
                    'phone_id' => $phone->id,
                ]);
                $prize->pivot->decrement('available_qty');

                return response()->json([
                    'success' => true,
                    'message' => 'Success',
                    'phone' => $phone ? $phone->value : ''
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Running out of prizes',
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Round is ended',
            ]);
        }
    }
}
