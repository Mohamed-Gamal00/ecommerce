@extends('dashboard.index')

@section('breadcrumb')
	@parent
@endsection

@section('section')
	<div class="page-title-box">
		<div class="row align-items-center">
			<div class="col-md-8">
				<h5 style="color: #252525" class="page-title">لوحة التحكم</h5>

			</div>
		</div>
	</div>
	<!-- end page title -->
	<div class="row">
		<div class="col-xl-3 col-md-6">
			<div class="card mini-stat bg-primary text-white">
				<div class="card-body">
					<div class="mb-4">
						<div class="float-start mini-stat-img me-4">
							<img src="{{asset('assets/images/services-icon/products.png')}}" alt="">
						</div>
						<h5 class="font-size-16 text-uppercase text-white-50">عدد المنتجات</h5>
						<h4 class="fw-medium font-size-24">{{$productsCount}}</i>
						</h4>
					</div>
					<div class="pt-2">
						<div class="float-end">
							<a href="{{route('products.index')}}" class="text-white-50"><i class="mdi mdi-arrow-right h5 text-white-50"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6">
			<div class="card mini-stat bg-primary text-white">
				<div class="card-body">
					<div class="mb-4">
						<div class="float-start mini-stat-img me-4">
							<img src="{{asset('assets/images/services-icon/orders.png')}}" alt="">
						</div>
						<h5 class="font-size-16 text-uppercase text-white-50">عدد الطلبات</h5>
						<h4 class="fw-medium font-size-24">{{$ordersCount}}</i>
						</h4>
					</div>
					<div class="pt-2">
						<div class="float-end">
							<a href="{{route('orders.index')}}" class="text-white-50"><i class="mdi mdi-arrow-right h5 text-white-50"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6">
			<div class="card mini-stat bg-primary text-white">
				<div class="card-body">
					<div class="mb-4">
						<div class="float-start mini-stat-img me-4">
							<img src="{{asset('assets/images/services-icon/currency.png')}}" alt="">
						</div>
						<h5 class="font-size-14 text-uppercase text-white-50">العملة الافتراضيه</h5>
						<h4 class="fw-medium font-size-16">{{$mainCurrency->name_ar ?? 'لا يوجد'}}</i>
						</h4>
					</div>
					<div class="pt-2">
						<div class="float-end">
							<a href="{{route('currencies.index')}}" class="text-white-50"><i class="mdi mdi-arrow-right h5 text-white-50"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6">
			<div class="card mini-stat bg-primary text-white">
				<div class="card-body">
					<div class="mb-4">
						<div class="float-start mini-stat-img me-4">
							<img src="{{asset('assets/images/services-icon/users.png')}}" alt="">
						</div>
						<h5 class="font-size-14 text-uppercase text-white-50">عدد العملاء</h5>
						<h4 class="fw-medium font-size-24">{{$usersCount}}</i>
						</h4>
					</div>
					<div class="pt-2">
						<div class="float-end">
							<a href="{{route('clients.index')}}" class="text-white-50"><i class="mdi mdi-arrow-right h5 text-white-50"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div class="row">

		<div class="col-xl-3 col-md-6">
			<div class="card mini-stat bg-primary text-white">
				<div class="card-body">
					<div class="mb-4">
						<div class="float-start mini-stat-img me-4">
							<img src="{{asset('assets/images/services-icon/admins.png')}}" alt="">
						</div>
						<h5 class="font-size-16 text-uppercase text-white-50">عدد المدراء</h5>
						<h4 class="fw-medium font-size-24">{{$adminsCount}}</i>
						</h4>
					</div>
					<div class="pt-2">
						<div class="float-end">
							<a href="{{route('admins.index')}}" class="text-white-50"><i class="mdi mdi-arrow-right h5 text-white-50"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6">
			<div class="card mini-stat bg-primary text-white">
				<div class="card-body">
					<div class="mb-4">
						<div class="float-start mini-stat-img me-4">
							<img src="{{asset('assets/images/services-icon/email.png')}}" alt="">
						</div>
						<h5 class="font-size-16 text-uppercase text-white-50">عدد الرسائل</h5>
						<h4 class="fw-medium font-size-24">{{$messagesCount}}</i>
						</h4>
					</div>
					<div class="pt-2">
						<div class="float-end">
							<a href="{{route('contact_us.index')}}" class="text-white-50"><i class="mdi mdi-arrow-right h5 text-white-50"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<!-- end row -->


	<!-- end row -->


	<!-- end row -->

@endsection
