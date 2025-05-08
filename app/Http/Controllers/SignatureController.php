<?php

namespace App\Http\Controllers;

use App\Models\Signature;
use Illuminate\Http\Request;

class SignatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pages.regen.signatures.index', [
            'signature' => Signature::where('id', '=', 1)->first(),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'signature_file_path' => 'required|file|mimes:png,jpg,jpeg|max:2048',
        ]);

        // delete the old signature file if it exists
        $old_signature = Signature::where('id', '=', 1)->first();
        if ($old_signature && $old_signature->signature_file_path) {
            $old_file_path = storage_path('app/public/' . $old_signature->signature_file_path);
            if (file_exists($old_file_path)) {
                unlink($old_file_path);
            }
        }

        $signature_file_path = $request->file('signature_file_path')->store('signatures', 'public');

        $signature = Signature::updateOrCreate(
            ['id' => 1],
            [
                'name' => $request->name,
                'signature_file_path' => $signature_file_path,
            ]
        );

        return redirect()->route('dashboard.regen.signatures');
    }
}
