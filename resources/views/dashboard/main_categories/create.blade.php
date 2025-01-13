@extends('dashboard.index')

@section('title', 'اضافة القسم')
<style>
    /* Ensure Select2 styles are correctly applied */
    .select2-container {
        width: 100% !important;
    }
</style>
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('main_categories.index') }}">الأقسام</a></li>
    <li class="breadcrumb-item active" aria-current="page">اضافة قسم</li>
@endsection


@section('section')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#home2" role="tab">
                            <span class="d-none d-md-block">قسم رئيسي</span><span class="d-block d-md-none"><i
                                    class="mdi mdi-home-variant h5"></i></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#profile2" role="tab">
                            <span class="d-none d-md-block">قسم فرعي</span><span class="d-block d-md-none"><i
                                    class="mdi mdi-account h5"></i></span>
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    {{-- main category --}}
                    <div class="tab-pane active p-3" id="home2" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        {{-- Form Start --}}
                                        <form method="post" action="{{ route('main_categories.store') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="type" value="main">

                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">اسم
                                                    القسم</label>
                                                <div class="col-sm-10">
                                                    <x-form.input type="text" name="name" value="{{ old('name') }}"
                                                        id="example-text-input" />
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">اسم
                                                    القسم بالانجليزي</label>
                                                <div class="col-sm-10">
                                                    <x-form.input type="text" name="name_en" value="{{ old('name_en') }}"
                                                        id="example-text-input" />
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label fw-bold">الخيارات</label>
                                                <div class="col-sm-10">
                                                    <select name="choice_id[]" id="subcategory1"
                                                        class="form-select colors-select" aria-label="الخيارات" multiple>
                                                        {!! buildCategoryOptions($mainChoices) !!}
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="example-text-input"
                                                    class="col-sm-2 col-form-label fw-bold">الصورة</label>
                                                <div class="col-sm-10">
                                                    <input id="imageUpload" type="file" class="form-select"
                                                        name="image" data-buttonname="btn-secondary">
                                                    @error('image')
                                                        <span class="error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <img src="#" id="imagePreview" class="img-thumbnail rounded mb-5"
                                                alt="Preview" style="width: 150px; display: none;">
                                            <div>
                                                <button class="btn btn-primary mt-5" type="submit">حفظ القسم</button>
                                            </div>
                                        </form>
                                    </div><!-- end cardbody -->
                                </div><!-- end card -->
                            </div> <!-- end col -->
                        </div>
                    </div>
                    {{-- sub category --}}
                    <div class="tab-pane p-3" id="profile2" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        {{-- Form Start --}}

                                        <form method="post" action="{{ route('main_categories.store') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="type" value="sub">
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">اسم
                                                    القسم الفرعي</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" name="name" type="text"
                                                        id="example-text-input">
                                                    @error('name')
                                                        <span class="error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>




                                            <div class="row mb-3">
                                                <label for="example-text-input"
                                                    class="col-sm-2 col-form-label fw-bold">اسم القسم الفرعي
                                                    بالانجليزي</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" name="name_en" type="text"
                                                        id="example-text-input"
                                                        value="{{ old('name_en') }}">
                                                    @error('name_en')
                                                        <span class="error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label fw-bold">الخيارات</label>
                                                <div class="col-sm-10">
                                                    <select name="choice_id[]" id="subcategory2"
                                                        class="form-select colors-select" aria-label="الخيارات" multiple>
                                                        {!! buildCategoryOptions($mainChoices) !!}
                                                    </select>
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
                                                            <label class="col-sm-2 col-form-label fw-bold">القسم
                                                                الرئيسي</label>
                                                            <div class="col-sm-10">
                                                                <select name='parent_id' class="form-select"
                                                                    aria-label="Default select example">
                                                                    <option selected>Open this select menu</option>
                                                                    {!! buildCategoryOptions($mainCategories) !!}
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <button class="btn btn-primary mt-5" type="submit">حفظ القسم</button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

<script>
    $(document).ready(function() {
        $('.colors-select').select2();
    });
</script>
