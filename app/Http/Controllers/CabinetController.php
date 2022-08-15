<?php

namespace App\Http\Controllers;

use App\Models\Cabinet;
use App\Repositories\Interfaces\CabinetRepo;
use Illuminate\Http\Request;

class CabinetController extends Controller
{
    public $cabinet;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CabinetRepo $cabinet)
    {
        $this->cabinet = $cabinet;
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

        $cabinet =   $this->cabinet->createOrUpdate(null,$request->only(['background','name']) );
        $data = [
            'message' => 'Cabinet created!',
            'data' => $cabinet
        ];
        return response()->json($data,201);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function schedulecheck(Request $request)
    {
        try {
            $validate = $request->validateWithBag('post',[
                'from' => 'required',
                'to' => 'required|after:from',

            ]);
            $response = $this->cabinet->setSchedule($request->all());
            return response()->json($response);
        }catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json($exception->errors(),422 );

        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cabinet  $cabinet
     * @return \Illuminate\Http\Response
     */
    public function show(Cabinet $cabinet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cabinet  $cabinet
     * @return \Illuminate\Http\Response
     */
    public function edit(Cabinet $cabinet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cabinet  $cabinet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cabinet $cabinet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cabinet  $cabinet
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Cabinet $cabinet)
    {
        $this->cabinet->deleteCabinet($cabinet->id);
        return response()->json('Cabinet deleted!');
    }
}
