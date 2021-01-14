<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\eventRequest;
use App\User;
use App\Event;
use Auth;

class EventController extends Controller
{
    public function create()
    {
      /*  $event = new Event;
        $event->user_id = 2;
        $event->name = 'Wycieczka rowerowa';
        $event->location = 'Tama nad Zalewem Zemborzyckim';
        $event->description = 'Dookoła zalewu';
        $event->datetime = '2020-07-11 14:00:00';

        $event->save();

        $user = User::find([2, 3]);
        $event->Users()->attach($user);

        return 'Success';*/
        $event = new Event();
        return view('event.eventForm',compact('event'));
    }

    public function store(eventRequest $request)
    {
        if(\Auth::user()==null){
            return view('events');
        }
        $event = new Event();
        $event->user_id = \Auth::user()->id;
        $event->name = $request->name;
        $event->location = $request->location;
        $event->description = $request->description;
        $event->datetime = $request->datetime;
        $event->save();
        $event->Users()->attach(\Auth::user());
        $user = User::find($request->users);
        $event->Users()->attach($user);
        if($event->save()){
            return redirect()->route('choose');
        }
        return "Wystąpił błąd.";
    }
    public function show(Event $event)
    {
        return view('event.show', compact('event'));
    }
    
    public function removeUser(Event $event)
    {
        $user = User::find(3);

        $event->users()->detach($user);
        
        return 'Success';
    }
    public function choose(Event $event,User $user)
    {   
        $user = Auth::user();
        return view('event.choose',compact('event'),compact('user'));
        

    }

    public function destroy($id)
    {
        $event = Event::find($id);
        if(\Auth::user()->id != $event->user_id)
        {
            return back()->with(['success'=>false, 'message_type'=>'danger',
                'message' => 'Nie posiadasz uprawnień do przeprowadzenia tej operacji.']);          
        }
        if($event->delete()){
            return redirect()->route('choose')->with(['success'=>true,
                'message_type' => 'success',
                'message' => 'Pomyślnie skasowano wydarzenie.']);
        }
        return back()->with(['success'=>false, 'message_type' => 'danger',
            'message' => 'Wystąpił błąd podczas kasowania wydarzenia użytkownika '.
                '.Spróbuj później.']);
    }


public function edit($id) {
    $event = Event::find($id);
    //Sprawdzenie czy użytkownik jest autorem komentarza
    if (\Auth::user()->id != $event->user_id) {
    return back()->with(['success' => false, 'message_type' => 'danger',
    'message' => 'Nie posiadasz uprawnień do przeprowadzenia tej operacji.']);
    }
    return view('event.eventEditForm', compact('event'));
    }
    public function update(Request $request, $id)
    { $event = Event::find($id);
    //Sprawdzenie czy użytkownik jest autorem komentarza
    if(\Auth::user()->id != $event->user_id)
    {
    return back()->with(['success' => false, 'message_type' => 'danger',
    'message' => 'Nie posiadasz uprawnień do przeprowadzenia tej operacji.']);
    }
      $event->name = $request->name;
        $event->location = $request->location;
        $event->description = $request->description;
        $event->datetime = $request->datetime;
        $user = User::find($request->users);
        $event->Users()->attach($user);
        if($event->save()){
            return redirect()->route('choose');
        }
        return "Wystąpił błąd.";
    }
}

