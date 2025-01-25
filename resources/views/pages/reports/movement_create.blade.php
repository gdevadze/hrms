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
                            <h4 class="mb-sm-0">გატარების დამატება</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

            </div>
            <!-- container-fluid -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">გატარების დამატება</h4>
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
                        <form action="{{ route('reports.movements.store') }}" method="POST" id="user_info">
                            @csrf
                            <div class="row">
                                <div class="col-xxl-12 col-md-12">
                                    <div>
                                        <label for="birthdate" class="form-label">თანამშრომელი</label>
                                        <select class="form-control" data-choices name="user_id" id="role_id">
                                            <option value="">აირჩიეთ</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->user_id }}">{{ $user->user->full_name }} - {{ $user->user->personal_num }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger errors birthdate_err"></span>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="birthdate" class="form-label">გამოცხადება</label>
                                        <input type="text" class="form-control" required name="start_date" value="" id="start_date" readonly="readonly">
                                        <span class="text-danger errors birthdate_err"></span>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="birthdate" class="form-label">გასვლა</label>
                                        <input type="text" class="form-control" required name="end_date" value="" id="end_date" readonly="readonly">
                                        <span class="text-danger errors birthdate_err"></span>
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/ka.js"></script>

    <script src="{{ asset('assets/libs/prismjs/prism.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#tel').inputmask({"mask": "599 99 99 99"});
            $('#name_ka').geokbd();
            $('#surname_ka').geokbd();
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
