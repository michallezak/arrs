@extends('layouts.app')

@section('content')
<div class='row'>
    @foreach($items as $item)
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box {{$item['color']}}">
            <div class="inner">
                <h3>{{$item['menu_name']}}</h3>
            </div>
            <div class="icon">
                <i class="ion {{$item['ion']}}"></i>
            </div>
            <a href="{{$item['url']}}" class="small-box-footer">Zobraz <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    @endforeach
</div><!-- /.row -->
@endsection
