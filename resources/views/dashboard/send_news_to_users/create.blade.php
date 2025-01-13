@extends('dashboard.index')

@section('title', 'النشرة البريدية')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">النشرة البريدية</li>
@endsection

@section('section')

    <x-alert type="success" />
    <div class="row">
        <label for="example-number-input" class="col-sm-8 col-form-label fw-bold">عدد المشتركين في
            النشرة البريدية هو
            : {{ $users->count() }}</label>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{ route('user_news.send') }}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">العنوان</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="title" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-number-input" class="col-sm-2 col-form-label fw-bold">الوصف</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="7" name="body"></textarea>
                                @error('body')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>


                        <button class="btn btn-primary" type="submit">ارسال</button>

                        <div class="row mt-5">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title" style="font-family: Noto Kufi Arabic">المشتركين</h4>
                                        <div data-repeater-list="group-a">
                                            <div class="row" data-repeater-item>


                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" id="selectAllCheckbox">
                                                    <label class="form-check-label fw-bold" for="selectAllCheckbox">
                                                        تحديد الكل
                                                    </label>
                                                </div>

                                                @forelse ($users as $user)
                                                    <div class="mb-3 col-lg-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox-item" type="checkbox"
                                                                value="{{ $user->id }}" name="users[]"
                                                                id="user_{{ $user->id }}">
                                                            <label class="form-check-label fw-bold"
                                                                for="user_{{ $user->id }}">
                                                                {{ $user->email }}
                                                            </label>

                                                        </div>
                                                        @error('users')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                @empty
                                                    <div>لا يوجد مشتركين</div>
                                                @endforelse

                                            </div>
                                            <!-- end row -->
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </form>


                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->

    </div>

    <script>
        document.getElementById('selectAllCheckbox').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.checkbox-item');
            checkboxes.forEach((checkbox) => {
                checkbox.checked = this.checked;
            });
        });
    </script>
    {{-- Form End --}}

@endsection
