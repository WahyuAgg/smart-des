@extends('layouts.auth')

@section('title', 'Login')

@section('content')
  <div x-data="loginForm" class="w-full max-w-md">

    {{-- Logo & Branding --}}
    <div class="text-center mb-8">
      <div
        class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-accent/20 backdrop-blur-sm border border-accent/30 mb-4">
        <div class="w-10 h-10 rounded-lg bg-accent flex items-center justify-center font-bold text-white text-xl">S
        </div>
      </div>
      <h1 class="text-2xl font-bold text-white tracking-tight">SmartDes</h1>
      <p class="text-sm text-slate-400 mt-1">Sistem Informasi Administrasi Kependudukan</p>
    </div>

    {{-- Login Card --}}
    <div class="bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl shadow-black/20 border border-white/20 p-8">

      <div class="mb-6">
        <h2 class="text-lg font-semibold text-slate-800">Masuk ke Akun</h2>
        <p class="text-sm text-slate-500 mt-0.5">Silakan masukkan email dan password Anda</p>
      </div>

      {{-- Error Alert --}}
      <div x-show="error" x-cloak x-transition
        class="mb-5 flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <svg class="w-5 h-5 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 9v4m0 4h.01M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z" />
        </svg>
        <p x-text="error" class="flex-1"></p>
        <button @click="error = null" class="text-red-400 hover:text-red-600">&times;</button>
      </div>

      {{-- Form --}}
      <form @submit.prevent="submit()" class="space-y-5">

        {{-- Email --}}
        <div>
          <label for="login-email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
          <div class="relative">
            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 8l7.9 5.2a2 2 0 0 0 2.2 0L21 8M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2Z" />
              </svg>
            </div>
            <input id="login-email" type="email" x-model="email" placeholder="admin@desa.id" required
              autocomplete="email"
              class="w-full pl-11 pr-3 py-2.5 rounded-lg border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent transition" />
          </div>
        </div>

        {{-- Password --}}
        <div>
          <label for="login-password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
          <div class="relative">
            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-2.25 0h13.5a1.5 1.5 0 0 1 1.5 1.5v6.75a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V12a1.5 1.5 0 0 1 1.5-1.5Z" />
              </svg>
            </div>
            <input id="login-password" :type="showPassword ? 'text' : 'password'" x-model="password"
              placeholder="••••••••" required autocomplete="current-password"
              class="w-full pl-11 pr-11 py-2.5 rounded-lg border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent transition" />
            <button type="button" @click="showPassword = !showPassword"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition">
              {{-- Eye icon --}}
              <svg x-show="!showPassword" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
              </svg>
              <svg x-show="showPassword" x-cloak class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
              </svg>
            </button>
          </div>
        </div>

        {{-- Submit --}}
        <button type="submit" :disabled="loading"
          class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-accent hover:bg-accent-hover disabled:opacity-50 disabled:cursor-not-allowed transition shadow-lg shadow-accent/25">
          <svg x-show="loading" class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.4 0 0 5.4 0 12h4z" />
          </svg>
          <span x-text="loading ? 'Memproses...' : 'Masuk'"></span>
        </button>

      </form>
    </div>

    {{-- Footer --}}
    <p class="text-center text-xs text-slate-500 mt-6">&copy; {{ date('Y') }} SmartDes &mdash; Sistem Informasi
      Administrasi Kependudukan</p>
  </div>
@endsection
