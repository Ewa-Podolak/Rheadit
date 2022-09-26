<?php

use App\Http\Controllers\userController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//User Routes
Route::get('/users/login/{username}/{pasword}', [userController::class, 'CheckLogin']); //Checks Login Credentials

Route::post('/users/register/{username}/{pasword}/{email}', [userController::class, 'RegisterUser']); //Creates new user if user with same username doesn't exist yet

Route::get('/users/sendemail/{email}', [userController::class, 'SendEmail']); //Sends email for resetting password

Route::patch('/users/resetpassword/{username}/{password}', [userController::class, 'ResetPassword']); //Updates password

Route::delete('/users/delete/{userid}', [userController::class, 'DeleteUser']);