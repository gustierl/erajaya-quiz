@extends('layouts.app')
@section('content')
<div class="row" >
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h5 class="mt-3">Hasil Quiz : {{$name}}</h5>
                    <div class="page-title-right">
                        <h5 class="mt-3">Total Score : {{$total_score}} </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" >
    <div class="col-xl-12">
        @foreach ($data as $item)
        <div class="card">
            <div class="card-body ">
                <div class="row">
                    <div class="col-8">
                        <h5> {{$item->question_name}} ?</h5>
                        <label> Jawaban : </label><br>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" disabled @if ($item->answer == $item->option_one) checked @endif><label>{{$item->option_one}}</label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" disabled @if ($item->answer == $item->option_two) checked @endif ><label>{{$item->option_two}}</label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" disabled @if ($item->answer == $item->option_three) checked @endif><label>{{$item->option_three}}</label>
                        </div>
                    </div>
                    <div style="text-align:right;" class="col-4">
                        <small> ID : {{$item->question_code}}</small><br>
                        <small> Jawaban Benar : {{$item->right_answer}}</small><br>
                        <small> Status :
                            @if ($item->answer == $item->right_answer)
                            <span class="badge bg-success">Benar</span>
                            @else
                            <span class="badge bg-danger">Salah</span>
                            @endif 
                        </small><br>
                        <small> Score : {{$item->score}} </small><br>
                        <h4></h4>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
