@extends('layouts.master')

@section('title')
 الاقسام
@endsection

@section('css')
<!-- Internal Data table css -->
<link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الأقسام</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الأقسام</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')

		@if ($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		@if(session()->has('Add'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>{{ session()->get('Add') }}</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif
	@if(session()->has('Error'))
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>{{ session()->get('Error') }}</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif
	
	@if(session()->has('edit'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>{{ session()->get('edit') }}</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif

	@if(session()->has('delete'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>{{ session()->get('delete') }}</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif

	{{-- row --}}
				<div class="row">






						<!--div-->
						<div class="col-md-12">
							<div class="card mg-b-20">
								<div class="card-body">
									<div class="table-responsive">
										<div class="col-sm-6 col-md-4 col-xl-3">
											<a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">+  إضافة قسم</a>
										<br>
										</div>
										<table id="example1" class="table key-buttons text-md-nowrap">
											<thead>
												<tr>
													<th class="border-bottom-0">رقم القسم</th>
													<th class="border-bottom-0">اسم القسم</th>
													<th class="border-bottom-0">الوصف</th>
													<th class="border-bottom-0">أنشئ بواسطة</th>
                                                    <th class="border-bottom-0">العمليات</th>
												</tr>
											</thead>
											<tbody>
												<?php $i =0?>
                                                @foreach ($sections as $s)

												<?php $i++?>

												<tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$s->name}}</td>
													<td>{{$s->description}}</td>
													<td>{{$s->created_by}}</td>
													<td>

														<a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
														   data-id="{{ $s->id }}" data-name="{{ $s->name }}"
														   data-description="{{ $s->description }}" data-toggle="modal" href="#exampleModal2"
														   title="تعديل"><i class="las la-pen"></i></a>
	
														<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
														   data-id="{{ $s->id }}" data-name="{{ $s->name }}" data-toggle="modal"
														   href="#modaldemo9" title="حذف"><i class="las la-trash"></i></a>
	
												</td>
												</tr>

                                                @endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<!--/div-->
						



				</div>




						<!--  add modal -->
		<div class="modal" id="modaldemo8">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">إضافة قسم </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<form action="/insert_section" method="POST">
							@csrf
			
									<div class="form-group">
										<label for="exampleInputEmail1">اسم القسم</label>
										<input type="text" class="form-control" id="name" name="name">
									</div>
			
									<div class="form-group">
										<label for="exampleFormControlTextarea1">ملاحظات</label>
										<textarea class="form-control" id="description" name="description" rows="3"></textarea>
									</div>
			
									<div class="modal-footer">
										<button type="submit" class="btn btn-success">تأكيد</button>
										<button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
									</div>
								</form>
					</div>
				
				</div>
			</div>
		</div>
		<!-- End Modal effects-->


				<div class="modal" id="exampleModal2">					
					<div class="modal-dialog modal-dialog-centered" role="document">						
						<div class="modal-content modal-content-demo">
							<div class="modal-header" style="text-align: center;">
								<h6 class="modal-title">تعديل القسم</h6><button aria-label="Close" class="close" data-dismiss="modal"
									type="button"><span aria-hidden="true">&times;</span></button>
							</div>
							<div class="modal-body">
								<form action="/update_section" method="post">
									{{-- {{ method_field('patch') }} --}}
									@csrf
			
									<div class="form-group">
										<input type="hidden" name="id" id="id" value="">
										<label for="exampleInputEmail1">اسم القسم</label>
										<input type="text" class="form-control" id="name" name="name">
									</div>
			
									<div class="form-group">
										<label for="exampleFormControlTextarea1">ملاحظات</label>
										<textarea class="form-control" id="description" name="description" rows="3"></textarea>
									</div>
			
									<div class="modal-footer">
										<button type="submit" class="btn btn-success">حفظ التعديل</button>
										<button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
					<!-- End Basic modal -->

					  <!-- delete -->
					  <div class="modal" id="modaldemo9">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="{{ route('section_delete') }}" method="post">
                                    @csrf

                                    <div class="modal-body">
                                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                                        <input type="hidden" name="id" id="id" value="">
                                        <input class="form-control" name="name" id="name" type="text" readonly>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                        <button type="submit" class="btn btn-danger">تاكيد</button>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>

				<!-- row closed -->




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
<script src="{{ URL::asset('assets/js/modal.js') }}"></script>


<script>
	$('#exampleModal2').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var name = button.data('name')
		var description = button.data('description')
		var modal = $(this)
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #name').val(name);
		modal.find('.modal-body #description').val(description);
	})
</script>

<script>
	$('#modaldemo9').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var name = button.data('name')
		var modal = $(this)
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #name').val(name);
	})
</script>

@endsection
