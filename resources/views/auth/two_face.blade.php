<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <div class="text-center">
            <h4 style="font-size: 20px; margin-top: 10px;"><strong>Two Factor Verification</strong></h4>
        </div>
        <form method="POST" action="{{route('two-step-verification.store')}}">
            @csrf
            <!-- Email Address -->
            <div>
                <x-label for="code" :value="__('Code')" />

                <x-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('code')" required autofocus />
{{--                @if($errors->any())--}}
{{--                    <h4>{{$errors->first()}}</h4>--}}
{{--                @endif--}}
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="btn btn-primary text-sm text-gray-600 hover:text-gray-900" href="{{ route('resend') }}">
                    {{ __('resend') }}
                </a>
                <x-button class="ml-3">
                    {{ __('Verify') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
