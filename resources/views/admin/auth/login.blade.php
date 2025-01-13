<!doctype html>
<html lang="en" dir="rtl">

@include('layouts.header')

<body>
    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card overflow-hidden">
                        <div class="bg-primary">
                            <div class="text-primary text-center p-4">
                                <h5 class="text-white font-size-20">مرحبا بعودتك!</h5>
                                <a href="" class="logo logo-admin">
                                    <img src="{{ asset('assets/images/logo-sm.png') }}" height="24" alt="logo">
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="p-3">
                                <form method="POST" action="{{ route('admin.login.store') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">البريد الإلكتروني</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="أدخل البريد الإلكتروني" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">كلمة المرور</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="أدخل كلمة المرور" required>
                                    </div>
                                    @if (session('error'))
                                        <div class="alert alert-danger">{{ session('error') }}</div>
                                    @endif
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">تسجيل
                                            الدخول</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('layouts.scripts')

</body>

</html>
