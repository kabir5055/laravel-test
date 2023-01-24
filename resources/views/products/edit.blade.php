@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Product</h1>
    </div>
    <form action="{{ route('update.product') }}" method="post" autocomplete="off" spellcheck="false" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="product_id" value="{{ $products->id }}">
        <section>
            <div class="row">
                <div class="col-md-6">
                    <!--Product-->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Product</h6>
                        </div>
                        <div class="card-body border">
                            <div class="form-group">
                                <label for="product_name">Product Name</label>
                                <input type="text"
                                       name="product_name"
                                       id="product_name"
                                       required
                                       value="{{ $products->title }}"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="product_sku">Product SKU</label>
                                <input type="text" name="product_sku"
                                       id="product_sku"
                                       required
                                       value="{{ $products->sku }}"
                                       class="form-control"></div>
                            <div class="form-group mb-0">
                                <label for="product_description">Description</label>
                                <textarea name="product_description"
                                          id="product_description"
                                          required
                                          rows="4"
                                          class="form-control">{{ $products->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <!--                    Media-->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"><h6
                                class="m-0 font-weight-bold text-primary">Media</h6></div>
                        <div class="card-body border">
                            <input type="hidden" name="product_image_id" value="{{ $product_image->id }}">
                            <input name="product_image" type="file" class="form-control">
                            <img width="80" height="80" src="{{asset($product_image->file_path)}}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <!--                Variants-->
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3"><h6
                                class="m-0 font-weight-bold text-primary">Variants</h6>
                        </div>
                        <div class="card-body pb-0" id="">
                            <div class="row">
                                <input type="hidden" name="product_variant_id1" value="{{ $product_variant_prices->product_variant_one }}">
                                <input type="hidden" name="product_variant_id2" value="{{ $product_variant_prices->product_variant_two }}">
                                <input type="hidden" name="product_variant_id3" value="{{ $product_variant_prices->product_variant_three }}">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Option</label>
                                        <select id="" name="variant_id1" class="form-control custom-select select2 select2-option">

                                            <?php $selected = ''?>
                                            @if($variant1->variant_id == $variant1->id)
                                                <?php $selected = 'selected'?>
                                                <option value="{{$variant1->id}}" {{ $selected }}>
                                                    {{$variant1->title}}
                                                </option>
                                            @endif

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="d-flex justify-content-between">
                                            <span>Value</span>
                                            <a href="#" class="remove-btn" data-index="${currentIndex}" onclick="removeVariant(event, this);">Remove</a>
                                        </label>

                                        <input id="" data-index="" name="product_variant1" class="form-control" multiple="multiple" value="{{ $variant1->variant }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Option</label>
                                        <select id="" name="variant_id2" class="form-control custom-select select2 select2-option">

                                            <?php $selected = ''?>
                                            @if($variant2->variant_id == $variant2->id)
                                                <?php $selected = 'selected'?>
                                                <option value="{{$variant2->id}}" {{ $selected }}>
                                                    {{$variant2->title}}
                                                </option>
                                            @endif

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="d-flex justify-content-between">
                                            <span>Value</span>
                                            <a href="#" class="remove-btn" data-index="${currentIndex}" onclick="removeVariant(event, this);">Remove</a>
                                        </label>

                                        <input id="" data-index="" name="product_variant2" class="form-control" multiple="multiple" value="{{ $variant2->variant }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Option</label>
                                        <select id="" name="variant_id3" class="form-control custom-select select2 select2-option">

                                            <?php $selected = ''?>
                                            @if($variant3->variant_id == $variant3->id)
                                                <?php $selected = 'selected'?>
                                                <option value="{{$variant3->id}}" {{ $selected }}>
                                                    {{$variant3->title}}
                                                </option>
                                            @endif

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="d-flex justify-content-between">
                                            <span>Value</span>
                                            <a href="#" class="remove-btn" data-index="${currentIndex}" onclick="removeVariant(event, this);">Remove</a>
                                        </label>

                                        <input id="" data-index="" name="product_variant3" class="form-control" multiple="multiple" value="{{ $variant3->variant }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow">
                        <div class="card-header text-uppercase">Price $ Stoke</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="card-body pb-0" id="">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Option</label>
                                                <h4 class="form-control">Price</h4>
                                            </div>
                                        </div>
                                        <input type="hidden" name="product_variant_prices_id" value="{{ $product_variant_prices->id }}">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="d-flex justify-content-between">
                                                    <span>Value</span>
                                                </label>
                                                <input id="" data-index="" name="product_price" class="form-control" multiple="multiple" value="{{ $product_variant_prices->price }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Option</label>
                                                <h4 class="form-control">Stoke</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="d-flex justify-content-between">
                                                    <span>Value</span>
                                                </label>
                                                <input id="" data-index="" name="product_stoke" class="form-control" multiple="multiple" value="{{ $product_variant_prices->stock }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-lg btn-primary">Save</button>
            <button type="button" class="btn btn-secondary btn-lg">Cancel</button>
        </section>
    </form>
@endsection

@push('page_js')
    <script type="text/javascript" src="{{ asset('js/product.js') }}"></script>
@endpush
