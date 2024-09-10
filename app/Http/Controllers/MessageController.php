<?php

namespace App\Http\Controllers;

use App\Events\MessageCreated;
use App\Http\Requests\Message\StoreMessageRequest;
use App\Http\Requests\Message\UpdateMessageRequest;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        return inertia('Message/Index', ['message' => Message::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessageRequest $request)
    {
        //todo remove me
        return back()->with('message', 'Przyłapałeś nas! Czat jest w trakcie przebudowy i został chwilow zablokowany, Przepraszamy!');

        $message = Auth::user()->messages()->create($request->validated() + ['conversation_id' => 2]);
        broadcast(new MessageCreated($message))->toOthers();

        return back()->with(['message' => 'Message Created Successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
