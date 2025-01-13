@extends('dashboard.index')
@section('title', 'الشريط المتحرك')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">شريط متحرك</li>

@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">


                    <x-alert type='success' />
                    <x-alert type='dark' />


                    <div class="container">
                        {{-- <a href="{{ route('advertisements.create') }}" class="btn btn-primary">اضف شريط متحرك</a> --}}
                        <table class="table mt-3">
                            <thead>
                                <tr>
                                    <th>العنوان</th>
                                    <th>الحالة</th>
                                    <th>الاعدادات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($advertisements as $advertisement)
                                    <tr>
                                        <td>{{ $advertisement->title }}</td>
                                        <td>{{ $advertisement->is_active ? 'مفعل' : 'غير مفعل ' }}</td>
                                        <td>
                                            <a href="{{ route('advertisements.edit', $advertisement->id) }}"
                                                style="font-size: 12px" ; class="btn btn-primary waves-effect waves-light"
                                                title="تعديل">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            {{-- <form action="{{ route('advertisements.destroy', $advertisement->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form> --}}
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
