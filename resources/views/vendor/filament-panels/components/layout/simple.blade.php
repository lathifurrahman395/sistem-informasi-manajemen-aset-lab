<x-filament-panels::layout.base :livewire="$livewire">
    <!-- Font: Fraunces untuk headline, Plus Jakarta Sans untuk teks -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,opsz,wght@0,9..144,600;0,9..144,700;1,9..144,600&display=swap" rel="stylesheet">

    <style>
        /* ==========================================================================
           TEMA: BLUEPRINT ASET — MODE TERANG (REVISI)
           Diagonal split (kartu login kiri) + blueprint grid & ikon aset
           tersebar di kanan bersama headline. Revisi: kartu lebih interaktif,
           node punya hover state, animasi masuk bertahap, kontras diperbaiki,
           mobile menampilkan identitas brand, indikator status aktif.
           ========================================================================== */

        html,
        body.fi-body {
            margin: 0 !important;
            padding: 0 !important;
            background-color: #ede1c4 !important;
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif !important;
            min-height: 100vh !important;
            overflow-x: hidden !important;
        }

        .fi-simple-header,
        x-filament-panels\:\:layout\.simple img {
            display: none !important;
        }

        /* ============================================================
           LATAR: gradient krem lembut + grid blueprint tipis + lingkaran
           dekoratif, memenuhi seluruh layar (bukan cuma kotak kosong)
           ============================================================ */
        .si-bg-wash {
            position: fixed;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(1100px 700px at 82% 15%, rgba(184, 146, 67, 0.24), transparent 60%),
                radial-gradient(700px 500px at 10% 90%, rgba(184, 146, 67, 0.16), transparent 60%),
                #ede1c4;
        }

        .si-blueprint-grid {
            position: fixed;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(184, 146, 67, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(184, 146, 67, 0.1) 1px, transparent 1px);
            background-size: 44px 44px;
            -webkit-mask-image: linear-gradient(90deg, transparent 0%, rgba(0, 0, 0, 0.9) 30%, rgba(0, 0, 0, 0.9) 100%);
            mask-image: linear-gradient(90deg, transparent 0%, rgba(0, 0, 0, 0.9) 30%, rgba(0, 0, 0, 0.9) 100%);
        }

        .si-blueprint-svg {
            position: fixed;
            inset: 0;
            z-index: 2;
            width: 100%;
            height: 100%;
            pointer-events: none;
            -webkit-mask-image: linear-gradient(180deg, transparent 0%, black 12%, black 88%, transparent 100%);
            mask-image: linear-gradient(180deg, transparent 0%, black 12%, black 88%, transparent 100%);
        }

        /* svg butuh pointer-events aktif di node agar hover berfungsi,
           sisanya (garis/label) tetap transparan terhadap klik */
        .si-blueprint-svg .bp-node-group {
            pointer-events: auto;
            cursor: default;
        }

        .si-blueprint-svg .bp-ring {
            fill: none;
            stroke: rgba(184, 146, 67, 0.18);
            stroke-width: 1;
        }

        .si-blueprint-svg .bp-line {
            fill: none;
            stroke: rgba(184, 146, 67, 0.5);
            stroke-width: 1.4;
            stroke-dasharray: 5 6;
            animation: bp-flow 2.2s linear infinite;
        }

        @keyframes bp-flow {
            to {
                stroke-dashoffset: -22;
            }
        }

        /* hover state per node: sedikit membesar + warna lebih tegas */
        .si-blueprint-svg .bp-node-group {
            transition: filter 0.2s ease;
        }

        .si-blueprint-svg .bp-node-group .bp-node {
            transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1), stroke 0.25s ease, fill 0.25s ease;
            transform-box: fill-box;
            transform-origin: center;
        }

        .si-blueprint-svg .bp-node-group .bp-icon {
            transition: stroke 0.25s ease;
        }

        .si-blueprint-svg .bp-node-group .bp-label {
            transition: fill 0.25s ease, opacity 0.25s ease;
        }

        .si-blueprint-svg .bp-node-group:hover .bp-node {
            transform: scale(1.12);
            stroke: #b8860b;
            fill: #fffdf7;
        }

        .si-blueprint-svg .bp-node-group:hover .bp-icon {
            stroke: #b8860b;
        }

        .si-blueprint-svg .bp-node-group:hover .bp-label {
            fill: #221c12;
        }

        @media (prefers-reduced-motion: reduce) {
            .si-blueprint-svg .bp-line {
                animation: none;
            }
        }

        .si-blueprint-svg .bp-node {
            fill: #faf3e2;
            stroke: rgba(157, 118, 43, 0.5);
            stroke-width: 1.4;
        }

        .si-blueprint-svg .bp-icon {
            fill: none;
            stroke: #9c7a3c;
            stroke-width: 1.6;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .si-blueprint-svg .bp-label {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.08em;
            /* dinaikkan dari #9c7a3c agar kontras lebih baik */
            fill: #7a5f2e;
            text-transform: uppercase;
        }

        /* ============================================================
           SPLIT DIAGONAL — panel kiri terpisah dari kanan oleh garis miring
           ============================================================ */
        .si-diagonal-panel {
            position: fixed;
            inset: 0;
            z-index: 3;
            width: min(46%, 620px);
            height: 100%;
            background: linear-gradient(172deg, #fdf8ec 0%, #fbf2dc 55%, #ecdcac 100%);
            clip-path: polygon(0 0, 100% 0, 78% 100%, 0 100%);
            border-right: 1px solid rgba(184, 146, 67, 0.3);
            box-shadow: 12px 0 40px rgba(157, 122, 55, 0.06);
        }

        /* ============================================================
           KONTEN
           ============================================================ */
        .si-split {
            position: relative;
            z-index: 10;
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* ---------- KIRI ---------- */
        .si-left {
            flex: 0 0 min(40%, 560px);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem 3rem 2.25rem;
        }

        .si-left-inner {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .si-brand {
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }

        .si-brand-logo {
            height: 40px !important;
            width: auto !important;
            object-fit: contain !important;
            filter: drop-shadow(0 2px 6px rgba(184, 146, 67, 0.25));
        }

        .si-brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.15;
        }

        .si-brand-line1 {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.18em;
            /* dinaikkan agar kontras lebih baik di atas krem terang */
            color: #7a5f2e;
        }

        .si-brand-line2 {
            font-size: 15px;
            font-weight: 800;
            letter-spacing: 0.04em;
            color: #221c12;
        }

        #si-login-panel {
            position: relative;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(157, 118, 43, 0.4);
            border-radius: 22px;
            padding: 2.65rem 2rem 2.1rem;
            box-shadow: 0 20px 50px rgba(157, 122, 55, 0.1);
            animation: si-fade-up 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
            transition: box-shadow 0.3s ease, transform 0.3s ease, border-color 0.3s ease;
            overflow: hidden;
        }

        /* aksen garis tipis di atas kartu, supaya tidak terasa polos */
        #si-login-panel::before {
            content: "";
            position: absolute;
            top: 0;
            left: 2rem;
            right: 2rem;
            height: 3px;
            border-radius: 0 0 4px 4px;
            background: linear-gradient(90deg, #e5c173, #b8860b 50%, #e5c173);
            opacity: 0.85;
        }

        /* kartu bereaksi halus terhadap hover & saat salah satu field fokus */
        #si-login-panel:hover {
            box-shadow: 0 24px 58px rgba(157, 122, 55, 0.16);
            transform: translateY(-2px);
        }

        #si-login-panel:has(input:focus) {
            border-color: rgba(184, 134, 11, 0.55);
            box-shadow: 0 24px 58px rgba(157, 122, 55, 0.18);
        }

        @keyframes si-fade-up {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .si-login-panel:has(.fi-fo-field-wrp.fi-fo-has-error) {
            animation: si-fade-up 0.6s cubic-bezier(0.16, 1, 0.3, 1) both,
                si-shake 0.4s ease-in-out 0.6s both;
        }

        #si-login-panel .fi-fo-field-wrp.fi-fo-has-error input {
            border-color: rgba(200, 60, 60, 0.55) !important;
        }

        @keyframes si-shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20% {
                transform: translateX(-6px);
            }

            40% {
                transform: translateX(5px);
            }

            60% {
                transform: translateX(-4px);
            }

            80% {
                transform: translateX(3px);
            }
        }

        .si-login-title {
            font-family: 'Fraunces', serif;
            font-optical-sizing: auto;
            font-weight: 700;
            font-size: 27px;
            color: #221c12;
            margin: 0.35rem 0 0.35rem 0;
        }

        .si-login-sub {
            font-size: 13px;
            /* dinaikkan dari 0.5 opacity agar lebih mudah dibaca */
            color: rgba(34, 28, 18, 0.62);
            margin: 0 0 1.5rem 0;
        }

        #si-login-panel form {
            --grid-gaps-y: 1.1rem !important;
        }

        #si-login-panel .grid {
            gap: 1.1rem !important;
        }

        #si-login-panel label,
        #si-login-panel .fi-fo-field-wrp label span {
            color: #8a6a30 !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            letter-spacing: 0.08em !important;
            text-transform: uppercase !important;
        }

        #si-login-panel .fi-input-wrp {
            background: rgba(255, 255, 255, 0.65) !important;
            border: 1px solid rgba(184, 146, 67, 0.35) !important;
            border-radius: 14px !important;
            transition: border-color 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease !important;
        }

        #si-login-panel .fi-input-wrp:focus-within {
            border-color: #b8860b !important;
            background-color: #fffdf7 !important;
            box-shadow: 0 0 0 3px rgba(184, 134, 11, 0.15) !important;
        }

        #si-login-panel .fi-input-wrp input {
            border: none !important;
            background: transparent !important;
        }

        #si-login-panel input[type="email"],
        #si-login-panel input[type="password"],
        #si-login-panel input[type="text"] {
            background: rgba(255, 255, 255, 0.65) !important;
            border: 1px solid rgba(184, 146, 67, 0.35) !important;
            border-radius: 14px !important;
            color: #221c12 !important;
            font-size: 14px !important;
            padding: 0.75rem 1rem 0.75rem 2.5rem !important;
            transition: border-color 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease !important;
        }

        #si-login-panel input[type="email"] {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%239c7a3c' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M4 4h16v16H4z'/%3E%3Cpath d='m22 6-10 7L2 6'/%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: left 0.85rem center !important;
            background-size: 16px 16px !important;
        }

        #si-login-panel input[type="password"] {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%239c7a3c' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='11' width='18' height='11' rx='2'/%3E%3Cpath d='M7 11V7a5 5 0 0 1 10 0v4'/%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: left 0.85rem center !important;
            background-size: 16px 16px !important;
            padding-right: 2.6rem !important;
        }

        #si-login-panel input:focus,
        #si-login-panel .fi-input-wrp:focus-within {
            border-color: #b8860b !important;
            background-color: #fffdf7 !important;
            box-shadow: 0 0 0 3px rgba(184, 134, 11, 0.15) !important;
        }

        #si-login-panel input:-webkit-autofill,
        #si-login-panel input:-webkit-autofill:hover,
        #si-login-panel input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px #fdfaf2 inset !important;
            -webkit-text-fill-color: #221c12 !important;
            caret-color: #221c12 !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        #si-login-panel .fi-input-wrp-suffix,
        #si-login-panel button[type="button"],
        #si-login-panel .fi-icon-btn {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        #si-login-panel button[type="button"] svg {
            color: rgba(184, 146, 67, 0.7) !important;
        }

        #si-login-panel button[type="button"]:hover svg {
            color: #b8860b !important;
        }

        #si-login-panel a[href*="password"] {
            color: #9c7204 !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            text-decoration: none !important;
        }

        #si-login-panel a[href*="password"]:hover {
            color: #6f540f !important;
        }

        #si-login-panel input[type="checkbox"] {
            background-color: transparent !important;
            border: 1px solid rgba(184, 146, 67, 0.55) !important;
            border-radius: 4px !important;
        }

        #si-login-panel input[type="checkbox"]:checked {
            background-color: #b8860b !important;
            border-color: #b8860b !important;
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e") !important;
            background-size: 100% 100% !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
        }

        #si-login-panel label[for*="remember"],
        #si-login-panel .fi-fo-checkbox-label {
            color: rgba(34, 28, 18, 0.68) !important;
            text-transform: none !important;
            font-weight: 500 !important;
            letter-spacing: normal !important;
        }

        #si-login-panel button[type="submit"] {
            position: relative !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            background: linear-gradient(135deg, #e5c173 0%, #b8860b 100%) !important;
            border-radius: 999px !important;
            border: none !important;
            padding: 0.85rem 1.6rem !important;
            box-shadow: 0 10px 24px rgba(184, 146, 67, 0.28) !important;
            transition: all 0.25s ease !important;
            width: 100% !important;
            margin-top: 1.6rem !important;
        }

        #si-login-panel button[type="submit"]::after {
            content: "→";
            display: inline-block;
            color: #2a2110;
            font-weight: 700;
            font-size: 15px;
            transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        #si-login-panel button[type="submit"]:hover::after {
            transform: translateX(5px);
        }

        #si-login-panel button[type="submit"] .fi-btn-label,
        #si-login-panel button[type="submit"] span:not(.animate-spin) {
            color: #2a2110 !important;
            font-weight: 700 !important;
            font-size: 13.5px !important;
            letter-spacing: 0.04em !important;
            text-transform: uppercase !important;
        }

        #si-login-panel button[type="submit"]>svg.animate-spin {
            display: none !important;
        }

        #si-login-panel button[type="submit"] .animate-spin {
            color: #2a2110 !important;
            width: 1.1rem !important;
            height: 1.1rem !important;
            margin-right: 0.5rem !important;
        }

        #si-login-panel div:has(> svg.animate-spin):not(button *) {
            display: none !important;
        }

        #si-login-panel button[type="submit"]:hover {
            box-shadow: 0 14px 30px rgba(184, 146, 67, 0.4) !important;
            transform: translateY(-1px);
        }

        #si-login-panel .text-center.text-sm,
        #si-login-panel form+.text-center,
        #si-login-panel div:has(> a[href$="/register"]),
        #si-login-panel div:has(> a[href$="/login"]) {
            display: none !important;
        }

        .si-left-footer {
            font-size: 12.5px;
            color: rgba(34, 28, 18, 0.58);
        }

        .si-left-footer a {
            color: #9c7204;
            font-weight: 600;
            text-decoration: none;
            margin-left: 4px;
        }

        .si-left-footer a:hover {
            color: #221c12;
            text-decoration: underline;
        }

        .si-copyright {
            font-size: 11px;
            color: rgba(122, 95, 46, 0.85);
            letter-spacing: 0.03em;
        }

        /* ---------- KANAN: nav + headline + blueprint + footer ---------- */
        .si-right {
            flex: 1;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2.75rem 4rem;
        }

        .si-nav {
            display: flex;
            justify-content: flex-end;
        }

        .si-nav-links {
            display: flex;
            gap: 2rem;
        }

        .si-nav-links a {
            position: relative;
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(34, 28, 18, 0.62);
            text-decoration: none;
            padding-bottom: 4px;
            transition: color 0.2s ease;
        }

        .si-nav-links a::after {
            content: "";
            position: absolute;
            left: 50%;
            right: 50%;
            bottom: 0;
            height: 1px;
            background: #b8860b;
            transition: left 0.25s cubic-bezier(0.16, 1, 0.3, 1), right 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .si-nav-links a:hover,
        .si-nav-links a.active {
            color: #221c12;
        }

        .si-nav-links a:hover::after,
        .si-nav-links a.active::after {
            left: 0;
            right: 0;
        }

        .si-hero {
            position: relative;
            max-width: 560px;
            margin-bottom: 1.5rem;
            animation: si-fade-up 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .si-hero-overline {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: #7a5f2e;
            margin-bottom: 1.1rem;
        }

        .si-hero-overline i {
            display: inline-block;
            width: 34px;
            height: 1px;
            background: #9c7a3c;
            font-style: normal;
        }

        .si-hero-title {
            font-family: 'Fraunces', serif;
            font-optical-sizing: auto;
            font-weight: 700;
            font-size: clamp(34px, 3.6vw, 48px);
            line-height: 1.18;
            color: #221c12;
            margin: 0 0 1.1rem 0;
        }

        .si-hero-mid {
            font-weight: 600;
            color: rgba(34, 28, 18, 0.6);
        }

        .si-hero-italic {
            font-style: italic;
            font-weight: 600;
            color: #b8860b;
        }

        p.si-hero-desc {
            font-size: 14px;
            line-height: 1.6;
            color: rgba(34, 28, 18, 0.62) !important;
            max-width: 400px;
            margin: 0 0 1.75rem 0;
        }

        .si-bottom-links {
            position: relative;
            display: flex;
            align-items: center;
            gap: 1.75rem;
        }

        .si-bottom-links a {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(34, 28, 18, 0.5);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .si-bottom-links a:hover {
            color: #b8860b;
        }

        /* ============================================================
           OVERLAY TRANSISI — muncul saat tombol Masuk ditekan, menutupi
           layar dengan fade + spinner sampai browser benar-benar
           berpindah ke halaman dashboard. Jika login gagal (validasi),
           overlay otomatis kembali disembunyikan lewat JS.
           ============================================================ */
        .si-transition-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(160deg, #fdf8ec, #ecdcac);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.45s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .si-transition-overlay.is-active {
            opacity: 1;
            pointer-events: auto;
        }

        .si-transition-inner {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.1rem;
            transform: translateY(10px);
            opacity: 0;
            transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.1s, opacity 0.5s ease 0.1s;
        }

        .si-transition-overlay.is-active .si-transition-inner {
            transform: translateY(0);
            opacity: 1;
        }

        .si-transition-logo {
            height: 52px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 4px 10px rgba(184, 146, 67, 0.3));
            animation: si-logo-pulse 1.6s ease-in-out infinite;
        }

        @keyframes si-logo-pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.06);
            }
        }

        .si-transition-spinner {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 3px solid rgba(184, 146, 67, 0.25);
            border-top-color: #b8860b;
            animation: si-spin 0.8s linear infinite;
        }

        @keyframes si-spin {
            to {
                transform: rotate(360deg);
            }
        }

        .si-transition-text {
            font-size: 12.5px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #7a5f2e;
            margin: 0;
        }

        @media (prefers-reduced-motion: reduce) {

            .si-transition-logo,
            .si-transition-spinner {
                animation: none;
            }
        }

        .si-corner {
            position: fixed;
            width: 10px;
            height: 10px;
            border: 1px solid rgba(184, 146, 67, 0.45);
            border-radius: 50%;
            z-index: 20;
            pointer-events: none;
        }

        .si-corner.tl {
            top: 18px;
            left: 18px;
        }

        .si-corner.tr {
            top: 18px;
            right: 18px;
        }

        .si-corner.bl {
            bottom: 18px;
            left: 18px;
        }

        .si-corner.br {
            bottom: 18px;
            right: 18px;
        }

        /* ============================================================
           MOBILE — sebelumnya .si-right disembunyikan total sehingga
           identitas kampus hilang di layar kecil. Sekarang menampilkan
           versi ringkas (tagline) di atas form.
           ============================================================ */
        .si-mobile-tagline {
            display: none;
        }

        @media (max-width: 900px) {

            .si-diagonal-panel,
            .si-blueprint-grid,
            .si-blueprint-svg,
            .si-corner {
                display: none;
            }

            .si-split {
                flex-direction: column;
            }

            .si-left {
                flex: 1 1 auto;
                width: 100%;
                padding: 2rem 1.5rem;
            }

            .si-right {
                display: none;
            }

            .si-mobile-tagline {
                display: block;
                font-size: 13px;
                line-height: 1.55;
                color: rgba(34, 28, 18, 0.62);
                border-top: 1px solid rgba(184, 146, 67, 0.25);
                padding-top: 0.9rem;
                margin-top: -0.4rem;
            }

            .si-mobile-tagline strong {
                display: block;
                font-family: 'Fraunces', serif;
                font-size: 17px;
                color: #221c12;
                margin-bottom: 0.25rem;
            }
        }
    </style>

    <div class="si-bg-wash"></div>
    <div class="si-blueprint-grid"></div>

    <!-- Blueprint: lingkaran dekoratif + garis penghubung + ikon aset,
         disebar ke seluruh area kanan (atas, tengah, bawah) supaya tidak polos.
         Setiap node kini punya class bp-node-group agar bisa di-hover dan
         dianimasikan masuk secara bertahap. -->
    <svg class="si-blueprint-svg" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice">
        <!-- lingkaran dekoratif besar, mengisi ruang kosong -->
        <circle class="bp-ring" cx="1170" cy="380" r="300" />
        <circle class="bp-ring" cx="1170" cy="380" r="210" />
        <circle class="bp-ring" cx="1180" cy="740" r="150" />
        <path class="bp-line" d="M 1290 470 L 1150 640" />
        <path class="bp-line" d="M 1150 640 L 1050 760" />
        <path class="bp-line" d="M 1150 640 L 1230 780" />

        <!-- garis penghubung antar node -->
        <path class="bp-line" d="M 980 245 L 1120 265 L 1240 250" />
        <path class="bp-line" d="M 1240 250 L 1340 340" />
        <path class="bp-line" d="M 980 245 L 910 375" />
        <path class="bp-line" d="M 1340 340 L 1290 470" />
        <path class="bp-line" d="M 1290 470 L 1360 600" />

        <!-- node: gedung -->
        <g class="bp-node-group" transform="translate(950,215)">
            <circle class="bp-node" cx="30" cy="30" r="26" />
            <g class="bp-icon" transform="translate(17,17)">
                <path d="M3 21h20" />
                <path d="M5 21V7l7-4 7 4v14" />
                <path d="M9 9h1" />
                <path d="M14 9h1" />
                <path d="M9 13h1" />
                <path d="M14 13h1" />
                <path d="M9 17h1" />
                <path d="M14 17h1" />
            </g>
            <text class="bp-label" x="30" y="76" text-anchor="middle">Gedung</text>
        </g>

        <!-- node: perangkat -->
        <g class="bp-node-group" transform="translate(1090,235)">
            <circle class="bp-node" cx="30" cy="30" r="26" />
            <g class="bp-icon" transform="translate(15,17)">
                <rect x="2" y="2" width="20" height="13" rx="1.5" />
                <path d="M0 19h24l-2-3H2z" />
            </g>
            <text class="bp-label" x="30" y="76" text-anchor="middle">Perangkat</text>
        </g>

        <!-- node: inventaris -->
        <g class="bp-node-group" transform="translate(1210,220)">
            <circle class="bp-node" cx="30" cy="30" r="26" />
            <g class="bp-icon" transform="translate(16,16)">
                <path d="M2 7 12 2l10 5-10 5-10-5Z" />
                <path d="M2 7v10l10 5 10-5V7" />
                <path d="M12 12v10" />
            </g>
            <text class="bp-label" x="30" y="76" text-anchor="middle">Inventaris</text>
        </g>

        <!-- node: berkas -->
        <g class="bp-node-group" transform="translate(1310,310)">
            <circle class="bp-node" cx="30" cy="30" r="26" />
            <g class="bp-icon" transform="translate(18,15)">
                <path d="M4 2h9l5 5v15H4Z" />
                <path d="M13 2v5h5" />
                <path d="M8 13h8" />
                <path d="M8 17h8" />
            </g>
            <text class="bp-label" x="30" y="76" text-anchor="middle">Berkas</text>
        </g>

        <!-- node: lab -->
        <g class="bp-node-group" transform="translate(1260,440)">
            <circle class="bp-node" cx="30" cy="30" r="26" />
            <g class="bp-icon" transform="translate(15,18)">
                <rect x="1" y="4" width="22" height="14" rx="2" />
                <circle cx="12" cy="11" r="3.4" />
                <path d="M5 8h.01" />
            </g>
            <text class="bp-label" x="30" y="76" text-anchor="middle">Lab</text>
        </g>

        <!-- node: aman -->
        <g class="bp-node-group" transform="translate(1330,570)">
            <circle class="bp-node" cx="30" cy="30" r="26" />
            <g class="bp-icon" transform="translate(18,15)">
                <rect x="3" y="11" width="18" height="11" rx="2" />
                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
            </g>
            <text class="bp-label" x="30" y="76" text-anchor="middle">Aman</text>
        </g>
    </svg>

    <div class="si-diagonal-panel"></div>

    <div class="si-corner tl"></div>
    <div class="si-corner tr"></div>
    <div class="si-corner bl"></div>
    <div class="si-corner br"></div>

    <!-- Overlay transisi menuju dashboard, disembunyikan secara default -->
    <div class="si-transition-overlay" id="si-transition-overlay">
        <div class="si-transition-inner">
            <img src="{{ asset('Logo.png') }}" alt="" class="si-transition-logo">
            <div class="si-transition-spinner"></div>
            <p class="si-transition-text">Mengalihkan ke dashboard...</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var overlay = document.getElementById('si-transition-overlay');
            var panel = document.getElementById('si-login-panel');
            if (!overlay || !panel) return;

            var form = panel.querySelector('form');
            if (!form) return;

            var hideTimer = null;

            // tampilkan overlay begitu tombol Masuk/Daftar ditekan.
            // Overlay dibiarkan menyala terus sampai:
            // (a) browser benar-benar berpindah halaman ke dashboard, atau
            // (b) terdeteksi error validasi (lihat MutationObserver di bawah).
            // Tidak ada timeout pendek di sini supaya proses login yang
            // agak lama (jaringan/server lambat) tidak membuat overlay
            // tertutup lebih dulu sebelum redirect selesai.
            form.addEventListener('submit', function() {
                overlay.classList.add('is-active');

                // jaring pengaman terakhir saja (bukan alur normal): kalau
                // dalam 15 detik halaman belum berpindah sama sekali dan
                // tidak ada error yang terdeteksi, baru overlay ditutup
                // supaya pengguna tidak terjebak menatap layar kosong
                // selamanya jika terjadi sesuatu yang tak terduga.
                clearTimeout(hideTimer);
                hideTimer = setTimeout(function() {
                    overlay.classList.remove('is-active');
                }, 15000);
            }, true);

            // begitu Livewire menampilkan error validasi (kredensial salah,
            // field kosong, dsb), langsung sembunyikan overlay agar pesan
            // error terlihat oleh pengguna — ini yang menghentikan overlay
            // lebih cepat pada kasus gagal login, bukan timeout pendek
            var observer = new MutationObserver(function() {
                if (panel.querySelector('.fi-fo-has-error')) {
                    clearTimeout(hideTimer);
                    overlay.classList.remove('is-active');
                }
            });
            observer.observe(panel, {
                childList: true,
                subtree: true,
                attributes: true
            });
        });
    </script>


    <div class="si-split">
        <!-- ============== KIRI ============== -->
        <div class="si-left">
            <div class="si-left-inner">
                <div class="si-brand">
                    <img src="{{ asset('Logo.png') }}" alt="Logo Universitas Malikussaleh" class="si-brand-logo">
                    <div class="si-brand-text">
                        <span class="si-brand-line1">MANAJEMEN ASET</span>
                        <span class="si-brand-line2">LAB</span>
                    </div>
                </div>

                <div class="si-login-panel" id="si-login-panel">
                    <h2 class="si-login-title">
                        @if (\Illuminate\Support\Facades\Route::is('filament.admin.auth.register'))
                        Buat Akun.
                        @else
                        Akses Portal.
                        @endif
                    </h2>
                    <p class="si-login-sub">
                        @if (\Illuminate\Support\Facades\Route::is('filament.admin.auth.register'))
                        Lengkapi data untuk membuat akun baru.
                        @else
                        Silakan masukkan kredensial operasional Anda.
                        @endif
                    </p>

                    <!-- Form Asli Filament -->
                    {{ $slot }}
                </div>

                <!-- Tagline ringkas khusus mobile, muncul karena .si-right
                     disembunyikan di layar kecil -->
                <div class="si-mobile-tagline">
                    <strong>Mengelola Aset &amp; Inventaris Kampus.</strong>
                    Sistem pendataan &amp; manajemen aset operasional terintegrasi Universitas Malikussaleh.
                </div>
            </div>

            <div style="display:flex; flex-direction:column; gap:0.9rem;">
                <div class="si-left-footer">
                    @if (\Illuminate\Support\Facades\Route::is('filament.admin.auth.register'))
                    <span>Sudah memiliki akun?</span>
                    <a href="{{ url('/admin/login') }}">Masuk di sini</a>
                    @else
                    <span>Belum memiliki akun?</span>
                    <a href="{{ url('/admin/register') }}">Daftar akun baru</a>
                    @endif
                </div>
                <div class="si-copyright">&copy; {{ date('Y') }} SI-ASET UNIMAL</div>
            </div>
        </div>

        <!-- ============== KANAN: nav + headline + footer ============== -->
        <div class="si-right">
            <nav class="si-nav">
                <div class="si-nav-links">
                    <a href="{{ url('/admin/login') }}" class="active">Beranda</a>
                </div>
            </nav>

            <div>
                <div class="si-hero">
                    <span class="si-hero-overline">Universitas Malikussaleh <i></i></span>
                    <h1 class="si-hero-title">
                        Mengelola Aset dan<br>
                        <em class="si-hero-italic">Inventaris</em> <span class="si-hero-mid">Lab Komputer.</span>
                    </h1>
                    <p class="si-hero-desc">
                        Sistem pendataan &amp; manajemen aset operasional terintegrasi untuk mendukung tata kelola kampus yang lebih efisien dan transparan.
                    </p>
                </div>
            </div>

            <div class="si-bottom-links">
                <a href="https://unimal.ac.id" target="_blank" rel="noopener">UNIMAL.AC.ID</a>
                <a href="https://informatika.unimal.ac.id/" target="_blank" rel="noopener">INFORMATIKA.UNIMAL.AC.ID</a>
                <a href="https://www.instagram.com/teknikinformatika_unimal" target="_blank" rel="noopener">@TEKNIKINFORMATIKA_UNIMAL</a>
            </div>
        </div>
    </div>
</x-filament-panels::layout.base>