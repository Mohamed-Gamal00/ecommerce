@extends('dashboard.index')

@section('title', 'مشاهدة الطلب')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">الطلبات</a></li>
    <li class="breadcrumb-item">مشاهدة الطلب</li>
@endsection

@section('section')


    <div class="row font-size-20 mb-3 p-3">
        اسم العميل
        : {{ $order->user->addresses->first()->first_name  . ' ' . $order->user->addresses->first()->last_name }}

        - {{('رقم الطلب') }} : {{ $order->number . '#' }}
    </div>
    <div class="row">
        @forelse($order->orderItems as $item)
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <ol class="activity-feed">
                            <li class="feed-item">
                                <div class="feed-item-list">
                                    <span class="date fw-bold">اسم المنتج : {{ $item->product->name }}</span>
                                </div>
                            </li>
                            <li class="feed-item">
                                <div class="feed-item-list">
                                    <span class="date fw-bold">القسم : {{ $item->product->parent->name }}</span>
                                </div>
                            </li>
                            <li class="feed-item">
                                <div class="feed-item-list">
                                    <span class="date fw-bold">الكمية : {{ $item->quantity }}</span>
                                </div>
                            </li>

                            <li class="feed-item">
                                <div class="feed-item-list">
                                    <span class="date fw-bold">السعر :
                                        {{ resolve('App\currency\Currency')->getCurrency($item->price) }}</span>
                                </div>
                            </li>

                            {{-- <li class="feed-item">
                                <div class="feed-item-list">
                                    <span class="date fw-bold">اللون : {{ $color->name ?? 'لم يحدد' }}</span>
                                </div>
                            </li> --}}


                            <li class="feed-item">
                                <div class="feed-item-list">
                                    <img class="img-thumbnail rounded me-2" alt="200x200" width="200"
                                        src="{{ $item->product->image_url }}" data-holder-rendered="true">
                                </div>
                            </li>
                        </ol>

                                                @if($order->choices->isNotEmpty())
                            <li class="feed-item">
                                <div class="feed-item-list">
                                    <span class="date fw-bold">اختيارات العميل:</span>
                                    <ul>
                                        @foreach($order->choices as $choice)
                                            <li>
                                                <strong>الخيار:</strong> {{ $choice->name ?? 'غير معروف' }}
                                                @if($choice->pivot->sub_choice_id)
                                                    <br><strong>الاختيارات الفرعية:</strong>
                                                    @php
                                                        $subChoices = json_decode($choice->pivot->sub_choice_id);
                                                    @endphp
                                                    @if(is_array($subChoices))
                                                        {{ implode(', ', $subChoices) }}
                                                    @else
                                                        {{ $choice->pivot->sub_choice_id }}
                                                    @endif
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @endif
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
                                    class="activity-text fw-bold">{{ $order->user->addresses->first()->first_name . ' ' . $order->user->addresses->first()->last_name }}</span>
                            </div>
                        </li>

                        <li class="feed-item">
                            <div class="feed-item-list">
                                <span class="date">رقم الهاتف: </span>
                                <span class="activity-text fw-bold">{{ "{$order->user->addresses->first()->phone_number}" }}</span>
                                    {{-- {{ $order->user->addresses->first()->country->phone_code . '+' }}--}}
                            </div>
                        </li>

                        <li class="feed-item">
                            <div class="feed-item-list">
                                <span class="date">البريد الالكتروني</span>
                                <span class="activity-text fw-bold">{{ $order->user->addresses->first()->email }}</span>
                            </div>
                        </li>


                        <li class="feed-item">
                            <div class="feed-item-list">
                                <span class="date">الدولة</span>
                                <span
                                    class="activity-text fw-bold">{{ $order->user->addresses->first()->country->name_ar }}</span>
                            </div>
                        </li>

                        <li class="feed-item">
                            <div class="feed-item-list">
                                <span class="date">المدينة</span>
                                <span class="activity-text fw-bold">{{ $order->user->addresses->first()->city->name_ar }}</span>
                            </div>
                        </li>

                        <li class="feed-item">
                            <div class="feed-item-list">
                                <span class="date">العنوان</span>
                                <span class="activity-text fw-bold">{{ $order->user->addresses->first()->address }}</span>
                            </div>
                        </li>

                        <li class="feed-item">
                            <div class="feed-item-list">
                                <span class="date">تكلفة الشحن</span>
                                <span
                                    class="activity-text fw-bold">{{ $order->shipping_price ?? 'الاستلام من المتجر' }}</span>
                            </div>
                        </li>

                        <li class="feed-item">
                            <div class="feed-item-list">
                                <span class="date">ملاحظات</span>
                                <span class="activity-text fw-bold">{{ $order->note ?? 'لا يوجد ملاحظات' }}</span>
                            </div>
                        </li>

                    </ol>
                    @if ($order->shipping_price)
                        <h5>
                            الاجمالي :
                            {{-- <span>{{ resolve('App\currency\Currency')->getCurrency($order->orderItems->sum('price')) }}</span> --}}
                            <span>{{ resolve('App\currency\Currency')->getCurrency($order->total_price + intval($order->shipping_price)) }}</span>
                        </h5>
                    @else
                        <h5>
                            الاجمالي :
                            {{-- <span>{{ resolve('App\currency\Currency')->getCurrency($order->orderItems->sum('price')) }} قبل الخصك</span> --}}
                            <span>{{ resolve('App\currency\Currency')->getCurrency($order->total_price) }}</span>
                        </h5>
                        </h5>
                    @endif

                </div>
            </div>
        </div>


    </div>

    <form action="{{ route('orders.update', $order->id) }}" method="post">
        @csrf
        @method('put')
        <td class="cart-tr content-block" valign="top">
            <div class="col-md-9">
                <label for="validationCustom04" class="form-label fw-bold">تغيير حالة
                    الطلب</label>
                <select class="form-select" name="order_status_id" id="validationCustom04" required>
                    @forelse($orderStatus as $status)
                        <option value="{{ $status->id }}" @selected($order->order_status_id == $status->id)>{{ $status->CurrentNameLang }}
                        </option>
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
