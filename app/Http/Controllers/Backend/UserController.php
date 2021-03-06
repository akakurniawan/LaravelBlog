<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\System\OptionRepository;
use App\Repositories\System\PostRepository;
use App\Repositories\System\UserRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    protected $userRepository;
    protected $optionRepository;

    /**
     * Create a new controller instance.
     * @param UserRepository $userRepository
     * @param OptionRepository $optionRepository
     */
    public function __construct(UserRepository $userRepository, OptionRepository $optionRepository)
    {
        $this->userRepository = $userRepository;
        $this->optionRepository = $optionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userRepository->eagerLoadAllPaginated('role');

        return view('admin.users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'name' => Input::get('name'),
            'email' => Input::get('email'),
            'password' => bcrypt(Input::get('password')),
            'status' => Input::get('status'),
            'role_id' => Input::get('role'),
        ];
        //TODO: create validator

        $this->userRepository->create($data);

        return Redirect::to(route('admin.users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userRepository->find($id);

        return view('admin.users.show')
            ->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->eagerLoadOne('role', $id);

        return view('admin.users.edit')
            ->with('user', $user);
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
        $data = array(
            'name' => Input::get('name'),
            'email' => Input::get('email'),
            'password' => bcrypt(Input::get('password')),
            'status' => Input::get('status'),
            'role_id' => Input::get('role'),
        );

        //TODO: create validator
        $this->userRepository->update($data, $id);

        return Redirect::to(route('admin.users.edit', ['id' => $id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PostRepository $postRepository
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostRepository $postRepository, $id)
    {
        $user = $this->userRepository->find($id);

        if ($this->userRepository->countUserPosts($id)) {
            $postRepository->forceDeleteAuthorPosts($user);
        }

        $this->userRepository->destroy($id);

        return Redirect::to(route('admin.users.index'));
    }
}
