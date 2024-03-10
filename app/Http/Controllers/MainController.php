<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormEmail;
use App\Mail\TestFormEmail;
use App\Models\Interest;
use App\Models\InterestItems;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MainController extends Controller
{
    public function index()
    {
        return inertia("HomeComponent");
    }

    public function aboutPage()
    {
        return inertia("AboutComponent");
    }

    public function interestPage()
    {
        $interests = Interest::select('interests.name', 'interests.description', 'interest_items.item')
            ->leftJoin('interest_items', 'interests.id', '=', 'interest_items.interest_id')
            ->get();
    
        $result = [];
    
        foreach ($interests as $interest) {
            $key = array_search($interest->name, array_column($result, 'name'));
    
            if ($key === false) {
                $result[] = [
                    'name' => $interest->name,
                    'description' => $interest->description,
                    'items' => $interest->item ? [$interest->item] : [],
                ];
            } else {
                if ($interest->item) {
                    $result[$key]['items'][] = $interest->item;
                }
            }
        }
        
        return inertia("InterestComponent", [
            'interests' => $result,
        ]);
    }

    public function createInterest(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:30'],
            'description' => ['required_without:item', 'unique:interests', 'max:50'],
            'item' => ['required_without:description', 'max:100'],
        ]);
        
        if (isset($validated['description']) && !isset($validated['item'])) {
            $existingInterest = Interest::where('name', $validated['name'])->first();

            if (!$existingInterest) {
                Interest::create($validated);
            }
        } elseif (isset($validated['item']) && !isset($validated['description'])) {
            $interest = Interest::where('name', $validated['name'])->first();

            InterestItems::create([
                'interest_id' => $interest->id,
                'item' => $validated['item'],
            ]);
        }

        return back();
    }

    public function educationPage()
    {
        return inertia("EducationComponent");
    }

    public function photoAlbumPage()
    {
        $photo = Photo::select('title', 'path')->get();

        return inertia("PhotoAlbumComponent", compact('photo'));
    }

    public function contactPage()
    {
        return inertia("ContactComponent");
    }

    public function sendEmail(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'date' => ['required', 'date'],
            'phone' => ['required', 'regex:/^(?:\+7|\+3)\d{9,11}$/'],
            'gender' => ['required'],
            'age' => ['required'],
            'email' => ['required', 'email'],
        ]);

        Mail::to('suren.arakelyan994@gmail.com')->send(new ContactFormEmail($validated));

        return inertia("ContactComponent", ['message' => 'Контакты успешно отправлены']);
    }

    public function testPage()
    {
        return inertia("TestComponent");
    }

    public function sendTest(Request $request)
    {
        $validated = $request->validate([
            'surname' => ['required'],
            'name' => ['required'],
            'lastname' => ['required'],
            'group' => ['required'],
            'first' => ['required', 'min:30'],
            'second' => ['required'],
            'third' => ['required'],
        ]);

        Mail::to('suren.arakelyan994@gmail.com')->send(new TestFormEmail($validated));

        return inertia("TestComponent", ['message' => 'Данные успешно отправлены']);
    }

    public function historyPage()
    {
        return inertia("HistoryComponent");
    }
}