@extends('dashboard.index')
@section('title', 'تعديل خيار')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('main_choices.index') }}">الخيارات</a></li>
    <li class="breadcrumb-item active" aria-current="page">تعديل خيار</li>
@endsection

@php
    $activeTab = $choice->parent_id ? 'sub' : 'main';
@endphp
@section('section')

    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'main' ? 'active' : '' }}" data-bs-toggle="tab" href="#home2" role="tab">
                <span class="d-none d-md-block">خيار رئيسي</span><span class="d-block d-md-none"><i
                        class="mdi mdi-home-variant h5"></i></span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'sub' ? 'active' : '' }}" data-bs-toggle="tab" href="#profile2"
                role="tab">
                <span class="d-none d-md-block">خيار فرعي</span><span class="d-block d-md-none"><i
                        class="mdi mdi-account h5"></i></span>
            </a>
        </li>
    </ul>

    <div class="tab-content">
        {{-- Main choice Edit --}}
        <div class="tab-pane {{ $activeTab == 'main' ? 'active' : '' }} p-3" id="home2" role="tabpanel">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- Form Start --}}
                            <form method="post" action="{{ route('main_choices.update', $choice->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="type" value="main">
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">اسم
                                        الخيار</label>
                                    <div class="col-sm-10">
                                        {{-- <input class="form-control" name="name" type="text" id="example-text-input"
                                            value="{{ old('name', $choice->name) }}">
                                        @error('name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror --}}
                                        <x-form.input name="name" type="text" value="{{ old('name', $choice->name) }}"  id="example-text-input" />

                                    </div>
                                </div>

                                <div>
                                    <button class="btn btn-primary mt-5" type="submit">تحديث الخيار</button>
                                </div>
                            </form>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div> <!-- end col -->
            </div>
        </div>
        {{-- Sub choice Edit --}}
        <div class="tab-pane {{ $activeTab == 'sub' ? 'active' : '' }} p-3" id="profile2" role="tabpanel">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- Form Start --}}
                            <form method="post" action="{{ route('main_choices.update', $choice->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="type" value="sub">
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">اسم الخيار
                                        الفرعي</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="name" type="text" id="example-text-input"
                                            value="{{ old('name', $choice->name) }}">
                                        @error('name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="form-group">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label fw-bold">الخيار الرئيسي</label>
                                            <div class="col-sm-10">
                                                <select name='parent_id' class="form-select"
                                                    aria-label="Default select example">
                                                    <option selected>Open this select menu</option>
                                                    {!! buildchoiceOptions($mainChoices, null, '', $choice->parent_id) !!}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-primary mt-5" type="submit">تحديث الخيار</button>
                                </div>
                            </form>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div> <!-- end col -->
            </div>
        </div>
    </div>

@endsection

@php
    function buildchoiceOptions($categories, $parent_id = null, $path = '', $selectedId = null)
    {
        $options = '';
        foreach ($categories as $choice) {
            if ($choice->parent_id == $parent_id) {
                $fullPath = $path ? $path . ' / ' . $choice->name : $choice->name;
                $selected = $selectedId == $choice->id ? 'selected' : '';
                $options .= '<option value="' . $choice->id . '" ' . $selected . '>' . $fullPath . '</option>';
                $options .= buildchoiceOptions($categories, $choice->id, $fullPath, $selectedId);
            }
        }
        return $options;
    }
@endphp
