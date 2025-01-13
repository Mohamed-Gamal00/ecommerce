@extends('dashboard.index')
@section('style')
    <style>
        .form-group {
            margin-bottom: 15px;
            margin-top: 15px;
        }
    </style>

    @push('styles')
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
    @endpush
@endsection
@section('section')
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                {{-- <div class="btn-back">
                    <a style="float: left" href="{{ route('pages.index') }}" class="btn btn-primary  "><i class="fa fa-reply"
                            aria-hidden="true"></i></a>
                </div> --}}

            </div>
        </div>
        <!-- start page title -->
        <div class="page-title-box">
            <div class="row mb-3 align-items-center">
                <h4 class="content-header-title float-left mb-0">صور وبيانات واجهة الموقع</h4>
            </div>
        </div>
        <!-- end page title -->

        {{-- @include('dashboard.layouts.includes.alerts.success') --}}

        <div class="row mb-3">
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
                        <form method="post" class="form form-vertical"
                              action="{{ route('header_banner.sotreAndUpdate') }}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">

                                <button type="button" class="btn btn-success" onclick="addImageUpload()">المزيد من
                                    الصور
                                </button>

                                <div class="image-upload-container">
                                    <div class="image-upload-one">

                                    </div>

                                </div>

                            </div>

                            <div style="display: ruby;">
                                @forelse($headerImages as $image)
                                    <div id="image-{{ $image->id }}">
                                        <div class="image-upload-one">
                                            <div class="center">
                                                <div class="form-input">
                                                    <!-- Arabic Image -->
                                                    @if ($image->header_image)
                                                        <label>
                                                            <div class="image-container">
                                                                <img src="{{ asset('storage/' . $image->header_image) }}"
                                                                     alt="Arabic Image">
                                                                <button class="button-remove2" type="button"
                                                                        onclick="confirmImageDelete({{ $image->id }})">x
                                                                </button>
                                                            </div>
                                                        </label>
                                                    @endif

                                                    <!-- English Image -->
                                                    @if ($image->header_image_en)
                                                        <label>
                                                            <div class="image-container">
                                                                <img src="{{ asset('storage/' . $image->header_image_en) }}"
                                                                     alt="English Image">
                                                            </div>
                                                        </label>
                                                    @endif

                                                    <input value="{{ $image->image_link }}" type="text"
                                                           class="form-control"
                                                           name="change_image_link[{{ $image->id }}]"
                                                           placeholder="ضع رابط الصورة هنا">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p>لا يوجد صور.</p>
                                @endforelse

                            </div>

                            <div class="col-12 my-3">
                                <button type="submit" class="btn btn-primary mr-1 mb-5 waves-effect waves-light">حفظ
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div> <!-- end col -->



    <script>
        function confirmImageDelete(imageId) {
            console.log('dbhbb');
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
                    deleteHeaderImage(imageId);
                }
            });
        }

        function deleteHeaderImage(imageId) {
            fetch('{{ route('headerImage.remove') }}', {
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
                            'فشل في حذف الصورة.',
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
@endsection
