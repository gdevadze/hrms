<form action="javascript:void(0)" id="user_info" method="post">
    @csrf
    <div class="row">
        <div class="col-xxl-4 col-md-6">
            <div>
                <label for="basiInput" class="form-label">@lang('name_ka')</label>
                <input type="text" class="form-control" name="name_ka" value="" id="name_ka">
                <span class="text-danger errors name_ka_err"></span>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div>
                <label for="basiInput" class="form-label">@lang('surname_ka')</label>
                <input type="text" class="form-control" name="surname_ka" value="" id="surname_ka">
                <span class="text-danger errors surname_ka_err"></span>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div>
                <label for="basiInput" class="form-label">@lang('name_en')</label>
                <input type="text" class="form-control" name="name_en" value="" id="basiInput">
                <span class="text-danger errors name_en_err"></span>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div>
                <label for="basiInput" class="form-label">@lang('surname_en')</label>
                <input type="text" class="form-control" name="surname_en" value="" id="basiInput">
                <span class="text-danger errors surname_en_err"></span>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div>
                <label for="tel" class="form-label">@lang('personal_number')</label>
                <input type="text" class="form-control" name="personal_num" value="" >
                <span class="text-danger errors personal_num_err"></span>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div>
                <label for="tel" class="form-label">@lang('phone')</label>
                <input type="text" class="form-control" name="tel" value="" id="tel" >
                <span class="text-danger errors tel_err"></span>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div>
                <label for="basiInput" class="form-label">@lang('email')</label>
                <input type="text" class="form-control" name="email" value="" id="basiInput">
                <span class="text-danger errors email_err"></span>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div>
                <label for="birthdate" class="form-label">@lang('birthdate')</label>
                <input type="text" class="form-control flatpickr-input" name="birthdate" id="birthdate" data-provider="flatpickr" data-date-format="d.m.Y" readonly="readonly">
                <span class="text-danger errors birthdate_err"></span>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div class="form-group">
                <label for="company_id_1">პროგრამაზე დაშვება</label>
                <select name="roles" id="role_id" class="form-control">
                    <option value="">აირჩიეთ</option>
                    @foreach ($roles as $role)
                        <option value="{{$role->name}}" @selected($role->name == 'მომხმარებელი')>{{$role->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div id="dEdu1" class="m-b-20 mt-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="f15 text-info"><strong>კომპანია <span id="gan">1</span></strong>
                    </div>
                </div>
                <div class="col-md-6" align="right">
                    <a href="javascript:void(0)" class="text-success Banner AddEdu" id="1"
                       style="display: inline;"><i class="fa fa-plus-square-o fa-lg"></i> დამატება</a>
                    &nbsp;
                    <a href="javascript:void(0)" class="text-danger Banner DelEdu" id="1"
                       style="display: inline;"><i class="fa fa-trash-o fa-lg"></i> წაშლა</a>

                </div>
            </div>
            <div class="card card-outline-info" style="padding:10px;">
                <div class="row ">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="company_id_1">კომპანია</label>
                            <select name="company_ids[]" id="company_id_1" class="form-control">
                                <option selected disabled>აირჩიეთ</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->title }} ({{ $company->identification_code }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="position_id_1">პოზიცია</label>
                            <select name="position_ids[]" id="position_id_1" class="form-control">
                                <option selected disabled>აირჩიეთ</option>
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="working_schedule_id_1">გრაფიკი</label>
                            <select name="working_schedule_ids[]" id="working_schedule_id_1" class="form-control">
                                <option selected disabled>აირჩიეთ</option>
                                @foreach($workingSchedules as $workingSchedule)
                                    <option value="{{ $workingSchedule->id }}">{{ $workingSchedule->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <a type="button" class="btn btn-primary waves-effect waves-light save-btn" data-link="{{ route('users.store') }}" href="javascript:void(0)">@lang('save')</a>
    </div>
</form>
<script src="{{ asset('assets/js/geokbd.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-pickers.init.js') }}"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ka.js"></script>
<script>
    $(document).ready(function(){
        $('#tel').inputmask({"mask": "599 99 99 99"});
        $('#name_ka').geokbd();
        $('#surname_ka').geokbd();
        flatpickr('.flatpickr-input', {
            allowInput: true,
            onChange(_dates, currentDateString, _picker, _data){
                var divEl = document.createElement("div");
                divEl.innerHTML = `[${new Date().toISOString()}] change: ${currentDateString}`;
                document.querySelector("div").appendChild(divEl);
            },
            parseDate(date){
                var divEl = document.createElement("div");
                divEl.innerHTML = `[${new Date().toISOString()}] parsing ${date}`;
                document.querySelector("div").appendChild(divEl);
            }
        });
    });

    $(document).on('click', '.AddEdu', function () {
        let nid = $(this).attr('id');
        let content = $('#dEdu' + nid).html();
        let newId = parseInt(nid) + 1;
        let newdiv = $("<div id='dEdu" + newId + "' class='m-b-20'>");
        newdiv.html(content);
        newdiv.find(".AddEdu").attr("id", newId);
        newdiv.find(".DelEdu").attr("id", newId);

        newdiv.find("#company_id_" + nid).attr("id", "company_id_" + newId);
        newdiv.find("#company_id_" + nid).attr("for", "company_id_" + newId);
        newdiv.find("#position_id_" + nid).attr("id", "position_id_" + newId);
        newdiv.find("#position_id_" + nid).attr("for", "position_id_" + newId);
        newdiv.find("#working_schedule_id_" + nid).attr("id", "working_schedule_id_" + newId);
        newdiv.find("#working_schedule_id_" + nid).attr("for", "working_schedule_id_" + newId);

        newdiv.find("#gan").html(newId);
        newdiv.find("input").val("");

        $('.AddEdu').hide();
        $('.DelEdu').hide();
        $('#dEdu' + nid).after(newdiv);
        $('#percent_' + newId).val($('#percent_1').val())
    });

    $(document).on('click', '.DelEdu', function () {
        var did = $(this).attr('id');
        if (did > 1) {
            $('#dEdu' + did).remove();
            $('.AddEdu').last().show();
            $('.DelEdu').last().show();
        } else {
            Swal.fire('შეცდომა!', 'წაშლა შეუძლებელია!', 'warning');
        }
    });
</script>
