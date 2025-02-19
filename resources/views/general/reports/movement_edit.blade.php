<form action="{{ route('reports.movements.update',$movement->id) }}" method="POST" id="user_info">
    @csrf
    <input type="hidden" name="user_id" value="{{ $movement->user_id }}">
    <div class="row">
        <div class="col-xxl-6 col-md-6">
            <div>
                <label for="birthdate" class="form-label">გამოცხადება</label>
                <input type="text" class="form-control" required name="start_date" value="{{ $movement->start_date }}" id="start_date" readonly="readonly">
                <span class="text-danger errors birthdate_err"></span>
            </div>
        </div>
        <div class="col-xxl-6 col-md-6">
            <div>
                <label for="birthdate" class="form-label">გასვლა</label>
                <input type="text" class="form-control" required name="end_date" value="{{ $movement->end_date }}" id="end_date" readonly="readonly">
                <span class="text-danger errors birthdate_err"></span>
            </div>
        </div>

        <div class="col-xxl-6 col-md-6">
            <div>
                <label for="birthdate" class="form-label">ახალი გამოცხადება</label>
                <input type="text" class="form-control" name="new_start_date" value="" id="start_date" readonly="readonly">
                <span class="text-danger errors birthdate_err"></span>
            </div>
        </div>
        <div class="col-xxl-6 col-md-6">
            <div>
                <label for="birthdate" class="form-label">ახალი გასვლა</label>
                <input type="text" class="form-control" name="new_end_date" value="" id="end_date" readonly="readonly">
                <span class="text-danger errors birthdate_err"></span>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary ms-auto">შენახვა</button>
    </div>
    <!-- end tab content -->
</form>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ka.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ka.js"></script>
<script>
    $(document).ready(function(){
        // $('#tel').inputmask({"mask": "599 99 99 99"});
        // $('#name_ka').geokbd();
        // $('#surname_ka').geokbd();
        flatpickr("#start_date", {
            "locale": "ka",
            enableTime: true,
            altInput: true,
            altFormat: "d.m.Y H:i",
            dateFormat: "Y-m-d H:i"
        });
        flatpickr("#end_date", {
            "locale": "ka",
            enableTime: true,
            altInput: true,
            altFormat: "d.m.Y H:i",
            dateFormat: "Y-m-d H:i"
        });
    });
</script>
