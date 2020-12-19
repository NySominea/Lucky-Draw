@if (isset($edit_route))
<a href="{{ $edit_route }}"
    class="action-icon text-warning"
    data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Edit"
>
    <i class="mdi mdi-square-edit-outline"></i>
</a>
@endif

@if (isset($delete_route))
<a href="javascript:void(0);" class="action-icon delete text-danger"
    data-route="{{ $delete_route }}"
    data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Delete"
>
    <i class="mdi mdi-delete"></i>
</a>
@endif
