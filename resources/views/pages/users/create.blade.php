@extends('layouts.app')
@push('css')
    <style>
        .required-add-field {
            border:1px solid red !important;
        }
    </style>
@endpush
@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">@lang('employees')</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

            </div>
            <!-- container-fluid -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">@lang('employees')</h4>
                        <div class="flex-shrink-0">
                            <a type="button" class="btn btn-primary waves-effect waves-light" id="add_user" href="javascript:void(0)"><i class="fa fa-plus-square-o"></i> @lang('add')</a>
                        </div>
                    </div><!-- end card header -->
                    <div class="card-body form-steps">
                        <form action="#" id="user_info">
                            @csrf
                            <div class="text-center pt-3 pb-4 mb-1">
                                <h5>თანამშრომლის რეგისტრაცია</h5>
                            </div>
                            <div id="custom-progress-bar" class="progress-nav mb-4">
                                <div class="progress" style="height: 1px;">
                                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>

                                <ul class="nav nav-pills progress-bar-tab custom-nav" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link rounded-pill active" data-progressbar="custom-progress-bar" id="pills-gen-info-tab" data-bs-toggle="pill" data-bs-target="#pills-gen-info" type="button" role="tab" aria-controls="pills-gen-info" aria-selected="true">1</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link rounded-pill" data-progressbar="custom-progress-bar" id="pills-company-info-tab" data-bs-toggle="pill" data-bs-target="#pills-company-info" type="button" role="tab" aria-controls="pills-company-info" aria-selected="false">2</button>
                                    </li>
{{--                                    <li class="nav-item" role="presentation">--}}
{{--                                        <button class="nav-link rounded-pill" data-progressbar="custom-progress-bar" id="pills-info-desc-tab" data-bs-toggle="pill" data-bs-target="#pills-info-desc" type="button" role="tab" aria-controls="pills-info-desc" aria-selected="false">3</button>--}}
{{--                                    </li>--}}
                                </ul>
                            </div>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="pills-gen-info" role="tabpanel" aria-labelledby="pills-gen-info-tab">
                                    <div>
                                        <div class="mb-4">
                                            <div>
                                                <h5 class="mb-1">ზოგადი ინფორმაცია</h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xxl-4 col-md-6">
                                                <div>
                                                    <label for="basiInput" class="form-label">@lang('name_ka')</label>
                                                    <input type="text" class="form-control" name="name_ka" value="" required id="name_ka">
                                                    <span class="text-danger errors name_ka_err"></span>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-md-6">
                                                <div>
                                                    <label for="basiInput" class="form-label">@lang('surname_ka')</label>
                                                    <input type="text" class="form-control" name="surname_ka" value="" required id="surname_ka">
                                                    <span class="text-danger errors surname_ka_err"></span>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-md-6">
                                                <div>
                                                    <label for="basiInput" class="form-label">@lang('name_en')</label>
                                                    <input type="text" class="form-control" name="name_en" value="" required id="basiInput">
                                                    <span class="text-danger errors name_en_err"></span>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-md-6">
                                                <div>
                                                    <label for="basiInput" class="form-label">@lang('surname_en')</label>
                                                    <input type="text" class="form-control" name="surname_en" value="" required id="basiInput">
                                                    <span class="text-danger errors surname_en_err"></span>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-md-6">
                                                <div>
                                                    <label for="tel" class="form-label">@lang('personal_number')</label>
                                                    <input type="text" class="form-control" name="personal_num" required value="" >
                                                    <span class="text-danger errors personal_num_err"></span>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-md-6">
                                                <div>
                                                    <label for="address" class="form-label">მისამართი</label>
                                                    <input type="text" class="form-control" name="address" value="" required id="address" >
                                                    <span class="text-danger errors tel_err"></span>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-md-6">
                                                <div>
                                                    <label for="tel" class="form-label">@lang('phone')</label>
                                                    <input type="text" class="form-control" name="tel" value="" required id="tel" >
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
                                                    <input type="text" class="form-control flatpickr-input" required name="birthdate" id="birthdate" data-provider="flatpickr" data-date-format="d.m.Y" readonly="readonly">
                                                    <span class="text-danger errors birthdate_err"></span>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-md-6">
                                                <div class="form-group">
                                                    <label for="company_id_1">პროგრამაზე დაშვება</label>
                                                    <select name="roles" id="role_id" class="form-control">
                                                        @foreach ($roles as $role)
                                                            <option value="{{$role->name}}" @selected($role->name == 'მომხმარებელი')>{{$role->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-md-6">
                                                <div class="form-group">
                                                    <label for="is_resident">რეზიდენტი</label>
                                                    <select name="is_resident" id="is_resident" class="form-control">
                                                        <option value="1" selected>კი</option>
                                                        <option value="0">არა</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-md-6">
                                                <div class="form-group">
                                                    <label for="country_id">ქვეყანა</label>
                                                    <select name="country_id" id="country_id" class="form-control">
                                                        @foreach ($countries as $country)
                                                            <option value="{{$country->id}}" @selected($country->id == 64)>{{$country->name_ka}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xxl-4 col-md-6">
                                                <div>
                                                    <label for="card_number" class="form-label">ბარათის ნომერი</label>
                                                    <input type="text" class="form-control" name="card_number" value="" id="card_number">
                                                    <span class="text-danger errors email_err"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start gap-3 mt-4">
                                        <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="pills-company-info-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>შემდეგი</button>
                                    </div>
                                </div>
                                <!-- end tab pane -->

                                <div class="tab-pane fade" id="pills-company-info" role="tabpanel" aria-labelledby="pills-company-info-tab">
                                    <div>
                                        <div class="mb-4">
                                            <div>
                                                <h5 class="mb-1">კომპანია</h5>
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

                                                    <div class="col-md-3">
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
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="department_id_1">დეპარტამენტი</label>
                                                            <select name="department_ids[]" id="department_id_1" class="form-control">
                                                                <option selected disabled>აირჩიეთ</option>
                                                                @foreach($departments as $department)
                                                                    <option value="{{ $department->id }}">{{ $department->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
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
                                                    <div class="col-md-3">
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
                                                    <div class="col-xxl-4 col-md-6">
                                                        <div>
                                                            <label for="contract_dates_1" class="form-label">ხელშეკრულების დაწყების თარიღი</label>
                                                            <input type="text" class="form-control flatpickr-input" name="contract_dates[]" id="contract_dates_1" data-provider="flatpickr" data-date-format="d.m.Y" readonly="readonly">
                                                            <span class="text-danger errors contract_dates_err"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-4 col-md-6">
                                                        <div>
                                                            <label for="contact_end_dates_1" class="form-label">ხელშეკრულების დასრულების თარიღი</label>
                                                            <input type="text" class="form-control flatpickr-input" name="contact_end_dates[]" id="contact_end_dates_1" data-provider="flatpickr" data-date-format="d.m.Y" readonly="readonly">
                                                            <span class="text-danger errors contact_end_dates_err"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="contact_types_1">ხელშეკრულების ტიპი</label>
                                                            <select name="contact_types[]" id="contact_types_1" class="form-control">
                                                                <option selected disabled>აირჩიეთ</option>
                                                                @foreach($contractTypes as $contractType)
                                                                    <option value="{{ $contractType['key'] }}">{{ $contractType['title'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start gap-3 mt-4">
                                        <button type="button" class="btn btn-link text-decoration-none btn-label previestab" data-previous="pills-gen-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> უკან</button>
                                        <button type="submit" class="btn btn-success btn-label right ms-auto save-btn" data-link="{{ route('users.store') }}" data-nexttab="pills-success-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>შენახვა</button>
{{--                                        <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="pills-info-desc-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to more info</button>--}}
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="pills-info-desc" role="tabpanel" aria-labelledby="pills-info-desc-tab">
                                    <div>
                                        <div class="text-center">
                                            <div class="profile-user position-relative d-inline-block mx-auto mb-2">
                                                <img src="assets/images/users/user-dummy-img.jpg" class="rounded-circle avatar-lg img-thumbnail user-profile-image" alt="user-profile-image">
                                                <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                    <input id="profile-img-file-input" type="file" class="profile-img-file-input" accept="image/png, image/jpeg">
                                                    <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                                    <span class="avatar-title rounded-circle bg-light text-body">
                                                                        <i class="ri-camera-fill"></i>
                                                                    </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <h5 class="fs-14">Add Image</h5>

                                        </div>
                                        <div>
                                            <label class="form-label" for="gen-info-description-input">Description</label>
                                            <textarea class="form-control" placeholder="Enter Description" id="gen-info-description-input" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start gap-3 mt-4">
                                        <button type="button" class="btn btn-link text-decoration-none btn-label previestab" data-previous="pills-company-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to General</button>
                                        <button type="submit" class="btn btn-success btn-label right ms-auto save-btn" data-link="{{ route('users.store') }}" data-nexttab="pills-success-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Submit</button>
                                    </div>
                                </div>
                                <!-- end tab pane -->

                                <div class="tab-pane fade" id="pills-success" role="tabpanel" aria-labelledby="pills-success-tab">
                                    <div>
                                        <div class="text-center">

                                            <div class="mb-4">
                                                <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>
                                            </div>
                                            <h5>Well Done !</h5>
                                            <p class="text-muted">You have Successfully Signed Up</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- end tab pane -->
                            </div>
                            <!-- end tab content -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/js/pages/form-wizard.init.js') }}"></script>
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
                "locale": "ka"
            });
        });

        $(".nexttab").click(function(){
            var form = document.getElementById('user_info').querySelectorAll("[required]")
            for(var i=0; i < form.length; i++){
                // console.log(form[i].value);
                console.log(form[i].value);
                // return
                form[i].classList.remove("required-add-field");
                if(form[i].value == '' && form[i].hasAttribute('required')){
                    form[i].classList.add("required-add-field");
                    // alert(form[i]+'There are some required fields!');
                    return false;
                }else{
                    // document.myForm.submit();
                }
            }
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

            newdiv.find("#department_id_" + nid).attr("id", "department_id_" + newId);
            newdiv.find("#department_id_" + nid).attr("for", "department_id_" + newId);

            newdiv.find("#working_schedule_id_" + nid).attr("id", "working_schedule_id_" + newId);
            newdiv.find("#working_schedule_id_" + nid).attr("for", "working_schedule_id_" + newId);

            newdiv.find("#contract_dates_" + nid).attr("id", "contract_dates_" + newId);
            newdiv.find("#contract_dates_" + nid).attr("for", "contract_dates_" + newId);

            newdiv.find("#contact_end_dates_" + nid).attr("id", "contact_end_dates_" + newId);
            newdiv.find("#contact_end_dates_" + nid).attr("for", "contact_end_dates_" + newId);

            newdiv.find("#contact_types_" + nid).attr("id", "contact_types_" + newId);
            newdiv.find("#contact_types_" + nid).attr("for", "contact_types_" + newId);

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

        $(document.body).on('click', '.save-btn', function () {
            let form = $('#user_info').serialize();
            let $this = $(this)
            console.log($this.data('link'))
            $this.html('<i class="fa fa-spin fa-spinner"></i> დაელოდეთ...');
            $this.prop('disabled', true);
            $.ajax({
                url: $this.data('link'),
                method: "POST",
                data: form,
                success: function (response) {
                    if (response.status == 0) {
                        Swal.fire('წარმატებული!',response.msg,'success');
                        $this.html('შენახვა');
                        reload()
                        $this.prop('disabled', false);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 422) { // when status code is 422, it's a validation issue
                        $('.errors').html('');
                        $.each(xhr.responseJSON.errors, function (i, error) {
                            $('.'+i+'_err').html(error);
                        });
                    }
                    $this.html('შენახვა');
                    $this.prop('disabled', false);
                }
            })
        })
    </script>

@endpush
