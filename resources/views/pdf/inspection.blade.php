@extends('components.layouts.ghost')

@section('content')
	<div class="mx-auto max-w-7xl bg-white px-6">

		<!-- Unit Info -->
		<table class="border-1 border-base-content table">
			<tr class="whitespace-nowrap border-0">
				<th class="bg-base-content/25 py-0 font-semibold uppercase">No Unit</th>
				<td class="border py-0">ABC1234_A</td>
				<th class="border-s-1 border-base-content bg-base-content/25 py-0 font-semibold uppercase">Lokasi</th>
				<td class="border py-0">Muara Enim</td>
			</tr>
			<tr class="border-base-content whitespace-nowrap border-b">
				<th class="bg-base-content/25 py-0 font-semibold uppercase">Jenis Kendaraan</th>
				<td class="border py-0">TRAILER</td>
				<th class="border-s-1 border-base-content bg-base-content/25 py-0 font-semibold uppercase">Nomor Seri Mesin</th>
				<td class="border py-0">123456789012345678</td>
			</tr>
			<tr class="whitespace-nowrap border-0">
				<th class="bg-base-content/25 py-0 font-semibold uppercase">Nomor Polisi</th>
				<td class="border py-0">BG1234ABC</td>
				<th class="border-s-1 border-base-content bg-base-content/25 py-0 font-semibold uppercase">Kilometer</th>
				<td class="border py-0">5000</td>
			</tr>
			<tr class="whitespace-nowrap border-0">
				<th class="bg-base-content/25 py-0 font-semibold uppercase">Tahun Pembuatan</th>
				<td class="border py-0">2014</td>
				<th class="border-s-1 border-base-content bg-base-content/25 py-0 font-semibold uppercase">Hours Meter</th>
				<td class="border py-0">5,5</td>
			</tr>
			<tr class="whitespace-nowrap border-0">
				<th class="bg-base-content/25 py-0 font-semibold uppercase">Perusahaan</th>
				<td class="border py-0">PT. Maju Mundur</td>
				<th class="border-s-1 border-base-content bg-base-content/25 py-0 font-semibold uppercase">Brand</th>
				<td class="border py-0">HINO</td>
			</tr>
		</table>

		<!-- Checklist Table -->
		<div class="mt-6 overflow-x-auto">
			<span class="ps-2 text-sm font-bold">Beri tanda √ dibawah ini sesuai hasil inspeksi</span>
			<table class="mt-2 w-full table-auto border border-gray-300 text-sm">
				<thead class="bg-base-content/15">
					<tr class="text-center uppercase">
						<th class="w-10 border px-2" rowspan="2">No</th>
						<th class="w-[280px] border px-2" rowspan="2">Deskripsi</th>
						<th class="w-15 border px-2 py-0 text-center" rowspan="2">Ada</th>
						<th class="w-15 border px-2 py-0 text-center" rowspan="2">Tidak Ada</th>
						<th class="border px-2" colspan="2">Kondisi</th>
						<th class="w-[200px] border px-2" rowspan="2">Keterangan</th>
					</tr>
					<tr class="text-center uppercase">
						<th class="w-15 border px-2 py-0 text-center">Baik</th>
						<th class="w-15 border px-2 py-0 text-center">Buruk</th>
					</tr>
				</thead>
				<tbody>
					@foreach (\App\Models\Question::get() as $item)
						@php
							$kelengkapan = rand(0, 1);
							$kondisi = rand(0, 1);
						@endphp
						<tr class="text-xs font-bold">
							<td class="border-base-content border px-2 py-[0.75px] text-center">{{ $loop->iteration }}</td>
							<td class="border-base-content border px-2 py-[0.75px]">{{ $item->question }}</td>
							<td class="border-base-content border px-2 py-[0.75px] text-center">{{ $kelengkapan ? '√' : null }}</td>
							<td class="border-base-content border px-2 py-[0.75px] text-center">{{ $kelengkapan ? null : '√' }}</td>
							<td class="border-base-content border px-2 py-[0.75px] text-center">{{ $kondisi ? '√' : null }}</td>
							<td class="border-base-content border px-2 py-[0.75px] text-center">{{ $kondisi ? null : '√' }}</td>
							{{-- <td class="border-base-content border px-2 py-[0.75px]">{{ rand(0, 1) ? fake()->sentence(3) : null }}</td> --}}
							<td class="border-base-content border px-2 py-[0.75px]"></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<!-- Approval Section -->
		<div class="mb-3 mt-6 text-sm">
			<span class="ps-2 text-sm font-bold">Beri tanda √ dibawah ini sesuai hasil inspeksi</span>
			<div class="flex flex-col">
				<div class="pdf-checkbox text-sm">Diijinkan dan telah memenuhi persyaratan</div>
				<div class="pdf-checkbox text-sm">Tidak diijinkan untuk dioperasikan (<span class="mx-2 mt-3 flex-grow border-b border-dotted border-black"></span>)</div>
				<div class="pdf-checkbox pdf-checkbox-checked text-sm/3.5">Lainnya (<span class="mx-2 flex-grow border-b border-dotted border-black">{{ fake()->sentence(10) }}</span>)</div>
			</div>
		</div>

		<!-- Signature & Inspection Info in One Row -->
		<table class="border-1 w-full">
			<thead class="bg-base-content/20 text-center text-black">
				<tr>
					<th class="border-1 py-2 text-sm font-bold">Petugas Inspeksi<br />(TC)</th>
					<th class="border-1 py-2 text-sm font-bold">Petugas Inspeksi<br />(SHE)</th>
					<th class="border-1 py-2 text-sm font-bold">Petugas Inspeksi<br />(OPERATION)</th>
					<th class="border-1 w-32 py-2 text-sm font-bold uppercase">Tanggal Inspeksi</th>
					<th class="border-1 py-2 text-sm font-bold uppercase">Mengetahui</th>
				</tr>
			</thead>
			<tbody class="text-center">
				<tr class="h-20">
					<td class="border-1 pt-14 font-bold">John Doe</td>
					<td class="border-1 pt-14 font-bold">John Doe</td>
					<td class="border-1 pt-14 font-bold">Jane Doe</td>
					<td class="border-1 font-bold">01/01/2023</td>
					<td class="border-1 whitespace-nowrap pt-14 font-bold uppercase">Manager Departemen</td>
				</tr>
			</tbody>
		</table>

		<!-- Footer -->
		<div class="mt-5">
			<p class="text-[14px]/4 font-bold">Note: Photo Alat/DT Kiri Kanan Depan Belakang Harus dilampirkan pada Form Daftar Periksa Dan Photo Copy STNK Beserta No Lambung Kiri
				Kanan Depan Dan Tulisan Rambu Jaga Jarak Beriringan 60 M Di Belakang Bak Vessel DT.</p>
		</div>
		@pageBreak
		<div class="h-screen min-h-screen w-full">
			<p class="mb-2 text-sm font-bold">Catatan :</p>
			<div class="note-container">
				{{ fake()->text(3000) }}
			</div>
		</div>
	</div>
@endsection
