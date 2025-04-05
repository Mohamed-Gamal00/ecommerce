@extends('dashboard.index')

@section('title', 'انشاء منتج')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">المنتجات</a></li>
    <li class="breadcrumb-item">انشاء منتج</li>
@endsection

@section('section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- Form Start --}}
                    <form class="repeater" action="{{ route('products.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3 mt-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">اسم المنتج</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="name" value="{{ old('name') }}" />
                            </div>
                        </div>
                        <div class="row mb-3 mt-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">اسم المنتج باللغة
                                الانجليزية</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="name_en" value="{{ old('name_en') }}" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">السعر الحالي</label>
                            <div class="col-sm-10">
                                <x-form.input type="number" name="price" value="{{ old('price') }}" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">السعر بعد
                                الخصم</label>
                            <div class="col-sm-10">
                                <x-form.input type="number" name="discount_price" value="{{ old('discount_price') }}" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">الوزن (كجم)</label>
                            <div class="col-sm-10">
                                <x-form.input type="number" name="weight" value="{{ old('weight') }}" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">الكميه</label>
                            <div class="col-sm-10">
                                <x-form.input type="number" name="quantity" value="{{ old('quantity') }}" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-number-input" class="col-sm-2 col-form-label fw-bold">الوصف</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="7" name="description">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        @if ($companies)
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label fw-bold">البراند</label>
                                <div class="col-sm-10">
                                    <select name="company_id" class="form-select" aria-label="البراند الخاص بالمنتج">
                                        <option value="" hidden selected disabled>اختر البراند الخاص بالمنتج</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">
                                                {{ $company->CurrentNameLang }}</option>
                                        @endforeach

                                    </select>
                                    @error('company_id')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endif


                        {{-- الاقسام --}}
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">القسم</label>
                            <div class="col-sm-10">
                                @php
                                    function getSubCategories($subCategories, $prefix = '')
                                    {
                                        $html = '';
                                        foreach ($subCategories as $category) {
                                            $html .=
                                                '<option value="' .
                                                $category->id .
                                                '">' .
                                                $prefix .
                                                $category->name .
                                                '</option>';
                                            if ($category->children->isNotEmpty()) {
                                                $html .= getSubCategories(
                                                    $category->children,
                                                    $prefix . $category->name . '/',
                                                );
                                            }
                                        }
                                        return $html;
                                    }
                                @endphp
                                <select name='parent_id' id="category" class="form-control">
                                    <option value="">اختار</option>
                                    {!! getSubCategories($subCategories) !!}
                                </select>


                                @error('status')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- الخيارات --}}
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">الخيارات</label>
                            <div class="col-sm-10">
                                <select name="choice_id[]" id="choices" class="form-select multi-select" multiple>
                                    <!-- سيتم تعبئتها ديناميكيًا من خلال الـ JavaScript -->
                                </select>
                            </div>
                        </div>

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            $(document).ready(function() {
                                $.ajax({
                                    url: '{{ route('fetch.choices') }}', // تأكد أن هذا يعيد فقط الخيارات الرئيسية
                                    type: 'GET',
                                    success: function(response) {
                                        let choicesDropdown = $('#choices');
                                        choicesDropdown.empty(); // تفريغ القائمة قبل الإضافة

                                        response.forEach(function(choice) {
                                            let mainOption = $('<option>', {
                                                value: choice.id,
                                                text: choice.name
                                            });

                                            choicesDropdown.append(mainOption); // إضافة الخيار الرئيسي فقط
                                        });
                                    },
                                    error: function(xhr, status, error) {
                                        console.error("Error fetching choices:", error);
                                    }
                                });
                            });
                        </script>



                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">حالة النشاط </label>
                            <div class="col-sm-10">
                                <select class="form-select" name="status" aria-label="Default select example">
                                    @error('status')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                    <option hidden disabled>اختر حالة المنتج</option>
                                    <option selected value="active">نشط</option>
                                    <option value="archived">غير نشط</option>
                                </select>
                                @error('status')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">حالة التوفر</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="product_availability_id"
                                    aria-label="Default select example">
                                    <option value="" disabled selected hidden>اختر حالة التوفر للمنتج</option>
                                    @forelse($availability_status as $availability)
                                        <option value="{{ $availability->id }}">{{ $availability->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                @error('product_availability_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">نوع المنتج</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="is_special" aria-label="Default select example">
                                    @error('is_special')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                    <option value="1">مميز</option>
                                    <option value="0" selected>عادي</option>
                                </select>
                                @error('status')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- الصورة الرئيسية --}}
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">الصورة
                                الرئيسية</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="image" id="imageUpload"
                                    data-buttonname="btn-secondary" accept="image/*">
                                @error('image')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <img src="#" id="imagePreview" class="img-thumbnail rounded mb-5" alt="Preview"
                            style="width: 150px; display: none;">
                        {{-- الصور --}}
                        <div class="form-body">
                            <button type="button" class="btn btn-success" onclick="addProductImageUpload()">المزيد من
                                الصور
                            </button>
                            <div class="image-upload-container">
                                <div class="image-upload-one">
                                    <!-- Existing image upload elements if any -->
                                </div>
                            </div>
                        </div>


                        {{-- الالوان --}}
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">الألوان</label>
                            <div class="col-sm-10">

                                <select name="colors[]" id="subcategory1" class="form-select multi-select"
                                    aria-label="الألوان" multiple>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                    @endforeach
                                </select>

                                @error('colors')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- مميزات المنتج --}}
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">اضافة مميزات للمنتج ( اختياري )</h4>
                                        <div data-repeater-list="product_features">
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
                                                    <label class="form-label fw-bold" for="name">الاسم
                                                        بالانجليزي</label>
                                                    <input type="text" id="name" name="feature_name_en"
                                                        class="form-control" placeholder="الاسم بالانجلليزي" />
                                                    @error('feature_name_en')
                                                        <span class="error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <!-- end col -->
                                                <div class="mb-3 col-lg-4">
                                                    <label class="form-label fw-bold">الميزه</label>
                                                    <input type="text" name="feature_description" class="form-control"
                                                        placeholder="اكتب وصف الميزه" />
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
                                        </div>
                                        <input data-repeater-create type="button" class="btn btn-success mt-2 mt-sm-0"
                                            value="اضافة المزيد" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>

                            <div>

                                <button class="btn btn-primary" type="submit">حفظ المنتج</button>
                            </div>
                    </form>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>

    <style>
        .image-upload-container {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }

        .image-upload-one {
            margin: 10px;
        }

        .image-container {
            position: relative;
            width: 200px;
            height: 200px;
        }

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

    <script></script>



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
            if (categoryId === '') {
                subcategorySelect.style.display = 'none';
                return;
            }

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

    <script>
        window.onload = function() {
            addProductImageUpload();
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

        function addProductImageUpload() {
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


    @push('scripts')
        <script src="{{ asset('assets/libs/jquery.repeater/jquery.repeater.min.js') }}"></script>

        <script src="{{ asset('assets/js/pages/form-repeater.int.js') }}"></script>
    @endpush

@endsection
