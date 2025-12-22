<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of contact messages.
     */
    public function index(Request $request)
    {
        try {
            $query = Contact::latest();

            // Filter by read status
            if ($request->has('filter')) {
                if ($request->filter === 'unread') {
                    $query->unread();
                } elseif ($request->filter === 'read') {
                    $query->read();
                }
            }

            $contacts = $query->paginate(20);
            $unreadCount = Contact::unread()->count();
            $totalCount = Contact::count();
        } catch (\Illuminate\Database\QueryException $e) {
            // If contacts table doesn't exist, return empty results
            $contacts = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20);
            $unreadCount = 0;
            $totalCount = 0;
        }

        return view('admin.contacts.index', compact('contacts', 'unreadCount', 'totalCount'));
    }

    /**
     * Display the specified contact message.
     */
    public function show(Contact $contact)
    {
        // Mark as read if not already read
        if (!$contact->read) {
            $contact->markAsRead();
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Mark message as read.
     */
    public function markAsRead(Contact $contact)
    {
        $contact->markAsRead();

        return back()->with('success', 'Message marked as read.');
    }

    /**
     * Mark message as unread.
     */
    public function markAsUnread(Contact $contact)
    {
        $contact->markAsUnread();

        return back()->with('success', 'Message marked as unread.');
    }

    /**
     * Update admin notes.
     */
    public function updateNotes(Request $request, Contact $contact)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $contact->update([
            'admin_notes' => $request->admin_notes,
        ]);

        return back()->with('success', 'Notes saved successfully.');
    }

    /**
     * Remove the specified contact message.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Message deleted successfully.');
    }

    /**
     * Delete multiple messages.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'contacts' => 'required|array',
            'contacts.*' => 'exists:contacts,id',
        ]);

        Contact::whereIn('id', $request->contacts)->delete();

        return back()->with('success', 'Selected messages deleted successfully.');
    }
}

