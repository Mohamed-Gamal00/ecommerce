@extends('dashboard.index')

@section('title', 'تعديل ميزة')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('store_featuers.index') }}">المميزات</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('companies.create') }}">تعديل ميزة</a></li>

@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{ route('store_featuers.update', $featuer->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">العنوان</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="title" value="{{ $featuer->title }}" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">العنوان بالانجليزي</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="title_en" value="{{ $featuer->title_en }}" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-number-input" class="col-sm-2 col-form-label fw-bold">الوصف</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="7" name="description">{{ $featuer->description }}</textarea>
                            </div>
                        </div>

                        <x-dashboard.image-preview image="{{ $featuer->image_url }}" fileName="image" width="200"
                            heigh="200" title="الصورة" />

                        <button style="display: block" class="btn btn-primary" type="submit">حفظ</button>
                    </form>

                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>

    {{-- Form End --}}

@endsection
