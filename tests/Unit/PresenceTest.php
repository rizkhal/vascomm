<?php

use App\Models\SchoolSchedule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    Carbon::setTestNow(Carbon::createFromTime(9, 45, 0, 'Asia/Makassar'));
});

test('it can subtract in minute', function () {
    $now = now()->subMinute(5);
    expect($now->format('H:i'))->toBe('09:40');
});

test('the given time is before current time', function () {
    expect(Carbon::parse(Carbon::createFromTime(9, 40, 0, 'Asia/Makassar'))->isTimeBefore(now()))->toBeTrue();
    expect(Carbon::parse(now())->isTimeBefore(Carbon::createFromTime(9, 40, 0, 'Asia/Makassar')))->toBeFalse();
});

test('the given time is after current time', function () {
    expect(Carbon::parse(Carbon::createFromTime(9, 50, 0, 'Asia/Makassar'))->isTimeAfter(now()))->toBeTrue();
    expect(Carbon::parse(now())->isTimeAfter(Carbon::createFromTime(9, 50, 0, 'Asia/Makassar')))->toBeFalse();
});

test('determine the given day is today', function () {
    $translatedDayName = ucfirst(now()->translatedFormat('l'));

    if (Schema::hasTable('rb_jadwal_pelajaran')) {
        $translatedDayName = SchoolSchedule::where('hari', $translatedDayName)->first()?->hari;
    }

    expect(is_today($translatedDayName))->toBeTrue();
});

test('it can know between two time', function () {
    $now = Carbon::now();

    $start = Carbon::createFromFormat('H:i a', '08:00 AM');
    $end = Carbon::createFromFormat('H:i a', '08:00 PM');

    expect($now->isBetween($start, $end))->toBe(true);
});

test('it past', function () {
    // just for sure
    expect(Carbon::create(2022, 9, 20, 0)->isPast())->toBeTrue();
});
