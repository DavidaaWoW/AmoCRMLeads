@extends('layouts.app')

@section('content')
    <div class="row" id="inc-temp" style="margin-top: 3em;">
            <div class="col-sm-6">
                <div class="card mx-auto" style="padding:20px; margin-bottom: 3em">
                    <div class="card-body">
                        <h5 class="card-title">Название: {{ $company->name }}</h5>
                    </div>
                    <div class="card-footer">
                        <div class="row" style="display: flex; flex-direction: row">
                            <div class="count-group col">
                                <span class="row">Компания создана: </span>
                                <span class="row"> {{ $created_at = date("D, d M Y H:i:s" ,$company->createdAt) }} </span>
                            </div>
                            <div class="price-per-one-group col">
                                <span class="row">Компания обновлена: </span>
                                <span class="row"> {{ $created_at = date("D, d M Y H:i:s" ,$company->updatedAt) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection
