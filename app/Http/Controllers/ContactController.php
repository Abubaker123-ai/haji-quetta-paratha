<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'message' => 'nullable|string|max:1000',
        ]);

        Contact::create($request->only('name', 'phone', 'address', 'message'));

        try {
            Mail::raw(
                "Naya Inquiry!\n\nNaam: {$request->name}\nPhone: {$request->phone}\nAddress: {$request->address}\nMessage: {$request->message}",
                function ($mail) {
                    $mail->to(config('mail.from.address'))
                         ->subject('Naya Contact — Haji Quetta Paratha');
                }
            );
        } catch (\Exception $e) {
            // Email fail hone par form submission rok nahi
        }

        return back()->with('success', 'Aapka message mil gaya! Hum jald rabta karenge.');
    }

    public function adminIndex()
    {
        $contacts = Contact::latest()->get();
        return view('admin.contacts', compact('contacts'));
    }
}
