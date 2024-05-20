<div class="table-responsive">
    <table class="table table-hover align-middle table-nowrap table-striped-columns mb-0">
        <thead class="table-light">
        <tr>

            <th scope="col">სახელი, გვარი</th>
            @for($i = 1; $i <= $daysInMonth; $i++)
                <th scope="col">{{ weekDayName($year,$month,$i) }}<Br>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }} {{ $monthName }}</th>
            @endfor
        </tr>
        </thead>
        <tbody>
        @foreach($users as $student)
{{--            @if(date('Y-m-d') <= date('Y-'.$month.'-'.str_pad($i, 2, '0', STR_PAD_LEFT)))--}}
                <tr>

                    <td>{{ $student->full_name }}
                        <input hidden class="user_id_class" data-user-id="{{ $student->id }}">
                    </td>
                    @for($i = 1; $i <= $daysInMonth; $i++)

                            @php
                                $converted = str_pad($i, 2, '0', STR_PAD_LEFT);
                            @endphp
                            <td>
                                {{ $student->dynamic_working_schedule()->where('date', date('Y-'.$month.'-'.$converted))->first()->dynamic_working_schedule_time->title ?? '' }}
                                </td>

                    @endfor

                </tr>
{{--            @endif--}}
        @endforeach
        </tbody>
    </table>
</div>
