@extends('dashboard.index')
@section('title', 'التصميم')

@section('section')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="page-title-box">
                <x-alert type='success'/>
                <x-alert type='dark'/>

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
                            <form method="post" action="{{ route('admins.store') }}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">الاسم</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="name" type="text" id="example-text-input"
                                               value="">
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
                                               value="">
                                        @error('email')
                                        <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">الرقم السري</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="password" type="password"
                                               id="example-text-input"
                                               value="">
                                        @error('password')
                                        <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">تأكيد الرقم
                                                                                                    السري</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="password_confirmation" type="password"
                                               id="example-text-input"
                                               value="">
                                    </div>
                                </div>

                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div> <!-- end col -->

                {{-- sub category in edit page --}}
            </div>


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
                                                       value="{{$rule->id}}"
                                                       name="rules[]"
                                                       id="setting_{{$rule->id}}">
                                                <label class="form-check-label fw-bold"
                                                       for="setting_{{$rule->id}}">
                                                    {{ $rule->name }}
                                                </label>

                                            </div>
                                        </div>
                                    @empty
                                        <div>لا يوجد فلاتر</div>
                                    @endforelse

                                </div>
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


        </div> <!-- container-fluid -->
    </div>

@endsection
