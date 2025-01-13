@extends('dashboard.index')

@section('title', 'اضافة القسم')

@section('breadcrumb')
	@parent
	<li class="breadcrumb-item"><a href="{{route('main_categories.index')}}">الأقسام</a></li>
	<li class="breadcrumb-item active" aria-current="page">اضافة قسم</li>
@endsection


@section('section')

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					{{-- Form Start --}}
					<form method="post" action="{{ route('main_categories.store') }}"
					      enctype="multipart/form-data">
						@csrf
						<div class="row mb-3">
							<label for="example-text-input" class="col-sm-2 col-form-label fw-bold">اسم
							                                                                        القسم</label>
							<div class="col-sm-10">
								<input class="form-control" name="name" type="text" id="example-text-input">
								@error('name')
								<span class="error">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="row mb-3">
							<label for="example-text-input" class="col-sm-2 col-form-label fw-bold">الصورة</label>
							<div class="col-sm-10">
								<input id="imageUpload" type="file" class="form-select" name="image"
								       data-buttonname="btn-secondary">
								@error('image')
								<span class="error">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<img src="#" id="imagePreview" class="img-thumbnail rounded mb-5" alt="Preview" style="width: 150px; display: none;">

				</div><!-- end cardbody -->
			</div><!-- end card -->
		</div> <!-- end col -->
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title mb-3">التصنيفات</h4>
					<div data-repeater-list="group-a">
						<div class="row" data-repeater-item>

							@forelse ($settings as $setting)
								<div class="mb-3 col-lg-2">
									<div class="form-check">
										<input class="form-check-input" type="checkbox"
										       value="{{ $setting->id }}"
										       name="category[]" id="invalidCheck1_{{$setting->id}}">

										<label class="form-check-label" for="invalidCheck1_{{$setting->id}}">
											{{ $setting->name }}
										</label>

									</div>
								</div>
							@empty
								<div>لا يوجد تصنيفات</div>
							@endforelse
							<!-- end col -->
							<!-- end col -->
						</div>
						<!-- end row -->
					</div>

					<div>
						<button class="btn btn-primary mt-5" type="submit">حفظ القسم</button>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>


	{{-- Form End --}}

@endsection