@extends('dashboard.index')
@section('title', 'اضافة مدير')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('admins.index') }}">المدراء</a></li>
    <li class="breadcrumb-item">اضافة مدير</li>
@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form method="post" action="{{ route('admins.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label">الاسم</label>

                            <div class="col-sm-10">
                                <x-form.input name="name" type="text" id="example-text-input"
                                    value="{{ old('name') }}" required id="example-text-input" />
                                {{-- <input class="form-control" name="name" type="text" id="example-text-input"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror --}}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label">البريد
                                الالكتروني</label>
                            <div class="col-sm-10">
                                <x-form.input name="email" type="email" id="example-text-input"
                                    value="{{ old('email') }}" required id="example-text-input" />
                                {{-- <input class="form-control" name="email" type="email" id="example-text-input"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <span class="error">{{ $message }}</span>
                                @enderror --}}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label">الرقم
                                السري</label>
                            <div class="col-sm-10">
                                <x-form.input name="new_password" type="password" id="example-text-input" value=""
                                    required id="example-text-input" />
                                {{-- <input class="form-control" name="new_password" type="password" id="example-text-input"
                                    value="">
                                @error('new_password')
                                    <span class="error">{{ $message }}</span>
                                @enderror --}}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label">تأكيد الرقم
                                السري</label>
                            <div class="col-sm-10">
                                {{-- <input class="form-control" name="new_password_confirmation" type="password"
                                    id="example-text-input" value=""> --}}

                                <x-form.input name="new_password_confirmation" type="password" id="example-text-input"  />
                            </div>
                        </div>


                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div> <!-- end col -->

    {{-- sub category in edit page --}}


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3" style="font-family: Noto Kufi Arabic">الصلاحيات</h4>
                    <div data-repeater-list="group-a">
                        <div class="row" data-repeater-item>

                            @forelse ($rules as $rule)
                                <div class="mb-3 col-lg-2">
                                    <div class="form-check">
                                        <input class="form-check-input checkbox-item" type="checkbox"
                                            value="{{ $rule->id }}" name="rules[]" id="setting_{{ $rule->id }}">

                                        <label class="form-check-label fw-bold" for="setting_{{ $rule->id }}">
                                            {{ $rule->name }}
                                        </label>

                                    </div>
                                </div>
                            @empty
                                <div>لا يوجد تصنيفات</div>
                            @endforelse

                        </div>
                        @error('rules')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <!-- end row -->
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div>
        <button class="btn btn-primary mt-5" type="submit">حفظ</button>
    </div>
    </form>

    {{-- Form End --}}

@endsection
