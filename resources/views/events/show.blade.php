@extends('layouts.main')
@section('title', $event->title)

@section('content')

    <div class="col-md-10 offset-md-1">
        <div class="row">
            <div id="image-container" class="col-md-6">
                <img src="/img/events/{{ $event->image }}" class="img-fluid" alt="{{ $event->title }}">
            </div>
            <div id="info-container" class="col-md-6">
                <h1>{{ $event->title }}</h1>
                <p class="event-city">
                    <span class="material-icons">location_on</span>{{ $event->city }}
                </p>
                <p class="events-participants">
                    <span class="material-icons">people_alt</span> {{ count($event->users) }} participantes
                </p>
                <p class="event-owner">
                    <span class="material-icons">star_rate</span> {{ $eventOwner['name'] }}
                </p>
                @if (!$isPart)
                    <form action="/events/join/{{ $event->id }}" method="post">
                        @csrf
                        <a href="/events/join/{{ $event->id }}" class="btn btn-primary" id="event-submit"
                            onclick="event.preventDefault();this.closest('form').submit()">
                            Confirmar Presença
                        </a>
                    </form>
                @else
                    <p class="is-part">Inscrição já efetuada!</p>
                @endif
                @if ($event->itens > 0)
                    <h3>O evento conta com:</h3>
                    <ul id="itens-list">
                        @foreach ($event->itens as $item)
                            <li>
                                <span class="material-icons">layers</span> <span>{{ $item }}</span>
                            </li>
                        @endforeach
                @endif
                </ul>
            </div>
            <div class="col-md-12" id="description-container">
                <h3>Sobre o evento:</h3>
                <p class="event-description">{{ $event->description }}</p>
            </div>
        </div>
    </div>

@endsection
