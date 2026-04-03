<x-layout>
    <div class="container py-5" style="margin-top: 80px;">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">

                <div class="card border-0 shadow-sm p-4">
                    <h4 class="mb-4" style="border-bottom: 2px solid #feed02; padding-bottom: 0.8rem;">
                        Verifica email
                    </h4>

                    <p class="small text-muted mb-4">
                        Grazie per esserti registrata! Prima di continuare, verifica il tuo indirizzo email cliccando sul link che ti abbiamo inviato. Se non hai ricevuto l'email, possiamo inviartene un'altra.
                    </p>

                    @if(session('status') == 'verification-link-sent')
                        <div class="alert alert-success mb-4">
                            Un nuovo link di verifica è stato inviato all'indirizzo email fornito.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn w-100 mb-3">
                            Reinvia email di verifica
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary w-100">
                            Logout
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </div>
</x-layout>