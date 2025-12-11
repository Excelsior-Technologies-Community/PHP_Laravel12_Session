<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller {
   
   // Get session data
   public function accessSessionData(Request $request) {
      if($request->session()->has('my_name')) {
         $data = $request->session()->get('my_name');
         return response()->json([
            'status' => 'success',
            'data' => $data,
            'message' => 'Data retrieved from session'
         ]);
      } else {
         return response()->json([
            'status' => 'error',
            'data' => null,
            'message' => 'No data in the session'
         ]);
      }
   }
   
   // Store session data
   public function storeSessionData(Request $request) {
      $request->session()->put('my_name', 'Virat Gandhi');
      $request->session()->put('last_updated', now()->toDateTimeString());
      
      return response()->json([
         'status' => 'success',
         'message' => 'Data has been added to session',
         'session_data' => [
            'my_name' => 'Virat Gandhi',
            'last_updated' => now()->toDateTimeString()
         ]
      ]);
   }
   
   // Delete session data
   public function deleteSessionData(Request $request) {
      $request->session()->forget('my_name');
      
      return response()->json([
         'status' => 'success',
         'message' => 'Data has been removed from session.'
      ]);
   }
   
   // Clear all session data
   public function clearSession(Request $request) {
      $request->session()->flush();
      
      return response()->json([
         'status' => 'success',
         'message' => 'All session data cleared.'
      ]);
   }
}