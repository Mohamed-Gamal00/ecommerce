@extends('dashboard.index')
@section('title', 'الألوان')

@section('breadcrumb')
	@parent
	<li class="breadcrumb-item active" aria-current="page">الألوان</li>

@endsection

@section('section')

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">

					<x-alert type='success'/>
					<x-alert type='danger'/>
					<x-alert type='dark'/>

					{{-- @can('color.create') --}}
						<div class="button-items text-end mb-4">
							<a type="submit" href="{{route('colors.create')}}"
							   class="btn btn-primary waves-effect waves-light">اضافة لون جديد</a>
						</div>
					{{-- @endcan --}}

					<div class="table-responsive mt-2">

						<table
								class="table table-editable table-nowrap align-middle table-edits table-striped table-bordered mt-2"
								id="product-table">
							<thead>
							<tr>
								<th>اللون</th>
								<th>تعديل</th>
								<th>حذف</th>
							</tr>
							</thead>

							<tbody>
							@forelse ($colors as $color)
								<tr data-id="5">
									<td data-field="id">{{ $color->name }}
										<button class="btn btn-danger"
										        style="background-color: {{$color->color_code}}; border: none;"></button>
									</td>

									{{-- @can('color.edit') --}}
										<td style="width: 7%;">
											<a href="{{ route('colors.edit', $color->id) }}"
											   style="font-size: 12px" ;
											   class="btn btn-primary waves-effect waves-light" title="تعديل">
												<i class="fas fa-pencil-alt"></i>
											</a>
										</td>
									{{-- @endcan --}}

									{{-- @can('color.delete') --}}
										<form method="post" action="{{ route('colors.destroy', $color->id) }}"
										      id=formDelete_{{ $color->id }} >
											@csrf
											@method('delete')
											<td style="width: 7%;">
												<button style="font-size: 12px;"
												        class="btn btn-danger waves-effect waves-light" title="حذف"
												        type="button" onclick="confirmDelete({{$color->id}})">
													<i class="fas fa-trash-alt"></i>
												</button>
											</td>
										</form>
									{{-- @endcan --}}
									@empty
										<td colspan="6">
											لا يوجد ألوان لعرضها
										</td>
								</tr>
							@endforelse
							</tbody>

							<!-- end tbody -->
						</table>
						<!-- end table -->
						{{ $colors->withQueryString()->links() }}
					</div>
					<!-- end -->
				</div>
			</div>
		</div> <!-- end col -->
	</div>

@endsection
