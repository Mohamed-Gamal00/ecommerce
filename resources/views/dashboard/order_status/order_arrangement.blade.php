@extends('dashboard.index')

@section('title', 'ترتيب حالات الطلب')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{route('order_status.index')}}">حالات الطلب</a></li>
    <li class="breadcrumb-item active">ترتيب حالات الطلب</li>
@endsection

@section('section')

    <!-- end page title -->
    <x-alert type='success'/>
    <x-alert type='danger'/>
    <x-alert type='info'/>

    <form action="{{route('order_status.arranging_update')}}" method="post">
        @forelse($orderStatus as $staus)
            @csrf
            @method('put')
            <div class="row mb-3">
                <label class="col-sm-1 col-form-label fw-bold">{{$val = $counter++}}</label>

                <div class="col-sm-10">
                    <select class="form-select" name="statuses_id[{{$val}}]"
                            aria-label="Default select example">
                        <option value="" disabled selected hidden>اختر حالة التوفر للمنتج</option>
                        @foreach($orderStatus as $staus)
                            <option
                                value="{{$staus->id}}" @selected($val == $staus->arrangement)>{{$staus->name}}</option>
                        @endforeach
                    </select>
                    @error('product_availability_id')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

        @empty
        @endforelse
        <button type="submit"
                class="btn btn-primary waves-effect waves-light">حفظ الترتيب
        </button>
    </form>






    {{-- Form End --}}

@endsection
