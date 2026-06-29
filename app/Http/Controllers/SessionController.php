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

      return redirect()->route('dashboard')
         ->with('success', 'Session data stored successfully.');
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

         return back()->with('success', "$key removed successfully.");
      }

      return back()->with('error', 'Session key not found.');
   }

   /**
    * Clear All Session
    */
   public function clear(Request $request)
   {
      $request->session()->flush();

      return redirect()->route('dashboard')
         ->with('success', 'All session data cleared.');
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
}