<form method="GET" action="{{ route('roles.index') }}" class="form-inline mb-sm-2 d-block d-sm-flex" id="form-filter">
    <div class="form-group mr-0 mr-sm-2">
        <label for="search" class="sr-only">Search...</label>
        <input type="text" name="search" class="form-control" id="search" placeholder="Search..." value="{{ request()->search }}">
    </div>
    <button type="submit" class="btn btn-light waves-effect waves-light mb-2 mb-sm-0">
        <i class="mdi mdi-account-search"></i> @lang('Search')
    </button>
</form>
