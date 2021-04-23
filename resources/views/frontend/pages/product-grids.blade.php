@extends('frontend.layouts.master')

@section('title','VIOLET || PRODUCT PAGE')

@section('main-content')
<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="index1.html">Trang chủ<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="blog-single.html">Sản phẩm</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Product Style -->
<form action="{{route('shop.filter')}}" method="POST">
    @csrf
    <section class="product-area shop-sidebar shop section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="shop-sidebar">
                        <!-- Single Widget -->
                        <div class="single-widget category">
                            <h3 class="title">Thể loại</h3>
                            <ul class="categor-list">
                                @php
                                // $category = new Category();
                                $menu=App\Models\Category::getAllParentWithChild();
                                @endphp
                                @if($menu)
                                <li>
                                    @foreach($menu as $cat_info)
                                    @if($cat_info->child_cat->count()>0)
                                <li><a href="{{route('product-cat',$cat_info->slug)}}">{{$cat_info->title}}</a>
                                    <ul>
                                        @foreach($cat_info->child_cat as $sub_menu)
                                        <li><a href="{{route('product-sub-cat',[$cat_info->slug,$sub_menu->slug])}}">{{$sub_menu->title}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                @else
                                <li><a href="{{route('product-cat',$cat_info->slug)}}">{{$cat_info->title}}</a></li>
                                @endif
                                @endforeach
                                </li>
                                @endif
                                {{-- @foreach(Helper::productCategoryList('products') as $cat)
                                            @if($cat->is_parent==1)
												<li><a href="{{route('product-cat',$cat->slug)}}">{{$cat->title}}</a></li>
                                @endif
                                @endforeach --}}
                            </ul>
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Shop By Price -->
                        <div class="single-widget range">
                            <h3 class="title">Mua sắm theo giá</h3>
                            <div class="price-filter">
                                <div class="price-filter-inner">
                                    @php
                                    $max=DB::table('products')->max('price');
                                    // dd($max);
                                    @endphp
                                    <div id="slider-range" data-min="0" data-max="{{$max}}"></div>
                                    <div class="product_filter">
                                        <button type="submit" class="filter_button">Bộ lọc</button>
                                        <div class="label-input">
                                            <span>Phạm vi:</span>
                                            <input style="" type="text" id="amount" readonly />
                                            <input type="hidden" name="price_range" id="price_range" value="@if(!empty($_GET['price'])){{$_GET['price']}}@endif" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ End Shop By Price -->
                        <!-- Single Widget -->
                        <div class="single-widget recent-post">
                            <h3 class="title">Sản phẩm gần đây</h3>
                            {{-- {{dd($recent_products)}} --}}
                            @foreach($recent_products as $product)
                            <!-- Single Post -->
                            @php
                            $photo=explode(',',$product->photo);
                            @endphp
                            <div class="single-post first">
                                <div class="image">
                                    <img src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                </div>
                                <div class="content">
                                    <h5><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h5>
                                    @php
                                    $org=($product->price-($product->price*$product->discount)/100);
                                    @endphp
                                    <p class="price">@if($product->discount)<del class="text-muted">{{number_format($product->price)}}đ</del>@endif {{number_format($org)}}đ </p>

                                </div>
                            </div>
                            <!-- End Single Post -->
                            @endforeach
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        @php
                            $brands=DB::table('brands')->orderBy('title','ASC')->where('status','active')->get();
                        @endphp
                        @if($brands)
                        <div class="single-widget category">
                            <h3 class="title">Thương hiệu</h3>
                            <ul class="categor-list">
                                @foreach($brands as $brand)
                                <li><a href="{{route('product-brand',$brand->slug)}}">{{$brand->title}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <!--/ End Single Widget -->
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-12">
                    <div class="row">
                        <div class="col-12">
                            <!-- Shop Top -->
                            <div class="shop-top">
                                <div class="shop-shorter">
                                    <div class="single-shorter">
                                        <label>Hiển thị:</label>
                                        <select class="show" name="show" onchange="this.form.submit();">
                                            <option value="">Mặc định</option>
                                            <option value="9" @if(!empty($_GET['show']) && $_GET['show']=='9' ) selected @endif>09</option>
                                            <option value="15" @if(!empty($_GET['show']) && $_GET['show']=='15' ) selected @endif>15</option>
                                            <option value="21" @if(!empty($_GET['show']) && $_GET['show']=='21' ) selected @endif>21</option>
                                            <option value="30" @if(!empty($_GET['show']) && $_GET['show']=='30' ) selected @endif>30</option>
                                        </select>
                                    </div>
                                    <div class="single-shorter">
                                        <label>Sắp xếp theo:</label>
                                        <select class='sortBy' name='sortBy' onchange="this.form.submit();">
                                            <option value="">Mặc định</option>
                                            <option value="title" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='title' ) selected @endif>A->Z</option>
                                            <option value="price" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='price' ) selected @endif>Giá</option>
                                            <option value="category" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='category' ) selected @endif>Thể loại</option>
                                            <option value="brand" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='brand' ) selected @endif>Thương hiệu</option>
                                        </select>
                                    </div>
                                </div>
                                <ul class="view-mode">
                                    <li class="active"><a href="javascript:void(0)"><i class="fa fa-th-large"></i></a></li>
                                    <li><a href="{{route('product-lists')}}"><i class="fa fa-th-list"></i></a></li>
                                </ul>
                            </div>
                            <!--/ End Shop Top -->
                        </div>
                    </div>
                    <div class="row">
                        {{-- {{$products}} --}}
                        @if(count($products)>0)
                        @foreach($products as $product)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="single-product">
                                <div class="product-img">
                                    <a href="{{route('product-detail',$product->slug)}}">
                                        @php
                                        $photo=explode(',',$product->photo);
                                        @endphp
                                        <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                        <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                        @if($product->discount)
                                        <span class="price-dec">{{$product->discount}} % Off</span>
                                        @endif
                                    </a>
                                    <div class="button-head">
                                        <div class="product-action">
                                            <!-- <a data-toggle="modal" data-target="#{{$product->id}}" title="Quick View" href="#"><i class="ti-eye"></i><span>Quick Shop</span></a> -->
                                            <a title="Wishlist" href="{{route('add-to-wishlist',$product->slug)}}"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                                        </div>
                                        <div class="product-action-2">
                                            <!-- <a href="{{route('add-to-cart',$product->slug)}}">Add to cart</a> -->
                                            <a data-toggle="modal" data-target="#{{$product->id}}" title="Quick View" href="#">Add to cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h3><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h3>
                                    @php
                                    $after_discount=($product->price-($product->price*$product->discount)/100);
                                    @endphp
                                    <span>{{number_format($after_discount)}}đ</span>
                                    @if($product->discount)
                                    <del style="padding-left:4%;">{{number_format($product->price)}}đ</del>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <h4 class="text-warning" style="margin:100px auto;">There are no products.</h4>
                        @endif



                    </div>
                    <div class="row">
                        <div class="col-md-12 justify-content-center d-flex">
                            {{$products->appends($_GET)->links()}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</form>

<!--/ End Product Style 1  -->



<!-- Modal -->
@if($products)
@foreach($products as $key=>$product)
<div class="modal fade" id="{{$product->id}}" tabindex="-1" role="dialog">
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
                                $photo=explode(',',$product->photo);
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
                            <h2>{{$product->title}}</h2>
                            <div class="quickview-ratting-review">
                                <div class="quickview-ratting-wrap">
                                    <div class="quickview-ratting">
                                        {{-- <i class="yellow fa fa-star"></i>
                                                        <i class="yellow fa fa-star"></i>
                                                        <i class="yellow fa fa-star"></i>
                                                        <i class="yellow fa fa-star"></i>
                                                        <i class="fa fa-star"></i> --}}
                                        @php
                                        $rate=DB::table('product_reviews')->where('product_id',$product->id)->avg('rate');
                                        $rate_count=DB::table('product_reviews')->where('product_id',$product->id)->count();
                                        @endphp
                                        @for($i=1; $i<=5; $i++) @if($rate>=$i)
                                            <i class="yellow fa fa-star"></i>
                                            @else
                                            <i class="fa fa-star"></i>
                                            @endif
                                            @endfor
                                    </div>
                                    <a href="#"> ({{$rate_count}} customer review)</a>
                                </div>
                                <div class="quickview-stock">
                                    @if($product->stock >0)
                                    <span><i class="fa fa-check-circle-o"></i> {{$product->stock}} in stock</span>
                                    @else
                                    <span><i class="fa fa-times-circle-o text-danger"></i> {{$product->stock}} out stock</span>
                                    @endif
                                </div>
                            </div>
                            @php
                            $after_discount=($product->price-($product->price*$product->discount)/100);
                            @endphp
                            <h3>
                                @if($product->discount)
                                <small>
                                    <del class="text-muted">{{number_format($product->price)}}đ</del>
                                </small>
                                @endif
                                {{number_format($after_discount)}}đ
                            </h3>
                            <div class="quickview-peragraph">
                                <p>{!! html_entity_decode($product->summary) !!}</p>
                            </div>
                            <form action="{{route('single-add-to-cart')}}" method="POST">
                                @csrf
                                @if($product->size)
                                <div class="size">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <h5 class="title">Size</h5>
                                            <select class="selectpicker" data-live-search="true" name="size" data-style="select-with-transition">
                                                @php
                                                $sizes=explode(',',$product->size);
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
                                        <input type="hidden" name="slug" value="{{$product->slug}}">
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
                                    <button type="submit" class="btn">Add to cart</button>
                                    <a href="{{route('add-to-wishlist',$product->slug)}}" class="btn min"><i class="ti-heart"></i></a>
                                </div>
                            </form>
                            <!-- <div class="default-social">
                                                <div class="sharethis-inline-share-buttons"></div>
                                            </div> -->
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
@push('styles')
<style>
    .pagination {
        display: inline-flex;
    }

    .filter_button {
        /* height:20px; */
        text-align: center;
        background: #F7941D;
        padding: 8px 16px;
        margin-top: 10px;
        color: white;
    }
</style>
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
{{-- <script>
        $('.cart').click(function(){
            var quantity=1;
            var pro_id=$(this).data('id');
            $.ajax({
                url:"{{route('add-to-cart')}}",
type:"POST",
data:{
_token:"{{csrf_token()}}",
quantity:quantity,
pro_id:pro_id
},
success:function(response){
console.log(response);
if(typeof(response)!='object'){
response=$.parseJSON(response);
}
if(response.status){
swal('success',response.msg,'success').then(function(){
document.location.href=document.location.href;
});
}
else{
swal('error',response.msg,'error').then(function(){
// document.location.href=document.location.href;
});
}
}
})
});
</script> --}}
<script>
    $(document).ready(function() {
        /*----------------------------------------------------*/
        /*  Jquery Ui slider js
        /*----------------------------------------------------*/
        if ($("#slider-range").length > 0) {
            const max_value = parseInt($("#slider-range").data('max')) || 500;
            const min_value = parseInt($("#slider-range").data('min')) || 0;
            const currency = $("#slider-range").data('currency') || '';
            let price_range = min_value + '-' + max_value;
            if ($("#price_range").length > 0 && $("#price_range").val()) {
                price_range = $("#price_range").val().trim();
            }

            let price = price_range.split('-');
            $("#slider-range").slider({
                range: true,
                min: min_value,
                max: max_value,
                values: price,
                slide: function(event, ui) {
                    $("#amount").val(currency + ui.values[0] + " -  " + currency + ui.values[1]);
                    $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                }
            });
        }
        if ($("#amount").length > 0) {
            const m_currency = $("#slider-range").data('currency') || '';
            $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
                "  -  " + m_currency + $("#slider-range").slider("values", 1));
        }
    })
</script>
@endpush