@extends('dashboard.index')
@section('title', 'تعديل بنر')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('designs.index') }}">البنرات</a></li>
    <li class="breadcrumb-item active" aria-current="page">تعديل بنر</li>
@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <x-alert type='success' />
                    <x-alert type='dark' />
                    {{-- Form Start --}}
                    <form method="post" action="{{ route('designs.update', $design->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <input readonly class="form-control" name="title" type="hidden" id="example-text-input"
                                    value="{{ $design->title }}">
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                                {{-- <x-form.input type="text" name="title" value="{{ $design->title }}" /> --}}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="example-number-input" class="col-sm-2 col-form-label fw-bold">الوصف</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="7" name="description">{{ $design->description }}</textarea>
                                @error('description')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">البنر</label>
                            <div class="col-sm-10">
                                <input id="imageUpload" type="file" class="form-select" name="image"
                                    data-buttonname="btn-secondary">
                                @error('image')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}

                        <x-dashboard.image-preview image="{{ $design->image ? Storage::url($design->image) : '' }}" fileName="image" heigh="80" width="200"
                            title="البنر" />

                        {{-- <img src="{{ asset('storage/' . $design->image) }}" id="imagePreview"
                            class="img-thumbnail rounded mb-5" alt="Preview" style="width: 150px; height: fit-content "> --}}

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
