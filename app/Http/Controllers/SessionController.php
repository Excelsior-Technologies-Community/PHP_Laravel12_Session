<?php

namespace App\Http\Controllers;

use App\Models\Student;

use Illuminate\Http\Request;

class SessionController extends Controller
{
   /**
    * Dashboard
    */
   public function dashboard(Request $request)
   {

      if (!session()->has('dashboard_opened')) {

         $this->addTimeline(
            $request,
            'Dashboard Opened',
            'User viewed session dashboard.'
         );

         session()->put('dashboard_opened', true);
      }

      $sessionData = $request->session()->all();

      return view('dashboard', [
         'sessionData' => $sessionData,
         'totalKeys' => count($sessionData),
         'sessionId' => $request->session()->getId(),
      ]);
   }

   /**
    * Show Create Form
    */
   public function create()
   {
      return view('create');
   }

   /**
    * Store Session Data
    */
   public function store(Request $request)
   {
      $request->validate([
         'name' => 'required|string|max:100',
         'email' => 'required|email',
         'city' => 'required|string|max:100',
         'age' => 'required|numeric|min:1|max:100',
      ]);

      $request->session()->put('name', $request->name);
      $request->session()->put('email', $request->email);
      $request->session()->put('city', $request->city);
      $request->session()->put('age', $request->age);

      $request->session()->put('last_updated', now()->format('d-m-Y H:i:s'));
      $request->session()->put('ip_address', $request->ip());
      $request->session()->put('browser', $request->userAgent());


      $this->addTimeline(
         $request,
         'Session Created',
         'New session data stored.'
      );

      $this->flashMessage(
         $request,
         'success',
         'Session created successfully.'
      );
      return redirect()->route('dashboard');
   }

   /**
    * View All Session Data
    */
   public function index(Request $request)
   {
      $sessionData = $request->session()->all();

      return view('session-test', compact('sessionData'));
   }

   /**
    * Search Session Key
    */
   public function search(Request $request)
   {
      $search = strtolower($request->search);

      $result = [];

      foreach ($request->session()->all() as $key => $value) {

         if (str_contains(strtolower($key), $search)) {
            $result[$key] = $value;
         }
      }

      return view('search', compact('result', 'search'));
   }

   /**
    * Remove One Session Key
    */
   public function remove(Request $request, $key)
   {
      if ($request->session()->has($key)) {

         $request->session()->forget($key);

         $this->addTimeline(
            $request,
            'Session Key Deleted',
            "$key removed from session."
         );

         $this->flashMessage(
            $request,
            'warning',
            "$key removed successfully."
         );

         return back();
      }

      $this->flashMessage(
         $request,
         'error',
         'Session key not found.'
      );

      return back();
   }

   /**
    * Clear All Session
    */
   public function clear(Request $request)
   {
      $request->session()->flush();

      $request->session()->put(
         'activity_timeline',
         [
            [
               'title' => 'Session Cleared',
               'description' => 'All session data removed.',
               'time' => now()->format('d M Y h:i:s A'),
            ]
         ]
      );

      $this->flashMessage(
         $request,
         'info',
         'All session data cleared.'
      );

      return redirect()->route('dashboard');
   }
   public function students(Request $request)
   {
      $search = $request->search;

      $students = Student::when($search, function ($query) use ($search) {
         $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->orWhere('city', 'like', '%' . $search . '%')
            ->orWhere('age', 'like', '%' . $search . '%');
      })
         ->latest()
         ->get();

      return view('students', compact('students', 'search'));
   }

   /**
    * API Get Session
    */
   public function get(Request $request)
   {
      return response()->json([
         'status' => true,
         'session' => $request->session()->all(),
      ]);
   }

   /**
    * Store activity into session timeline
    */
   private function addTimeline(Request $request, $title, $description)
   {
      $timeline = $request->session()->get('activity_timeline', []);

      array_unshift($timeline, [
         'title' => $title,
         'description' => $description,
         'time' => now()->format('d M Y h:i:s A'),
      ]);

      if (count($timeline) > 20) {
         array_pop($timeline);
      }

      $request->session()->put('activity_timeline', $timeline);
   }

   /**
    * Store flash notification
    */
   private function flashMessage(Request $request, $type, $message)
   {
      $request->session()->flash($type, $message);
   }

   public function timeline(Request $request)
   {
      $timeline = $request->session()->get('activity_timeline', []);

      return view('timeline', compact('timeline'));
   }

   public function flash(Request $request, $type)
   {
      switch ($type) {

         case 'success':
            $message = 'Profile updated successfully.';
            break;

         case 'error':
            $message = 'Something went wrong.';
            break;

         case 'warning':
            $message = 'Please verify your email.';
            break;

         default:
            $message = 'Welcome back!';
            $type = 'info';
            break;
      }

      $this->flashMessage(
         $request,
         $type,
         $message
      );

      $this->addTimeline(
         $request,
         ucfirst($type) . ' Flash',
         $message
      );

      return redirect()->route('flash.page');
   }

   public function flashPage(Request $request)
   {
      $this->addTimeline(
         $request,
         'Flash Manager Opened',
         'User opened flash message manager.'
      );

      return view('flash');
   }
}
