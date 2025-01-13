@extends('dashboard.index')

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form method="post" action="{{ route('products.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label">اسم
                                                                                            المنتج</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="name" type="text" id="example-text-input">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-number-input" class="col-sm-2 col-form-label">السعر</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="price" type="number" id="example-number-input">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-number-input" class="col-sm-2 col-form-label">الخصم</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="number" name="compare_price"
                                       id="example-number-input">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-number-input" class="col-sm-2 col-form-label">الوصف</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="7" name="description"
                                          id="example-number-input"></textarea>
                            </div>
                        </div>


                        <livewire:categories/>
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
                             src="assets/images/small/img-3.jpg" data-holder-rendered="true">

                        <button class="btn btn-primary" type="submit">حفظ المنتج</button>
                    </form>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>

    {{-- Form End --}}

@endsection
