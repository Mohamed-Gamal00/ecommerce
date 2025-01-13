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
                      {{$data->description	}}
                    </div>

                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>
@endsection
