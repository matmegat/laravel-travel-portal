@extends('layouts.master')

@section('content')

@if(isset($search))
    <h3>Search: {{ $search }}</h3>
@endif

{{ $tours->appends(Input::except(array('page', '_token')))->links('admin.pagination') }}

<table class="table table-striped">
    <tr>
        <th>id</th>
        <th>Image</th>
        <th>Title</th>
        <th>Price Min</th>
        <th>Show at</th>
    </tr>
    @foreach($tours as $tour)
        <tr>
            <td>{{ $tour['productId'] }}</td>
            <td>
                @if(!empty($tour['images']))
                    <img src="{{ $tour['images'][0]['path'] }}" class="responsive" style="max-height:50px;">
                @else
                    <div class="no_image"><p>NO TOUR IMAGE</p></div>
                @endif
            </td>
            <td>
                {{ preg_replace('/^WT\d+\ |^\(WT.+\)\ /', '',  trim($tour['name']))}}
            </td>
            <td>
                ${{ $tour['priceMin'] }}
            </td>
            <td>
                <div class="btn-group" role="group">
                    <a href="{{ url('admin/tours/set-feature/'.$tour['productId']) }}" class="btn btn-sm btn-{{ $tour['feature']==0 ? 'default' : 'primary'  }}">Feature</a>
                    <a href="{{ url('admin/tours/set-homepage-tours-australia/'.$tour['productId']) }}" class="btn btn-sm btn-{{ $tour['homepage_tours_australia']==0 ? 'default' : 'success'  }}">Homepage Australia Tours</a>
                    <a href="{{ url('admin/tours/set-homepage-tours-sale/'.$tour['productId']) }}" class="btn btn-sm btn-{{ $tour['homepage_tours_sale']==0 ? 'default' : 'info'  }}">Homepage tours on sale</a>
                </div>
            </td>
        </tr>
    @endforeach
</table>

{{ $tours->appends(Input::except(array('page', '_token')))->links('admin.pagination') }}
@stop