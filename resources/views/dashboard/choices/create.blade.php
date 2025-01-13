@extends('dashboard.index')

@section('title', 'اضافة خيار جديد')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('main_choices.index') }}">الخيارات</a></li>
    <li class="breadcrumb-item active" aria-current="page">اضافة خيار جديد</li>
@endsection


@section('section')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#home2" role="tab">
                            <span class="d-none d-md-block">خيار رئيسي</span><span class="d-block d-md-none"><i
                                    class="mdi mdi-home-variant h5"></i></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#profile2" role="tab">
                            <span class="d-none d-md-block">خيار فرعي</span><span class="d-block d-md-none"><i
                                    class="mdi mdi-account h5"></i></span>
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    {{-- main choice --}}
                    <div class="tab-pane active p-3" id="home2" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        {{-- Form Start --}}
                                        <form method="post" action="{{ route('main_choices.store') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="type" value="main">

                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">اسم
                                                    الخيار</label>
                                                <div class="col-sm-10">
                                                    <x-form.input type="text" name="name" id="example-text-input" />
                                                </div>
                                            </div>

                                            <div>
                                                <button class="btn btn-primary mt-5" type="submit">حفظ</button>
                                            </div>
                                        </form>
                                    </div><!-- end cardbody -->
                                </div><!-- end card -->
                            </div> <!-- end col -->
                        </div>
                    </div>
                    {{-- sub choices --}}
                    <div class="tab-pane p-3" id="profile2" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        {{-- Form Start --}}
                                        <form method="post" action="{{ route('main_choices.store') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="type" value="sub">
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">اسم
                                                    الخيار الفرعي</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" name="name" type="text"
                                                        id="example-text-input">
                                                    @error('name')
                                                        <span class="error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                @php
                                                    function buildCategoryOptions(
                                                        $categories,
                                                        $parent_id = null,
                                                        $path = '',
                                                    ) {
                                                        $options = '';
                                                        foreach ($categories as $category) {
                                                            if ($category->parent_id == $parent_id) {
                                                                $fullPath = $path
                                                                    ? $path . ' / ' . $category->name
                                                                    : $category->name;
                                                                $options .=
                                                                    '<option value="' .
                                                                    $category->id .
                                                                    '">' .
                                                                    $fullPath .
                                                                    '</option>';
                                                                $options .= buildCategoryOptions(
                                                                    $categories,
                                                                    $category->id,
                                                                    $fullPath,
                                                                );
                                                            }
                                                        }
                                                        return $options;
                                                    }
                                                @endphp

                                                <div class="row mb-3">
                                                    <div class="form-group">
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label fw-bold">الخيار
                                                                الرئيسي</label>
                                                            <div class="col-sm-10">
                                                                <select name='parent_id' class="form-select"
                                                                    aria-label="Default select example">
                                                                    <option selected>Open this select menu</option>
                                                                    {!! buildCategoryOptions($mainChoices) !!}
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <button class="btn btn-primary mt-5" type="submit">حفظ</button>
                                            </div>
                                        </form>
                                    </div><!-- end cardbody -->
                                </div><!-- end card -->
                            </div> <!-- end col -->
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>



    {{-- Form End --}}

@endsection
