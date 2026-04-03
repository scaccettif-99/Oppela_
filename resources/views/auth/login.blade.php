<x-layout>
    <div class="container py-5" style="margin-top: 80px;">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">

                <div class="card border-0 shadow-sm p-4">
                    <h4 class="mb-4" style="border-bottom: 2px solid #feed02; padding-bottom: 0.8rem;">
                        Accedi
                    </h4>

                    {{-- Session Status --}}
                    @if(session('status'))
                        <div class="alert alert-success mb-4">{{ session('status') }}</div>
                    @endif

                    {{-- Errori --}}
                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label small text-muted">Email</label>
                            <input id="email" type="email" name="email"
                                    class="form-control" value="{{ old('email') }}"
                                    required autofocus autocomplete="username">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label small text-muted">Password</label>
                            <input id="password" type="password" name="password"
                                    class="form-control"
                                    required autocomplete="current-password">
                        </div>

                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input id="remember_me" type="checkbox" name="remember"
                                        class="form-check-input">
                                <label for="remember_me" class="form-check-label small text-muted">
                                    Ricordami
                                </label>
                            </div>
                            @if(Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="small text-muted">
                                    Password dimenticata?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="btn w-100">Accedi</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-layout>