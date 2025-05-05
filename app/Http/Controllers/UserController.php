<?php

namespace App\Http\Controllers;

 use App\Models\User ;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;           
use Illuminate\Support\Facades\Auth;
 use Illuminate\Support\Facades\Password;
class UserController extends Controller
{

    public function createUser()
    {
        return view('dashboard.users');
    }

    /**
     * Ajouter un nouvel utilisateur.
     */
    public function Store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'utype' => 'in:USR,ADM',  
        ]);

        // Vérification des erreurs de validation
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Création de l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'utype' => $request->utype ?? 'USR', // Défaut à 'USR'
        ]);

        // Redirection après succès
        return redirect()
            ->route('dashboard.users')
            ->with('success', 'Utilisateur ajouté avec succès.');
    }


    public function Index()
    {
        // Récupérer tous les utilisateurs
        $users = User::paginate(10);

        // Passer les utilisateurs à la vue
        return view('dashboard.users', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'utype' => 'required|in:USR,ADM',
        ]);
    
        $user = User::findOrFail($id);
        $user->update($request->all());
    
        return redirect()->route('dashboard.users')->with('success', 'Utilisateur mis à jour avec succès.');
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    
        return redirect()->route('dashboard.users')->with('success', 'Utilisateur supprimé avec succès.');
    }
    
     

    //Login 

    public function showLogin()
    {
        return view('dashboard.login'); // Assurez-vous que la vue se trouve dans resources/views/auth/login.blade.php
    }

    // Traiter la connexion
    public function login(Request $request)
    {
        // Étape 1 : Valider l'email et le mot de passe
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ]);
    
        // Étape 2 : Tentative de connexion
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate(); // Protection contre la fixation de session
            return redirect()->route('dashboard')->with('success', 'Connexion réussie.');
        }
    
        // Étape 3 : Retour avec message d’erreur
        return back()->withErrors([
            'email' => 'Les informations de connexion sont incorrectes.',
        ])->withInput();
    }
    
    // Déconnexion
    public function logout()
    {
        Auth::logout();
        return redirect()->route('dashboard.login')->with('success', 'Déconnecté avec succès.');
    }

    // Afficher le formulaire de réinitialisation de mot de passe
    public function showForgotPasswordForm()
    {
        return view('admin.login'); // Assurez-vous que cette vue existe
    }

    // Envoyer le lien de réinitialisation de mot de passe
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Lien de réinitialisation envoyé à votre adresse e-mail.');
        }

        return back()->withErrors(['email' => __($status)]);
    }

    
    public function showProfile()
    {
        // Vérifiez si l'utilisateur est authentifié
        if (Auth::check()) {
            // Récupérer les informations de l'utilisateur connecté
            $user = Auth::user();  // Récupère l'utilisateur authentifié

            // Vous pouvez aussi ajouter d'autres informations comme le nombre de messages non lus, etc.
            $user->inbox_count = 27;  // Exemple : nombre de messages non lus (vous pouvez le calculer dynamiquement)

            // Retourner la vue avec les données de l'utilisateur
            return view('dashboard.home', compact('user'));
        }

        // Si l'utilisateur n'est pas authentifié, rediriger vers la page de connexion
        return redirect()->route('login');
    }

 
}
 