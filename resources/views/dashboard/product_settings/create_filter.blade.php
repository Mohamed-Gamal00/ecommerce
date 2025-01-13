@extends('dashboard.index')
@section('title', 'تصنيفات المنتجات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{route('products_settings.index')}}">خيارات المنتجات</a></li>
    <li class="breadcrumb-item active" aria-current="page">تصنيفات المنتجات</li>
@endsection

@section('section')

    <form action="{{ route('products.filters.update', $productFilter->id) }}" method="post">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <x-alert type='success'/>
                        <x-alert type='dark'/>
                        <h4 class="card-title" style="font-family: Noto Kufi Arabic">التصنيفات</h4>
                        <div data-repeater-list="group-a">
                            <div class="row" data-repeater-item>

                                @forelse ($productFilter->subSettings as $setting)
                                    <div class="mb-3 col-lg-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   value="{{ $setting->id }}" name="filters[]"
                                                   id="setting_{{$setting->id}}"
                                                   id="invalidCheck1"
                                                   checked>
                                            <label class="form-check-label fw-bold"
                                                   for="setting_{{$setting->id}}">
                                                {{ $setting->name }}
                                            </label>

                                        </div>
                                    </div>
                                @empty
                                    <div>لا يوجد تصنيفات</div>
                                @endforelse

                            </div>
                            <!-- end row -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- sub category in edit page --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title" style="font-family: Noto Kufi Arabic">اضافة تصنيف جديد</h4>
                        <div data-repeater-list="group-a">
                            <div class="row" data-repeater-item>
                                @forelse ($productFilter->chiled->subSettings ?? [] as $setting)
                                    @if (!$productFilter->subSettings->contains('id', $setting->id))
                                        <div class="mb-3 col-lg-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                       value="{{ $setting->id }}" name="filters[]"
                                                       id="setting_{{$setting->id}}">
                                                <label class="form-check-label fw-bold"
                                                       for="setting_{{$setting->id}}">
                                                    {{ $setting->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                @empty
                                    <div>لا يوجد تصنيفات</div>
                                @endforelse

                                <!-- end col -->
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div>
            <button class="btn btn-primary mt-5" type="submit">حفظ التعديلات</button>
        </div>
    </form>

@endsection
