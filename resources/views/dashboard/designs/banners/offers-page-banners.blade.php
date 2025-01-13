@extends('dashboard.index')
@section('title', 'البنرات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">بنرات صفحة العروض</li>
@endsection

@section('section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">


                    <x-alert type='success' />
                    <x-alert type='dark' />
                    <x-alert type='danger' />
                    {{--                     
                                       @can('design.create')
                                           <div class="button-items text-end">
                                               <a type="submit" href="{{ route('designs.create') }}"
                                                  class="btn btn-primary waves-effect waves-light ">انشاء بنر جديد</a>
                                           </div>
                                       @endcan --}}
                    <div class="row">
                        @forelse ($offerPagePanners as $panner)
                            <div class="col-md-6 col-lg-6 col-xl-3">
                                <!-- Simple card -->
                                <div class="card">
                                    <img alt="" class="card-img-top" width="100%" height="200"
                                        src="{{ $panner->image_url }}" data-holder-rendered="true">
                                    <div class="card-body">
                                        <a href="{{ route('designs.edit', $panner->id) }}" style="font-size: 12px" ;
                                            class="btn btn-primary waves-effect waves-light" title="تعديل">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div><!-- end col -->

                        @empty
                        <p>لا يوجد صور</p>
                        @endforelse
                    </div>


                    <!-- end -->
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
