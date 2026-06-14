@if(session('success'))
    <div role="alert" id="alert-success" class="alert alert-success mb-4 shadow-sm transition-opacity duration-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div role="alert" class="alert alert-error mb-4 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('error') }}</span>
    </div>
@endif

@if($errors->any())
    <div role="alert" class="alert alert-error mb-4 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M4.93 19h14.14c1.05 0 1.7-1.14 1.18-2.05L13.18 4.95a1.34 1.34 0 00-2.36 0L3.75 16.95C3.23 17.86 3.88 19 4.93 19z" />
        </svg>
        <div>
            <ul class="text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if(session('success'))
    <script>
        setTimeout(() => {
            const alertEl = document.getElementById('alert-success');
            if (alertEl) {
                alertEl.style.opacity = '0';
                setTimeout(() => alertEl.remove(), 700);
            }
        }, 2000);
    </script>
@endif