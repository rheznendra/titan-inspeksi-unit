<div class="w-full overflow-x-auto">
	<table class="border-1 border-base-content/15 table table-auto rounded-lg">
		<tr class="whitespace-nowrap border-0">
			<th>No Unit</th>
			<td>: {{ $unitInformation['no_unit'] ?? '-' }}</td>
			<th class="border-s-1 border-base-content/15">Lokasi</th>
			<td>: {{ $unitInformation['lokasi'] ?? '-' }}</td>
		</tr>
		<tr class="whitespace-nowrap border-0">
			<th>Jenis Kendaraan</th>
			<td>: {{ $unitInformation['jenis_kendaraan'] ?? '-' }}</td>
			<th class="border-s-1 border-base-content/15">Nomor Seri Mesin</th>
			<td>: {{ $unitInformation['nomor_seri_mesin'] ?? '-' }}</td>
		</tr>
		<tr class="whitespace-nowrap border-0">
			<th>Nomor Polisi</th>
			<td>: {{ $unitInformation['nomor_polisi'] ?? '-' }}</td>
			<th class="border-s-1 border-base-content/15">Kilometer</th>
			<td>: {{ $unitInformation['kilometer'] ?? '-' }}</td>
		</tr>
		<tr class="whitespace-nowrap border-0">
			<th>Tahun Pembuatan</th>
			<td>: {{ $unitInformation['tahun_pembuatan'] ?? '-' }}</td>
			<th class="border-s-1 border-base-content/15">Hours Meter</th>
			<td>: {{ $unitInformation['hours_meter'] ?? '-' }}</td>
		</tr>
		<tr class="whitespace-nowrap border-0">
			<th>Perusahaan</th>
			<td>: {{ $unitInformation['perusahaan'] ?? '-' }}</td>
			<th class="border-s-1 border-base-content/25">Brand</th>
			<td>: {{ $unitInformation['brand'] ?? '-' }}</td>
		</tr>
	</table>
</div>
