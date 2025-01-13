@extends('dashboard.index')

@section('title', 'اضافةشريط متحرك')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('advertisements.index') }}">الشريط المتحرك</a></li>
    <li class="breadcrumb-item active" aria-current="page">انشاء شريط متحرك</li>
@endsection

@section('section')

    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <div class="container">
                        <form action="{{ route('advertisements.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="title">العنوان</label>
                                {{-- <input type="text" name="title" class="form-control" id="title" required> --}}
                                <x-form.input type="text" name="title"
                                    id="example-text-input" />

                            </div>
                            <div class="form-group form-check my-3">
                                <input type="checkbox" name="is_active" class="form-check-input" id="is_active">
                                <label class="form-check-label"
                                    for="is_active">{{ $advertisement->is_active ? 'مفعل' : 'غير مفعل ' }}</label>
                            </div>
                            <button type="submit" class="btn btn-primary">اضافة</button>
                        </form>
                    </div>

                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>


    {{-- Form End --}}

@endsection
