@extends('dashboard.index')

@section('title', 'تعديل طلب')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('representatives_orders.index') }}">طلبات الشراء بالجملة</a></li>
    <li class="breadcrumb-item">تعديل طلب</li>
@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <div class="container">
                        <form action="{{ route('bulk_orders.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">الاسم</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $order->name }}" required>
                            </div>
                            <div class="form-group my-3">
                                <label for="phone">الهاتف</label>
                                <input type="number" class="form-control" id="phone" name="phone"
                                    value="{{ $order->phone }}" required>
                            </div>
                            <div class="form-group my-3">
                                <label for="company_name">اسم الشركة او الجهة</label>
                                <input type="text" class="form-control" id="company_name" name="company_name"
                                    value="{{ $order->company_name }}" required>
                            </div>
                            <div class="form-group my-3">
                                <label for="description">انواع المنتجات المطلوبة	</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $order->description }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-success">تعديل</button>
                        </form>
                    </div>

                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('currency').addEventListener('change', function() {
            var selectedCountryId = this.value;
            var cityCheckboxes = document.querySelectorAll('.city-checkbox');

            cityCheckboxes.forEach(function(checkbox) {
                var currencyId = checkbox.getAttribute('data-currency-id');
                if (selectedCountryId === '' || currencyId !== selectedCountryId) {
                    checkbox.parentElement.parentElement.style.display = 'none';
                } else {
                    checkbox.parentElement.parentElement.style.display = 'block';
                }
            });
        });
    </script>

@endsection
