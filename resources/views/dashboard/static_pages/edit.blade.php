@extends('dashboard.index')

@section('title', 'تعديل صفحة الموقع')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('pages.index') }}">صفحات الموقع</a></li>
    <li class="breadcrumb-item active" aria-current="page">تعديل</li>
@endsection

@section('section')

    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <div class="container">
                        <form action="{{ route('pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                {{-- <label for="title">العنوان</label> --}}
                                {{-- <x-form.input type="text" name="title" value="{{ $page->title }}" required id="example-text-input" /> --}}

                                {{-- <input type="text" readonly name="title" class="form-control" id="title"
                                    value="{{ $page->title }}" required> --}}
                                <input type="hidden" readonly name="title" class="form-control" id="title"
                                    value="{{ $page->title }}" required>
                            </div>
                            <div class="form-group my-3">
                                <label for="content">المحتوي</label>
                                {{-- <textarea name="content" class="form-control text-editor" id="content" required>{{ $page->content }}</textarea> --}}
                                <textarea id="elm1" name="content">{!! $page->content !!}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">تحديث</button>
                        </form>
                    </div>
                @endsection

                @section('scripts')
                    <!--tinymce js-->
                    <script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>

                    <!-- init js -->
                    <script src="{{ asset('assets/js/pages/form-editor.init.js') }}"></script>
                    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/classic/ckeditor.js"></script>
                    <script>
                        ClassicEditor.create(document.querySelector('.text-editor')).catch(error => {
                            console.error(error);
                        });
                    </script> --}}

                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>


    {{-- Form End --}}

@endsection
