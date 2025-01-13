@extends('dashboard.index')
@section('title', 'تعديل البيانات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('admins.index') }}">المدراء</a></li>
    <li class="breadcrumb-item">تعديل البيانات</li>
@endsection


@section('section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <x-alert type='success' />
                <x-alert type='dark' />
                <x-alert type='danger' />
                <div class="card-body">
                    {{-- Form Start --}}
                    <form method="post" action="{{ route('admins.update', $admin->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label">الاسم</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="name" type="text" id="example-text-input"
                                    value="{{ $admin->name }}">
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label">البريد
                                الالكتروني</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="email" type="email" id="example-text-input"
                                    value="{{ $admin->email }}">
                                @error('email')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label">الصلاحيات</label>

                            @forelse ($rules as $rule)
                                <div class="mb-3 col-lg-2">
                                    <div class="form-check">
                                        <input class="form-check-input checkbox-item" type="checkbox"
                                            value="{{ $rule->id }}" name="rules[]" id="setting_{{ $rule->id }}"
                                            {{ in_array($rule->id, $adminRules) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="setting_{{ $rule->id }}">
                                            {{ $rule->name }}
                                        </label>

                                    </div>
                                </div>
                            @empty
                                <div>لا يوجد تصنيفات</div>
                            @endforelse

                        </div>


                        <button class="btn btn-primary mt-5" type="submit">حفظ</button>
                    </form>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->

        {{-- sub category in edit page --}}
    </div>

    {{-- @can('admin.change_password') --}}
        <div class="row mt-5">
            <div class="col-12">
                <div class="font-size-18 fw-bold mb-2">تغيير الرقم السري</div>
                <div class="card">
                    <div class="card-body">
                        {{-- Form Start --}}
                        <form method="post" action="{{ route('admins.update_password', $admin->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')


                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">الرقم
                                    السري</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="new_password" type="password" id="example-text-input"
                                        value="">
                                    @error('new_password')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">تأكيد الرقم
                                    السري</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="new_password_confirmation" type="password"
                                        id="example-text-input" value="">
                                </div>
                            </div>
                            <button class="btn btn-primary mt-5" type="submit">حفظ</button>

                        </form>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div> <!-- end col -->

            {{-- sub category in edit page --}}
        </div>
    {{-- @endcan --}}

    {{-- Form End --}}

@endsection
