@extends('dashboard.index')

@section('title', 'تعديل منتج')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">المنتجات</a></li>
    <li class="breadcrumb-item">تعديل منتج</li>
@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="repeater" action="{{ route('products.update', $product->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <div>
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">اسم
                                    المنتج</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="name" type="text" id="example-text-input"
                                        value="{{ $product->CurrentNameLang }}">
                                    @error('name')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3 mt-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">اسم المنتج
                                    باللغة
                                    الانجليزية</label>
                                <div class="col-sm-10">
                                    <x-form.input type="text" name="name_en" value="{{ $product->name_en }}" />
                                    @error('name_en')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="example-number-input" class="col-sm-2 col-form-label fw-bold">السعر
                                    الحالي</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="price" type="number" value="{{ $product->price }}">
                                    @error('price')
                                        <span class=" error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">السعر بعد
                                    الخصم</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="number" name="discount_price"
                                        value="{{ $product->discount_price }}">
                                    @error('discount_price')
                                        <span class=" error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-number-input" class="col-sm-2 col-form-label fw-bold">الوزن
                                    (كجم)</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="weight" type="number"
                                        value="{{ $product->weight }}">
                                    @error('price')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-number-input" class="col-sm-2 col-form-label fw-bold">الكميه</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="number" name="quantity"
                                        value="{{ $product->quantity }}">
                                    @error('quantity')
                                        <span class=" error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-number-input" class="col-sm-2 col-form-label fw-bold">الوصف</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="7" name="description">{{ $product->description }}</textarea>
                                </div>
                            </div>

                            @if ($companies)
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label fw-bold">تحديد منتج</label>
                                    <div class="col-sm-10">
                                        <select name="company_id" class="form-select" aria-label="البراند الخاص بالمنتج">
                                            <option value="" hidden selected disabled>اختر المنتج الخاص بكود الخصم
                                            </option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}" @selected($product->company_id == $company->id)>
                                                    {{ $company->CurrentNameLang }}</option>
                                            @endforeach

                                        </select>
                                        @error('company_id')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            {{-- categories الاقسام --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label fw-bold">القسم</label>
                                <div class="col-sm-10">
                                    @php
                                        function getSubCategories(
                                            $subCategories,
                                            $prefix = '',
                                            $selectedCategoryId = null,
                                        ) {
                                            $html = '';
                                            foreach ($subCategories as $category) {
                                                $selected = $selectedCategoryId == $category->id ? 'selected' : '';
                                                $html .=
                                                    '<option value="' .
                                                    $category->id .
                                                    '" ' .
                                                    $selected .
                                                    '>' .
                                                    $prefix .
                                                    $category->name .
                                                    '</option>';
                                                if ($category->children->isNotEmpty()) {
                                                    $html .= getSubCategories(
                                                        $category->children,
                                                        $prefix . $category->name . '/',
                                                        $selectedCategoryId,
                                                    );
                                                }
                                            }
                                            return $html;
                                        }
                                    @endphp
                                    <select name='parent_id' id="category" class="form-control">
                                        <option value="" hidden>Select Category</option>
                                        {!! getSubCategories($subCategories, '', $product->category_id) !!}
                                    </select>

                                    @error('parent_id')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>


                            {{-- الخيارات --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label fw-bold">الخيارات</label>
                                <div class="col-sm-10">
                                    <select name="choice_id[]" id="choices" class="form-select multi-select"
                                        aria-label="الخيارات" multiple>
                                        <option></option>
                                    </select>
                                </div>
                            </div>

                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                                $(document).ready(function() {
                                    var selectedChoices = @json($productChoices);

                                    $('#category').change(function() {
                                        var categoryId = $(this).val();
                                        $.ajax({
                                            url: '{{ route('fetch.choices') }}',
                                            type: 'GET',
                                            data: {
                                                category_id: categoryId
                                            },
                                            success: function(response) {
                                                $('#choices').empty();
                                                response.forEach(function(choice) {
                                                    var isSelected = selectedChoices.includes(choice.id) ?
                                                        'selected' : '';
                                                    $('#choices').append('<option value="' + choice.id + '" ' +
                                                        isSelected + '>' + choice.name + '</option>');
                                                });
                                            }
                                        });
                                    });

                                    // Trigger change to load choices if editing
                                    $('#category').trigger('change');
                                });
                            </script>


                            {{-- حالة النشاط --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label fw-bold">حالة النشاط</label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="status" aria-label="Default select example">
                                        @error('status')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                        <option value="" hidden disabled>اختر حالة المنتج</option>
                                        <option value="active" @selected($product->status == 'active')>نشط</option>
                                        <option value="archived" @selected($product->status == 'archived')>غير نشط
                                        </option>
                                    </select>
                                    @error('status')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- حالة  التوفر --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label fw-bold">حالة التوفر</label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="product_availability_id"
                                        aria-label="Default select example">
                                        <option value="" hidden disabled>اختر حالة التوفر للمنتج</option>
                                        @forelse($availability_status as $availability)
                                            <option value="{{ $availability->id }}" @selected($product->product_availability_id == $availability->id)>
                                                {{ $availability->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('availability_status')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- نوع المنتج --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label fw-bold">نوع المنتج</label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="is_special" aria-label="Default select example">
                                        @error('status')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                        <option value="" hidden disabled>اختر نوع المنتج</option>
                                        <option value="1" @selected($product->is_special == '1')>مميز</option>
                                        <option value="0" @selected($product->is_special == '0')>عادي</option>
                                    </select>
                                    @error('is_special')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- الالوان --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label fw-bold">الألوان</label>
                                <div class="col-sm-10">
                                    <select name="colors[]" id="subcategory" class="form-select multi-select"
                                        aria-label="الألوان" multiple>
                                        @foreach ($colors as $color)
                                            <option value="{{ $color->id }}"
                                                {{ in_array($color->id, $product->colors->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                {{ $color->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('colors')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <x-dashboard.image-preview image="{{ $product->image_url }}" fileName="image" width="150"
                            heigh="150" title="الصورة الرئيسية" /> --}}


                            <x-dashboard.image-preview image="{{ $product->image_url }}" fileName="image" width="150"
                                heigh="150" title="الصورة الرئيسية" />


                            {{-- مزيد من الصور --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label fw-bold">صور المنتج</label>
                                <div class="col-sm-10">
                                    <div class="form-body">
                                        <button type="button" class="btn btn-success"
                                            onclick="addProductImageUploadEdit()">المزيد من
                                            الصور
                                        </button>
                                        <div class="image-upload-container">
                                            <div class="image-upload-one">
                                                <!-- Existing image upload elements if any -->
                                            </div>
                                        </div>
                                    </div>


                                    {{-- الصور --}}
                                    <div style="display: ruby;">
                                        @forelse($product->images as $image)
                                            @if ($image->image)
                                                <div id="image-{{ $image->id }}">
                                                    <div class="image-upload-one">
                                                        <div class="center">
                                                            <div class="form-input">
                                                                {{-- image --}}
                                                                <label for="file-ip-1">
                                                                    <div class="image-container">
                                                                        <img alt="Preview"
                                                                            src="{{ asset('storage/' . $image->image) }}"
                                                                            data-holder-rendered="true" id="preview-1">
                                                                        <div class="overlay"></div>
                                                                        <button class="button-remove2" type="button"
                                                                            onclick="confirmProductImageDelete({{ $image->id }})">
                                                                            x
                                                                        </button>

                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @empty
                                        @endforelse
                                    </div>

                                </div>
                            </div>


                            {{-- مميزات --}}

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label fw-bold">مميزات للمنتج ( اختياري )</label>
                                <div class="col-sm-10">
                                    <div class="card">
                                        <div class="card-body">
                                            <div data-repeater-list="product_features">

                                                @if (empty($product->features->first()->feature_name))
                                                    <div class="row" data-repeater-item>
                                                        <div class="mb-3 col-lg-2">
                                                            <label class="form-label fw-bold" for="name">الاسم</label>
                                                            <input type="text" id="name" name="feature_name"
                                                                class="form-control" placeholder="اكتب اسم الميزه" />
                                                            @error('feature_name')
                                                                <span class="error">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3 col-lg-2">
                                                            <label class="form-label fw-bold" for="feature_name_en">الاسم
                                                                بالانجليزي</label>
                                                            <input type="text" id="feature_name_en"
                                                                name="feature_name_en" class="form-control"
                                                                placeholder="الاسم بالانجليزي" />
                                                            @error('feature_name_en')
                                                                <span class="error">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <!-- end col -->
                                                        <input name="feature_id" hidden>

                                                        <div class="mb-3 col-lg-4">
                                                            <label class="form-label fw-bold">الميزه</label>
                                                            <input type="text" name="feature_description"
                                                                class="form-control" placeholder="اكتب وصف الميزه" />
                                                            @error('feature_description')
                                                                <span class="error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-2 col-sm-4 align-self-center">
                                                            <label class="form-label fw-bold"></label>
                                                            <div class="d-grid">
                                                                <input data-repeater-delete type="button"
                                                                    class="btn btn-primary mb-2" value="مسح" />
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endif


                                                @foreach ($product->features as $feature)
                                                    <div class="row" data-repeater-item>
                                                        <div class="mb-3 col-lg-2">
                                                            <label class="form-label fw-bold" for="name">الاسم</label>
                                                            <input type="text" id="name" name="feature_name"
                                                                value="{{ $feature->feature_name }}" class="form-control"
                                                                placeholder="اكتب اسم الميزه" />
                                                            @error('feature_name')
                                                                <span class="error">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3 col-lg-2">
                                                            <label class="form-label fw-bold" for="feature_name_en">الاسم
                                                                بالانجليزي</label>
                                                            <input type="text" id="feature_name_en"
                                                                name="feature_name_en"
                                                                value="{{ $feature->feature_name_en }}"
                                                                class="form-control" placeholder="الاسم بالانجليزي" />
                                                            @error('feature_name_en')
                                                                <span class="error">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <input value="{{ $feature->id }}" name="feature_id" hidden>

                                                        <input value="{{ $feature->id }}" name="feature_delete" hidden>
                                                        <!-- end col -->
                                                        <div class="mb-3 col-lg-4">
                                                            <label class="form-label fw-bold">الميزه</label>
                                                            <input type="text" name="feature_description"
                                                                value="{{ $feature->feature_description }}"
                                                                class="form-control" placeholder="اكتب وصف الميزه" />
                                                            @error('feature_description')
                                                                <span class="error">{{ $message }}</span>
                                                            @enderror
                                                        </div>


                                                        <div class="col-lg-2 col-sm-4 align-self-center">
                                                            <label class="form-label fw-bold"></label>
                                                            <div class="d-grid">
                                                                <input data-repeater-delete type="button"
                                                                    class="btn btn-primary mb-2" value="مسح" />
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endforeach
                                                <!-- end row -->
                                            </div>
                                            <input data-repeater-create type="button"
                                                class="btn btn-success mt-2 mt-sm-0" value="اضافة المزيد" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="row mt-5">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">اضافة مميزات للمنتج ( اختياري )</h4>
                                            <div data-repeater-list="product_features">

                                                @if (empty($product->features->first()->feature_name))
                                                    <div class="row" data-repeater-item>
                                                        <div class="mb-3 col-lg-2">
                                                            <label class="form-label fw-bold" for="name">الاسم</label>
                                                            <input type="text" id="name" name="feature_name"
                                                                class="form-control" placeholder="اكتب اسم الميزه" />
                                                            @error('feature_name')
                                                                <span class="error">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3 col-lg-2">
                                                            <label class="form-label fw-bold" for="feature_name_en">الاسم
                                                                بالانجليزي</label>
                                                            <input type="text" id="feature_name_en"
                                                                name="feature_name_en" class="form-control"
                                                                placeholder="الاسم بالانجليزي" />
                                                            @error('feature_name_en')
                                                                <span class="error">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <!-- end col -->
                                                        <input name="feature_id" hidden>

                                                        <div class="mb-3 col-lg-4">
                                                            <label class="form-label fw-bold">الميزه</label>
                                                            <input type="text" name="feature_description"
                                                                class="form-control" placeholder="اكتب وصف الميزه" />
                                                            @error('feature_description')
                                                                <span class="error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-2 col-sm-4 align-self-center">
                                                            <label class="form-label fw-bold"></label>
                                                            <div class="d-grid">
                                                                <input data-repeater-delete type="button"
                                                                    class="btn btn-primary mb-2" value="مسح" />
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endif


                                                @foreach ($product->features as $feature)
                                                    <div class="row" data-repeater-item>
                                                        <div class="mb-3 col-lg-2">
                                                            <label class="form-label fw-bold" for="name">الاسم</label>
                                                            <input type="text" id="name" name="feature_name"
                                                                value="{{ $feature->feature_name }}" class="form-control"
                                                                placeholder="اكتب اسم الميزه" />
                                                            @error('feature_name')
                                                                <span class="error">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3 col-lg-2">
                                                            <label class="form-label fw-bold" for="feature_name_en">الاسم
                                                                بالانجليزي</label>
                                                            <input type="text" id="feature_name_en"
                                                                name="feature_name_en"
                                                                value="{{ $feature->feature_name_en }}"
                                                                class="form-control" placeholder="الاسم بالانجليزي" />
                                                            @error('feature_name_en')
                                                                <span class="error">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <input value="{{ $feature->id }}" name="feature_id" hidden>

                                                        <input value="{{ $feature->id }}" name="feature_delete" hidden>
                                                        <!-- end col -->
                                                        <div class="mb-3 col-lg-4">
                                                            <label class="form-label fw-bold">الميزه</label>
                                                            <input type="text" name="feature_description"
                                                                value="{{ $feature->feature_description }}"
                                                                class="form-control" placeholder="اكتب وصف الميزه" />
                                                            @error('feature_description')
                                                                <span class="error">{{ $message }}</span>
                                                            @enderror
                                                        </div>


                                                        <div class="col-lg-2 col-sm-4 align-self-center">
                                                            <label class="form-label fw-bold"></label>
                                                            <div class="d-grid">
                                                                <input data-repeater-delete type="button"
                                                                    class="btn btn-primary mb-2" value="مسح" />
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endforeach
                                                <!-- end row -->
                                            </div>
                                            <input data-repeater-create type="button"
                                                class="btn btn-success mt-2 mt-sm-0" value="اضافة المزيد" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                            <div>
                                <button id="submitBtn" class="btn btn-primary mb-5" type="submit">حفظ المنتج</button>
                            </div>
                    </form>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>

@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.multi-select').select2();

    });
</script>


<script>
    document.getElementById('category').addEventListener('change', function() {
        var categoryId = this.value;
        var subcategorySelect = document.getElementById('subcategory');

        // Clear existing options
        subcategorySelect.innerHTML = '';

        // If no main category is selected, hide subcategory select


        subcategorySelect.style.display = 'block'; // Show subcategory select

        fetch(`/admin/sub_category/${categoryId}`)
            .then(response => response.json())
            .then(data => {
                var defaultOption = new Option('', '');
                subcategorySelect.appendChild(defaultOption);

                data.forEach(subcategory => {
                    var option = new Option(subcategory.name, subcategory.id);
                    subcategorySelect.appendChild(option);
                });
            });
    });
</script>

{{-- edit images scripts and styley --}}

<style>
    .image-upload-container {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
    }

    /* .image-upload-one {
        margin: 10px;
    } */

    /* .image-container {
        position: relative;
        width: 200px;
        height: 200px;
    } */

    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-container {
        position: relative;
        display: inline-block;
    }

    .image-container:hover .overlay {
        opacity: 1;
    }

    .image-container:hover .button-remove2 {
        opacity: 1;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Adjust opacity to your preference */
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }

    .button-remove2 {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(1);
        /* Adjust the transform origin to center */
        background-color: transparent;
        border: none;
        color: #fff;
        /* Adjust color as per your design */
        font-weight: bold;
        font-size: 40px;
        padding: 8px 12px;
        border-radius: 50%;
        cursor: pointer;
        transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
        /* Apply transition for both opacity and transform */
        z-index: 1;
        opacity: 0;
    }

    .button-remove2:hover {
        transform: translate(-50%, -50%) scale(1.2);
        /* Scale up the button slightly more on hover */
    }

    .image-upload-one {
        animation: fadeIn 0.5s ease forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }
</style>

<script>
    window.onload = function() {
        addProductImageUploadEdit();
    };

    function previewImage(event, index) {
        const input = event.target;
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById(`preview-${index}`);
            preview.src = reader.result;
        };
        reader.readAsDataURL(input.files[0]);
    }

    function removeImage(index) {
        const preview = document.getElementById(`preview-${index}`);
        const input = document.getElementById(`file-ip-${index}`);
        input.value = "";
        const container = document.querySelector(
            `.image-upload-container #image-upload-${index}`
        );
        container.parentNode.removeChild(container);
    }

    let uploadIndex = 2; // Start with 2 as there's already one input

    function addProductImageUploadEdit() {
        const container = document.querySelector(".image-upload-container");
        const newInput = document.createElement("div");
        newInput.classList.add("image-upload-one");
        newInput.innerHTML = `
                <div class="image-upload-container">
                  <div class="image-upload-one" id="image-upload-${uploadIndex}">
                    <div class="center">
                      <div class="form-input">
                        <label for="file-ip-${uploadIndex}">
                          <div class="image-container">
                            <img alt="Preview" src="" data-holder-rendered="true" id="preview-${uploadIndex}">
                            <div class="overlay"></div>
                            <input type="file" hidden id="file-ip-${uploadIndex}" name="header[${uploadIndex}][image]" accept="image/*" onchange="previewImage(event, ${uploadIndex})">
                            <button class="button-remove2" type="button" onclick="removeImage(${uploadIndex})">x</button>
                          </div>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              `;
        container.appendChild(newInput);

        const baseUrl = window.location.origin;
        const relativeImagePath = "/assets/images/upload-image.jpg";
        const fullImageUrl = baseUrl + relativeImagePath;
        document.getElementById(`preview-${uploadIndex}`).src = fullImageUrl;

        newInput.style.opacity = 0;
        setTimeout(() => {
            newInput.style.opacity = 1;
        }, 10);
        uploadIndex++;
    }
</script>


<script>
    function confirmProductImageDelete(imageId) {
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: 'لن يمكنك التراجع عن هذا الإجراء!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'نعم، قم بالحذف!',
            cancelButtonText: 'لا، ألغِ الأمر'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteProductImage(imageId);
            }
        });
    }

    function deleteProductImage(imageId) {
        console.log(imageId);
        fetch('{{ route('image.delete') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    image_id: imageId
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Log the response for debugging
                if (data.message === 'Image Deleted Successfully') {
                    document.getElementById(`image-${imageId}`).remove();
                    Swal.fire(
                        'تم الحذف!',
                        'تم حذف الصورة بنجاح.',
                        'success'
                    );
                } else {
                    Swal.fire(
                        'فشل!',
                        data.message,
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'فشل!',
                    'فشل في حذف الصورة.',
                    'error'
                );
            });
    }
</script>
@push('scripts')
    <script src="{{ asset('assets/libs/jquery.repeater/jquery.repeater.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/form-repeater.int.js') }}"></script>
@endpush
