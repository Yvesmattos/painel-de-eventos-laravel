@extends('layouts.main')

@section('title', 'Dasboard')

@section('content')

    <div class="col-md-10 offset-md-1 dashboard-title-container">
        <h1>Meus Eventos</h1>
    </div>
    <div class="col-md-10 offset-md-1 dashboard-events-container">
        @if (count($events) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Participantes</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td scropt="row">{{ $loop->index + 1 }}</td>
                            <td><a href="/events/{{ $event->id }}">{{ $event->title }}</a></td>
                            <td>{{ count($event->users) }}</td>
                            <td>
                                <div class="actions">
                                    <a href="/events/edit/{{ $event->id }}" class="btn btn-info edit-btn"><span
                                            class="material-icons" style="color: white">
                                            mode_edit
                                        </span>Editar</a>
                                </div>
                                <div class="actions">
                                    <form action="/events/{{ $event->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete-btn">
                                            <span class="material-icons">
                                                delete
                                            </span>Excluir</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Você ainda não tem eventos, <a href="/events/create">criar evento</a></p>
        @endif
    </div>
    <div class="col-md-10 offset-md-1 dashboard-title-container">
        <h1>Eventos que estou inscrito</h1>
    </div>
    <div class="col-md-10 offset-md-1 dashboard-events-container">
        @if (count($participants) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Participantes</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($participants as $event)
                        <tr>
                            <td scropt="row">{{ $loop->index + 1 }}</td>
                            <td><a href="/events/{{ $event->id }}">{{ $event->title }}</a></td>
                            <td>{{ count($event->users) }}</td>
                            <td>
                                <form action="/events/leave/{{$event->id}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger delete-btn exit">
                                    <span class="material-icons">delete</span> Sair do evento
                                </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Nenhuma inscrição realizada. <a href="/">Confira os eventos disponíveis.</a> </p>
        @endif
    </div>
@endsection
