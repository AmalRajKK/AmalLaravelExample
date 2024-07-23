<?php

namespace App\Http\Controllers;

use App\Mail\JobPosted;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{

    public function index()
    {
        $jobs = Job::with('employer')->latest()->Paginate(10);
        return view('jobs.index', ['jobs' => $jobs]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required', 'min:3', 'digits_between:0,9'],
        ]);

        $job = Job::create([
            'title' => request('title'),
            'salary' => request('salary'),
            'employer_id' => 1,
        ]);

        Mail::to($job->employer->user)->send(new JobPosted($job));


        return redirect('/jobs');
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function show(Job $job)
    {
        return view('jobs.show', ['job' => $job]);
    }
    public function edit(Job $job)
    {
        return view('jobs.edit', ['job' => $job]);
    }
    public function update(Job $job, Request $request)
    {

        $request->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required', 'min:3', 'digits_between:0,9'],
        ]);
        $job->update([
            'title' => request('title'),
            'salary' => request('salary'),
        ]);

        return redirect('/jobs/' . $job->id);
    }
    public function delete(Job $job)
    {
        $job->delete();
        return redirect('/jobs');
    }
}
