@extends('dashboard.index')

@section('title', 'اضافة سؤال')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('common_questions.index') }}">الاسئلة الشائعة</a></li>
    <li class="breadcrumb-item">انشاء سؤال</li>
@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <div class="container">
                        <form action="{{ route('common_questions.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="title">العنوان</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="form-group my-3">
                                <label for="description">الوصف</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success my-3">اضافة</button>
                        </form>
                    </div>

                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>

@endsection
