<div class="dropdown d-inline-block">
    <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="mdi mdi-bell-outline"></i>
        @if ($newCount)
            <span class="badge bg-danger rounded-pill">{{ $newCount }}</span>
        @endif
    </button>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
        aria-labelledby="page-header-notifications-dropdown">
        <div class="p-3">

            <div class="row align-items-center">
                <div class="col">
                    <h5 class="m-0 font-size-16"> اشعارات ({{ $newCount }}) </h5>
                </div>
            </div>

        </div>
        <div data-simplebar style="max-height: 250px;">
            @forelse($notifications as $notification)
                <a href="{{ route('notifications.read', ['notification_id' => $notification->id, 'url' => $notification->data['url']]) }}"
                    class="text-reset notification-item">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-xs">
                                <span class="avatar-title bg-success rounded-circle font-size-16">
                                    <i class="mdi mdi-cart-outline"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $notification->data['title'] }}</h6>
                            <div class="font-size-12 text-muted">
                                <p class="mb-1 @if ($notification->unread()) fw-bold @endif">
                                    {{ $notification->data['body'] }}
                                    .
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                لا يوجد اشعارات
            @endforelse
        </div>

        <div class="p-2 border-top">
            <div class="d-grid">
                <a class="btn btn-sm btn-link font-size-14 text-center" href="{{ route('notifications.index') }}">
                    مشاهدة الكل
                </a>
            </div>
        </div>

    </div>
</div>
