<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ContactController extends Controller
{
    //
    public function store(Request $request)
    {
        // return request()->all();
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric',
            'address' => 'required|string|max:5000',
        ],[
            'name.required' => 'Please enter your name',
            'email.required' => 'Please enter your email',
            'phone.required' => 'Please enter your phone',
            'phone.numeric' => 'Please enter a valid phone number',
            'address.required' => 'Please enter your address',
        ]);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->address = $request->address;

        $contact->save();

        return back()->with('success', 'Contact added successfully');
    }
    public function download($id)
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return back()->with('error', 'Contact not found');
        }

        $pdf = \PDF::loadView('pdf', compact('contact'));
        return $pdf->download('contact-'.$contact->name.'.pdf');
    }
}
