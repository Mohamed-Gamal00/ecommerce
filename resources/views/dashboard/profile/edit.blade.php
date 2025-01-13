@extends('dashboard.index')
@section('title', 'التصميم')

@section('section')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="page-title-box">
                <x-alert type='success'/>
                <x-alert type='danger'/>

                <div class="row align-items-center">

                    <div class="col-md-4">
                        <div class="float-end d-none d-md-block">
                            <div class="dropdown">

                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Separated link</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
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


                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div> <!-- end col -->

                {{-- sub category in edit page --}}
            </div>
            <div>
                <button class="btn btn-primary mt-5" type="submit">حفظ التغييرات</button>
            </div>
            </form>

            {{-- Form End --}}


        </div> <!-- container-fluid -->
    </div>

@endsection
