@extends('dashboard.index')
@section('title', 'انشاء بنر')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('designs.index') }}">البنرات</a></li>
    <li class="breadcrumb-item active" aria-current="page">انشاء بنر</li>
@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <x-alert type='success' />
                    <x-alert type='dark' />
                    {{-- Form Start --}}
                    <form method="post" action="{{ route('designs.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">عنوان البنر</label>
                            <div class="col-sm-10">
                                {{-- <x-form.input type="text" name="title" /> --}}
                                <input class="form-control" name="title" type="text" id="example-text-input"
                                    value="">

                                @error('title')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="example-number-input" class="col-sm-2 col-form-label fw-bold">الوصف</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="7" name="description"></textarea>
                                @error('description')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">البنر</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-select" name="image" data-buttonname="btn-secondary"
                                    accept="image/*">
                                @error('image')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
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
