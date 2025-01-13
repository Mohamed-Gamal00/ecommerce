@extends('dashboard.index')
@section('title', 'انشاء بنر')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('banners.index') }}">البنرات</a></li>
    <li class="breadcrumb-item active" aria-current="page">انشاء بنر</li>
@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <x-alert type='success'/>
                    <x-alert type='dark'/>
                    {{-- Form Start --}}
                    <form method="post" action="{{ route('banners.store') }}"
                          enctype="multipart/form-data">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
{{--
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">البنر</label>
                            <div class="col-sm-10">
                                <input id="imageUpload" type="file" class="form-control" name="header_image"
                                       data-buttonname="btn-secondary">
                                @error('header_image')
                                <span class="error">{{ $message }}</span>
                                @enderror

                                <img src="" id="imagePreview"
                                     class="img-thumbnail rounded mt-2" alt="Preview"
                                     style="width: 150px; height: fit-content ">
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">البنر للغة
                                الانجليزية</label>
                            <div class="col-sm-10">
                                <input id="imageUpload" type="file" class="form-control" name="header_image_en"
                                       data-buttonname="btn-secondary">
                                @error('header_image_en')
                                <span class="error">{{ $message }}</span>
                                @enderror

                                <img src="" id="imagePreview"
                                     class="img-thumbnail rounded mt-2" alt="Preview"
                                     style="width: 150px; height: fit-content ">
                            </div>
                        </div> --}}

                        <x-dashboard.image-preview image=""
                            fileName="header_image" heigh="80" width="200" title="بنر للغة العربية" />

                        <x-dashboard.image-preview image=""
                            fileName="header_image_en" heigh="80" width="200" title="بنر للغةالانجليزية" />

                        <div>
                            <button class="btn btn-primary mt-5" type="submit">حفظ التعديل</button>
                        </div>
                    </form>
                </div><!-- end card -->
            </div> <!-- end col -->

            {{-- sub category in edit page --}}
        </div>

    {{-- Form End --}}

@endsection
