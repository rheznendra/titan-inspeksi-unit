<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

	@livewireStyles
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-base-200 min-h-screen font-sans antialiased">

	{{-- NAVBAR mobile only --}}
	<x-nav class="lg:hidden" sticky>
		<x-slot:brand>
			<x-app-brand />
		</x-slot:brand>
		<x-slot:actions>
			<label class="me-3 lg:hidden" for="main-drawer">
				<x-icon class="cursor-pointer" name="o-bars-3" />
			</label>
		</x-slot:actions>
	</x-nav>

	{{-- MAIN --}}
	<x-main>
		{{-- SIDEBAR --}}
		<x-slot:sidebar class="bg-base-100 lg:bg-inherit" drawer="main-drawer" collapsible>

			{{-- BRAND --}}
			<x-app-brand class="px-5 pt-4" />

			{{-- MENU --}}
			<x-menu activate-by-route>

				<x-menu-item title="Inspeksi" icon="c-clipboard-document-list" link="{{ route('home') }}" />

				@if (config('app.env') !== 'production')
					<x-menu-sub title="Master Data" icon="o-list-bullet">
						<x-menu-item title="Inspection Question" icon="o-question-mark-circle" link="{{ route('master-data.inspection.questions') }}" />
					</x-menu-sub>
				@endif
			</x-menu>
		</x-slot:sidebar>

		{{-- The `$slot` goes here --}}
		<x-slot:content>
			{{ $slot }}
		</x-slot:content>
	</x-main>

	{{--  TOAST area --}}
	<x-toast />
	@livewireScripts
</body>

</html>
