@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if(Session::get('error'))
                       <div class="alert alert-danger">{{Session::get('error')}}</div> 
                    @else
                       <div class="alert alert-info">You are logged in!</div> 
                        
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
