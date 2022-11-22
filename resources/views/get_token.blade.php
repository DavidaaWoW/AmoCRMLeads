@extends('layouts.app')

@section('content')
    <form action="{{ route('getToken') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Токен</label>
            <input type="text" class="form-control" name="token">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Base domain</label>
            <input type="text" class="form-control" name="domain" value="@if($user->domain) {{ $user->domain }} @endif">
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
@endsection
