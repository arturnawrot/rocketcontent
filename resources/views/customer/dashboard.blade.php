Hi, {{ auth()->user()->name }}

</br>

<a href="{{ route('auth.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    Logout
</a>

<form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
    @csrf
</form>

</br>

<a href="{{ route('customer.content.request.view') }}">Request New Content</a>