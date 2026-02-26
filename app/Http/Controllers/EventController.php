<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index()
    {
        $events = Event::latest()->paginate(15);
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!$this->isValidDateInput($value)) {
                    $fail('The ' . str_replace('_', ' ', $attribute) . ' format is invalid.');
                }
            }],
            'event_time' => 'nullable',
            'location' => 'nullable|string|max:255',
            'event_image' => 'nullable|image',
            'status' => 'required|in:upcoming,completed,cancelled',
        ]);

        $validated['event_date'] = $this->normalizeDateInput($validated['event_date']);

        if ($request->hasFile('event_image')) {
            $validated['event_image'] = $request->file('event_image')->store('events', 'public');
        }

        Event::create($validated);

        return redirect()->route('events.index')->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!$this->isValidDateInput($value)) {
                    $fail('The ' . str_replace('_', ' ', $attribute) . ' format is invalid.');
                }
            }],
            'event_time' => 'nullable',
            'location' => 'nullable|string|max:255',
            'event_image' => 'nullable|image',
            'status' => 'required|in:upcoming,completed,cancelled',
        ]);

        $validated['event_date'] = $this->normalizeDateInput($validated['event_date']);

        if ($request->hasFile('event_image')) {
            // Delete old image if exists
            if ($event->event_image) {
                Storage::disk('public')->delete($event->event_image);
            }
            $validated['event_image'] = $request->file('event_image')->store('events', 'public');
        }

        $event->update($validated);

        return redirect()->route('events.index')->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event)
    {
        if ($event->event_image) {
            Storage::disk('public')->delete($event->event_image);
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }

    private function isValidDateInput(?string $value): bool
    {
        if (empty($value)) {
            return false;
        }

        foreach (['Y-m-d', 'd/m/Y'] as $format) {
            try {
                $date = Carbon::createFromFormat($format, $value);
                if ($date && $date->format($format) === $value) {
                    return true;
                }
            } catch (\Throwable) {
                // Try next format
            }
        }

        return false;
    }

    private function normalizeDateInput(string $value): string
    {
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) === 1) {
            return Carbon::createFromFormat('Y-m-d', $value)->format('Y-m-d');
        }

        return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
}
