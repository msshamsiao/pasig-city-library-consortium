<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
    /**
     * Display all library activities, events, and news with complete timeline.
     * This method returns ALL 8 activities with full descriptions.
     */
    public function index()
    {
        // COMPLETE DATA FOR ALL 8 ACTIVITIES WITH FULL DESCRIPTIONS
        $activities = [
            // Activity 1: New Digital Collection Launch
            [
                'id' => 1,
                'date' => 'January 15, 2025',
                'title' => 'New Digital Collection Launch',
                'description' => 'We are excited to announce the launch of our new digital collection featuring over 5,000 e-books, audiobooks, and digital magazines. This collection includes academic journals, fiction and non-fiction titles, and specialized research materials.',
                'has_image' => true,
                'image' => null,
                'category' => 'announcement'
            ],
            
            // Activity 2: Reading Program for Children
            [
                'id' => 2,
                'date' => 'January 10, 2025',
                'title' => 'Reading Program for Children',
                'description' => 'Join our monthly reading program designed for children ages 5-12. Every Saturday from 10 AM to 12 PM, we host interactive storytelling sessions, book discussions, and creative writing workshops.',
                'has_image' => false,
                'image' => null,
                'category' => 'program'
            ],
            
            // Activity 3: Library Hours Extended
            [
                'id' => 3,
                'date' => 'January 5, 2025',
                'title' => 'Library Hours Extended',
                'description' => 'Starting February 1st, all consortium libraries will extend their operating hours. Monday through Friday: 7 AM to 10 PM, Saturday: 8 AM to 8 PM, Sunday: 10 AM to 6 PM.',
                'has_image' => false,
                'image' => null,
                'category' => 'announcement'
            ],
            
            // Activity 4: Research Workshop Series
            [
                'id' => 4,
                'date' => 'December 28, 2024',
                'title' => 'Research Workshop Series',
                'description' => 'Learn advanced research techniques in our monthly workshop series. Topics include database navigation, citation management, academic writing, and digital literacy skills for students and professionals.',
                'has_image' => true,
                'image' => null,
                'category' => 'workshop'
            ],
            
            // Activity 5: Holiday Reading Challenge
            [
                'id' => 5,
                'date' => 'December 20, 2024',
                'title' => 'Holiday Reading Challenge',
                'description' => 'Participate in our annual holiday reading challenge! Read at least 5 books during the holiday season and win prizes. Challenge runs from December 20 to January 15.',
                'has_image' => false,
                'image' => null,
                'category' => 'event'
            ],
            
            // Activity 6: Author Meet and Greet
            [
                'id' => 6,
                'date' => 'December 15, 2024',
                'title' => 'Author Meet and Greet',
                'description' => 'Meet renowned Filipino authors in our special series of author talks and book signings. Join us for intimate discussions about their writing process and latest works.',
                'has_image' => false,
                'image' => null,
                'category' => 'event'
            ],
            
            // Activity 7: Library Card Registration Drive
            [
                'id' => 7,
                'date' => 'December 10, 2024',
                'title' => 'Library Card Registration Drive',
                'description' => 'Free library card registration for all Pasig City residents! Visit any consortium library with a valid ID and proof of residency to get your card on the spot.',
                'has_image' => false,
                'image' => null,
                'category' => 'announcement'
            ],
            
            // Activity 8: Student Volunteer Program
            [
                'id' => 8,
                'date' => 'December 5, 2024',
                'title' => 'Student Volunteer Program',
                'description' => 'High school and college students can now apply for our volunteer program. Gain valuable experience in library operations while earning community service hours.',
                'has_image' => false,
                'image' => null,
                'category' => 'program'
            ]
        ];

        // Return view with all activities data
        return view('activities', compact('activities'));
    }

    /**
     * Display a specific activity's full details page.
     * 
     * @param int $id The activity ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        // TODO: When you implement database, fetch specific activity like this:
        // $activity = Activity::findOrFail($id);
        // return view('activities.show', compact('activity'));
        
        // For now, redirect back with info message
        return redirect()->route('activities')
            ->with('info', 'Activity details page coming soon!');
    }

    /**
     * Filter activities by category.
     * 
     * @param string $category The category to filter by
     * @return \Illuminate\View\View
     */
    public function filterByCategory($category)
    {
        // TODO: Implement when you have database
        // $activities = Activity::where('category', $category)->latest()->get();
        
        return redirect()->route('activities')
            ->with('info', 'Category filtering coming soon!');
    }
}
