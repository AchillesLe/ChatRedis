@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">List room</div>
                <div class="card-body">
                   <chat-room></chat-room>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">My Room</div>
                <div class="card-body">
                   <room></room>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
