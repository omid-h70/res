@extends('layouts.main.main')
@section('content')

<div class="container documents">
<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-4">
    <div class="jumbotron">
        <div class="jumbotron-photo">
            <img src="{{ asset( '/public/plugins/bootflat/img/Jumbotron.jpg') }}" />
        </div>
        <div class="jumbotron-contents">
            <h1>Implementing the HTML and CSS into your user interface project</h1>
            <h2>HTML Structure</h2>
            <p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
              <h2>CSS Structure</h2>
            <p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
        </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="jumbotron">
      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-example-generic" data-slide-to="1"></li>
          <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="item active"><img src="{{ asset( '/public/plugins/bootflat/img/slider1.jpg') }}" ></div>
          <div class="item"><img src="{{ asset( '/public/plugins/bootflat/img/slider2.jpg') }}"></div>
          <div class="item"><img src="{{ asset( '/public/plugins/bootflat/img/slider3.jpg') }}"></div>
        </div>
        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
      </div>
      <div class="jumbotron-contents">
        <h1>Implementing the HTML and CSS into your user interface project</h1>
        <h2>HTML Structure</h2>
        <p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
        <h2>CSS Structure</h2>
        <p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
      </div>
    </div>
  </div>
  <div class="col-md-2"></div>
</div>
<div class="example">
    <div class="row">
        
        <div class="col-sm-4 col-md-3">
          <div class="thumbnail">
            <img class="img-rounded" src="{{ asset( '/public/plugins/bootflat/img/thumbnail-1.jpg') }}" >
            <div class="caption text-center">
              <h3>Thumbnail label</h3>
              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id ...</p>
              <p><a href="#" class="btn btn-warning" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
            </div>
          </div>
        </div>
        <div class="col-sm-4 col-md-3">
          <div class="thumbnail">
            <img class="img-rounded" src="{{ asset( '/public/plugins/bootflat/img/thumbnail-2.jpg') }}">
            <div class="caption text-center">
              <h3>Thumbnail label</h3>
              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id ...</p>
              <p><a href="#" class="btn btn-warning" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
            </div>
          </div>
        </div>
        <div class="col-sm-4 col-md-3">
          <div class="thumbnail">
            <img class="img-rounded" src="{{ asset( '/public/plugins/bootflat/img/thumbnail-3.jpg') }}">
            <div class="caption text-center">
              <h3>Thumbnail label</h3>
              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id ...</p>
              <p><a href="#" class="btn btn-warning" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
            </div>
          </div>
        </div>
        <div class="col-sm-4 col-md-3">
          <div class="thumbnail">
            <img class="img-rounded" src="{{ asset( '/public/plugins/bootflat/img/thumbnail-4.jpg') }}">
            <div class="caption text-center">
              <h3>Thumbnail label</h3>
              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id ...</p>
              <p><a href="#" class="btn btn-warning" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
            </div>
          </div>
        </div>
        
    </div>
</div>
</div>    
@endsection