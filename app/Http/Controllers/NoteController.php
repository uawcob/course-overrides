<?php

namespace App\Http\Controllers;

use App\Note;
use App\Context;
use App\Course;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Note::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::withTrashed()->with('contexts')->orderBy('deleted_at')->get();

        return view('notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contexts = collect(Context::common())->merge(Course::distinct()->pluck('code'));

        return view('notes.create', compact('contexts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $note = Note::create($request->all());

        if ($request->has('context')) {
            foreach ($request->context as $context) {
                $note->contexts()->save(new Context(['key' => $context]));
            }
        }

        return redirect(route('notes.show', $note));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show($note)
    {
        $note = Note::withTrashed()->with('contexts')->find($note);

        return view('notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit($note)
    {
        $note = Note::withTrashed()->with('contexts')->find($note);

        $contexts = Course::distinct()
            ->pluck('code')
            ->merge(Context::common())
            ->diff($note->contexts->pluck('key'));

        return view('notes.edit', [
            'contexts' => $contexts,
            'note' => $note,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        $note->update($request->all());

        if ($request->has('context')) {
            Context::where('note_id', $note->id)->delete();
            foreach ($request->context as $context) {
                $note->contexts()->save(new Context(['key' => $context]));
            }
        }

        return redirect(route('notes.show', $note));
    }

    public function disable($note)
    {
        $note = Note::withTrashed()->find($note);

        $this->authorize('delete', $note);

        if ($note->trashed()) {
            $note->restore();
        } else {
            $note->delete();
        }

        return redirect(route('notes.show', $note));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $note->forceDelete();

        return redirect(route('notes.index'));
    }
}
