<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;


class Login2Controller extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username() {
        return config('adldap_auth.usernames.eloquent');
    }

    protected function validateLogin(Request $request) {
        $this->validate($request, [
            $this->username() => 'required|string|regex:/^[a-zA-Z]+\.[a-zA-Z]+$/',
            'password' => 'required|string',
        ]);
    }

    protected function attemptLogin(Request $request) {
        $credentials = $request->only('username', 'password');
        $username = $credentials[$this->username()];
        $password = $credentials['password'];


        if($this->verificationIdentifiant($username)) {
            if($this->verificationUtilisateur($username, $password)){
                $user = new User();
                $user->username = $username;
                $this->guard()->login($user, false);
                return true;
            }
        }


        // the user doesn't exist in the LDAP server or the password is wrong
        // log error
        return false;
    }



    function verificationIdentifiant($idUtilisateur) {
        $idRoot = "uid=ldapreader-toul,ou=sysusers,dc=local";
        $mdpRoot = 'YeEa#hh6e';

        $connexion = $this->connexionServeur($idRoot, $mdpRoot);

        if ($connexion != null){
        $filtre = "(uid=".$idUtilisateur.")";
        $recherche = ldap_search($connexion, 'dc=local', $filtre);
        if ($recherche){
        $resultat = ldap_get_entries($connexion, $recherche);
        if($resultat['count'] > 0){
            // on place en variable globale le groupe (region-centre-euipe) de l utilisateur
        $GLOBALS['groupe'] =  $resultat[0]["ou"][0];
        return true;
        }else{
            $mail = $idUtilisateur;
            ?>
            <div class="alert alert-danger"><center>Adresse mail <?php echo $mail; ?>inconnue</center></div>
            <?php
        }
        }else{
            ?>
            <div class="alert alert-danger"><center>Erreur lors de la recherche</center></div>
            <?php
        }
        }
        //ldap_close($connexion);
        return false;

    }

    function verificationUtilisateur($idUtilisateur, $mdp) {
        $idConnexion = "uid=".$idUtilisateur.",ou=users,dc=inserm.fr,dc=local";

        $connexion = $this->connexionServeur($idConnexion, $mdp);
        // teste la variable $connexion est nulle donc si la connexion s est bien deroulee
        if (isset($connexion)){
            ldap_close($connexion);
        }
        return ($connexion != null);
    }





    function connexionServeur($idConnexion, $mdpConnexion) {
        $adresse1 = "ldaps://ldap1.inserm.fr";
        $adresse2 = "ldaps://ldap2.inserm.fr";
        $adresse3 = "ldaps://ldap3.inserm.fr";

        $connexionLDAP = ldap_connect($adresse1);
        // comme l inserm est en OpenLDAP, la fonction retournera toujours une ressource et non un booleen
        if ($connexionLDAP){
            // le @ sert a ne pas envoyer un code erreur
            $bindLDAP = @ldap_bind($connexionLDAP, $idConnexion, $mdpConnexion);
            if ($bindLDAP){
                //echo "connexion LDAP réussi";
                return $connexionLDAP;
            }else{
                // essai d une connection sur ldap2 Inserm
                $connexionLDAP = ldap_connect($adresse2);
                if ($connexionLDAP){
                    $bindLDAP = @ldap_bind($connexionLDAP, $idConnexion, $mdpConnexion);
                    if ($bindLDAP){
                        //echo "connexion LDAP réussi";
                        return $connexionLDAP;
                    }else{
                        // essai d une connection sur ldap3 Inserm
                        $connexionLDAP = ldap_connect($adresse3);
                        if ($connexionLDAP){
                            $bindLDAP = @ldap_bind($connexionLDAP, $idConnexion, $mdpConnexion);
                            if ($bindLDAP){
                                //echo "connexion LDAP réussi";
                                return $connexionLDAP;
                            }
                        }
                    }

                    ?>
                        <div class="alert alert-danger"><center>Identifiant ou mot de passe erroné</center></div>
                    <?php
                }
            }
        }else{
            ?>
            <div class="alert alert-danger"><center>Impossible de joindre le serveur LDAP</center></div>
            <?php
        }
        return null;
    }


}