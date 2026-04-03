<x-layout>
    <div class="container py-5" style="margin-top: 80px;">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">

                <div class="card border-0 shadow-sm p-4">
                    <h4 class="mb-4" style="border-bottom: 2px solid #feed02; padding-bottom: 0.8rem;">
                        Reimposta password
                    </h4>

                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="mb-3">
                            <label for="email" class="form-label small text-muted">Email</label>
                            <input id="email" type="email" name="email"
                                    class="form-control"
                                    value="{{ old('email', $request->email) }}"
                                    required autofocus autocomplete="username">
                        </div> 

                        <div class="mb-3">
                            <label for="password" class="form-label small text-muted">Nuova password</label>
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

                        <button type="submit" class="btn w-100">
                            Reimposta password
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-layout>