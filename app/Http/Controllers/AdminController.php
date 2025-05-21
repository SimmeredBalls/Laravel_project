<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

use App\Models\Room;

use App\Models\Booking;

use App\Models\Gallery;

use App\Models\Contact;

use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Staff;

use Illuminate\Support\Facades\Notification;

use App\Notifications\SendEmailNotification;



class AdminController extends Controller
{
    public function index()
    {
        if(Auth::id())
        {
            $usertype = Auth::user()->usertype;

            if($usertype == 'user')
            {
                $room = Room::all();
                $gallery = Gallery::all();
                return view('home.index',compact('room','gallery'));
            }

            else if($usertype == 'admin')
            {
                return view('admin.index');
            }

            else
            {
                return redirect()->back();
            }
        }
    }

    public function home()
    {
        $room = Room::all();
        $gallery = Gallery::all();
        return view('home.index',compact('room','gallery'));
    }

    public function create_room()
    {
        return view('admin.create_room');
    }

    public function add_room(Request $request)
    {
        $data = new Room;
        $data->room_title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->wifi = $request->wifi;
        $data->room_type = $request->type;
        $image=$request->image;

        if($image)
        {
            $imagename=time().'.'.$image->getClientOriginalExtension();
            $request->image->move('room',$imagename);
            $data->image=$imagename;
        }

        $data->save();

        return redirect()->back();
    }

    public function view_room()
    {
        $data = Room::all();
        return view('admin.view_room',compact('data'));
    }

    public function delete_room($id)
    {
        $data = Room::find($id);

        $data->delete();

        return redirect()->back();
    }

    public function update_room($id)
    {
        $data = Room::find($id);


        return view('admin.update_room',compact('data'));
    }

    public function edit_room(Request $request, $id)
    {
        $data = Room::find($id);

        $data->room_title = $request->title;

        $data->description = $request->description;

        $data->price = $request->price;

        $data->wifi = $request->wifi;

        $data->room_type = $request->type;

        $image=$request->image;

        if($image)
        {
            $imagename=time().'.'.$image->getClientOriginalExtension();
            $request->image->move('room',$imagename);
            $data->image=$imagename;
        }

        $data->save();

        return redirect()->back();
    }

    public function bookings()
    {
        $data = Booking::all();
        return view('admin.booking',compact('data'));
    }

    public function delete_booking($id)
    {
        $data = Booking::find($id);
        $data->delete();

        return redirect()->back();
    }

    public function approve_book($id)
    {
        $booking = Booking::find($id);
        $booking->status='approve';
        $booking->save();
        return redirect()->back();
    }

    public function reject_book($id)
    {
        $booking = Booking::find($id);
        $booking->status='rejected';
        $booking->save();
        return redirect()->back();
    }

    public function view_gallery()
    {
        $gallery = Gallery::all();

        return view('admin.gallery',compact('gallery'));
    }

    public function upload_gallery(Request $request)
    {
        $data = new Gallery;

        $image = $request->image;

        if($image)
        {
            $imagename=time().'.'.$image->getClientOriginalExtension();
            $request->image->move('gallery',$imagename);
            $data->image = $imagename;
            $data->save();

            return redirect()->back();
        }
    }

    public function delete_gallery($id)
    {
        $data = Gallery::find($id);
        $data->delete();
        return redirect()->back();
    }

    public function all_messages()
    {
        $data = Contact::all();

        return view('admin.all_message', compact('data'));
    }

    public function send_mail($id)
    {   
        $data = Contact::find($id);

        return view('admin.send_mail', compact('data'));
    }

    public function mail(Request $request, $id)
    {
        $contact = Contact::findOrFail($id); // use findOrFail to handle missing IDs

        $details = [
            'greeting'    => $request->greeting,
            'body'        => $request->body,
            'action_text' => $request->action_text,
            'action_url'  => $request->action_url,
            'endline'     => $request->endline,
        ];

        // Ensure Contact model uses Notifiable and has a valid 'email' attribute
        Notification::route('mail', $contact->email)->notify(new SendEmailNotification($details));

        return redirect()->back()->with('success', 'Email sent successfully.');
    }

    public function payments()
    {
        $payments = \App\Models\Payment::with(['user', 'booking.room'])->latest()->get();
        return view('admin.payments', compact('payments'));
    }

    public function create_staff_form()
    {
        return view('admin.create_staff');
    }

    public function create_staff(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'phone' => 'nullable|string',
            'role' => 'required|string|max:255',
        ]);
    
        Staff::create($request->only('name', 'email', 'phone', 'role'));
    
        return redirect()->back()->with('success', 'Staff created successfully.');
    }
    

    public function view_staff()
    {
        $staff = Staff::all();
        return view('admin.view_staff', compact('staff'));
    }
    
    
    public function update_staff($id)
    {
        $staff = Staff::findOrFail($id);
        return view('admin.update_staff', compact('staff'));
    }
    
    public function edit_staff(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'role' => 'required',
        ]);
    
        $staff = Staff::findOrFail($id);
        $staff->update($request->only('name', 'email', 'phone', 'role'));
    
        return redirect()->route('admin.view_staff')->with('success', 'Staff updated successfully.');
    }
    
    public function delete_staff($id)
    {
        Staff::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Staff deleted successfully.');
    }

    public function markPaymentAsPaid($id)
    {
        $payment = Payment::with('booking')->findOrFail($id);

        if ($payment->status === 'completed') {
            return redirect()->back()->with('success', 'Payment already marked as completed.');
        }

        $payment->update([
            'status' => 'completed',
            'transaction_id' => $payment->transaction_id ?? strtoupper(Str::uuid()),
            'paid_at' => now(),
        ]);

        // Create invoice if not yet created
        if (!$payment->booking->invoice) {
            Invoice::create([
                'booking_id' => $payment->booking_id,
                'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
                'total_amount' => $payment->amount,
                'issued_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Payment marked as completed and invoice generated.');
    }

}
