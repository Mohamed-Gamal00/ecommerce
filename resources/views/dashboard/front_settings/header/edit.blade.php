@extends('dashboard.index')

@section('title', 'تعديل نص متحرك')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{route('header_text.index')}}">النصوص المتحركه</a></li>
    <li class="breadcrumb-item active" aria-current="page">تعديل نص متحرك</li>
@endsection

@section('section')

    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{route('header_text.update', $headerText->id)}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">عنوان النص</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="title" type="text" value="{{$headerText->title}}">
                                @error('title')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input"
                                   class="col-sm-2 col-form-label fw-bold">النص</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="7"
                                          name="description">{{$headerText->description}}</textarea>
                                @error('description')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">حفظ النص</button>
                    </form>


                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>


    {{-- Form End --}}

@endsection
