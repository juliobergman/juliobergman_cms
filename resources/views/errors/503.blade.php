@extends('layouts.error')
@section('title', 'Down for Maintenance | Julio Bergman')
@section('error', "503")
@section('image')
<div class="image">
    <img src="/storage/ui/error/maintenance.svg" alt="">
</div>
@endsection
@section('content')
<div class="title">We'll be back soon!</div>
<div class="message">
    Sorry for the inconvenience but I'm performing some maintenance at the moment. If you need to you can always <a href="mailto:me@juliobergman.com">contact me</a>, otherwise the site will be back online shortly!
</div>
<div class="caption">- Julio Bergman</div>
@endsection
