<?php
/**
 * @author Chrisostomos Bakouras.
 */

namespace App\Http\Controllers\Frontend;


use App\Helpers\BlogHelper;
use App\Http\Controllers\Controller;
use App\Repositories\System\CategoryRepository;
use App\Repositories\System\OptionRepository;
use App\Repositories\System\PostRepository;

class BlogController extends Controller
{
    protected $postRepository;
    protected $categoryRepository;
    protected $optionRepository;

    /**
     * Create a new controller instance.
     *
     * @param  PostRepository $postRepository
     * @param OptionRepository $optionRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(PostRepository $postRepository, OptionRepository $optionRepository, CategoryRepository $categoryRepository)
    {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
        $this->optionRepository = $optionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Display the specified resource.
     *
     * @param $postSlug
     * @return \Illuminate\Http\Response
     */
    public function showSlug($postSlug)
    {
        $post = $this->postRepository->findBySlug($postSlug);

        return view($post->view_template)
            ->with('post', $post);
    }

    public function showFrontPage()
    {
        $frontPageId = $post = $this->optionRepository->findOptionIntegerValueByName('front-page-id');
        $post = $this->postRepository->find($frontPageId);

        return view($post->view_template)
            ->with('post', $post);
    }
}
