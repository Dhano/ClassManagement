<li class="nav-item">
    <a class="nav-link {{Request::is('enquiry*') ? 'active' : ''}}" href="#navbar-enquiry" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-enquiry">
        <i class="ni ni-ruler-pencil text-primary"></i>
        <span class="nav-link-text">enquiry</span>
    </a>
    <div class="collapse {{Request::is('/enquiry*') ? 'show' : ''}}" id="navbar-enquiry">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="/enquiry/create" class="nav-link">Add Enquiry</a>
            </li>
            <li class="nav-item">
                <a href="/enquiry" class="nav-link">Manage Enquiry</a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link {{Request::is('admin/events*') ? 'active' : ''}}" href="#navbar-events" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-dashboards">
        <i class="ni ni-calendar-grid-58 text-primary"></i>
        <span class="nav-link-text">Events</span>
    </a>

    <div class="collapse {{Request::is('admin/events*') ? 'show' : ''}}" id="navbar-events">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="/admin/events/create" class="nav-link">Add Events</a>
            </li>
            <li class="nav-item">
                <a href="/admin/events" class="nav-link">Manage Events</a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link {{Request::is('classes*') ? 'active' : ''}}" href="#navbar-class" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-class">
        <i class="fa fa-layer-group text-primary"></i>
        <span class="nav-link-text">Class</span>
    </a>
    <div class="collapse {{Request::is('classes*') ? 'show' : ''}}" id="navbar-class">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="/classes/create" class="nav-link">Add Class</a>
            </li>
            <li class="nav-item">
                <a href="/classes" class="nav-link">Manage Class</a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('/news-feed*') ? 'active' : '' }}" href="#navbar-news-feed" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-dashboards">
        <i class="ni ni-single-copy-04 text-primary"></i>
        <span class="nav-link-text">News</span>
    </a>
    <div class="collapse {{ Request::is('/news-feed*') ? 'show' : '' }}" id="navbar-news-feed">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="/news-feed/create" class="nav-link">Publish News</a>
            </li>
            <li class="nav-item">
                <a href="/news-feed" class="nav-link">Manage News Feed</a>
            </li>
        </ul>
    </div>
</li>
