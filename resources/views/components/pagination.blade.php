@if($models->count() && method_exists($models, 'links'))
<div id="pagination" class="mt-2">
    @if($models->hasPages())
        {!! $models->appends(Request::except('page'))->render() !!}
    @endif
</div>
<div class="text-right mt-2">
    Showing {{ $models->firstItem() }} to {{ $models->lastItem() }}
    of  {{ $models->total() }} entries
</div>
@endif
