<x-layout>
    <div class="container py-5" style="margin-top: 80px;">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">

                <div class="card border-0 shadow-sm p-4">
                    <h4 class="mb-4" style="border-bottom: 2px solid #feed02; padding-bottom: 0.8rem;">
                        Registrazione
                    </h4>

                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label small text-muted">Nome</label>
                            <input id="name" type="text" name="name"
                                    class="form-control" value="{{ old('name') }}"
                                    required autofocus autocomplete="name">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label small text-muted">Email</label>
                            <input id="email" type="email" name="email"
                                    class="form-control" value="{{ old('email') }}"
                                    required autocomplete="username">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label small text-muted">Password</label>
                            <input id="password" type="password" name="password"
                                    class="form-control"
                                    required autocomplete="new-password">
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label small text-muted">Conferma password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                    class="form-control"
                                    required autocomplete="new-password">
                        </div>

                        <button type="submit" class="btn w-100 mb-3">Registrati</button>

                        <div class="text-center">
                            <a href="{{ route('login') }}" class="small text-muted">
                                Hai già un account? Accedi
                            </a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-layout>