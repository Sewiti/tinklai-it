<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{
    public function __construct()
    {
        \Carbon\Carbon::setlocale('lt');
        $this->middleware('auth');
    }


    public function index()
    {
        $userId = auth()->user()->id;

        $pairs = \DB::table('messages')
            ->select(\DB::raw('
                DISTINCT IF(`from`>`to`, `to`, `from`) AS `a`,
                         IF(`from`>`to`, `from`, `to`) AS `b`'))
            ->where('from', $userId)
            ->orWhere('to', $userId)
            ->get();

        $conversations = [];
        foreach ($pairs as $pair) {
            if ($userId != $pair->a)
                $oth = $pair->a;
            else
                $oth = $pair->b;

            array_push($conversations,
                Message::select('messages.message', 'messages.from', 'messages.to', 'messages.read', 'messages.created_at', 'users.id', 'users.name', 'users.email', 'users.type')
                    ->leftJoin('users', \DB::raw(0), '=', \DB::raw(0))
                    ->where('users.id', '=', $oth)
                    ->where(function ($query) use($pair) {
                        $query->where(function ($query) use($pair) {
                            $query->where('to', '=', $pair->a)
                                ->where('from', '=', $pair->b);
                        })->orWhere(function ($query) use($pair) {
                            $query->where('to', '=', $pair->b)
                                ->where('from', '=', $pair->a);
                        });
                    })->orderBy('created_at', 'DESC')
                    ->first()
            );
        }


        usort($conversations, function ($a, $b) {
            if ($a->created_at > $b->created_at) {
                return -1;
            } elseif ($a->created_at < $b->created_at) {
                return 1;
            }
            return 0;
        });

        $users = User::where('id', '!=', $userId)->get();

        return view('messages.index', [
            'conversations' => $conversations,
            'users' => $users,
        ]);
    }


    public function show($recipientId)
    {
        $userId = auth()->user()->id;
        if ($recipientId == $userId) {
            return abort(404); // TODO: should be 400?
        }

        $recipient = User::findOrFail($recipientId);

        $messages = Message::where(function ($query) use($userId, $recipientId) {
                $query->where('from', '=', $userId)
                    ->where('to', '=', $recipientId);
            })
            ->orWhere(function ($query) use($userId, $recipientId) {
                $query->where('from', '=', $recipientId)
                    ->where('to', '=', $userId);
            })->orderBy('created_at', 'ASC')
            ->get();

        foreach ($messages as $message) {
            if ($message->to == $userId) {
                $message->read = true;
                $message->save();
            }
        }

        return view('messages.show', [
            'messages' => $messages,
            'recipient' => $recipient,
        ]);
    }


    public function store()
    {
        $data = request()->validate([
            'recipientId' => 'required|integer|min:0',
            'message' => 'max:500',
        ]);
        if ($data['message'] == '') {
            return redirect(route('messages.show', ['recipientId' => $data['recipientId']]));
        }

        $recipientId = User::findOrFail($data['recipientId'])->id;

        $userId = auth()->user()->id;
        if ($recipientId == $userId) {
            return abort(404); // TODO: should be 400?
        }

        $message = new Message();
        $message->message = $data['message'];
        $message->from = $userId;
        $message->to = $recipientId;
        $message->save();

        return redirect(route('messages.show', ['recipientId' => $data['recipientId']]));
    }


    public function new()
    {
        $data = request()->validate([
            'recipientId' => 'required|integer|min:-1',
        ]);
        $id = $data['recipientId'];

        if ($id < 0) {
            return redirect(route('messages.index'));
        }

        return redirect(route('messages.show', ['recipientId' => $id]));
    }
}
