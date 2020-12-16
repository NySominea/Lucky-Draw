<?php

namespace App\Models\Pivots;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DrawPrize extends Pivot
{
    use SortableTrait;

    protected $table = 'draw_prize';

    protected $fillable = ['order_column', 'draw_id', 'prize_id', 'qty', 'available_qty'];
}
