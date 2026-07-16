<div>
    @foreach ($this->users as $user)
        <div>
            <h3>{{ $user->name }}</h3>
        </div>
    @endforeach
</div>
