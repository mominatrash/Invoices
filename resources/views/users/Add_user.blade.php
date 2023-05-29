@extends('layouts.master')
@section('css')
    <!-- Internal Nice-select css  -->
    <link href="{{ URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet" />
@section('title')
    اضافة مستخدم - مورا سوفت للادارة القانونية
@stop


@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة
                مستخدم</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">


    <div class="col-lg-12 col-md-12">

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>خطا</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('show_users') }}">رجوع</a>
                    </div>
                </div><br>
                <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
                    action="{{ route('store_user', 'test') }}" method="post">
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="id" id="id">
                                <label>الاسم </label>
                                <div class="form-group">
                                    <input type="text" placeholder="name" name="name" id="name"
                                        class="form-control" />
                                    <span id="name_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>الايميل </label>
                                <div class="form-group">
                                    <input type="email" placeholder="email" name="email" id="email"
                                        class="form-control" />
                                    <span id="email_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label>اسم الدور </label>
                                <div class="form-group">
                                    <select class="form-select form-select-lg mb-3 form-control" name="roles_name[]" id="roles_name" aria-label=".form-select-lg example" multiple>
                                        <?php $m = App\Models\Role::all(); ?>
                                        @foreach ($m as $n)
                                            <option value="{{ $n->name }}">{{ $n->name }}</option>
                                        @endforeach
                                    </select>
                                    <span id="roles_name_error" class="text-danger"></span>
                                </div>
                            </div>
                            
                            
                            
                            
                            
                            <div class="col-md-6">
                                <label>الحالة </label>
                                <div class="form-group">


                                    <select class="form-select form-select-lg mb-3 form-control" name="status"
                                        id="status" aria-label=".form-select-lg example">

                                        <option selected>-------</option>
                                        <option value="مفعل">مفعل</option>
                                        <option value="غير مفعل">غير مفعل</option>

                                    </select>
                                    <span id="status_error" class="text-danger"></span>
                                </div>
                            </div>





                            <div class="col-md-6">
                                <label>كلمة السر </label>
                                <div class="form-group">
                                    <input type="password" placeholder="Password" name="password" id="password"
                                        class="form-control" />
                                    <span id="password_error" class="text-danger"></span>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        {{-- <button type="submit" style="display: none" id="add_user2" class="btn btn-primary btn-block">تتم الاضافة ...</button> --}}
                        <button type="submit" id="add_user" class="btn btn-primary btn-block">اضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')


<!-- Internal Nice-select js-->
<script src="{{ URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js') }}"></script>

<!--Internal  Parsley.min js -->
<script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
<!-- Internal Form-validation js -->
<script src="{{ URL::asset('assets/js/form-validation.js') }}"></script>

<script>
    var select = document.getElementById('roles_name');
    select.addEventListener('mousedown', function (e) {
        e.preventDefault();

        var originalScrollTop = this.scrollTop;
        var mouseX = e.clientX - this.getBoundingClientRect().left;
        var mouseY = e.clientY - this.getBoundingClientRect().top;

        e.target.selected = !e.target.selected;

        setTimeout(function () {
            select.scrollTop = originalScrollTop;
        }, 0);

        // Trigger a click event at the mouse position to open/close the dropdown
        var event = new MouseEvent('click', {
            clientX: mouseX,
            clientY: mouseY
        });
        select.dispatchEvent(event);
    });
 </script>


@endsection
