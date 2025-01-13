@extends('dashboard.index')

@section('title', 'مشاهدة الرسالة')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{route('contact_us.index')}}">الرسائل</a></li>
    <li class="breadcrumb-item active">مشاهدة الرساله</li>
@endsection

@section('section')

    <div class="card-body">

        <div class="d-flex mb-4">
            <div class="flex-shrink-0 me-3">
            </div>
            <div class="flex-grow-1">
                <small class="text-muted">الاسم :</small>
                <h4 class="font-size-15 m-0">{{$message->name}}</h4>
            </div>

            <div class="flex-grow-1">
                <small class="text-muted">البريد الالكتروني :</small>
                <h4 class="font-size-15 m-0">{{$message->email}}</h4>
            </div>

            <div class="flex-grow-1">
                <small class="text-muted">رقم الهاتف :</small>
                <h4 class="font-size-15 m-0">{{$message->phone_number}}</h4>
            </div>
        </div>

        <h4 class="font-size-16">الرسالة</h4>

        <p>{{$message->message}}</p>

        <hr/>
    </div>
    </div>

@endsection
