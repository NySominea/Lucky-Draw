<?php

namespace App\Repositories\Draw;

use DB;
use Hash;
use App\Models\Draw;
use App\Models\Pivots\DrawPrize;
use Illuminate\Support\Arr;
use App\Criteria\SearchCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class DrawRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DrawRepositoryEloquent extends BaseRepository implements DrawRepository
{
    protected $fieldSearchable = [
        'round_number',
        'status'
    ];

    public function model()
    {
        return Draw::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(SearchCriteria::class));
    }

    public function createOrUpdate(array $attributes, $id = null)
    {
        $prizes = Arr::get($attributes, 'prizes', []);
        $thumbnail = Arr::get($attributes, 'thumbnail', null);

        DB::beginTransaction();
        try {

            $model = $id
                        ? parent::update($attributes, $id)
                        : parent::create($attributes);

            if ($model) {
                $model->saveSingleMedia($thumbnail, 'prize', $model->round_number);
            }

            $ids = [];
            foreach ($prizes as $lang => $prize) {
                if (!is_null($prize['id'])) {
                    if ($prize['qty'] > 0) {
                        $ids[] = $prize['id'];
                        DrawPrize::updateOrCreate(
                            ['draw_id' => $model->id, 'prize_id' => $prize['id']],
                            ['qty' => $prize['qty'], 'available_qty' => $prize['qty']],
                        );
                    }
                }
            }
            DrawPrize::whereNotIn('prize_id', $ids)->where('draw_id', $model->id)->delete();

            DB::commit();
            return [
                'success' => true,
                'model' => $model,
            ];

        } catch (\Throwable $th) {
            DB::rollback();
            return [
                'success' => false,
                'message' => $th->getMessage()
            ];
        }
    }
}
