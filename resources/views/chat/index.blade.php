@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-9">
            <chat></chat>
        </div>
        <div class="col-3">
        	
        	<!--quem vai fazer a parte de usuário logado será o vue.js-->
            <users></users>
        </div>
    </div>
</div>

@endsection