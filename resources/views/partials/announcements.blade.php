<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
    <i class="fas fa-bullhorn"></i>
    @if(Auth::user()->new_announcements()->count() > 0)
    <span class="badge badge-warning navbar-badge">{{ Auth::user()->new_announcements()->count() }}</span>
    @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">
            {{ Auth::user()->new_announcements()->count() }} 
            Announcements
        </span>
        <div class="dropdown-divider"></div>
        @forelse (Auth::user()->new_announcements() as $new_announcement)
            <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showAnnouncement" data-href="{{ route('announcements.show', $new_announcement->id) }}" class="dropdown-item">
                {{-- <i class="fas fa-envelope mr-2"></i> --}} {{ $new_announcement->title }}
                <span class="float-right text-muted text-sm">{{ $new_announcement->getAnnouncementDuration() }}</span>
            </a>
            <div class="dropdown-divider"></div>
        @empty
            <a href="#" class="dropdown-item">
                No Announcement
            </a>
            <div class="dropdown-divider"></div>
        @endforelse
        @can('announcements.index')
        {{-- <div class="dropdown-divider"></div> --}}
        <a href="{{ route('announcements.index') }}" class="dropdown-item dropdown-footer">See All Announcements</a>
        @endcan
    </div>
</li>