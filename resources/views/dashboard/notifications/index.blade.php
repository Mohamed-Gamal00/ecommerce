@extends('dashboard.index')
@section('title', 'الاشعارات')

@section('breadcrumb')
	@parent
	<li class="breadcrumb-item">الاشعارات</li>
@endsection

@section('section')

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">

					<div>
						<h5 class="font-size-16 mb-4">الاشعارات</h5>
						@forelse($notifications as $notification)
							<a href="{{$notification->data['url']}}?notification_id={{$notification->id}}">
								<div class="table-responsive">
									<table class="table table-nowrap table-hover mb-0">
										<tbody>
										<tr>
											<th scope="row">{{++$counter}}</th>
											<td>
												<a href="{{$notification->data['url']}}?notification_id={{$notification->id}}"
												   class="text-reset @if($notification->unread()) fw-bold @endif">{{$notification->data['title']}}</a>
											</td>
											<td class="@if($notification->unread()) fw-bold @endif">
												{{$notification->created_at->format('M d, Y h:i A')}}

											</td>

											<td class="@if($notification->unread()) fw-bold @endif">
												{{$notification->data['body']}}
											</td>
											<td>
												@if($notification->unread())
													<span class="badge bg-danger-subtle text-danger font-size-12">لم تتم المشاهدة</span>
												@else
													<span class="badge bg-primary-subtle text-primary font-size-12"> تمت المشاهدة</span>
												@endif
											</td>
										</tr>
										</tbody>
									</table>
								</div>
							</a>
						@empty

						@endforelse
					</div>

				</div><!-- end cardbody -->
			</div><!-- end card -->
		</div> <!-- end col -->

		{{-- sub category in edit page --}}
	</div>

@endsection