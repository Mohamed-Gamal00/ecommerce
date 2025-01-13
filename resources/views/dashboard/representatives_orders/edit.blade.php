@extends('dashboard.index')

@section('title', 'تعديل طلب')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('representatives_orders.index') }}">طلبات المناديب</a></li>
    <li class="breadcrumb-item">تعديل طلب</li>
@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <div class="container">
                        <form action="{{ route('representatives_orders.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">الاسم</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $order->name }}" required>
                            </div>
                            <div class="form-group my-3">
                                <label for="phone">الهاتف</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ $order->phone }}" required>
                            </div>
                            <div class="form-group my-3">
                                <label for="description">الوصف</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $order->description }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-success">تعديل</button>
                        </form>
                    </div>

                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>

@endsection
