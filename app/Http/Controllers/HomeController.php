<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Conference;
use App\Models\Event;
use App\Models\Publication;
use App\Models\Project;
use App\Models\Partner;
use App\Models\Page;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Получаем последние новости и мероприятия для главной страницы
        $latestNews = News::published()->latest()->take(10)->get();
        $upcomingConferences = Conference::upcoming()->take(10)->get();
        
        // Получаем контент главной страницы
        $homePage = Page::where('slug', 'home')->first();
        
        return view('home', compact('latestNews', 'upcomingConferences', 'homePage'));
    }
    
    public function about()
    {
        $aboutPage = Page::where('slug', 'about')->first();
        return view('about', compact('aboutPage'));
    }
    
    public function media()
    {
        $mediaPage = Page::where('slug', 'media')->first();
        return view('about.media', compact('mediaPage'));
    }
    
    public function cooperation()
    {
        $cooperationPage = Page::where('slug', 'cooperation')->first();
        return view('about.cooperation', compact('cooperationPage'));
    }
    
    public function offer()
    {
        $offerPage = Page::where('slug', 'offer')->first();
        return view('about.offer', compact('offerPage'));
    }
    
    public function events()
    {
        $events = Event::paginate(10);
        return view('events.index', compact('events'));
    }
    
    public function eventShow(Event $event)
    {
        return view('events.show', compact('event'));
    }
    
    public function publications()
    {
        $publications = Publication::latest('published_at')->paginate(10);
        return view('publications.index', compact('publications'));
    }
    
    public function publicationShow(Publication $publication)
    {
        return view('publications.show', compact('publication'));
    }
    
    public function projects()
    {
        $projects = Project::paginate(10);
        return view('projects.index', compact('projects'));
    }
    
    public function projectShow(Project $project)
    {
        return view('projects.show', compact('project'));
    }
    
    public function partners()
    {
        $partners = Partner::all();
        return view('partners.index', compact('partners'));
    }
    
    public function partnerShow(Partner $partner)
    {
        return view('partners.show', compact('partner'));
    }
    
    public function membership()
    {
        $membershipPage = Page::where('slug', 'membership')->first();
        return view('membership', compact('membershipPage'));
    }
}
