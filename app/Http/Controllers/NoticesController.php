<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Provider;

use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use PhpSpec\Formatter\Html\Template;

class NoticesController extends Controller {

    /**
     * Create a new notices controller instance
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show all notices
     * @return string
     */
	public function index()
    {
        return 'all notices';
    }

    /**
     * Show a page to create a new notice
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // get list of providers
        // load a view to create a new notice

        $providers = Provider::lists('name', 'id');

        return view('notices.create', compact('providers'));
    }

    /**
     * Compile the DMCA template from the form
     * @param $data
     * @param Guard $auth
     * @return mixed
     */
    public function compileDmcaTemplate($data, Guard $auth){
        $data = $data + [
                'name' => $auth->user()->name,
                'email' => $auth->user()->email,
        ];

        return view()->file(app_path('Http/Templates/dmca.blade.php'), $data);
    }

    /**
     * Ask the user to confirm the DMCA that will be delivered
     * @param Requests\PrepareNoticeRequest $request
     * @param Guard $auth
     * @return \Response
     */
    public function confirm(Requests\PrepareNoticeRequest $request, Guard $auth)
    {
        $template = $this->compileDmcaTemplate($data = $request->all(), $auth);

        session()->flash('dmca', $data);

        return view('notices.confirm', compact('template'));
    }

    public function store(){
         $data = session()->get('dmca');

         return $data;
    }
}
