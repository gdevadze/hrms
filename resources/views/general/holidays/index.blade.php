<div class="live-preview">
    <div class="accordion custom-accordionwithicon-plus" id="accordionWithplusicon">
        @foreach($yearHolidays as $key => $yearHoliday)
            <div class="accordion-item">
                <h2 class="accordion-header" id="holiday-{{ $key }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accor_plusExamplecollapse{{ $key }}" aria-expanded="false" aria-controls="accor_plusExamplecollapse2">
                        @lang('holidays') - {{ $key }}
                    </button>
                </h2>
                <div id="accor_plusExamplecollapse{{ $key }}" class="accordion-collapse collapse" aria-labelledby="holiday-{{ $key }}" data-bs-parent="#accordionWithplusicon">
                    <div class="accordion-body">
                        <div class="row">
                            @foreach($yearHoliday as $holiday)
                                <div class="col-md-3">
                                    <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                        <i class="ri-check-double-line label-icon"></i><strong>{{ $holiday->title }}</strong>
                                        <br>
                                        {{ $holiday['formatted_date'] }}
                                        @can('holiday-edit')
                                            <button type="button" class="btn" style="position: absolute;
    top: 0;
    right: 0;
    z-index: 2;
    font-size: 18px;
    padding: 1rem 1rem;"><i class="fa fa-edit"></i></button>
                                        @endcan
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
