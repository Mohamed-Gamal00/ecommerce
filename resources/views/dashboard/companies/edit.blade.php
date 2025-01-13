@extends('dashboard.index')

@section('title', 'تعديل الشركه')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('companies.index') }}">الشركات</a></li>
    <li class="breadcrumb-item active" aria-current="page">تعديل الشركه</li>

@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{ route('companies.update', $company->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">اسم الشركة</label>
                            <div class="col-sm-10">
                                {{-- <input class="form-control" name="name" type="text" value="{{$company->name}}">
								@error('name')
								<span class="error">{{ $message }}</span>
								@enderror --}}
                                <x-form.input type="text" name="name" value="{{ $company->CurrentNameLang }}" />

                            </div>
                        </div>


                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">اسم الشركة بالانجليزي</label>
                            <div class="col-sm-10">

                                <x-form.input type="text" name="name_en" value="{{ $company->name_en }}" />

                            </div>
                        </div>




                        <x-dashboard.image-preview image="{{ $company->image_url }}" fileName="image" width="200"
                            heigh="200" title="الصورة" />

                        <button style="display: block" class="btn btn-primary" type="submit">حفظ الشركه</button>
                    </form>

                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>

    {{-- Form End --}}

@endsection
