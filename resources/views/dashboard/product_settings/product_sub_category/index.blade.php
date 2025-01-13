@extends('dashboard.index')

@section('title', 'انشاء تصنيف')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{route('products_settings.index')}}">خيارات المنتجات</a></li>
    <li class="breadcrumb-item">انشاء تصنيف</li>
@endsection

@section('section')
    <x-alert type="success"/>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{route('products.subCategory.store', $product->id)}}" method="post">
                        @csrf

                        <div class="col-sm-10 mb-5">

                            <select name="sub_category_id" class="form-select">
                                <option value="" disabled selected>التصنيفات</option>
                                @foreach ($subCategories->settings as $subCategory)
                                    <option
                                        value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                @endforeach
                            </select>
                            @error('sub_category_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>


                        <div>
                            <button class="btn btn-primary" type="submit">حفظ</button>
                        </div>
                    </form>


                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>

@endsection
