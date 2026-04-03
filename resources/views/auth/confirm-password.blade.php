<x-layout>
    <div class="container py-5" style="margin-top: 80px;">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">

                <div class="card border-0 shadow-sm p-4">
                    <h4 class="mb-4" style="border-bottom: 2px solid #feed02; padding-bottom: 0.8rem;">
                        Conferma password
                    </h4>

                    <p class="small text-muted mb-4">
                        Questa è un'area sicura. Conferma la tua password prima di continuare.
                    </p>

                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="password" class="form-label small text-muted">Password</label>
                            <input id="password" type="password" name="password"
                                    class="form-control"
                                    required autocomplete="current-password">
                        </div>

                        <button type="submit" class="btn w-100">
                            Conferma
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-layout>