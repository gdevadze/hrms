<style>
    tr>th:first-child, tr>td:first-child {
        position: sticky;
        left: 0;
    }
</style>
<div class="table-responsive">
    <form id="movementsForm">
        @csrf
        <table class="table align-middle table-nowrap table-striped-columns mb-0">
            <thead class="table-light">
            <tr>
                <th>თანამშრომელი</th>
                @for ($day = 1; $day <= $month_days; $day++)
                    <th>{{ $day.' '.getMonthName($date->month) }} <br> {{ weekDayName($date->year, $date->month, $day) }}</th>
                @endfor
                <th>ჯამი</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td style="background-color: white;">{{ $user->full_name }}</td>
                    @for ($day = 1; $day <= $month_days; $day++)
                        @php
                            $currentDate = \Carbon\Carbon::create($date->year, $date->month, $day);
                            $movement = $user->movements->first(function ($m) use ($currentDate) {
                                return $currentDate->isSameDay($m->start_date) || $currentDate->isSameDay($m->end_date);
                            });
                        @endphp
                        <td>
                            @if($movement)
                            <div class="col-xxl-12 col-md-12">
                                <input type="hidden" name="user_id[]" value="{{ $user->id }}">
                                <input type="hidden" name="date[]" value="{{ $currentDate->toDateString() }}">
                                <div>
                                    <label class="form-label">ნამუშევარი საათი</label>
                                    <input type="text" class="form-control worked-hours" name="worked_hours[]"
                                           value="{{ $movement ? $movement->worked_hours : '' }}">
                                </div>
                                <div>
                                    <label class="form-label">ღამე ნამუშევარი საათი</label>
                                    <input type="text" class="form-control at-night-hours" name="at_night_hours[]"
                                           value="{{ $movement ? $movement->at_night_hours : '' }}">
                                </div>
                            </div>
                                @endif
                        </td>
                    @endfor
                    <td style="background-color: white;">{{ $user->movements()->sum('worked_hours') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <button type="button" id="saveMovements" class="btn btn-primary mt-3">Save</button>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#saveMovements').click(function () {
            let formDataArray = $('#movementsForm').serializeArray();
            let chunkSize = 900;
            let totalChunks = Math.ceil(formDataArray.length / chunkSize);

            function sendChunk(chunkIndex) {
                if (chunkIndex >= totalChunks) {
                    alert('All data saved successfully!');
                    return;
                }

                let chunkData = formDataArray.slice(chunkIndex * chunkSize, (chunkIndex + 1) * chunkSize);

                $.ajax({
                    url: '{{ route("reports.confirmation_movements.update.data") }}',
                    type: 'POST',
                    data: $.param(chunkData),
                    headers: {
                        'X-CSRF-TOKEN': $('input[name=_token]').val()
                    },
                    success: function () {
                        sendChunk(chunkIndex + 1); // Send the next chunk
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }

            sendChunk(0); // Start sending chunks
        });
    });
</script>
