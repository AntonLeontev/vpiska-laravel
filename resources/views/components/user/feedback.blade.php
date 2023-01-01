@props(['feedback' => $feedback])

<div class="reviews__card">
    <div class="card__photo"><img src="{{ $feedback->author->avatar }}" alt="Аватар"></div>
    <div class="card__info">
        <div class="card__header">
            <div class="card__name">
                <a href="{{ route('users.show', $feedback->author->id) }}">
                    <p><b>{{ $feedback->author->full_name }}</b></p>
                </a>
            </div>
        </div>
        <div class="card__date">
            <p>{{ now()->parse($feedback->created_at)->diffForHumans(now(), true) }} назад</p>
        </div>
        <div class="card__text">
            <p>{{ $feedback->text }}</p>
        </div>
    </div>
</div>
