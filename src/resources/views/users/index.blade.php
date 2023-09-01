@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
@endsection

@section('content')
<div class="attendance-table">
    <table class="attendance-table__inner">
        <tr class="attendance-table__row">
            <th class="attendance-table__header">勤務開始</th>
            <th class="attendance-table__header">勤務終了</th>
            <th class="attendance-table__header">休憩時間</th>
            <th class="attendance-table__header">勤務時間</th>
        </tr>
        <tr class="attendance-table__row">
            <td class="attendance-table__item">
                @if($user->workStartTime)
                {{ $user->workStartTime->format('H:i:s') }}
                @endif
            </td>
            <td class="attendance-table__item">
                @if($user->workEndTime)
                {{ $user->workEndTime->format('H:i:s') }}
                @endif
            </td>
            <td class="attendance-table__item">{{ $user->breakTimeFormatted }}</td>
            <td class="attendance-table__item">{{ $user->totalWorkTime }}</td>
        </tr>
    </table>
</div>
@endsection

