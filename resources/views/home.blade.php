@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <div class="content content-main">
        <div class="button">
            <div class="container">
                <div class="button__row">
                    <x-home.primary-button>
                        <x-slot:route>
                            {{ route('events.create') }}
                        </x-slot:route>
                        <x-slot:image>
                            {{Vite::image('icons/plus.svg')}}
                        </x-slot:image>
                        <x-slot:alt-text>
                            Создать
                        </x-slot:alt-text>
                        <x-slot:button-text>
                            Создать
                        </x-slot:button-text>
                        <x-slot:description>
                            Создатели мероприятий размещают объявление о событии и устанавливают цену за вход, оплата передается организатору через нашу платформу при помощи безопасной сделки
                        </x-slot:description>
                    </x-home.primary-button>
                    {{-- //TODO select city --}}
                    <x-home.primary-button>
                        <x-slot:route>
                            {{ route('events.index') }}
                        </x-slot:route>
                        <x-slot:image>
                            {{Vite::image('icons/search.svg')}}
                        </x-slot:image>
                        <x-slot:alt-text>
                            Найти
                        </x-slot:alt-text>
                        <x-slot:button-text>
                            Найти
                        </x-slot:button-text>
                        <x-slot:description>
                            Проведите хорошо время, не затрачивая силы на координацию меропрития. Вы можете выбрать формат вечеринки в зависимости от цели и бюджета
                        </x-slot:description>
                    </x-home.primary-button>
                </div>
            </div>
        </div>
    </div>
@endsection
