@extends('dashboard.index')

@section('title', 'تعديل سؤال')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('common_questions.index') }}">الاسئلة الشائعة</a></li>
    <li class="breadcrumb-item">تعديل سؤال</li>
@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <div class="container">
                        <form action="{{ route('common_questions.update', $commonQuestion->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="title">العنوان</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ $commonQuestion->title }}" required>
                            </div>
                            <div class="form-group my-3">
                                <label for="description">الوصف</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $commonQuestion->description }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-success my-3">تعديل</button>
                        </form>
                    </div>

                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('currency').addEventListener('change', function() {
            var selectedCountryId = this.value;
            var cityCheckboxes = document.querySelectorAll('.city-checkbox');

            cityCheckboxes.forEach(function(checkbox) {
                var currencyId = checkbox.getAttribute('data-currency-id');
                if (selectedCountryId === '' || currencyId !== selectedCountryId) {
                    checkbox.parentElement.parentElement.style.display = 'none';
                } else {
                    checkbox.parentElement.parentElement.style.display = 'block';
                }
            });
        });
    </script>

@endsection
