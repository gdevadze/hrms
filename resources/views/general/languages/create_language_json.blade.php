<form action="javascript:void(0)" id="language_json_form" method="post">
    @csrf
    <div class="row">

        <div class="col-xxl-6 col-md-6">
            <div>
                <label for="key" class="form-label">Key</label>
                <input type="text" class="form-control" name="key" value="" id="key">
                <span class="text-danger errors key_err"></span>
            </div>
        </div>
        <div class="col-xxl-6 col-md-6">
            <div>
                <label for="value" class="form-label">მნიშვნელობა</label>
                <input type="text" class="form-control" name="value" value="" id="value">
                <span class="text-danger errors value_err"></span>
            </div>
        </div>

    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary waves-effect waves-light save-btn" data-link="{{ route('languages.store.language.json',$id) }}" href="javascript:void(0)">შენახვა</button>
    </div>
</form>
