@extends('layouts.app')

@section('content')
    <div style="display: flex;">
        <h1 style="margin: 2em">Список ваших сделок</h1>
        <div style="display: flex; align-items: center; justify-content: center">
            <button class="btn btn-primary"><a href="{{ route('getLeads') }}" style="text-decoration: none; color: black">Обновить
                    список</a></button>
        </div>
    </div>
    <div class="row" id="inc-temp" style="margin-top: 1em;">
        @foreach($leads as $lead)
            <div class="col-sm-6">
                <div class="card mx-auto" style="padding:20px; margin-bottom: 3em">
                    <div class="card-body">
                        <h5 class="card-title">Название: {{ $lead->name }}</h5>
                        <h5 class="card-title">Стоимость: {{ $lead->price }} ₽</h5>
                        <h5 class="card-title">Статус: {{ $lead->status }}</h5>
                        @if($lead->company)
                            <h5 class="card-title"> Компания: <a href="{{ route('company', $lead->company->id) }}">{{ $lead->company->name }} </a></h5>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="row" style="display: flex; flex-direction: row">
                            <div class="count-group col">
                                <span class="row">Сделка создана: </span>
                                <span class="row"> {{ $created_at = date("D, d M Y H:i:s" ,$lead->createdAt) }} </span>
                            </div>
                            <div class="price-per-one-group col">
                                <span class="row">Сделка обновлена: </span>
                                <span class="row"> {{ $created_at = date("D, d M Y H:i:s" ,$lead->updatedAt) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
