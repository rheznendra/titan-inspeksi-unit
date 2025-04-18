@php
	$tc = \App\Enums\InspectionAuthor::TC->value;
	$disabled = !$unitInformationForm->unitExists;
@endphp
<div class="border-t-base-content/15 border-t-1 mt-5 flex flex-col pt-3">
	<input type="hidden" wire:model="form.front_image" @disabled($disabled) />
	<input type="hidden" wire:model="form.back_image" @disabled($disabled) />
	<div class="flex flex-col">
		<x-button :icon="$unitInformationForm->unit->permit->front_image ?? $form->front_image ? 'mdi.image-check' : 'mdi.image-remove'" @class([
			'md:w-48 w-full',
			'text-left',
			'btn-primary' =>
				$unitInformationForm->unit->permit->front_image ?? $form->front_image,
			'btn-error btn-outline' =>
				!$unitInformationForm->unit->permit?->front_image &&
				!$form->front_image,
		]) label="Foto Depan" wire:click="$js.openModalCamera('front')" :disabled="$disabled" />
		@error('form.front_image')
			<span class="text-error mt-1 text-sm font-semibold">{{ $message }}</span>
		@enderror
	</div>
	<div class="mt-3 flex flex-col">
		<x-button :icon="$unitInformationForm->unit->permit->back_image ?? $form->back_image ? 'mdi.image-check' : 'mdi.image-remove'" @class([
			'md:w-48 w-full',
			'text-left',
			'btn-primary' =>
				$unitInformationForm->unit->permit->back_image ?? $form->back_image,
			'btn-error btn-outline' =>
				!$unitInformationForm->unit->permit?->back_image && !$form->back_image,
		]) label="Foto Belakang" wire:click="$js.openModalCamera('back')" :disabled="$disabled" />
		@error('form.back_image')
			<span class="text-error mt-1 text-sm font-semibold">{{ $message }}</span>
		@enderror
	</div>
</div>
<x-modal class="backdrop-blur" :title="$modalCameraTitle" box-class="md:w-[500px] md:max-w-[500px]" wire:model="modalCamera" separator>
	<div wire:ignore>
		@if ($unitInformationForm->unit->author === $tc)
			<div class="flex flex-col items-center">
				<div class="mb-3" id="camera-container">
					<video class="rotate-y-180" id="camera" width="500" autoplay disablePictureInPicture />
				</div>
				<select class="select select-primary w-fit" id="cameraDevices" name="cameraDevices"></select>
			</div>
		@endif
		<img class="rotate-y-180 hidden" id="preview-shot" alt="Preview" />
		<span class="hidden font-bold" id="device-alert"></span>
	</div>
	@if ($unitInformationForm->unit->author === $tc)
		<x-slot:actions>
			<div class="flex w-full justify-between">
				@if (!$isPreview)
					<x-button label="Tutup" @click="$wire.modalCamera = false" />
					<x-button class="btn-primary" @click="$js.takeImage" label="Foto" icon="o-camera" />
				@elseif ($isPreview)
					<x-button class="btn-error" @click="$js.retakeImage" label="Ulang" icon="c-arrow-path-rounded-square" />
					@if (!$imageConfirmed)
						<x-button class="btn-success" @click="$js.confirmImage" label="Konfirmasi" icon="o-check" />
					@endif
				@endif
			</div>
		</x-slot:actions>
	@endif
</x-modal>

@script
	<script>
		const isTC = {{ $unitInformationForm->unit->author === $tc ? 'true' : 'false' }};
		const previewShot = document.getElementById('preview-shot');
		let imageData = null;
		let imageType = null;
		let deviceError = false;

		@if ($unitInformationForm->unit->author === $tc)
			const cameraContainer = document.getElementById('camera-container');
			const cameraDevices = document.getElementById('cameraDevices');
			const camera = document.getElementById('camera');
			const deviceAlert = document.getElementById('device-alert');

			let currentStream = null;
			let currentDeviceId = null;

			const toggleDeviceError = (error = false) => {
				if (error) {
					cameraContainer.classList.add('hidden');
					camera.classList.add('hidden');
					cameraDevices.classList.add('hidden');
					deviceAlert.classList.remove('hidden');
				} else {
					camera.classList.remove('hidden');
					cameraDevices.classList.remove('hidden');
					deviceAlert.classList.add('hidden');
				}
			};

			async function getCameraDevices() {
				const devices = await navigator.mediaDevices.enumerateDevices();
				const cameras = devices.filter(device => device.kind === 'videoinput');

				if (cameras.length === 0) {
					deviceError = true;
					$wire.alertCameraError('Device/kamera tidak tersedia.');
					return;
				}
				cameraDevices.innerHTML = '';
				cameras.forEach(device => {
					const option = document.createElement('option');
					option.value = device.deviceId;
					option.textContent = device.label || `Camera ${cameraDevices.length + 1}`;
					cameraDevices.appendChild(option);
				});
			}

			async function startCamera(deviceId) {
				if (currentStream) {
					currentStream.getTracks().forEach(track => track.stop());
				}
				const constraints = {
					video: {
						deviceId: {
							exact: deviceId
						}
					}
				};
				currentStream = await navigator.mediaDevices.getUserMedia(constraints);
				camera.srcObject = currentStream;
			}

			async function streamCamera() {
				await getCameraDevices()
				if (cameraDevices.options.length > 0) {
					currentDeviceId = cameraDevices.options[0].value;
					togglePreviewShot(false)
					startCamera(currentDeviceId);
				}
			}

			cameraDevices.addEventListener('change', async () => {
				const selectedDeviceId = cameraDevices.value;
				if (selectedDeviceId !== currentDeviceId) {
					currentDeviceId = selectedDeviceId;
					await startCamera(currentDeviceId)
				}
			});

			$js('takeImage', async () => {
				const canvas = document.createElement('canvas');
				canvas.width = camera.videoWidth;
				canvas.height = camera.videoHeight;
				const context = canvas.getContext('2d');
				context.drawImage(camera, 0, 0, canvas.width, canvas.height);
				imageData = canvas.toDataURL('image/jpeg', 1);
				togglePreviewShot();
				previewShot.src = imageData;
				await $wire.$set('isPreview', true);
			});

			$js('retakeImage', async () => {
				await $wire.retakeImage(imageType);
				togglePreviewShot(false);
				previewShot.removeAttribute('src');
				if (!currentStream) {
					await streamCamera();
				}
			});

			$js('confirmImage', async () => {
				await $wire.confirmImage(imageType, imageData);
			})
		@endif

		function previewImage() {
			togglePreviewShot();
			previewShot.src = $wire.$get('imageUrl');
		}

		$js('openModalCamera', async (type) => {
			imageType = type;

			await $wire.imageExists(type);

			if (!$wire.$get('isPreview')) {
				if (isTC === '1') {
					await streamCamera();
				} else {
					previewImage();
				}
			} else {
				previewImage();
			}
			if (!deviceError && isTC === '1') {
				await $wire.initModalCamera(type);
			}
		});

		const togglePreviewShot = (hide = true) => {
			if (!hide) {
				previewShot.classList.add('hidden');
				if (isTC === '1') {
					cameraContainer.classList.remove('hidden');
					camera.classList.remove('hidden');
					cameraDevices.classList.remove('hidden');
				}
			} else {
				previewShot.classList.remove('hidden');
				if (isTC === '1') {
					cameraContainer.classList.add('hidden');
					camera.classList.add('hidden');
					cameraDevices.classList.add('hidden');
				}
			}
		}
	</script>
@endscript
