@extends('layouts.main')
@section('title', 'Edição do evento' . $event->title)

@section('content')

    <div id="event-create-container" class="col-md-6 offset-md-3">
        <h1>Edição do evento {{ $event->title }}</h1>
        <form action="/events/update/{{ $event->id }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="image">Imagem do evento:</label>
                <input type="file" id="image" name="image" class="form-control-file">
                <img src="/img/events/{{ $event->image }}" alt="{{ $event->title }}" class="img-preview">
            </div>
            <div class="form-group">
                <label for="title">Evento:</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Nome do evento"
                    value="{{ $event->title }}">
            </div>
            <div class="form-group">
                <label for="title">Data do evento:</label>
                <input type="date" class="form-control" id="date" name="date"
                    value="{{ $event->date->format('Y-m-d') }}">
            </div>
            <div class="  form-group">
                <label for="title">Cidade:</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="Local do evento"
                    value="{{ $event->city }}">
            </div>
            <div class="form-group">
                <label for="title">Disponível para:</label>
                <select name="availability" id="availability" class="form-control">
                    <option value="0">Todos</option>
                    <option value="1" {{ $event->availability == 1 ? "selected = 'selected'" : '' }}>Cadastrados</option>
                </select>
            </div>
            <div class=" form-group">
                <label for="title">Descrição:</label>
                <textarea name="description" id="description" class="form-control"
                    placeholder="Detalhes do evento">{{ $event->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="title">O evento contará com:</label>
                <div class="form-group">
                    <input type="checkbox" name="itens[]" value="Cadeiras"> Cadeiras
                </div>
                <div class="form-group">
                    <input type="checkbox" name="itens[]" value="Palco"> Palco
                </div>
                <div class="form-group">
                    <input type="checkbox" name="itens[]" value="Bebida liberada"> Bebida liberada
                </div>
                <div class="form-group">
                    <input type="checkbox" name="itens[]" value="Buffet"> Buffet
                </div>
                <div class="form-group">
                    <input type="checkbox" name="itens[]" value="Sorteio de brindes"> Sorteio de brindes
                </div>
            </div>
            <input type="submit" class="btn  btn-primary" value="Atualizar evento">
        </form>
    </div>

@endsection
