<form method="GET" action="{{ route('draws.index') }}" class="form-inline mb-sm-2 d-block d-sm-flex" id="form-filter">
    <div class="form-group mr-0 mr-sm-2">
        <label for="search" class="sr-only">Search...</label>
        <input type="text" name="search" class="form-control" id="search" placeholder="Search..." value="{{ request()->search }}">
    </div>
    <div class="form-group mr-0 mr-sm-2">
        <select class="custom-select" id="status-select" name="status">
            <option value="">Status</option>
            <option value="1" {{ request()->status === '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ request()->status === '0' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>
    <button type="submit" class="btn btn-light waves-effect waves-light mb-2 mb-sm-0">
        <i class="mdi mdi-account-search"></i> @lang('Search')
    </button>
</form>
