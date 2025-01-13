@extends('dashboard.index')

@section('title', 'تعديل الشريط المتجرك')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('advertisements.index') }}">الشريط المتحرك</a></li>
    <li class="breadcrumb-item active" aria-current="page">تعديل نص متحرك</li>
@endsection

@section('section')

    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <div class="container">
                        <form action="{{ route('advertisements.update', $advertisement->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="title">العنوان</label>
                                {{-- <input type="text" name="title" class="form-control" id="title"
                                    value="{{ $advertisement->title }}" required> --}}
                                <x-form.input type="text" name="title" required value="{{ $advertisement->title }}"
                                    id="example-text-input" />
                            </div>
                            
                            <div class="form-group">
                                <label for="title_en">العنوان بالانجليزي</label>
                                <x-form.input type="text" name="title_en" value="{{ $advertisement->title_en }}"
                                    id="example-text-input" />
                            </div>

                            
                            <div class="form-group form-check my-3">
                                <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
                                    {{ $advertisement->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    {{ $advertisement->is_active ? 'مفعل' : 'غير مفعل ' }}</label>
                            </div>
                            <button type="submit" class="btn btn-primary">تحديث</button>
                        </form>
                    </div>


                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>


    {{-- Form End --}}

@endsection
