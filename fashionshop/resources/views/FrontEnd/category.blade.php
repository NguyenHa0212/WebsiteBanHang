@extends('Layout_user')
@section('title')
    {{ $header_name }}
@endsection
@section('content')
    <section class="main-container col2-left-layout">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-sm-8 col-xs-12 col-sm-push-4 col-md-push-3">
                    <!-- Breadcrumbs -->
                    <div class="breadcrumbs" style="float: right;">
                        <ul>
                            <li class="home"> <a href="{{ route('home') }}" title="Go to Home Page">Home</a>
                                <span>/</span>
                            </li>
                            @foreach ($categoryProduct as $cate_pro)
                                @if ($cate_pro->cate_product->category_sub != '')
                                    @php
                                        $cateparent = App\Category::where('category_id', $cate_pro->cate_product->category_sub)->first();
                                        $cateparent2 = App\Category::where('category_id', $cateparent->category_sub)->first();
                                    @endphp
                                    @if ($cateparent2)
                                        <li style="text-transform: lowercase;" class="category1599"> <a href=""
                                                title="">{{ $cateparent2->category_name }}</a> <span>/ </span> </li>
                                    @endif
                                    @if ($cateparent)
                                        <li style="text-transform: lowercase;" class="category1600"> <a href=""
                                                title="">{{ $cateparent->category_name }}</a> <span>/</span> </li>
                                    @endif
                                @endif
                            @endforeach

                            <li style="text-transform: lowercase;" class="category1600"> <a href=""
                                    title="">{{ $header_name }}</a> </li>
                        </ul>
                    </div>
                    <!-- Breadcrumbs End -->
                    <div class="page-title">
                        <h2 class="page-heading"> <span class="page-heading-title">{{ $header_name }}</span>
                        </h2>
                    </div>
                    <div class="category-description std">
                        <div class="slider-items-products">
                            <div id="category-desc-slider" class="product-flexslider hidden-buttons">
                                <div class="slider-items slider-width-col1 owl-carousel owl-theme">

                                    <!-- Item -->
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                    <article class="col-main" id="table_data">
                        @include('FrontEnd.cate_include');
                    </article>
                    <!--	///*///======    End article  ========= //*/// -->
                </div>
               
                <input type="hidden" id="hiden_id_slug" value="{{ $header_id }}">
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            loadCompare();
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                fetch_data(page);
            });
            // Change Show
            $(document).on('change', '.change_view', function(e) {
                e.preventDefault();
                var show = $(this).val();

                $.ajax({
                    type: 'get',
                    url: '{{ route('category-product.index') }}',
                    data: {show:show, id:$('#hiden_id_slug').val()},
                    success:function(data){
                        $('#table_data').html(data);
                    }
                });
            });
            $('.click_compare').click(function(){
                window.location.href = '{{ route('wishlist.create') }}';
            });
            $(document).on('click', '.click_clear', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'post',
                    url: "{{ route('product-detail.store') }}",
                    dataType: 'json',
                    success: function(response) {
                        if(response.status==200){
                            loadCompare();
                        }

                    }
                });

            });
        });
        function fetch_data(page) {
            $.ajax({
                url: "{{ url('category-product/create?page=') }}" +page,
                data: {id:$('#hiden_id_slug').val() },
                success: function(data) {
                    $('#table_data').html(data);
                }
            });
        }

    </script>
@endsection
