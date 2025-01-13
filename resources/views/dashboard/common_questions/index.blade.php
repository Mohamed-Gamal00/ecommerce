@extends('dashboard.index')
@section('title', 'الاسئلة الشائعة')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">الاسئلة الشائعة</li>
@endsection

@section('section')

    <div class="container">
        <x-alert type='success' />
        <x-alert type='info' />
        <x-alert type='dark' />
        <a href="{{ route('common_questions.create') }}" class="btn btn-primary">اضافة سؤال</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>العنوان</th>
                    <th>الوصف</th>
                    <th>اعدادات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($questions as $question)
                    <tr>
                        <td>{{ $question->title }}</td>
                        <td>{{ $question->description }}</td>
                        <td>
                            <a href="{{ route('common_questions.edit', $question->id) }}" class="btn btn-dark">تعديل</a>
                            <form action="{{ route('common_questions.destroy', $question->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
