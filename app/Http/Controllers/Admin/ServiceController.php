<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Http\Resources\Admin\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        if (!empty($search)) {
            $services = Service::search($search)->paginate(10)->withQueryString();
        } else {
            $services = Service::orderBy('id', 'DESC')->paginate(10);
        }

        return Inertia::render('Admin/Services/Index', [
            'services' => ServiceResource::collection($services),
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
    public function store(ServiceRequest $request)
    {
        Service::create($request->validated());

        return redirect()->route('admin.services.index')->with('flash', [
            'success' => 'New service has been added'
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
    public function update(ServiceRequest $request, Service $service)
    {
        $service->update($request->validated());

        return redirect()->back()->with('flash', [
            'success' => 'Service has been updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);
        $service->delete($id);

        return redirect()->back()->with('flash', [
            'success' => 'Service has been deleted'
        ]);
    }
}
