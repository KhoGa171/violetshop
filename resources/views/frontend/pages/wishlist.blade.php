@extends('frontend.layouts.master')
@section('title','Wishlist Page')
@section('main-content')
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{('home')}}">Trang chủ<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="javascript:void(0);">Yêu thích</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
			
	<!-- Shopping Cart -->
	<div class="shopping-cart section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<!-- Shopping Summery -->
					<table class="table shopping-summery">
						<thead>
							<tr class="main-hading">
								<th>SẢN PHẨM</th>
								<th>TÊN SẢN PHẨM</th>
								<th class="text-center">GIÁ</th> 
								<th class="text-center">THÊM VÀO GIỎ HÀNG</th> 
								<th class="text-center"><i class="ti-trash remove-icon"></i></th>
							</tr>
						</thead>
						<tbody>
							@if(Helper::getAllProductFromWishlist())
								@foreach(Helper::getAllProductFromWishlist() as $key=>$wishlist)
									<tr>
										@php 
											$photo=explode(',',$wishlist->product['photo']);
										@endphp
										<td class="image" data-title="No"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></td>
										<td class="product-des" data-title="Description">
											<p class="product-name"><a href="{{route('product-detail',$wishlist->product['slug'])}}">{{$wishlist->product['title']}}</a></p>
											<p class="product-des">{!!($wishlist['summary']) !!}</p>
										</td>
										<td class="total-amount" data-title="Total"><span>{{number_format($wishlist['amount'])}}đ</span></td>
										<td><a data-toggle="modal" data-target="#{{$wishlist->product['id']}}" class='btn text-white'>Thêm vào giỏ hàng</a></td>
										<td class="action" data-title="Remove"><a href="{{route('wishlist-delete',$wishlist->id)}}"><i class="ti-trash remove-icon"></i></a></td>
									</tr>
								@endforeach
							@else 
								<tr>
									<td class="text-center">
										Bạn chưa có gì trong danh sách yêu thích. <a href="{{route('product-grids')}}" style="color:blue;">Tiếp tục mua sắm</a>

									</td>
								</tr>
							@endif


						</tbody>
					</table>
					<!--/ End Shopping Summery -->
				</div>
			</div>
		</div>
	</div>
	<!--/ End Shopping Cart -->
			
	<!-- Start Shop Services Area  -->
	<section class="shop-services section">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-rocket"></i>
						<h4>MIỄN PHÍ VẬN CHUYỂN</h4>
                        <p>Đơn hàng trên 1.000.000đ</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-reload"></i>
						<h4>ĐỔI TRẢ MIỄN PHÍ</h4>
                        <p>Trong vòng 7 ngày trở lại</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-lock"></i>
						<h4>THANH TOÁN CHẮC CHẮN</h4>
                        <p>Thanh toán an toàn 100%</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-tag"></i>
						<h4>Giá tốt nhất</h4>
                        <p>Giá đảm bảo</p>
					</div>
					<!-- End Single Service -->
				</div>
			</div>
		</div>
	</section>
	<!-- End Shop Newsletter -->
	
	@include('frontend.layouts.newsletter')
	
	<!-- Modal -->
@if($wishlist->product)
@foreach($wishlist->product as $key=>$product)
<div class="modal fade" id="{{$wishlist->product['id']}}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div class="row no-gutters">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <!-- Product Slider -->
                        <div class="product-gallery">
                            <div class="quickview-slider">
                                @php
                                $photo=explode('|',$wishlist->product['photo']);
                                // dd($photo);
                                @endphp
                                @foreach($photo as $data)
                                <div class="single-slider">
                                    <img src="{{$data}}" alt="{{$data}}">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- End Product slider -->
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="quickview-content">
                            <h2>{{$wishlist->product['title']}}</h2>
                            <div class="quickview-ratting-review">
                                <div class="quickview-ratting-wrap">
                                    <div class="quickview-ratting">
                                        @php
                                        $rate=DB::table('product_reviews')->where('product_id',$wishlist->product['id'])->avg('rate');
                                        $rate_count=DB::table('product_reviews')->where('product_id',$wishlist->product['id'])->count();
                                        @endphp
                                        @for($i=1; $i<=5; $i++) @if($rate>=$i)
                                            <i class="yellow fa fa-star"></i>
                                            @else
                                            <i class="fa fa-star"></i>
                                            @endif
                                            @endfor
                                    </div>
                                    <a href="#"> ({{$rate_count}} đánh giá)</a>
                                </div>
                                <div class="quickview-stock">
                                    @if($wishlist->product['stock'] >0)
                                    <span><i class="fa fa-check-circle-o"></i>{{$wishlist->product['stock']}} in stock</span>
                                    @else
                                    <span><i class="fa fa-times-circle-o text-danger"></i> {{$wishlist->product['stock']}} out stock</span>
                                    @endif
                                </div>
                            </div>
                            @php
                            $after_discount=($wishlist->product['price']-($wishlist->product['price']*$wishlist->product['discount'])/100);
                            @endphp
                            <h3>
                                @if($wishlist->product['discount'])
                                <small><del class="text-muted">{{number_format($wishlist->product['price'])}}đ</del></small>
                                @endif
                                {{number_format($after_discount)}}đ
                            </h3>
                            <div class="quickview-peragraph">
                                <p>{!! html_entity_decode($wishlist->product['summary']) !!}</p>
                            </div>
                            <form action="{{route('single-add-to-cart')}}" method="POST" class="mt-4">
                                @csrf
                                @if($wishlist->product['size'])
                                <div class="size">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <h5 class="title">Size</h5>
                                            <select class="selectpicker" data-live-search="true" name="size" data-style="select-with-transition">
                                                @php
                                                $sizes=explode(',',$wishlist->product['size']);
                                                @endphp
                                                @foreach($sizes as $size)
                                                <option>{{$size}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="quantity">
                                    <!-- Input Order -->
                                    <div class="input-group">
                                        <div class="button minus">
                                            <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                <i class="ti-minus"></i>
                                            </button>
                                        </div>
                                        <input type="hidden" name="slug" value="{{$wishlist->product['slug']}}">
                                        <input type="text" name="quant[1]" class="input-number" data-min="1" data-max="1000" value="1">
                                        <div class="button plus">
                                            <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                                <i class="ti-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!--/ End Input Order -->
                                </div>
                                <div class="add-to-cart">
                                    <button type="submit" class="btn">Thêm vào giỏ hàng</button>
                                    <a href="{{route('add-to-wishlist',$wishlist->product['slug'])}}" class="btn min"><i class="ti-heart"></i></a>
                                </div>
                            </form>
                            <div class="default-social">
                                <!-- ShareThis BEGIN -->
                                <div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif
<!-- Modal end -->
	
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@endpush