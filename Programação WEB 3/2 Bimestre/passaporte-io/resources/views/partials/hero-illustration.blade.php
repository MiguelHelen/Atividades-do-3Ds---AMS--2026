<svg viewBox="0 0 400 320" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
    <defs>
        <radialGradient id="glow" cx="50%" cy="50%" r="50%">
            <stop offset="0%" stop-color="#ffffff" stop-opacity="0.5"/>
            <stop offset="100%" stop-color="#ffffff" stop-opacity="0"/>
        </radialGradient>
        <linearGradient id="ticketGrad" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#ffffff" stop-opacity="0.95"/>
            <stop offset="100%" stop-color="#ffffff" stop-opacity="0.8"/>
        </linearGradient>
    </defs>

    <!-- Glow background -->
    <circle cx="200" cy="160" r="170" fill="url(#glow)"/>

    <!-- Ticket back (rotated) -->
    <g transform="translate(200,160) rotate(-8)">
        <rect x="-130" y="-75" width="260" height="150" rx="16" fill="#ffffff" opacity="0.18"/>
    </g>

    <!-- Ticket front -->
    <g transform="translate(200,165) rotate(6)">
        <rect x="-130" y="-75" width="260" height="150" rx="16" fill="url(#ticketGrad)"/>
        <!-- Perforation circle left -->
        <circle cx="-130" cy="0" r="14" fill="#6d6df6"/>
        <!-- Perforation circle right -->
        <circle cx="130" cy="0" r="14" fill="#6d6df6"/>
        <!-- Dashed divider -->
        <line x1="60" y1="-75" x2="60" y2="75" stroke="#c7c7f9" stroke-width="2" stroke-dasharray="6,6"/>

        <!-- Left content lines -->
        <rect x="-105" y="-45" width="120" height="14" rx="4" fill="#a5a6f0"/>
        <rect x="-105" y="-20" width="90" height="8" rx="3" fill="#d8d8fb"/>
        <rect x="-105" y="-5" width="100" height="8" rx="3" fill="#d8d8fb"/>
        <rect x="-105" y="10" width="70" height="8" rx="3" fill="#d8d8fb"/>

        <!-- Barcode -->
        <rect x="-105" y="35" width="3" height="28" fill="#6d6df6"/>
        <rect x="-98" y="35" width="6" height="28" fill="#6d6df6"/>
        <rect x="-88" y="35" width="3" height="28" fill="#6d6df6"/>
        <rect x="-80" y="35" width="6" height="28" fill="#6d6df6"/>
        <rect x="-70" y="35" width="3" height="28" fill="#6d6df6"/>
        <rect x="-62" y="35" width="8" height="28" fill="#6d6df6"/>
        <rect x="-50" y="35" width="3" height="28" fill="#6d6df6"/>
        <rect x="-42" y="35" width="6" height="28" fill="#6d6df6"/>
        <rect x="-32" y="35" width="3" height="28" fill="#6d6df6"/>
        <rect x="-24" y="35" width="6" height="28" fill="#6d6df6"/>
        <rect x="-14" y="35" width="3" height="28" fill="#6d6df6"/>

        <!-- Right content: star icon -->
        <circle cx="95" cy="-20" r="28" fill="#fbbf24" opacity="0.3"/>
        <path d="M95 -42 L102 -27 L119 -25 L107 -13 L110 4 L95 -4 L80 4 L83 -13 L71 -25 L88 -27 Z" fill="#fbbf24"/>

        <rect x="40" y="20" width="110" height="10" rx="4" fill="#a5a6f0"/>
        <rect x="40" y="38" width="80" height="8" rx="3" fill="#d8d8fb"/>
    </g>

    <!-- Floating dots -->
    <circle cx="60" cy="60" r="6" fill="#ffffff" opacity="0.6"/>
    <circle cx="340" cy="80" r="9" fill="#ffffff" opacity="0.5"/>
    <circle cx="350" cy="250" r="5" fill="#ffffff" opacity="0.6"/>
    <circle cx="40" cy="260" r="7" fill="#ffffff" opacity="0.4"/>
</svg>