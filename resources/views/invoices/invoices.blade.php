@extends('layouts.master')
@section('title')
    قائمة الفواتير
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة
                    الفواتير</span>
            </div>
        </div>

    </div>

    <!-- breadcrumb -->
@endsection
@section('content')

    @if (session()->has('delete_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم حذف الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif
    
    @if (session()->has('Add'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم إضافة الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif


    <!-- row -->
    {{-- <div class="row">
                <form method="post" action="/insert" class="form">
                    @csrf
                    <input type="text" name="name">
                    <button type="submit"  class="btn btn-dark btn-sm" >تأكيد</button>

                </form>
                </div>
                <br>
                <br>
                <div class="container">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">الإسم</th>
                        <th scope="col">تعديل</th>
                        <th scope="col">حذف</th>
                      </tr>
                    </thead>
                    <tbody>

                        @foreach ($invoices as $inv)

                        <tr>
                            <td>{{$inv->id}}</td>
                            <td>{{$inv->name}}</td>
                            <td>
                                <a href="{{route('edit',$inv->id)}}" class="btn btn-primary btn-sm">Edit</a>
                            </td>

                            <td>
                                <form method="post" action="/delete" class="form">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $inv->id }}">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </td>
                          </tr>


                        @endforeach



                    </tbody>
                  </table> --}}

    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">

                <a href="/create_invoice" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                        class="fas fa-plus"></i>&nbsp; اضافة فاتورة</a>

                        <a class="modal-effect btn btn-sm btn-primary" href="{{ url('export') }}"
                        style="color:white"><i class="fas fa-file-download"></i>&nbsp;تصدير اكسيل</a>

                <div class="d-flex justify-content-between" style="margin-top: 20px">
                    <h4 class="card-title mg-b-0">قائمة الفواتير</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                {{-- <p class="tx-12 tx-gray-500 mb-2">Example of Valex Bordered Table.. <a href="">Learn more</a></p> --}}
            </div>
            <style>
                .table td {
                    text-align: center;
                    vertical-align: middle;
                }
            </style>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">رقم الفاتورة</th>
                                <th class="border-bottom-0">تاريخ الفاتورة</th>
                                <th class="border-bottom-0">تاريخ الإستحقاق</th>
                                <th class="border-bottom-0">المنتج</th>
                                <th class="border-bottom-0">القسم</th>
                                <th class="border-bottom-0">الخصم</th>
                                <th class="border-bottom-0">نسبة الضريبة</th>
                                <th class="border-bottom-0">قيمة الضريبة</th>
                                <th class="border-bottom-0">الإجمالي</th>
                                <th class="border-bottom-0">الحالة</th>
                                <th class="border-bottom-0">ملاحظات</th>
                                <th class="border-bottom-0">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                $key = 1;
                            @endphp

                            @foreach ($invoices as $i)
                                <tr>
                                    <td>{{ $key }}</td>

                                    <td>
                                        <a href="{{ url('invoice_details') }}/{{ $i->id }}">
                                            {{ $i->invoice_number }}
                                        </a>
                                    </td>

                                    <td>{{ $i->invoice_date }}</td>
                                    <td>{{ $i->due_date }}</td>
                                    <td>{{ $i->product }}</td>
                                    <td>{{ $i->section->name }}</td>
                                    <td>{{ $i->discount }}</td>
                                    <td>{{ $i->rate_vat }}</td>
                                    <td>{{ $i->value_vat }}</td>
                                    <td>{{ $i->total }}</td>
                                    <td>
                                        @if ($i->value_status == 1)
                                            <span class="text-success">{{ $i->status }}</span>
                                        @elseif($i->value_status == 2)
                                            <span class="text-danger">{{ $i->status }}</span>
                                        @else
                                            <span class="text-warning">{{ $i->status }}</span>
                                        @endif

                                    </td>
                                    <td>{{ $i->note }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button aria-expanded="false" aria-haspopup="true"
                                                class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
                                            <div class="dropdown-menu tx-13">

                                                <a class="dropdown-item"
                                                    href=" {{ url('edit_invoice') }}/{{ $i->id }}">تعديل
                                                    الفاتورة</a>



                                                <a class="dropdown-item" href="delete_invoice"
                                                    data-invoice_id="{{ $i->id }}" data-toggle="modal"
                                                    data-target="#delete_invoice"><i
                                                        class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
                                                    الفاتورة</a>



                                                <a class="dropdown-item"
                                                    href="{{ URL::route('show_status', [$i->id]) }}"><i
                                                        class=" text-success fas
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        fa-money-bill"></i>&nbsp;&nbsp;تغير
                                                    حالة
                                                    الدفع</a>



                                                <a class="dropdown-item" href="archive"
                                                    data-invoice_id="{{ $i->id }}" data-toggle="modal"
                                                    data-target="#archive"><i
                                                        class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;نقل الي
                                                    الارشيف</a>



                                                <a class="dropdown-item" href="/print_invoice/{{ $i->id }}"><i
                                                        class="text-success fas fa-print"></i>&nbsp;&nbsp;طباعة
                                                    الفاتورة
                                                </a>

                                            </div>
                                        </div>

                                    </td>

                                </tr>
                                @php
                                $key++;
                            @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- حذف الفاتورة -->
    <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ url('delete_invoice/') }}" method="post">

                        @csrf
                </div>
                <div class="modal-body">
                    هل انت متاكد من عملية الحذف ؟
                    <input type="text" name="invoice_id" id="invoice_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">تاكيد</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <!-- ارشيف الفاتورة -->
    <div class="modal fade" id="archive" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ارشفة الفاتورة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ url('archive/') }}" method="post">

                        {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    هل انت متاكد من عملية الارشفة ؟
                    <input type="hidden" name="invoice_id" id="invoice_id" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-success">تاكيد</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- row closed -->
    </div>
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

    <script>
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>

    <script>
        $('#archive').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>


@endsection
