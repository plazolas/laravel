<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\Agency\AgencyCreateRequest;
use App\Http\Requests\Agency\AgencyUpdateRequest;
use App\Http\Requests\Agency\AgencyToggleActiveRequest;
use App\Http\Requests\Agency\AgencyDestroyRequest;
use App\Repositories\AgencyRepository;
use App\Validators\AgencyValidator;

use App\Entities\Agency;

use Auth;
use Storage;
use File;
use Image;
use Input;


class AgenciesController extends Controller
{

    /**
     * @var AgencyRepository
     */
    protected $repository;

    /**
     * @var AgencyValidator
     */
    protected $validator;

    /**
     * Constructor.
     *
     * @param AgencyRepository $repository
     * @param AgencyValidator $validator
     */
    public function __construct(AgencyRepository $repository, AgencyValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        if (request()->wantsJson()) {
            $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
            $agencies = $this->repository->all();

            return response()->json([
                'data' => $agencies,
            ]);
        }

        return view('agencies.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AgencyCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AgencyCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $agency = $this->repository->create($request->all());

            $response = [
                'message' => 'Agency created.',
                'data' => $agency->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $agency = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $agency,
            ]);
        }

        return view('agencies.show', compact('agency'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Agency $agency
     * @return \Illuminate\Http\Response
     */
    public function edit(Agency $agency = null)
    {
        if (!$agency->id) {
            $agency = Auth::user()->agency;
        }

        $readonly = false;
        if(! Auth::user()->can('modify-agency')){
            $readonly = true;
        }

        return view('agencies.edit', compact('agency', 'readonly'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  AgencyUpdateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(AgencyUpdateRequest $request)
    {

        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $agency = $this->repository->findBySlug($request->input('agency_slug'));

            $agency = $this->repository->update($request->all(), $agency->id);

            $response = [
                'message' => 'Agency updated.',
                'data' => $agency->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Delete the specified Agency.
     *
     * @param Agency $agency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agency $agency)
    {
        $deleted = $this->repository->delete($agency->id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Agency deleted.',
                'deleted' => $deleted,
            ]);
        }

        flash('Agency deleted.', 'info');
        return redirect()->back();
    }

    /**
     * Toggle an agency as active or inactive.
     *
     * @param Agency $agency
     * @return \Illuminate\Http\Response
     */
    public function active(Agency $agency)
    {
        $agency = $this->repository->active($agency->id);

        if ($agency->active) {
            $message = 'Agency activated.';
        } else {
            $message = 'Agency deactivated.';
        }

        if (request()->wantsJson()) {

            return response()->json([
                'message' => $message,
                'data' => $agency,
            ]);
        }

        flash($message, 'info');
        return redirect()->back();
    }

    /**
     * Change the agency of the authed user.
     *
     * @param Agency $agency
     * @return \Illuminate\Http\Response
     */
    public function ghost(Agency $agency)
    {
        if (!$agency->id) {
            return redirect()->back()->with('message', 'Agency does not exist.');
        }

        $user = Auth::user();
        $user->agency_id = $agency->id;
        $user->save();

        flash('You are now a part of ' . $agency->name . ' (#' . $agency->id . ').', 'info');
        return redirect()->back();
    }
}
