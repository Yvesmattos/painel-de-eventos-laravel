<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Event;
use  App\Models\User;

class EventController extends Controller
{

    public function index()
    {

        $search = request('search');

        if (trim($search)) {

            $events = Event::where([
                ['title', 'like', '%' . $search . '%']
            ])->get();
        } else {
            $events = Event::all();
        }


        return view('welcome', ['events' => $events, 'search' => $search]);
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $event = new Event;

        $event->title = $request->title;
        $event->date = $request->date;
        $event->city = $request->city;
        $event->availability = $request->availability;
        $event->description = $request->description;
        $event->itens = $request->itens;
        $event->image = "";

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImg = $request->image;
            $extension = $requestImg->extension();
            $imgName = md5($requestImg->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $requestImg->move(public_path('img/events'), $imgName);
            $event->image = $imgName;
        }

        $user = auth()->user();
        $event->user_id = $user->id;

        $event->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso!');
    }

    public function show($id)
    {

        $event = Event::findOrFail($id);

        $user = auth()->user();

        $isPart = false;

        if ($user) {
            $userEvents = $user->participants->toArray();
            foreach ($userEvents as $uE) {
                if ($uE['id'] == $id) {
                    $isPart = true;
                }
            }
        }

        $eventOwner = User::where('id', $event->user_id)->first()->toArray();

        return view('events.show', ['event' => $event, 'eventOwner' => $eventOwner, 'isPart' => $isPart]);
    }

    public function destroy($id)
    {

        $event = Event::findOrFail($id)->delete();

        return redirect('/dashboard')->with('msg', 'Exclusão bem sucedida!');
    }


    public function edit($id)
    {

        $user = auth()->user();

        $event = Event::findOrFail($id);

        if ($user->id != $event->user_id) {
            return redirect('/dashboard');
        }

        return view('events.edit', ['event' => $event]);
    }

    public function update(Request $request)
    {

        $data = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path('img/events'), $imageName);

            $data['image'] = $imageName;
        }

        Event::findOrFail($request->id)->update($data);

        return redirect('/dashboard')->with('msg', 'Evento editado com sucesso!');
    }

    public function dashboard()
    {
        $user = auth()->user();

        $events = $user->events;

        $participants = $user->participants;

        return view('events.dashboard', ['events' => $events, 'participants' => $participants]);
    }

    public function joinEvent($id)
    {
        $user = auth()->user();

        $user->participants()->attach($id);

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Presença confirmada no evento' . $event->title);
    }

    public function leaveEvent($id)
    {
        $user = auth()->user();
        $user->participants()->detach($id);

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Saída do evento bem sucedida' . $event->title);
    }
}
