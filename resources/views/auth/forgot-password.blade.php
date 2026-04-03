<x-layout>
    <div class="container py-5" style="margin-top: 80px;">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">

                <div class="card border-0 shadow-sm p-4">
                    <h4 class="mb-3" style="border-bottom: 2px solid #feed02; padding-bottom: 0.8rem;">
                        Password dimenticata
                    </h4>

                    <p class="small text-muted mb-4">
                        Inserisci la tua email e ti invieremo un link per reimpostare la password.
                    </p>

                    @if(session('status'))
                        <div class="alert alert-success mb-4">{{ session('status') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label small text-muted">Email</label>
                            <input id="email" type="email" name="email"
                                    class="form-control" value="{{ old('email') }}"
                                    required autofocus>
                        </div>

                        <button type="submit" class="btn w-100 mb-3">
                            Invia link di reset
                        </button>

                        <div class="text-center">
                            <a href="{{ route('login') }}" class="small text-muted">
                                Torna al login
                            </a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-layout>