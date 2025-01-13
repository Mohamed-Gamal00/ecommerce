@extends('dashboard.index')

@section('section')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h6 class="page-title">Dashboard</h6>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Welcome to Veltrix Dashboard</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        <div class="float-end d-none d-md-block">
                            <div class="dropdown">

                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Separated link</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- Form Start --}}
                            <form method="post" action="{{ route('products.update', $product->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">اسم
                                        المنتج</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="name" type="text" id="example-text-input"
                                            value="{{ $product->CurrentNameLang }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-number-input" class="col-sm-2 col-form-label">السعر</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="price" type="number"
                                            id="example-number-input"value="{{ $product->price }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-number-input" class="col-sm-2 col-form-label">الخصم</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="number" name="compare_price"
                                            id="example-number-input" value="{{ $product->compare_price }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-number-input" class="col-sm-2 col-form-label">الوصف</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" rows="7" name="description" id="example-number-input">value="{{ $product->description }}"</textarea>
                                    </div>
                                </div>


                                <livewire:categories />
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">حالة المنتج</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" name="status" aria-label="Default select example">
                                            <option selected>Open this select menu</option>
                                            <option value="active">نشط</option>
                                            <option value="archived">غير نشط</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">الصورة</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-select" name="image"
                                            data-buttonname="btn-secondary">
                                    </div>
                                </div>


                                <img class="img-thumbnail rounded me-2" alt="200x200" width="200"
                                    src="{{ asset('storage/' . $product->image) }}" data-holder-rendered="true">

                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div> <!-- end col -->
            </div>
            <button class="btn btn-primary" type="submit">حفظ المنتج</button>
            </form>

            {{-- Form End --}}


        </div> <!-- container-fluid -->
    </div>
@endsection
