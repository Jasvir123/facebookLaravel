<a href="{{ route('profile.view', $user->id) }}" rel="noopener noreferrer">
    <span class="{{ $class ?? "" }}">{{ $user->fullName }}</span>
</a>
