@extends('dashboard.index')
@section('title', 'تعديل بنر')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('banners.index') }}">البنرات</a></li>
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
                    <form method="post" action="{{ route('banners.update', $design->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <x-dashboard.image-preview
                            image="{{ Storage::exists('public/' . $design->header_image) ? asset('storage/' . $design->header_image) : '' }}"
                            fileName="header_image" heigh="80" width="200" title="بنر للغة العربية" />

                        <x-dashboard.image-preview
                            image="{{ Storage::exists('public/' . $design->header_image_en) ? asset('storage/' . $design->header_image_en) : '' }}"
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
