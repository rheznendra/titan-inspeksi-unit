<div style="margin: 0 24px; width: 100%;">
	<table style="width: 100%; border-collapse: collapse; border: 1px solid #000; font-size: 14px; margin-bottom: 24px;">
		<tr>
			<th style="width: 120px; border-right: 1px solid #000;">
				@php
					$logo = public_path('assets/img/logo-titan.png');
				@endphp
				@inlinedImage($logo)
			</th>
			<th style="padding: 12px; font-size: 15px; text-transform: uppercase;">
				Daftar Periksa Supporting Equipment<br />(Water Truck, Fuel Trucks, Lube Truck,<br />Crane Trucks, Bus, Dump Truck)
			</th>
			<th style="width: 256px; border-left: 1px solid #000; font-weight: 400; font-size: 12px;">
				<table style="border-collapse: collapse; width: 100%;">
					<tr>
						<td style="width: 60px; padding-left: 8px; text-align: left; border-bottom: 1px solid #000;">No.</td>
						<td style="padding-left: 20px; padding-right: 4px; border-bottom: 1px solid #000;">:</td>
						<td style="text-align: left; border-bottom: 1px solid #000;">FM-TITAN-OPR-027</td>
					</tr>
					<tr style=" border-bottom: 1px solid #000;">
						<td style="width: 80px; padding-left: 8px; text-align: left; border-bottom: 1px solid #000;">Tgl. Terbit</td>
						<td style="padding-left: 20px; padding-right: 4px; border-bottom: 1px solid #000;">:</td>
						<td style="text-align: left; border-bottom: 1px solid #000;">01 Juli 2016</td>
					</tr>
					<tr style=" border-bottom: 1px solid #000">
						<td style="width: 80px; padding-left: 8px; text-align: left; border-bottom: 1px solid #000;">Revisi</td>
						<td style="padding-left: 20px; padding-right: 4px; border-bottom: 1px solid #000;">:</td>
						<td style="text-align: left; border-bottom: 1px solid #000;">02</td>
					</tr>
					<tr>
						<td style="width: 80px; padding-left: 8px; text-align: left;">Halaman</td>
						<td style="padding-left: 20px; padding-right: 4px;">:</td>
						<td style="text-align: left;">@pageNumber dari @totalPages</td>
					</tr>
				</table>
			</th>
		</tr>
	</table>
</div>
