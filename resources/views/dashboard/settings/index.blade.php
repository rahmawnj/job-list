@extends('dashboard._layout.main')

@section('container')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>

    <h1 class="page-header">{{ $title }}</h1>

    <style>
        .milestone-setting-card { border:1px solid rgba(0,0,0,.08); border-radius:10px; background:#fff; padding:20px; height:100%; }
        .milestone-setting-toolbar { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:12px; }
        .milestone-sortable-list { list-style:none; padding:0; margin:12px 0 0; min-height:8px; }
        .milestone-sortable-item { display:flex; align-items:center; gap:12px; padding:12px 14px; margin-bottom:8px; border:1px solid rgba(0,0,0,.08); border-radius:8px; background:#f8f9fa; cursor:grab; user-select:none; }
        .milestone-sortable-item:active { cursor:grabbing; }
        .milestone-sortable-item.dragging { opacity:.55; border-style:dashed; }
        .milestone-drag-handle { color:#6c757d; font-size:16px; width:18px; text-align:center; flex-shrink:0; }
        .milestone-sortable-label { flex:1; font-weight:600; color:#343a40; word-break:break-word; }
        .milestone-sortable-number { min-width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center; border-radius:50%; background:rgba(42,147,213,.1); color:#2a93d5; font-size:12px; font-weight:700; flex-shrink:0; }
        .milestone-delete-btn { border:0; background:transparent; color:#dc3545; width:30px; height:30px; display:inline-flex; align-items:center; justify-content:center; border-radius:6px; padding:0; flex-shrink:0; }
        .milestone-delete-btn:hover { background:rgba(220,53,69,.1); }
        .milestone-empty { border:1px dashed rgba(0,0,0,.15); border-radius:8px; padding:14px; margin-top:12px; color:#6c757d; text-align:center; font-size:13px; }
        .milestone-add-row { display:none; gap:8px; margin-top:10px; }
        .milestone-add-row.is-visible { display:flex; }
        .milestone-add-row .form-control { flex:1; }
    </style>

    <div class="row">
        <div class="col-xl-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Milestone Settings</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                </div>

                @if (session()->has('success'))
                    <div class="flash-data-success" data-flashdatasuccess="{{ session('success') }}"></div>
                @endif
                @if (session()->has('error'))
                    <div class="flash-data-error" data-flashdataerror="{{ session('error') }}"></div>
                @endif

                <div class="panel-body">
                    @php
                        $currentSteps = array_values(array_filter(array_map('trim', explode(',', (string) $milestoneSteps->description))));
                        $currentStatuses = array_values(array_filter(array_map('trim', explode(',', (string) $milestoneStatuses->description))));
                    @endphp

                    <form action="/content/store" method="POST" id="milestone-settings-form">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="section" value="setting">
                        <input type="hidden" name="milestone_steps" id="milestone_steps">
                        <input type="hidden" name="milestone_statuses" id="milestone_statuses">

                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="milestone-setting-card">
                                    <div class="milestone-setting-toolbar">
                                        <label class="form-label fw-bold mb-0">MILESTONE_STEPS</label>
                                        <button type="button" class="btn btn-sm btn-primary milestone-add-btn" data-target="steps"><i class="fa fa-plus me-1"></i> Add</button>
                                    </div>

                                    <ul class="milestone-sortable-list" id="milestone-steps-list">
                                        @foreach ($currentSteps as $index => $step)
                                            <li class="milestone-sortable-item" draggable="true" data-value="{{ $step }}">
                                                <span class="milestone-drag-handle"><i class="fa fa-grip-vertical"></i></span>
                                                <span class="milestone-sortable-number">{{ $index + 1 }}</span>
                                                <span class="milestone-sortable-label">{{ $step }}</span>
                                                <button type="button" class="milestone-delete-btn" title="Delete item"><i class="fa fa-trash"></i></button>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="milestone-empty" data-empty="steps" style="{{ count($currentSteps) ? 'display:none;' : '' }}">Belum ada milestone.</div>
                                    <div class="milestone-add-row" data-add-row="steps">
                                        <input type="text" class="form-control milestone-add-input" data-add-input="steps" placeholder="e.g. reference_check" autocomplete="off">
                                        <button type="button" class="btn btn-primary milestone-confirm-add" data-add-confirm="steps">Add</button>
                                    </div>
                                    <div class="text-muted small mt-2">Drag and drop untuk mengubah urutan.</div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="milestone-setting-card">
                                    <div class="milestone-setting-toolbar">
                                        <label class="form-label fw-bold mb-0">MILESTONE_STATUSES</label>
                                        <button type="button" class="btn btn-sm btn-primary milestone-add-btn" data-target="statuses"><i class="fa fa-plus me-1"></i> Add</button>
                                    </div>

                                    <ul class="milestone-sortable-list" id="milestone-statuses-list">
                                        @foreach ($currentStatuses as $index => $status)
                                            <li class="milestone-sortable-item" draggable="true" data-value="{{ $status }}">
                                                <span class="milestone-drag-handle"><i class="fa fa-grip-vertical"></i></span>
                                                <span class="milestone-sortable-number">{{ $index + 1 }}</span>
                                                <span class="milestone-sortable-label">{{ $status }}</span>
                                                <button type="button" class="milestone-delete-btn" title="Delete item"><i class="fa fa-trash"></i></button>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="milestone-empty" data-empty="statuses" style="{{ count($currentStatuses) ? 'display:none;' : '' }}">Belum ada status.</div>
                                    <div class="milestone-add-row" data-add-row="statuses">
                                        <input type="text" class="form-control milestone-add-input" data-add-input="statuses" placeholder="e.g. cancelled" autocomplete="off">
                                        <button type="button" class="btn btn-primary milestone-confirm-add" data-add-confirm="statuses">Add</button>
                                    </div>
                                    <div class="text-muted small mt-2">Drag and drop untuk mengubah urutan.</div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">Save Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function getList(key) {
                return document.getElementById(key === 'steps' ? 'milestone-steps-list' : 'milestone-statuses-list');
            }

            function refreshList(list) {
                list.querySelectorAll('.milestone-sortable-item').forEach(function (item, index) {
                    const number = item.querySelector('.milestone-sortable-number');
                    if (number) number.textContent = index + 1;
                });

                const key = list.id === 'milestone-steps-list' ? 'steps' : 'statuses';
                const empty = document.querySelector('[data-empty="' + key + '"]');
                if (empty) empty.style.display = list.querySelector('.milestone-sortable-item') ? 'none' : 'block';
            }

            function bindItemEvents(list, item) {
                item.addEventListener('dragstart', function (event) {
                    item.classList.add('dragging');
                    event.dataTransfer.effectAllowed = 'move';
                });

                item.addEventListener('dragend', function () {
                    item.classList.remove('dragging');
                    refreshList(list);
                });

                item.addEventListener('dragover', function (event) {
                    event.preventDefault();
                    const active = list.querySelector('.milestone-sortable-item.dragging');
                    if (!active || active === item) return;
                    const rect = item.getBoundingClientRect();
                    const before = event.clientY < rect.top + rect.height / 2;
                    list.insertBefore(active, before ? item : item.nextSibling);
                });

                const deleteButton = item.querySelector('.milestone-delete-btn');
                if (deleteButton) {
                    deleteButton.addEventListener('click', function () {
                        item.remove();
                        refreshList(list);
                    });
                }
            }

            function addItem(key) {
                const list = getList(key);
                const input = document.querySelector('[data-add-input="' + key + '"]');
                if (!list || !input) return;

                const value = input.value.trim();
                if (!value) {
                    input.focus();
                    return;
                }

                const exists = Array.from(list.querySelectorAll('.milestone-sortable-item')).some(function (item) {
                    return (item.dataset.value || '').toLowerCase() === value.toLowerCase();
                });
                if (exists) {
                    input.value = '';
                    input.focus();
                    return;
                }

                const item = document.createElement('li');
                item.className = 'milestone-sortable-item';
                item.draggable = true;
                item.dataset.value = value;
                item.innerHTML = '<span class="milestone-drag-handle"><i class="fa fa-grip-vertical"></i></span>' +
                    '<span class="milestone-sortable-number"></span>' +
                    '<span class="milestone-sortable-label"></span>' +
                    '<button type="button" class="milestone-delete-btn" title="Delete item"><i class="fa fa-trash"></i></button>';
                item.querySelector('.milestone-sortable-label').textContent = value;
                list.appendChild(item);
                bindItemEvents(list, item);
                refreshList(list);
                input.value = '';
                input.focus();
            }

            document.querySelectorAll('.milestone-sortable-list').forEach(function (list) {
                list.querySelectorAll('.milestone-sortable-item').forEach(function (item) {
                    bindItemEvents(list, item);
                });
                refreshList(list);
            });

            document.querySelectorAll('.milestone-add-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const key = button.dataset.target;
                    const row = document.querySelector('[data-add-row="' + key + '"]');
                    const input = document.querySelector('[data-add-input="' + key + '"]');
                    if (row) row.classList.toggle('is-visible');
                    if (input && row && row.classList.contains('is-visible')) input.focus();
                });
            });

            document.querySelectorAll('.milestone-confirm-add').forEach(function (button) {
                button.addEventListener('click', function () {
                    addItem(button.dataset.addConfirm);
                });
            });

            document.querySelectorAll('.milestone-add-input').forEach(function (input) {
                input.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        addItem(input.dataset.addInput);
                    }
                });
            });

            const form = document.getElementById('milestone-settings-form');
            if (form) {
                form.addEventListener('submit', function () {
                    document.getElementById('milestone_steps').value = Array.from(getList('steps').querySelectorAll('.milestone-sortable-item')).map(function (item) {
                        return item.dataset.value || '';
                    }).filter(Boolean).join(',');

                    document.getElementById('milestone_statuses').value = Array.from(getList('statuses').querySelectorAll('.milestone-sortable-item')).map(function (item) {
                        return item.dataset.value || '';
                    }).filter(Boolean).join(',');
                });
            }
        });
    </script>
@endsection
