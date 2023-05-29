@extends('layouts.master')

@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{ URL::asset('assets/plugins/treeview/treeview-rtl.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title')
    اضافة الصلاحيات - مورا سوفت للادارة القانونية
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الصلاحيات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة
                    نوع مستخدم</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
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
  
    
    <style>
        .title-highlight {
            background-image: linear-gradient(to right, #f8e2b7, #f3c07f);
            padding: 2px 8px;
            border-radius: 4px;
            display: inline-block;
        }
    </style>
    
    {!! Form::open(['route' => 'store_role', 'method' => 'POST']) !!}
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card mg-b-20">
                    <div class="card-body">
                        <div class="main-content-label mg-b-5">
                            <div class="col-xs-7 col-sm-7 col-md-7">
                                <div class="form-group">
                                    <p><span class="title-highlight">اسم الصلاحية :</span></p>
                                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
    
                        <ul id="treeview1">
                            <li>
                                <a href="#">الصلاحيات</a>

                                <br><br>
                                <ul>
                                    <div class="row" style="display: flex; justify-content: center;">
                                        @foreach ($permission as $value)
                                            @if ($value->parent == 0)
                                                <div class="col-xs-12 col-sm-6 col-md-4 mb-4" style="border-style: ridge; padding: 1.5%; background-color: #f0efea; border-radius: 10px; margin-bottom: 20px; width: 80%; max-width: 400px; margin-right: 10px; margin-left: 10px;">
                                                    <label style="font-size: 14px; font-size: 26px;">
                                                        {{ Form::checkbox('permission[]', $value->id, false, ['class' => 'name', 'data-parent' => $value->name, 'onclick' => 'checkChildPermissions(this)']) }}
                                                        <span class="title-highlight">{{ $value->name }}</span>
                                                    </label>
                                                    <br> <br>
    
                                                    <?php $permissions_chi = \App\Models\Permission::where('parent', $value->id)->get(); ?>
                                                    <?php $permissions_chi_cont = \App\Models\Permission::where('parent', $value->id)->count(); ?>
    
                                                    @if ($permissions_chi_cont > 5)
                                                        <div class="row">
                                                            @foreach ($permissions_chi as $permissions_ch)
                                                                <div class="col-md-6">
                                                                    <div style="margin-right: 8%;">
                                                                        <label style="font-size: 14px; color: black;">
                                                                            {{ Form::checkbox('permission[]', $permissions_ch->id, false, ['class' => 'name', 'data-parent' => $value->name]) }}
                                                                            {{ $permissions_ch->name }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        @foreach ($permissions_chi as $permissions_ch)
                                                            <div style="margin-right: 8%;">
                                                                <label style="font-size: 14px; color: black;">
                                                                    {{ Form::checkbox('permission[]', $permissions_ch->id, false, ['class' => 'name', 'data-parent' => $value->name]) }}
                                                                    {{ $permissions_ch->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    @endif
    
                                                    <br>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- /col -->
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-main-primary">تاكيد</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
    
    {!! Form::close() !!}
    
@endsection









    
    
@section('js')
    <!-- Internal Treeview js -->
    <script src="{{ URL::asset('assets/plugins/treeview/treeview.js') }}"></script>

    <script>
        var parentCheckboxes = document.querySelectorAll('input[name="permission[]"][data-parent]');
    
        for (var i = 0; i < parentCheckboxes.length; i++) {
            parentCheckboxes[i].addEventListener('change', function() {
                var parentCheckbox = this;
                var parentName = parentCheckbox.getAttribute('data-parent');
                var childPermissions = document.querySelectorAll('input[name="permission[]"][data-parent="' + parentName + '"]');
    
                for (var j = 0; j < childPermissions.length; j++) {
                    childPermissions[j].checked = parentCheckbox.checked;
                }
            });
        }
    
        var childCheckboxes = document.querySelectorAll('input[name="permission[]"]:not([data-parent])');
    
        for (var k = 0; k < childCheckboxes.length; k++) {
            childCheckboxes[k].addEventListener('change', function() {
                var childCheckbox = this;
                var parentName = childCheckbox.getAttribute('data-parent');
                var parentCheckbox = document.querySelector('input[name="permission[]"][data-parent="' + parentName + '"]');
                var siblingCheckboxes = document.querySelectorAll('input[name="permission[]"][data-parent="' + parentName + '"]');
    
                if (!childCheckbox.checked) {
                    parentCheckbox.checked = false;
                } else {
                    var allChecked = true;
                    for (var m = 0; m < siblingCheckboxes.length; m++) {
                        if (!siblingCheckboxes[m].checked) {
                            allChecked = false;
                            break;
                        }
                    }
                    if (allChecked) {
                        parentCheckbox.checked = true;
                    }
                }
            });
        }
    </script>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
@endsection
