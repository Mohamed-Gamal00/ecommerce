@extends('dashboard.index')
@section('title', 'الاعدادات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">الاعدادات</li>
@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <x-alert type='success'/>
                    <x-alert type='danger'/>

                    {{-- Form Start --}}
                    <form method="post" action="{{ route('profile.settings.update') }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('put')


                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold"> الرقم السري
                                                                                                     الحالي</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="old_password"
                                       data-buttonname="btn-secondary" value="{{ old('old_password') }}">
                                @error('old_password')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">الرقم السري
                                                                                                    الجديد</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="new_password"
                                       data-buttonname="btn-secondary">
                                @error('new_password')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">تأكيد الرقم
                                                                                                    السري</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="new_password_confirmation"
                                       data-buttonname="btn-secondary">
                            </div>
                        </div>


                        <div>
                            <button class="btn btn-primary mt-5" type="submit">حفظ التغييرات</button>
                        </div>
                    </form>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->

        {{-- sub category in edit page --}}
    </div>

@endsection
