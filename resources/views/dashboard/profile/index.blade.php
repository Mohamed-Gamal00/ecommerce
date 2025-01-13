@extends('dashboard.index')
@section('title', 'البيانات الشخصيه')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">البيانات الشخصيه</li>
@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <x-alert type='success'/>
                    <x-alert type='dark'/>
                    {{-- Form Start --}}
                    <form method="post" action="{{ route('profile.update', $admin->id) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label">الاسم:</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="name" type="text" id="example-text-input"
                                       value="{{Auth::guard('admin')->user()->name}}">
                                @error('name')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label">البريد
                                                                                            الالكتروني:</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="email" type="text" id="example-text-input"
                                       value="{{Auth::guard('admin')->user()->email}}">
                                @error('email')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label">تغيير الصورة
                                                                                            الشخصيه</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-select" name="image"
                                       data-buttonname="btn-secondary" accept="image/*">
                                @error('image')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            @if($admin->image)
                                <img class="img-thumbnail rounded me-2 col-sm-2" alt="200x200" width="200"
                                     src="{{asset('storage/'. $admin->image) }}" data-holder-rendered="true">
                            @else
                                <img class="img-thumbnail rounded me-2 col-sm-2" alt="200x200" width="200"
                                     src="{{asset('assets/images/admin.jpg') }}" data-holder-rendered="true">

                            @endif
                        </div>


                        <div>
                            <button class="btn btn-primary mt-5" type="submit">حفظ التعديل</button>
                        </div>
                    </form>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->

        {{-- sub category in edit page --}}
    </div>

@endsection
