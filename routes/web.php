<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get("users", function() {
	$results = app('db')->select("SELECT * FROM users");
	return $results;
});

$router->put("user/{id}", function($id, \Illuminate\Http\Request $req) {
	$user=$req->input('user');
	$update = app('db')->table('users')->where('id', $id)->update(['name' => $user['name']]);
	return $update;
});

$router->delete("user/{id}", function($id) {
	$delete= app('db')->table('users')->where('id', intval($id))->delete();
	return $delete;
});


$router->get("tasks/{id}", function($id) {
	$results = app('db')->table('user_tasks')->where('user_id', $id)->get();
	return $results;
});

// Create
$router->post("task", function(\Illuminate\Http\Request $req) {
	$task=$req->input("task");

	$insert = app('db')->table('user_tasks')->insertGetId(['description' => $task['description'], 'state' => $task['state']??0, 'user_id'=>$task['user']]);
	return $insert;
});
// Update
$router->put("task/{id}", function($id, \Illuminate\Http\Request $req) {
	$task=$req->input("task");
	$update = app('db')->table('user_tasks')->where('id', $id)->update(['description' => $task['description'], 'state' => $task['state'], 'user_id'=>$task['user']]);
	return $update;
});