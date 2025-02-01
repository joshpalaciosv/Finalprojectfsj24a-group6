<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

/**
 * @OA\Info(title="API Documentation", version="1.0")
 */
/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="User",
 *     required={"name", "email", "password"},
 *     @OA\Property(property="id", type="integer", readOnly=true),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="email", type="string", format="email"),
 *     @OA\Property(property="password", type="string", format="password", writeOnly=true),
 *     @OA\Property(property="created_at", type="string", format="date-time", readOnly=true),
 *     @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true)
 * )
 */

class UserController extends Controller
{
    
     /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Get all users",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     )
     * )
     */
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        return response()->json($users);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Create a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
     /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Get user by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function show(User $user)
    {
        //
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    //public function update(Request $request, string $id)
    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Update user",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function update(Request $request, User $user)
    {
        //
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:8',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        $user->update($validatedData);

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    //public function destroy(string $id)
     /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Delete user",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="User deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
   /**
     * @OA\Get(
     *     path="/api/user-registrations/day/{date}",
     *     summary="Get user registrations for a specific day",
     *     @OA\Parameter(
     *         name="date",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string", format="date", example="05-10-2023")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="date", type="string", format="date"),
     *                 @OA\Property(property="count", type="integer")
     *             )
     *         )
     *     )
     * )
     */

    public function registrationsPerDay(Request $request, $date)
    {
        // Convert the date from dd-mm-yyyy to yyyy-mm-dd format
        $formattedDate = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');

        $registrations = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
        ->whereDate('created_at', $formattedDate)
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->get();

        return response()->json($registrations);
    }
    /**
     * @OA\Get(
     *     path="/api/user-registrations/week/{date}",
     *     summary="Get user registrations for a specific week",
     *     @OA\Parameter(
     *         name="date",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string", format="date", example="05-10-2023")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="week", type="string"),
     *                 @OA\Property(property="count", type="integer")
     *             )
     *         )
     *     )
     * )
     */
    public function registrationsPerWeek(Request $request, $date)
    {
        // Convert the date from dd-mm-yyyy to yyyy-mm-dd format
        $formattedDate = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');

        $registrations = User::select(DB::raw('YEARWEEK(created_at, 1) as week'), DB::raw('count(*) as count'))
            ->whereBetween('created_at', [Carbon::parse($formattedDate)->startOfWeek(), Carbon::parse($formattedDate)->endOfWeek()])
            ->groupBy('week')
            ->orderBy('week', 'desc')
            ->get();

        return response()->json($registrations);
    }

}
