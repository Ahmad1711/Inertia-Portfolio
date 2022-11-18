<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects=ProjectResource::collection(Project::with('skill')->get());
        return inertia('Projects/Index',['projects'=>$projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $skills=Skill::all();
        return inertia('Projects/Create',['skills'=>$skills]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $image=$request->file('image')->store('projects','public');
        Project::create([
            'name'=>$request->name,
            'skill_id'=>$request->skill_id,
            'url'=>$request->url,
            'image'=>$image,
        ]);
        return redirect()->route('projects.index')->with(['message'=>'project create successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);
        $skills = Skill::all();
        return inertia('Projects/Edit', ['project' => $project, 'skills' => $skills]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, $id)
    {
        $project = Project::find($id);

        Storage::delete('public/' . $project->image);
        $newimage = $request->file('image')->store('projects', 'public');
        $project->update([
            'name' => $request->name,
            'skill_id' => $request->skill_id,
            'url' => $request->url,
            'image' => $newimage,
        ]);

        return redirect()->route('projects.index')->with(['message'=>'project update successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        Storage::delete('public/' . $project->image);
        $project->delete();
        return redirect()->back()->with(['message'=>'project delete successfully']);
    }
}
