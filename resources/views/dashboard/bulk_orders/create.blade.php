@extends('dashboard.index')

@section('title', ' اضافة طلب')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('bulk_orders.index') }}">طلبات الشراء بالجملة</a></li>
    <li class="breadcrumb-item">انشاء طلب</li>
@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <div class="container">
                        <form action="{{ route('bulk_orders.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">الاسم</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group my-3">
                                <label for="phone">الهاتف</label>
                                <input type="number" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="form-group my-3">
                                <label for="company_name">اسم الشركة او الجهة</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" required>
                            </div>
                            <div class="form-group my-3">
                                <label for="description">انواع المنتجات المطلوبة	</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">اضافة</button>
                        </form>
                    </div>

                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>

@endsection
