@extends('dashboard.index')

@section('title', 'مشاهدة ارجاع الطلبات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{route('return_orders.index')}}">ارجاع الطلبات</a></li>
    <li class="breadcrumb-item">مشاهدة ارجاع الطلب</li>
@endsection

@section('section')

    <div class="row font-size-20">
        اسم العميل
        : {{$order->addresses->first()->first_name . ' ' . $order->addresses->first()->last_name}}

        - رقم الطلب هو : {{$order->number . '#' }}
    </div>

    <div class="row">
        @forelse($order->orderItems as $item)
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">اسم المنتج :{{$item->product->name}}</h4>
                        <ol class="activity-feed">
                            <li class="feed-item">
                                <div class="feed-item-list">
                                    <span class="date fw-bold">القسم : {{$item->product->parent->name}}</span>
                                </div>
                            </li>
                            <li class="feed-item">
                                <div class="feed-item-list">
                                    <span
                                        class="date fw-bold">الكمية : {{$item->quantity}}</span>
                                </div>
                            </li>

                            <li class="feed-item">
                                <div class="feed-item-list">
                                    <span
                                        class="date fw-bold">السعر : {{resolve('App\currency\Currency')->getCurrency($item->price)}}</span>
                                </div>
                            </li>

                            <li class="feed-item">
                                <div class="feed-item-list">
                                    <span
                                        class="date fw-bold">اللون : {{$color->name ?? 'لم يحدد'}}</span>
                                </div>
                            </li>


                            <li class="feed-item">
                                <div class="feed-item-list">
                                    <img class="img-thumbnail rounded me-2" alt="200x200" width="200"
                                         src="{{$item->product->image_url}}" data-holder-rendered="true">
                                </div>
                            </li>
                        </ol>

                    </div>
                </div>
            </div>
        @empty
        @endforelse

    </div>


    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">الفاتوره</h4>
                    <ol class="activity-feed">
                        <li class="feed-item">
                            <div class="feed-item-list">
                                <span class="date">اسم العميل : </span>
                                <span
                                    class="activity-text fw-bold">{{$order->addresses->first()->first_name . ' ' . $order->addresses->first()->last_name}}</span>
                            </div>
                        </li>

                        <li class="feed-item">
                            <div class="feed-item-list">
                                <span class="date">رقم الهاتف: </span>
                                <span
                                    class="activity-text fw-bold">{{"{$order->addresses->first()->phone_number} -"}} {{$order->addresses->first()->country->phone_code . '+'}}</span>
                            </div>
                        </li>

                        <li class="feed-item">
                            <div class="feed-item-list">
                                <span class="date">البريد الالكتروني</span>
                                <span
                                    class="activity-text fw-bold">{{$order->addresses->first()->email}}</span>
                            </div>
                        </li>


                        <li class="feed-item">
                            <div class="feed-item-list">
                                <span class="date">الدولة</span>
                                <span
                                    class="activity-text fw-bold">{{$order->addresses->first()->country->name_ar}}</span>
                            </div>
                        </li>

                        <li class="feed-item">
                            <div class="feed-item-list">
                                <span class="date">المدينة</span>
                                <span
                                    class="activity-text fw-bold">{{$order->addresses->first()->city->name_ar}}</span>
                            </div>
                        </li>

                        <li class="feed-item">
                            <div class="feed-item-list">
                                <span class="date">العنوان</span>
                                <span
                                    class="activity-text fw-bold">{{$order->addresses->first()->address}}</span>
                            </div>
                        </li>

                        <li class="feed-item">
                            <div class="feed-item-list">
                                <span class="date">تكلفة الشحن</span>
                                <span
                                    class="activity-text fw-bold">{{$order->shipping_price ?? 'الاستلام من المتجر'}}</span>
                            </div>
                        </li>

                        <li class="feed-item">
                            <div class="feed-item-list">
                                <span class="date">ملاحظات</span>
                                <span
                                    class="activity-text fw-bold">{{$order->note ?? 'لا يوجد ملاحظات'}}</span>
                            </div>
                        </li>

                    </ol>
                    @if($order->shipping_price)

                        <h5>
                            الاجمالي :
                            {{resolve('App\currency\Currency')->getCurrency($order->orderItems->sum('price') + intval($order->shipping_price)) }}
                        </h5>
                    @endif

                </div>
            </div>
        </div>


    </div>

    <form action="{{route('orders.update', $order->id)}}" method="post">
        @csrf
        @method('put')
        <td class="cart-tr content-block"
            valign="top">
            <div class="col-md-9">
                <label for="validationCustom04" class="form-label fw-bold">تغيير حالة
                                                                           الطلب</label>
                <select class="form-select" name="order_status_id"
                        id="validationCustom04" required>
                    @forelse($orderStatus as $status)
                        <option
                            value="{{$status->id}}" @selected($order->order_status_id == $status->id)>{{$status->name}}</option>
                    @empty
                    @endforelse
                </select>
                <div class="invalid-feedback">
                    Please select a valid state.
                </div>
            </div>
            <button class="btn btn-primary mt-5" type="submit">حفظ الحالة
            </button>
        </td>

    </form>
    <!-- end row -->
@endsection
