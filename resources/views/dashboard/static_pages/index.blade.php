@extends('dashboard.index')
@section('title', 'صفحات الموقع')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">صفحات الموقع</li>

@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">


                    <x-alert type='success' />
                    <x-alert type='dark' />


                    <div class="container">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>العنوان</th>
                                    <th>الاعدادات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pages as $page)
                                    <tr>
                                        <td>{{ $page->title }}</td>
                                        <td>
                                            <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-primary">تعديل</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- end -->
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
