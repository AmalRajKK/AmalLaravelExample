<x-layout>
    <x-slot:title>Job</x-slot:title>
    <x-slot:heading>Job</x-slot:heading>
    <h2 class="font-bold text-lg">{{$job->title}}</h2>
    <p> This Job Pays {{$job->salary}} per year</p>
    @can('edit', $job)
    <p class="mt-6">
        <x-button href="/jobs/{{$job->id}}/edit">Edit Job</x-button>
     </p>
    @endcan

</x-layout>
