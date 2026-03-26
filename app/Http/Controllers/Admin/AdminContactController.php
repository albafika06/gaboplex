<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class AdminContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->paginate(15);
        $nonLus   = Contact::where('lu', false)->count();
        return view('admin.contacts', compact('contacts', 'nonLus'));
    }

    public function marquerLu(Contact $contact)
    {
        $contact->update(['lu' => true]);
        return back();
    }
}