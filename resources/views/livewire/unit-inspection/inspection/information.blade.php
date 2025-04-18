<div class="w-full overflow-x-auto">
	<table class="border-1 border-base-content/15 mb-3 table table-auto rounded-lg">
		<tr class="whitespace-nowrap">
			<th>Name</th>
			<td>: {{ $unitInformationForm->name ?? '-' }}</td>
			<th class="border-s-1 border-base-content/15">Username</th>
			<td>: {{ $unitInformationForm->username ?? '-' }}</td>
			<th class="border-s-1 border-base-content/15">Author</th>
			<td>: {{ $unitInformationForm->author ?? '-' }}</td>
		</tr>
	</table>
	<table class="border-1 border-base-content/15 table min-w-full table-auto rounded-lg">
		<tr class="whitespace-nowrap border-0">
			<th>No Unit</th>
			<td>: {{ $unitInformationForm->unit_number ?? '-' }}</td>
			<th class="border-s-1 border-base-content/15">Lokasi</th>
			<td>: {{ $unitInformationForm->location ?? '-' }}</td>
		</tr>
		<tr class="whitespace-nowrap border-0">
			<th>Jenis Kendaraan</th>
			<td>: {{ $unitInformationForm->vehicle_type ?? '-' }}</td>
			<th class="border-s-1 border-base-content/15">Nomor Seri Mesin</th>
			<td>: {{ $unitInformationForm->engine_serial_number ?? '-' }}</td>
		</tr>
		<tr class="whitespace-nowrap border-0">
			<th>Nomor Polisi</th>
			<td>: {{ $unitInformationForm->plate_number ?? '-' }}</td>
			<th class="border-s-1 border-base-content/15">Kilometer</th>
			<td>: {{ $unitInformationForm->kilometer ?? '-' }}</td>
		</tr>
		<tr class="whitespace-nowrap border-0">
			<th>Tahun Pembuatan</th>
			<td>: {{ $unitInformationForm->year_manufacture ?? '-' }}</td>
			<th class="border-s-1 border-base-content/15">Hours Meter</th>
			<td>: {{ $unitInformationForm->hours_meter ?? '-' }}</td>
		</tr>
		<tr class="whitespace-nowrap border-0">
			<th>Perusahaan</th>
			<td>: {{ $unitInformationForm->company ?? '-' }}</td>
			<th class="border-s-1 border-base-content/25">Brand</th>
			<td>: {{ $unitInformationForm->brand ?? '-' }}</td>
		</tr>
	</table>
</div>
