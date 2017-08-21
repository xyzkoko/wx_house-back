@extends('layouts.app')
@section('app')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">欢迎,{{ Auth::user()->name }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
</div>
@endsection
