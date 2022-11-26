@extends('layouts.app')

@section('title')
    Баланс
@endsection

@section('content')
    <div class="content">
        <x-common.modal id="with_mom">
            <div class="select__row">
                <div class="select__input">
                    <div class="withdrawal__resources">
                        <form action="" method="POST">
                            <h4 class="form-title">Вывод средств</h4>
                            <div class="form-group">
                                <div class="form-label">Номер карты</div>
                                <input type="text" class="form-control" placeholder="1111 ____ ____ ____ 1111"
                                    name="withdraw_card" id="withdraw_card" required>
                                <input type="hidden" name="vpiska" value="{{ auth()->user()->id }}">
                            </div>
                            <div class="form-group form-group__sum">
                                <div class="form-label">Сумма к выводу</div>
                                <div class="form-group__wrapper">
                                    <input type="text" class="form-control" placeholder="0₽" name="sum" required>
                                    <small class="form-text">Минимальная сумма вывода 1000₽</small>
                                </div>
                            </div>
                            <button id="withdraw_req" class="btn" type="submit">Вывести средства</button>
                        </form>
                    </div>
                </div>
            </div>
        </x-common.modal>
        <div class="withdrawal">
            <div class="container">
                <div class="withdrawal__row">
                    <div class="withdrawal__head">
                        <h3 class="withdrawal__title">Вывод средств</h3>
                        <div class="title__close withdrawal__close">
                            <p><a href="/"><img src="{{ Vite::image('icons/close.svg') }}" alt="close"></a></p>
                        </div>
                    </div>
                    <div class="withdrawal__data">
                        <div class="withdrawal__info">
                            <form action="#">
                                <h4 class="form-title">Ваш баланс:</h4>
                                <div class="withdrawal__balance">
                                    {{ auth()->user()->balance }} р
                                </div>
                            </form>
                        </div>
                        <div class="withdrawal__code activate-code">
                            {{-- //TODO code activation --}}
                            <x-common.form action="{{route('activate_code')}}" method="POST">
                                <h4 class="form-title">Активация кода</h4>
                                <div class="activate-code__row">
                                    <input name="code" id="with_code" type="text"
                                        class="form-control activate-code__input" placeholder="Введите код">
                                    <div class="activate-code__btn">
                                        <button id="activate_code" class="btn btn--purple">Активировать</button>
                                    </div>
                                </div>
                            </x-common.form>
                        </div>
                        <div class="activate-code__btn">
                            <a href="#with_mom"><button class="btn btn--purple">Вывод средств</button></a>
                        </div>
                        <div class="withdrawal__history">
                            <h4 class="form-title">
                                История операций
                            </h4>
                            <table class="table-history" cellspacing="0">
                                {{-- <thead>
                                    <tr>
                                        <th>Дата</th>
                                        <th>Сумма</th>
                                        <th>Описание</th>
                                    </tr>
                                </thead> --}}
                                <tbody>
                                    @foreach (auth()->user()->balanceTransfers->sortByDesc('created_at') as $transfer)
                                        <tr>
                                            <td>{{$transfer->date}}</td>
                                            <td>{{$transfer->description}}</td>
                                            <td>{{$transfer->signedSum}} р</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
