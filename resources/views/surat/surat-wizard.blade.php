@extends('layouts.app')

@section('title', 'Pengajuan Surat')

@section('content')

    <x-card>

        <x-slot:header>

            Pengajuan Surat

        </x-slot:header>

        <x-progress :steps="$steps" :no-step="$noStep" />

        @include('surat.steps.' . $currentStep)

        <x-slot:footer>

            <x-navigation />

        </x-slot:footer>

    </x-card>

@endsection


@push('scripts')
    <script>
        const API = {
            templates: '/api/jenis-surat',
            detail: '/api/jenis-surat',
        };

        const wizard = {
            currentStep: 1,
            selectedTemplate: null,
            pengajuanId: null,
            nikValues: [],
            nikFields: [],
            manualFields: [],
            templates: [],
        };

        document.addEventListener('DOMContentLoaded', init);

        function init() {

            bindEvents();

            loadTemplates();

        }

        function bindEvents() {

            const container = getTemplateContainer();

            if (!container) return;

            container.addEventListener('click', onTemplateClick);

        }

        function getTemplateContainer() {

            return document.getElementById('template-list');

        }

        async function loadTemplates() {

            const container = getTemplateContainer();

            if (!container) return;

            try {

                const response = await fetch(API.templates);

                const json = await response.json();

                wizard.templates = json?.data?.data ?? [];

                renderTemplates();

            } catch (error) {

                console.error(error);

                container.innerHTML = `
                <div class="alert alert-danger">
                    Gagal memuat template surat.
                </div>
            `;

            }

        }

        function renderTemplates() {

            const container = getTemplateContainer();

            if (!container) return;

            container.innerHTML = '';

            if (!wizard.templates.length) {

                container.innerHTML = `
                <div class="text-muted">
                    Tidak ada template surat.
                </div>
            `;

                return;

            }

            wizard.templates.forEach(template => {

                container.insertAdjacentHTML(
                    'beforeend',
                    createTemplateCard(template)
                );

            });

        }

        function createTemplateCard(template) {

            return `
            <div
                class="card mb-2 template-item"
                data-id="${template.id}"
                style="cursor:pointer;">

                <div class="card-body">

                    <h5 class="card-title">

                        ${template.nama_jenis_surat}

                    </h5>

                    <p class="card-text text-muted mb-0">

                        ${template.deskripsi ?? ''}

                    </p>

                </div>

            </div>
        `;

        }

        function onTemplateClick(event) {

            const card = event.target.closest('.template-item');

            if (!card) return;

            const id = Number(card.dataset.id);

            wizard.selectedTemplate =
                wizard.templates.find(t => t.id === id);

            updateSelectedCard(card);

            console.log(wizard.selectedTemplate);

            document
                .getElementById('btn-next')
                .addEventListener('click', () => {

                    loadNikFields();

                });

            enableNextButton();


        }

        function getNextButton() {

            return document.getElementById('btn-next');

        }


        function enableNextButton() {

            const button = getNextButton();

            if (!button) return;

            button.disabled = false;

        }

        function updateNextButton() {

            const button = getNextButton();

            if (!button) return;

            button.disabled = wizard.selectedTemplate === null;

        }

        function updateSelectedCard(selectedCard) {

            document.querySelectorAll('.template-item')
                .forEach(card => {

                    card.classList.remove(
                        'border-primary',
                        'selected'
                    );

                });

            selectedCard.classList.add(
                'border-primary',
                'selected'
            );

        }

        async function loadNikFields() {

            if (!wizard.selectedTemplate) return;

            try {

                const response = await fetch(

                    `${API.detail}/${wizard.selectedTemplate.id}`

                );

                const json = await response.json();

                console.log(
                    json.jenis_surat
                    .srt_jenis_surat_penduduks
                );

                wizard.nikFields =
                    json.jenis_surat.srt_jenis_surat_penduduks;

                renderNikFields();

            } catch (error) {

                console.error(error);

            }

        }

        function renderNikFields() {

            const container =
                getTemplateContainer();

            container.innerHTML = '';

            wizard.nikFields.forEach(field => {

                container.insertAdjacentHTML(

                    'beforeend',

                    createNikField(field)

                );

            });

        }


        function createNikField(field) {

            return `
        <div class="mb-3">

            <label class="form-label">

                ${field.label}

            </label>

            <input
                class="form-control nik-input"
                data-kode="${field.kode}"
                placeholder="${field.deskripsi}">

        </div>
    `;

        }

        const niks = [];

        document
            .querySelectorAll('.nik-input')
            .forEach(input => {

                niks.push(input.value);

            });

        console.log(niks);
    </script>
@endpush
