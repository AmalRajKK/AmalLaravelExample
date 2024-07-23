<x-layout>
    <x-slot:title>Jobs</x-slot:title>
    <x-slot:heading>Jobs</x-slot:heading>
    <div class="space-y-4">
        <div>
            <x-button href="/jobs/create">Create Job</x-button>
        </div>
        @foreach ($jobs as $job)
        <a href="/jobs/{{ $job['id'] }}" class="block px-4 py-6 border border-gray-200 rounded-lg">
            <div class="font-bold text-blue-500 text-sm">{{ $job->employer->name}}</div>
            <div>
                <strong>{{$job['title']}} : </strong> {{$job['salary']}} a year
            </div>
        </a>
        @endforeach
        <div>
            {{ $jobs->links() }}
        </div>
    </div>
</x-layout>
