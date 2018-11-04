<?php

namespace App\Http\Controllers;

use App\Company;
use App\User;
use App\Role;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * @SWG\Swagger(
 *   @SWG\Info(
 *     title="My first swagger documented API",
 *     version="1.0.0"
 *   )
 * )
 */
class UsersController extends Controller {

	protected function ValidationResponse( array $errors)
    {
        return response()->json([
            'error' => $errors,
        ], Response::HTTP_BAD_REQUEST);
    }
 /**
     * Check the login credentials and get the access token
     * @return \Illuminate\Http\Response
     */

     /**
     * @SWG\Post(
     *   path="/blx/public/api/v1/login",
     *   description= "Check the login credentials and get the access token",
     *   summary="Check the login credentials and get the access token",
     *   operationId="login",
     * @SWG\Parameter(
     *          name="email",
     *          description="User email",
     *          required=true,
     *          type="string",
     *          in="path"
     *   ),
     *  @SWG\Parameter(
     *          name="password",
     *          description="User password",
     *          required=true,
     *          type="string",
     *          in="path"
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=406, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     *
     */

    public function login(Request $request)
    {
		 
		    /**
         * Get a validator for an incoming login request.
         *
         * @param  array  $request
         * @return \Illuminate\Contracts\Validation\Validator
         */
        $valid = validator($request->only( 'email', 'password' ), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($valid->fails()) {
			return $this->ValidationResponse($valid->errors()->all());
        }
		
		$params = $request->only('email', 'password');

		$username = $params['email'];
		$password = $params['password'];

		if(\Auth::attempt(['email' => $username, 'password' => $password])){
			return \Auth::user()->createToken('my_user', []);
		}

		return response()->json(['error' => 'Invalid username or Password']);

		return response()->json([ 'data' => $request->all()], 200); 
		 
	}
	
	/**
     * Check the login credentials and get the access token
     * @return \Illuminate\Http\Response
     */

     /**
     * @SWG\Get(
     *   path="/blx/public/api/v1/users",
     *   description= "Get all users",
     *   summary="Get all users",
     *   operationId="users",
     * @SWG\Parameter(
     *          name="auth",
     *          description="an authorization header",
     *          required=true,
     *          type="string",
     *          in="header"
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=406, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     *
     */
    public function index(Request $request)
    {
		return User::all();
        
    }
      
    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return $company;
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());
        return $user;
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return '';
    }
}
