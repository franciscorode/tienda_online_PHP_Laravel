<?php
//namespace Registro\Http\Controllers;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\User;
use Redirect;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use GuzzleHttp\Client;
//use App\Client;

class UserController extends Controller
{
    
    use AuthenticatesUsers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    public function activate($code)
    {
      $users = User::where('code',$code);
      $exist = $users->count();
      $user = $users->first();
      if($exist == 1 and $user->active == 0)
      {
        $id = $user->id;
        return view('auth.date_complete',compact('id'));
      }else{
        return redirect::to('/');
      }
    }
    public function complete(Request $request, $id)
    {
      $user = User::find($id);
      $user->password = bcrypt($request->password);
      $user->activate = 1;
      $user->save();
      Auth::guest();
      /*return redirect::to('auth.login');*/
      Session::flash('mensaje', 'El usuario se ha creado');
      
      //recogemos las categorias
      $categorias = \App\Categoria::all();
      //recogemos los productos excepto aquellos que sean exclusivos para los usuarios logeados
      $productos = \App\Producto::exclusivo()->orderBy('name', 'DESC')->paginate();
      //redirigimos a la vista home enviando las categorias y los productos
      //return view('home', compact('productos', 'categorias'));
     return view('auth.login');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function peticionyrespuesta() {


        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => '919561790448-kijeulv7pto5bpkeqs5pfhli0lv6ludv.apps.googleusercontent.com', 
            'clientSecret'            => 'Ww9j_Ax7ll2i-fmqfMiUxpKI',  
            'redirectUri'             => route('edit/autocompletar'),
            'urlAuthorize'            => 'https://accounts.google.com/o/oauth2/auth',
            'urlAccessToken'          => 'https://accounts.google.com/o/oauth2/token',
            'urlResourceOwnerDetails' => 'https://accounts.google.com/o/oauth2/resource',
            'scopes'                   => ['https://www.googleapis.com/auth/userinfo.email'],
        ]);

        
        // Si no tenemos un código de autorización a continuación, obtener uno 
        if (!isset($_GET['code'])) {

            // Obtener la URL de autorización del proveedor; esto devuelve la 
            // opción urlAuthorize y genera y aplica cualquier parámetro necesario
            $authorizationUrl = $provider->getAuthorizationUrl();

            // Obtener el estado genera para usted y almacenarla en la sesión. 
            $_SESSION['oauth2state'] = $provider->getState();

           
            // redirigir al usuario a la URL de autorización. 
            header('Location: ' . $authorizationUrl);
            exit;

        // Comprobar estado dado en contra de uno previamente almacenada para mitigar el ataque CSRF
        } elseif (empty($_GET['state']) || (isset($_SESSION['oauth2state']) && $_GET['state'] !== $_SESSION['oauth2state'])) {

            if (isset($_SESSION['oauth2state'])) {
                unset($_SESSION['oauth2state']);
            }

            exit('Invalid state');

        } else {

            try {

                 // Trate de obtener un token de acceso mediante la concesión código de autorización. 
                $accessToken = $provider->getAccessToken('authorization_code', [
                    'code' => $_GET['code'],
                ]);
                
             //use gruzzle
             $client = new Client();
             //$res = $client->request('GET', 'https://www.googleapis.com/plus/v1/people/me?key=AIzaSyDCDZ4035anJ_0uoqAuF88QmcuqAWQBzaY'/* . $accessToken->getToken()*/);
             $res = $client->get('https://www.googleapis.com/plus/v1/people/me?key=AIzaSyDCDZ4035anJ_0uoqAuF88QmcuqAWQBzaY&access_token=' . $accessToken->getToken());
             
             $user = json_decode($res->getBody());
             

             //recogemos los datos que queremos del archivo json devuelto por el servicio de google+
             $nombrecompleto = $user->displayName;
             $name = $user->name->givenName;
             $apellidos = $user->name->familyName;
             $email = $user->emails[0]->value;
             $foto = $user->cover->coverPhoto->url;
             
             //introducimos en la sesion dichos datos para rellenar el formulario de edicion
             Session::put('name', $name);
             Session::put('apellidos', $apellidos);
             Session::put('email+', $email);
             Session::put('foto', $foto);
             
             //recogemos el usuario logeado
             $user = Auth::user();
             
             //retornamos a la vista deit
             return view('auth.edit', compact('user'));
           
                

            } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

                // No se pudo obtener el token de acceso de usuario o datos. 
                exit($e->getMessage());

            }

        }

    }
}
