@extends('dashboard.index')
@section('title', 'تعديل البيانات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{route('clients.index')}}">العملاء</a></li>
    <li class="breadcrumb-item">تغيير الرقم السري</li>
@endsection

@section('section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <x-alert type="success"/>
                <x-alert type="dark"/>
                <div class="card-body">
                    {{-- Form Start --}}
                    <form method="post" action="{{ route('clients.update', $client->id) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('put')


                        <div class="row mb-3 mt-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">الاسم
                                                                                                    الاول</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" value="{{$client->first_name}}" name="first_name"/>
                            </div>
                        </div>

                        <div class="row mb-3 mt-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">الاسم
                                                                                                    الاخير</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" value="{{$client->family_name}}" name="family_name"/>
                            </div>
                        </div>

                        <div class="row mb-3 mt-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">البريد
                                                                                                    الالكتروني</label>
                            <div class="col-sm-10">
                                <x-form.input type="email" value="{{$client->email}}" name="email"/>
                            </div>
                        </div>

                        <div class="row mb-3 mt-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">رقم
                                                                                                    الهاتف</label>
                            <div class="col-sm-10">
                                <x-form.input type="number" value="{{$client->phone_number}}" name="phone_number"/>
                            </div>
                        </div>

                        <button class="btn btn-primary mt-5" type="submit">حفظ</button>

                    </form>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->

        {{-- sub category in edit page --}}
    </div>

    {{-- @can('client.edit') --}}
        <div class="row">
            <div class="col-12">
                <div class="font-size-18 fw-bold mb-2">تغيير الرقم السري</div>
                <div class="card">
                    <div class="card-body">
                        {{-- Form Start --}}
                        <form method="post" action="{{ route('client.update_password', $client->id) }}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')


                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">الرقم
                                                                                                        السري</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="new_password" type="password"
                                           id="example-text-input"
                                           value="">
                                    @error('new_password')
                                    <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">تأكيد الرقم
                                                                                                        السري</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="new_password_confirmation" type="password"
                                           id="example-text-input"
                                           value="">
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
