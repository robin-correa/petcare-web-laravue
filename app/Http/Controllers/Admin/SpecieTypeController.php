<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SpecieTypeRequest;
use App\Http\Resources\Admin\SpecieTypeResource;
use App\Models\SpecieType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SpecieTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        if (!empty($search)) {
            $specieTypes = SpecieType::search($search)->paginate(10)->withQueryString();
        } else {
            $specieTypes = SpecieType::orderBy('id', 'DESC')->paginate(10);
        }

        return Inertia::render('Admin/SpecieTypes/Index', [
            'specieTypes' => SpecieTypeResource::collection($specieTypes),
            'search' => $search ?? '',
        ]);
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
     */
    public function store(SpecieTypeRequest $request)
    {
        SpecieType::create($request->validated());

        return redirect()->route('admin.specieTypes.index')->with('flash', [
            'success' => 'New specie type has been added'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
     */
    public function update(SpecieTypeRequest $request, SpecieType $specieType)
    {
        $specieType->update($request->validated());

        return redirect()->back()->with('flash', [
            'success' => 'Specie type has been updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $specieType = SpecieType::findOrFail($id);
        $specieType->delete($id);

        return redirect()->back()->with('flash', [
            'success' => 'Specie type has been deleted'
        ]);
    }
}
