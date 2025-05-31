<?php

namespace App\Http\Controllers;
use App\Models\Demande_revendeur;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;           
class ContactController extends Controller
{


    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'sujet' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'message' => 'required|string',
    ]);

    Demande_revendeur::create([
        'name' => $request->name,
        'sujet' => $request->sujet,
        'email' => $request->email,
        'phone' => $request->phone,
        'message' => $request->message,
    ]);

    return back()->with('success', 'Votre Demande a été envoyé avec succès.');
}


    //Revendeurs
    public function Index(Request $request)
    {
        $search = $request->input('search');
    
        $demandes = Demande_revendeur::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%")
                         ->orWhere('sujet', 'like', "%{$search}%");
        })->paginate(10);
    
        return view('dashboard.contact', compact('demandes', 'search'));
    }
public function updateDemandeRevendeur(Request $request)
{
    $request->validate([
        'id' => 'required|exists:demande_revendeur,id',
        'name' => 'required|string|max:255',
        'company' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'message' => 'required|string',
    ]);

    $demande = Demande_revendeur::findOrFail($request->id);
    $demande->update($request->all());

    return redirect()->back()->with('success', 'Demande mise à jour avec succès.');
}

public function destroyDemandeRevendeur($id)
{
    $demande = Demande_revendeur::findOrFail($id);
    $demande->delete();

    return redirect()->back()->with('success', 'Demande supprimée avec succès.');
}

}