@extends('dashboard._layout.main')

@section('container')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">{{$title}}</li>
    </ol>

    <h1 class="page-header">{{$title}}</h1>

    <style>
        .milestone-setting-card {
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 10px;
            background: #fff;
            padding: 20px;
            height: 100%;
        }

        .milestone-sortable-list {
            list-style: none;
            padding: 0;
            margin: 12px 0 0;
        }

        .milestone-sortable-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            margin-bottom: 8px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 8px;
            background: #f8f9fa;
            cursor: grab;
            user-select: none;
            transition: background 0.15s ease, border-color 0.15s ease, opacity 0.15s ease;
        }

        .milestone-sortable-item:active {
            cursor: grabbing;
        }

        .milestone-sortable-item.dragging {
            opacity: 0.55;
            border-style: dashed;
        }

        .milestone-drag-handle {
            color: #6c757d;
            font-size: 16px;
            width: 18px;
            text-align: center;
            flex-shrink: 0;
        }

        .milestone-sortable-label {
            flex: 1;
            font-weight: 600;
            color: #343a40;
            text-transform: none;
            word-break: break-word;
        }

        .milestone-sortable-number {
            min-width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(42, 147, 213, 0.1);
            color: #2a93d5;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .milestone-drag-note {
            margin-top: 8px;
            color: #6c757d;
            font-size: 13px;
        }
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
                    <form action="/content/store" method="POST" id="milestone-settings-form">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="section" value="setting">
                        <input type="hidden" name="milestone_steps" id="milestone_steps">
                        <input type="hidden" name="milestone_statuses" id="milestone_statuses">

                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="milestone-setting-card">
                                    <label class="form-label fw-bold">MILESTONE_STEPS</label>
                                    <ul class="milestone-sortable-list" id="milestone-steps-list">
                                        @foreach (array_filter(array_map('trim', explode(',', $milestoneSteps->description))) as $index => $step)
                                            <li class="milestone-sortable-item" draggable="true" data-value="{{ $step }}">
                                                <span class="milestone-drag-handle"><i class="fa fa-grip-vertical"></i></span>
                                                <span class="milestone-sortable-number">{{ $index + 1 }}</span>
                                                <span class="milestone-sortable-label">{{ $step }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="milestone-drag-note">Drag and drop untuk mengubah urutan milestone.</div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="milestone-setting-card">
                                    <label class="form-label fw-bold">MILESTONE_STATUSES</label>
                                    <ul class="milestone-sortable-list" id="milestone-statuses-list">
                                        @foreach (array_filter(array_map('trim', explode(',', $milestoneStatuses->description))) as $index => $status)
                                            <li class="milestone-sortable-item" draggable="true" data-value="{{ $status }}">
                                                <span class="milestone-drag-handle"><i class="fa fa-grip-vertical"></i></span>
                                                <span class="milestone-sortable-number">{{ $index + 1 }}</span>
                                                <span class="milestone-sortable-label">{{ $status }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="milestone-drag-note">Drag and drop untuk mengubah urutan status.</div>
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
            function setupSortableList(list) {
                let draggedItem = null;

                list.querySelectorAll('.milestone-sortable-item').forEach(function (item) {
                    item.addEventListener('dragstart', function (event) {
                        draggedItem = item;
                        item.classList.add('dragging');
                        event.dataTransfer.effectAllowed = 'move';
                        event.dataTransfer.setData('text/plain', item.dataset.value || '');
                    });

                    item.addEventListener('dragend', function () {
                        item.classList.remove('dragging');
                        draggedItem = null;
                        refreshNumbers(list);
                    });

                    item.addEventListener('dragover', function (event) {
                        event.preventDefault();

                        if (!draggedItem || draggedItem === item) {
                            return;
                        }

                        const rect = item.getBoundingClientRect();
                        const before = event.clientY < rect.top + (rect.height / 2);

                        if (before) {
                            list.insertBefore(draggedItem, item);
                        } else {
                            list.insertBefore(draggedItem, item.nextSibling);
                        }
                    });
                });

                refreshNumbers(list);
            }

            function refreshNumbers(list) {
                list.querySelectorAll('.milestone-sortable-item').forEach(function (item, index) {
                    const number = item.querySelector('.milestone-sortable-number');
                    if (number) {
                        number.textContent = index + 1;
                    }
                });
            }

            function getOrderedValues(list) {
                return Array.from(list.querySelectorAll('.milestone-sortable-item'))
                    .map(function (item) {
                        return item.dataset.value || '';
                    })
                    .filter(Boolean)
                    .join(',');
            }

            const stepsList = document.getElementById('milestone-steps-list');
            const statusesList = document.getElementById('milestone-statuses-list');
            const settingsForm = document.getElementById('milestone-settings-form');

            if (stepsList) {
                setupSortableList(stepsList);
            }

            if (statusesList) {
                setupSortableList(statusesList);
            }

            if (settingsForm) {
                settingsForm.addEventListener('submit', function () {
                    document.getElementById('milestone_steps').value = getOrderedValues(stepsList);
                    document.getElementById('milestone_statuses').value = getOrderedValues(statusesList);
                });
            }
        });
    </script>
@endsection
