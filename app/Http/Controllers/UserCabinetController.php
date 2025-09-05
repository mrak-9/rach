<?php

namespace App\Http\Controllers;

use App\Models\ConferenceParticipant;
use App\Models\ConferenceAbstract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserCabinetController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('cabinet.index', compact('user'));
    }
    
    public function profile()
    {
        $user = Auth::user();
        return view('cabinet.profile', compact('user'));
    }
    
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'workplace' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'academic_degree' => 'nullable|string|max:255',
        ]);
        
        $emailChanged = $user->email !== $request->email;
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'city' => $request->city,
            'workplace' => $request->workplace,
            'position' => $request->position,
            'academic_degree' => $request->academic_degree,
        ]);
        
        // Если email изменился, сбрасываем верификацию
        if ($emailChanged) {
            $user->email_verified_at = null;
            $user->save();
            $user->sendEmailVerificationNotification();
            
            return back()->with('success', 'Профиль обновлен. На новый email отправлено письмо для подтверждения.');
        }
        
        return back()->with('success', 'Профиль успешно обновлен.');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Неверный текущий пароль.']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Пароль успешно изменен.');
    }
    
    public function events()
    {
        $user = Auth::user();
        $participations = ConferenceParticipant::with(['conference', 'abstracts'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('cabinet.events', compact('participations'));
    }
    
    public function certificates()
    {
        $user = Auth::user();
        $approvedParticipations = ConferenceParticipant::with('conference')
            ->where('user_id', $user->id)
            ->where('is_approved', true)
            ->whereHas('conference', function($query) {
                $query->where('end_date', '<', now());
            })
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('cabinet.certificates', compact('approvedParticipations'));
    }
    
    public function membership()
    {
        $user = Auth::user();
        $hasActiveMembership = $user->hasActiveMembership();
        $membershipExpiresAt = $user->membership_expires_at;
        
        return view('cabinet.membership', compact('user', 'hasActiveMembership', 'membershipExpiresAt'));
    }
}
