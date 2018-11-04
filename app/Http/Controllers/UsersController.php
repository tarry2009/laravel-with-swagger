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
 *     basePath="/api/",
 *     schemes={"https", "http"},
 *     host="one.nhtsa.gov",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="L5 Swagger API",
 *         description="L5 Swagger API description",
 *         @SWG\Contact(
 *             email="darius@matulionis.lt"
 *         ),
 *     )
 * )
 */
/**
 * @SWG\SecurityScheme(
 *   securityDefinition="passport",
 *   type="oauth2",
 *   tokenUrl="/oauth/token",
 *   flow="password",
 *   scopes={}
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
 * @SWG\Get(
 *      path="/webapi/SafetyRatings/modelyear/",
 *      operationId="getvehicles",
 *      tags={"Vehicles"},
 *      summary="Get list of vehicles",
 *      description="Returns list of vehicles",
 *      @SWG\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @SWG\Response(response=400, description="Bad request"),
 *       security={
 *           {"api_key_security_example": {}}
 *       }
 *     )
 *
 * Returns list of vehicles
 */
 	public function vehicles(Request $request){
		   
        
		$newarray = $nhtsa = array();
		
		if (empty($request->model))
			return $this->respond(array('Error'=>'Model name required'),400); 
			
		if (empty($request->manufacturer))
			return $this->respond(array('Error'=>'Manufacturer name required'),400); 
		 
		if (!empty($request->modelYear) && is_numeric($request->modelYear)){
 
			$url = 'https://one.nhtsa.gov/webapi/api/SafetyRatings/modelyear/'.$request->modelYear.'/make/'.$request->manufacturer.'/model/'.$request->model.'?format=json';
			$nhtsa = $this->getData($url);
			
			
			$newarray['Count'] = $nhtsa['Count']; 
			$newarray['Results'] = [];
			
			if (!empty($nhtsa['Results'])){
				foreach ($nhtsa['Results'] as $i=>$vid){ 
					
					if($request->withRating=='true' ){ 
								
							$crash_rating_url = 'https://one.nhtsa.gov/webapi/api/SafetyRatings/VehicleId/'.$vid['VehicleId'].'?format=json';
							$crash_rating_data = $this->getData($crash_rating_url );
							 
							if (isset($crash_rating_data['Results'][0]['OverallRating'])){ 
								$newarray['Results'][$i]['CrashRating'] = $crash_rating_data['Results'][0]['OverallRating']; 
							} 
								 
					}
					$newarray['Results'][$i]['VehicleId'] = $vid['VehicleId'];
					$newarray['Results'][$i]['Description'] = $vid['VehicleDescription'];
					
				}
			}
				 
			 
			return $this->respond($newarray);
		} else {
			return $this->respond(array('Error'=>'Model Year required'),400);
			 
		}
	 
	}
    
    /**
 * @SWG\Get(
 *      path="/blx/public/api/v1/projects",
 *      operationId="getProjectsList",
 *      tags={"Projects"},
 *      summary="Get list of projects",
 *      description="Returns list of projects",
 *      @SWG\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @SWG\Response(response=400, description="Bad request"),
 *       security={
 *           {"api_key_security_example": {}}
 *       }
 *     )
 *
 * Returns list of projects
 */
/**
 * @SWG\Get(
 *      path="/blx/public/api/v1/projects/{id}",
 *      operationId="getProjectById",
 *      tags={"Projects"},
 *      summary="Get project information",
 *      description="Returns project data",
 *      @SWG\Parameter(
 *          name="id",
 *          description="Project id",
 *          required=true,
 *          type="integer",
 *          in="path"
 *      ),
 *      @SWG\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *      @SWG\Response(response=400, description="Bad request"),
 *      @SWG\Response(response=404, description="Resource Not Found"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *     },
 * )
 *
 */
 
 
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
