<a href="{{ route('profile.view', $user->id) }}" target="_blank" rel="noopener noreferrer">
    <span class="{{ $class ?? "" }}">{{ $user->fullName }}</span>
</a>
