<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\ConferenceParticipant;
use App\Models\ConferenceAbstract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ConferenceController extends Controller
{
    public function index()
    {
        $currentConferences = Conference::current()->get();
        $pastConferences = Conference::past()->get();
        
        return view('conferences.index', compact('currentConferences', 'pastConferences'));
    }
    
    public function show(Conference $conference)
    {
        $userParticipation = null;
        
        if (Auth::check()) {
            $userParticipation = ConferenceParticipant::where('conference_id', $conference->id)
                ->where('user_id', Auth::id())
                ->first();
        }
        
        return view('conferences.show', compact('conference', 'userParticipation'));
    }
    
    public function register(Request $request, Conference $conference)
    {
        $user = Auth::user();
        
        // Проверяем, что регистрация открыта
        if (!$conference->isRegistrationOpen()) {
            return back()->with('error', 'Регистрация на конференцию закрыта.');
        }
        
        // Проверяем, не зарегистрирован ли уже пользователь
        $existingParticipation = ConferenceParticipant::where('conference_id', $conference->id)
            ->where('user_id', $user->id)
            ->first();
            
        if ($existingParticipation) {
            return back()->with('error', 'Вы уже зарегистрированы на эту конференцию.');
        }
        
        $request->validate([
            'event_date' => 'required|date',
            'format' => 'required|string',
        ]);
        
        // Проверяем членство, если требуется
        if ($conference->requires_membership && !$user->hasActiveMembership()) {
            return back()->with('error', 'Для участия в этой конференции требуется активное членство в РАЧ.');
        }
        
        ConferenceParticipant::create([
            'conference_id' => $conference->id,
            'user_id' => $user->id,
            'event_date' => $request->event_date,
            'format' => $request->format,
            'organization' => $user->workplace,
            'has_membership' => $user->hasActiveMembership(),
            'is_approved' => false, // Требует подтверждения администратором
        ]);
        
        return back()->with('success', 'Ваша заявка на участие в конференции отправлена. Ожидайте подтверждения.');
    }
    
    public function submitAbstract(Request $request, Conference $conference)
    {
        $user = Auth::user();
        
        // Проверяем, что пользователь зарегистрирован на конференцию
        $participation = ConferenceParticipant::where('conference_id', $conference->id)
            ->where('user_id', $user->id)
            ->first();
            
        if (!$participation) {
            return back()->with('error', 'Сначала зарегистрируйтесь на конференцию.');
        }
        
        // Проверяем, что регистрация еще открыта
        if (!$conference->isRegistrationOpen()) {
            return back()->with('error', 'Прием тезисов закрыт.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB
            'agree_to_publish' => 'required|accepted',
        ]);
        
        // Сохраняем файл
        $filePath = $request->file('file')->store('abstracts', 'public');
        
        ConferenceAbstract::create([
            'conference_id' => $conference->id,
            'user_id' => $user->id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'agree_to_publish' => true,
            'is_approved' => false,
        ]);
        
        return back()->with('success', 'Тезисы успешно загружены.');
    }
}
