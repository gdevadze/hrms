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
                            <h4 class="mb-sm-0">თანამშრომლის რედაქტირება</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

            </div>
            <!-- container-fluid -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">თანამშრომლის რედაქტირება</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('users.update',$user->id) }}" method="POST" id="user_info">
                            @csrf
                            <div class="row">
                                <div class="col-xxl-4 col-md-6">
                                    <div>
                                        <label for="basiInput" class="form-label">@lang('name_ka')</label>
                                        <input type="text" class="form-control" name="name_ka" value="{{ $user->name_ka }}" required id="name_ka">
                                        <span class="text-danger errors name_ka_err"></span>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-6">
                                    <div>
                                        <label for="basiInput" class="form-label">@lang('surname_ka')</label>
                                        <input type="text" class="form-control" name="surname_ka" value="{{ $user->surname_ka }}" required id="surname_ka">
                                        <span class="text-danger errors surname_ka_err"></span>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-6">
                                    <div>
                                        <label for="basiInput" class="form-label">@lang('name_en')</label>
                                        <input type="text" class="form-control" name="name_en" value="{{ $user->name_en }}" required id="basiInput">
                                        <span class="text-danger errors name_en_err"></span>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-6">
                                    <div>
                                        <label for="basiInput" class="form-label">@lang('surname_en')</label>
                                        <input type="text" class="form-control" name="surname_en" value="{{ $user->surname_en }}" required id="basiInput">
                                        <span class="text-danger errors surname_en_err"></span>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-6">
                                    <div>
                                        <label for="tel" class="form-label">@lang('personal_number')</label>
                                        <input type="text" class="form-control" name="personal_num" required value="{{ $user->personal_num }}" >
                                        <span class="text-danger errors personal_num_err"></span>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-6">
                                    <div>
                                        <label for="address" class="form-label">მისამართი</label>
                                        <input type="text" class="form-control" name="address" value="{{ $user->address }}" required id="address" >
                                        <span class="text-danger errors tel_err"></span>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-6">
                                    <div>
                                        <label for="tel" class="form-label">@lang('phone')</label>
                                        <input type="text" class="form-control" name="tel" value="{{ $user->tel }}" required id="tel" >
                                        <span class="text-danger errors tel_err"></span>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-6">
                                    <div>
                                        <label for="basiInput" class="form-label">@lang('email')</label>
                                        <input type="text" class="form-control" name="email" value="{{ $user->email }}" id="basiInput">
                                        <span class="text-danger errors email_err"></span>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-6">
                                    <div>
                                        <label for="birthdate" class="form-label">@lang('birthdate')</label>
                                        <input type="text" class="form-control flatpickr-input" required name="birthdate" value="{{ $user->formatted_birthdate }}" id="birthdate" data-provider="flatpickr" data-date-format="d.m.Y" readonly="readonly">
                                        <span class="text-danger errors birthdate_err"></span>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-6">
                                    <div class="form-group">
                                        <label for="company_id_1">პროგრამაზე დაშვება</label>
                                        {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-md-6">
                                    <div class="form-group">
                                        <label for="is_resident">რეზიდენტი</label>
                                        <select name="is_resident" id="is_resident" class="form-control">
                                            <option value="1" @selected($user->is_resident == 1)>კი</option>
                                            <option value="0" @selected($user->is_resident == 0)>არა</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-md-6">
                                    <div class="form-group">
                                        <label for="country_id">ქვეყანა</label>
                                        <select name="country_id" id="country_id" class="form-control">
                                            @foreach ($countries as $country)
                                                <option value="{{$country->id}}" @selected($country->id == $user->country_id)>{{$country->name_ka}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-md-6">
                                    <div>
                                        <label for="card_number" class="form-label">ბარათის ნომერი</label>
                                        <input type="text" class="form-control" name="card_number" value="{{ $user->card_number }}" id="card_number">
                                        <span class="text-danger errors email_err"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>კომპანია</th>
                                        <th>დეპარტამენტი</th>
                                        <th>პოზიცია</th>
                                        <th>გრაფიკი</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user['user_companies'] as $userCompany)
                                        <tr>
                                            <td>{{ $userCompany->company->title }}</td>
                                            <td>{{ $userCompany->department->title ?? '' }}</td>
                                            <td>{{ $userCompany->position->title }}</td>
                                            <td>{{ $userCompany->working_schedule->title }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-primary shadow btn-xs sharp mr-1 edit-company" data-id="{{ $userCompany->id }}" href="javascript:void(0)"><i class="fa fa-edit"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
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

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary ms-auto">შენახვა</button>
                            </div>
                            <!-- end tab content -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_form_detail" tabindex="-1" role="dialog"
         aria-labelledby="exampleStandardModalLabel"
         data-bs-backdrop="static"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="htmlDisplay"></div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                            class="fa fa-times mr-2"
                            aria-hidden="true"></i> დახურვა
                    </button>
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

        $(document.body).on('click', '.edit-company', function () {
            $('#modal_form_detail').modal('show'); // show bootstrap modal when complete loaded
            $(".htmlDisplay").html('<h3 align=center class=text-warning><i class="fa fa-spinner fa-spin" style="font-size:24px"></i> @lang('wait')...</h3>');
            $.ajax({
                url: "{{ route('users.edit.user.company') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    'id': $(this).data('id')
                },
                success: function (msg) {
                    if (msg.status == 0) {
                        $('.htmlDisplay').html(msg.html);
                        $('#modal_title').html(msg.title)
                        $('modal_form_detail').modal('hide');
                    }else if(msg.status == 2){
                        $('.htmlDisplay').html(`<h3 align=center class=text-danger>${msg.error}</h3>`);
                    }
                    else {
                        $('.htmlDisplay').html('<h3 align=center class=text-danger><i class="fa fa-spin fa-spinner"></i> ამანათზე ინფორმაცია ვერ მოიძებნა!</h3>');
                    }
                },
                error: function () {
                    alert('შეცდომა, გაიმეორეთ მოქმედება.');
                }
            })
        })

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
            let form = $('#user_info1').serialize();
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
