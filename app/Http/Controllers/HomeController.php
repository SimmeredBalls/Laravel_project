<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Gallery; 
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    // Show single room + future bookings
    public function room_details($id)
    {
        $room = Room::findOrFail($id);

        $bookings = Booking::where('room_id', $id)
            ->where('end_date', '>=', now())
            ->orderBy('start_date')
            ->get();

        return view('home.room_details', compact('room', 'bookings'));
    }

    public function about_details()
    {
        return view('home.about_details');
    }

    public function our_room_details(Request $request)
    {
        $query = Room::query();

        if ($request->filled('room_title')) {
            $query->where('room_title', 'like', '%' . $request->room_title . '%');
        }

        if ($request->filled('type')) {
            $query->where('room_type', $request->type);
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        if ($request->has('wifi')) {
            $query->where('wifi', 'yes');
        }

        $room = $query->paginate(6);
        return view('home.our_room_details', compact('room'));
    }

    public function gallery_details()
    {
        $gallery = Gallery::all();
        return view('home.gallery_details', compact('gallery'));
    }

    public function contact_details()
    {
        return view('home.contact_details');
    }

    public function add_booking(Request $request, $roomId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['You must be logged in to book a room.']);
        }

        $room = Room::findOrFail($roomId);

        $start = Carbon::parse($request->startDate);
        $end = Carbon::parse($request->endDate);
        $nights = max($start->diffInDays($end), 1);

        // 🔍 Check if room is already booked during the selected date range
        $conflict = Booking::where('room_id', $room->id)
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_date', [$start, $end])
                    ->orWhereBetween('end_date', [$start, $end])
                    ->orWhere(function ($query) use ($start, $end) {
                        $query->where('start_date', '<=', $start)
                                ->where('end_date', '>=', $end);
                    });
            })
            ->where('status', '!=', 'cancelled') // ❗ still block active or pending bookings
            ->exists();

        if ($conflict) {
            return redirect()->back()->with('message', '0');
        }

        $total = $request->filled('total_price')
            ? floatval($request->total_price)
            : $room->price * $nights;

        $booking = Booking::create([
            'user_id'      => Auth::id(),
            'room_id'      => $room->id,
            'name'         => $request->name,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'start_date'   => $start,
            'end_date'     => $end,
            'nights'       => $nights,
            'total_price'  => $total,
            'status'       => 'waiting',
            'notes'        => $request->notes,
        ]);

        return redirect()->route('payment.form', $booking->id);
    }



    public function my_bookings()
    {
        $bookings = Booking::where('user_id', Auth::id())->with('room', 'payment')->get();
        return view('home.my_bookings', compact('bookings'));
    }

    public function cancel_booking($id)
    {
        $booking = Booking::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $booking->status = 'cancelled';
        $booking->save();

        return redirect()->route('my.bookings')->with('status', 'Booking canceled.');
    }

    public function contact(Request $request)
    {
        Contact::create($request->only(['name', 'email', 'phone', 'message']));
        return redirect()->back()->with('message', 'Message Sent Successfully');
    }
}
