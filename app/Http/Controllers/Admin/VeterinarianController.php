<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VeterinarianRequest;
use App\Http\Resources\Admin\VeterinarianResource;
use App\Models\Veterinarian;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VeterinarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        if (!empty($search)) {
            $veterinarians = Veterinarian::search($search)->paginate(10)->withQueryString();
        } else {
            $veterinarians = Veterinarian::orderBy('id', 'DESC')->paginate(10);
        }

        return Inertia::render('Admin/Veterinarians/Index', [
            'veterinarians' => VeterinarianResource::collection($veterinarians),
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
    public function store(VeterinarianRequest $request)
    {
        Veterinarian::create($request->validated());

        return redirect()->route('admin.veterinarians.index')->with('flash', [
            'success' => 'New veterinarian has been added'
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
    public function update(VeterinarianRequest $request, Veterinarian $veterinarian)
    {
        $veterinarian->update($request->validated());

        return redirect()->back()->with('flash', [
            'success' => 'Veterinarian has been updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $veterinarian = Veterinarian::findOrFail($id);
        $veterinarian->delete($id);

        return redirect()->back()->with('flash', [
            'success' => 'Veterinarian has been deleted'
        ]);
    }
}
