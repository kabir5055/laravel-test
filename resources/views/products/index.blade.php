@extends('layouts.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
    </div>


    <div class="card">
        <form action="{{ route('filter.product') }}" method="get" class="card-header">
            <div class="form-row justify-content-between">
                <div class="col-md-2">
                    <input type="text" name="title" placeholder="Product Title" class="form-control" value="{{ request('title') }}">
                </div>
                {{--                <div class="col-md-2">--}}
                {{--                    <select name="variant" id="" class="form-control">--}}
                {{--                        <option value="All" {{request('variant') == "ALl" ? 'selected' : ''}} >Select Variant</option>--}}
                {{--                        <h3>Color</h3>--}}
                {{--                        @foreach($variants as $variant)--}}
                {{--                            @if($variant->variant_id == 1)--}}
                {{--                                <option value="{{ $variant->id }}">{{ $variant->variant }}</option>--}}
                {{--                            @endif--}}
                {{--                        @endforeach--}}
                {{--                        <h3>Size</h3>--}}
                {{--                        @foreach($variants as $variant)--}}
                {{--                            @if($variant->variant_id == 2)--}}
                {{--                                <option value="{{ $variant->id }}">{{ $variant->variant }}</option>--}}
                {{--                            @endif--}}
                {{--                        @endforeach--}}
                {{--                        <h3>Style</h3>--}}
                {{--                        @foreach($variants as $variant)--}}
                {{--                            @if($variant->variant_id == 6)--}}
                {{--                                <option value="{{ $variant->id }}">{{ $variant->variant }}</option>--}}
                {{--                            @endif--}}
                {{--                        @endforeach--}}
                {{--                    </select>--}}
                {{--                </div>--}}

                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Price Range</span>
                        </div>
                        <input type="text" name="price_from" aria-label="First name" placeholder="From" class="form-control" value="{{ request('price_from') }}">
                        <input type="text" name="price_to" aria-label="Last name" placeholder="To" class="form-control" value="{{ request('price_to') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date" placeholder="Date" class="form-control" value="{{ request('date') }}">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="card-body">
            <div class="table-response">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Variant</th>
                        <th width="150px">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @php $i=1 @endphp
                    @foreach($products as $product)
                        <tr>
                            <td>{{$i++}}</td>
                            <td> {{ $product->title }} <br> Created at : {{ date("d-M-y",strtotime($product->created_at)) }}</td>
                            <td>{{substr($product->description,0,50)}}</td>
                            <td>
                                <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">

                                    <dt class="col-sm-5 pb-0">
                                        @foreach($variants as $variant)
                                            @if($product->id == $variant->product_id)
                                                {{ $variant->variant }}<span>/</span>
                                            @endif
                                        @endforeach
                                        {{--                                        {{ $product->variant }}--}}
                                    </dt>
                                    <dd class="col-sm-7">
                                        <dl class="row mb-0">
                                            <dt class="col-sm-4 pb-0">Price : {{ $product->price }}</dt>
                                            <dd class="col-sm-8 pb-0">InStock : {{ $product->stock }}</dd>
                                        </dl>
                                    </dd>
                                </dl>
                                <button onclick="$('#variant').toggleClass('h-auto')" class="btn btn-sm btn-link">Show more</button>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('edit.product',['id'=>$product->id]) }}" class="btn btn-success">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>

                </table>
            </div>

        </div>

        <div class="card-footer">
            <div class="row justify-content-between">
                <div class="col-md-6">
                    <p>Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} out of {{$products->total()}}</p>
                </div>
                <div class="col-md-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
