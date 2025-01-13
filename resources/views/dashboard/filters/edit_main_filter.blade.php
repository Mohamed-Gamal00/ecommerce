@extends('dashboard.index')

@section('title', 'تعديل التصنيف الرئيسي')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{route('filters.index')}}">التصنيفات</a></li>
    <li class="breadcrumb-item active" aria-current="page"> تعديل التصنيف الرئيسي</li>
@endsection


@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <x-alert type="success"/>
                    <x-alert type='dark'/>

                    <h4 class="card-title"> تعديل اسم التصنيف الرئيسي</h4>

                    <form class="repeater" method="post" action="{{ route('filters.update', $filter->id) }}">
                        @csrf
                        @method('put')
                        <div data-repeater-list="group-a">
                            <div class="row" data-repeater-item>
                                <div class="mb-3 col-lg-4">
                                    <label class="form-label" for="name">اسم التصنيف</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                           value="{{$filter->name}}"/>
                                    @error('name')
                                    <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mt-2 mt-sm-0">حفظ</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection
